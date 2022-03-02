<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;
use App\Exceptions\ErrorException;

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
        $users = User::where('id', '!=', $this->currentUser()->id)
            ->openAdd()
            ->whereNotIn('id', $arr)
            ->paginate($this->paginationNum);
        return view('app.relations-list', ['userList' => $users, 'action' => 'add-friend']);
    }

    public function addFriend($friendId)
    {
        if (!$this->currentUser()->isFriendable($friendId)) {
            return back()->withInput();
        }
        $this->currentUser()->addFriend($friendId);
        if ($this->currentUser()->isAddSuccess($friendId)) {
            return redirect()->route('relations.get_add_friend_list');
        }
        throw new ErrorException();
    }

    public function getRequests()
    {
        $requestRelations = $this->currentUser()->requestingRelations()
            ->wherePivot('type', 'request')
            ->get();
        $requestUsers = User::whereIn('id', $requestRelations->pluck(['id']))->paginate($this->paginationNum);
        return view('app.relations-list', ['userList' => $requestUsers, 'action' => 'requests']);
    }

    public function responseRequest($userId, Request $request)
    {
        $type = isset($request->type) ? strtolower($request->type) : '';
        $arr = ['accept', 'decline'];
        if (!in_array($type, $arr) || !$this->currentUser()->isRequestedBy($userId)) {
            throw new ErrorException();
        }
        $relation = $this->currentUser()->getRequestingRelation($userId);
        if ($relation == null) {
            throw new ErrorException();
        }
        if ($type == 'accept') {
            $relation->update([
                'type' => 'friend',
            ]);
        } else {
            $relation->delete();
        }
        return redirect(route('relations.get_requests'));
    }
}
