<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;

class RelationController extends Controller
{
    private $paginationNum = 0;

    public function __construct()
    {
        $settings = Valuestore::make(storage_path('app/settings.json'));
        $this->paginationNum = $settings->get('relation_pagination', 0);
    }

    /**
     * Display a listing of user who are not friend
     */
    public function getAddFriendList()
    {
        $friendIds = $this->currentUser()->friends()->pluck(['id']);
        $requestIds = $this->currentUser()->requestUsers()->pluck(['id']);
        $arr = $friendIds->merge($requestIds);
        $users = User::where('id', '!=', $this->currentUser()->id)->whereNotIn('id', $arr)->paginate($this->paginationNum);
        if (count($users) >= 0) {
            return view('app.relations-list', ['userList' => $users, 'action' => 'add-friend']);
        }
        return redirect('error');
    }

    public function addFriend($friendId)
    {
        if (!$this->currentUser()->isFriendable($friendId)) {
            return redirect('error');
        }
        $this->currentUser()->addFriend($friendId);
        if ($this->currentUser()->isAddSuccess($friendId)) {
            return redirect()->route('relations.get_add_friend_list');
        }
        return redirect('error');
    }

    public function getRequests()
    {
        $requestRelations = $this->currentUser()->requestingRelations()
            ->where('type', 'request')
            ->select('user_id')
            ->get();
        $requestUsers = [];
        if ($requestRelations->count() >= 0) {
            $requestUsers = User::whereIn('id', $requestRelations)->paginate($this->paginationNum);
        } else {
            return redirect('error');
        }
        if ($requestUsers->count() >= 0) {
            return view('app.relations-list', ['userList' => $requestUsers, 'action' => 'requests']);
        }
        return redirect('error');
    }

    public function responseRequest($userId, Request $request)
    {
        $type = isset($request->type) ? strtolower($request->type) : '';
        $arr = ['accept', 'decline'];
        if (!in_array($type, $arr) || !$this->currentUser()->isRequestedBy($userId)) {
            return redirect('error');
        }
        $relation = $this->currentUser()->getRequestingRelation($userId);
        if ($relation == null) {
            return redirect('error');
        }
        if ($type == 'accept') {
            $relation->type = 'friend';
            if ($relation->save()) {
                return redirect(route('relations.get_requests'));
            }
            return redirect('error');
        } else {
            if ($relation->delete()) {
                return redirect(route('relations.get_requests'));
            }
            return redirect('error');
        }
    }
}
