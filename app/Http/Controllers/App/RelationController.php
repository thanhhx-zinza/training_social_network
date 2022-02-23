<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Relation;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;

class RelationController extends Controller
{
    private $paginationNum = 0;

    public function __construct()
    {
        $settings = Valuestore::make(storage_path('app/settings.json'));
        $this->paginationNum = $settings->get('relation_pagination');
        if ($this->paginationNum == null) {
            $this->paginationNum = 0;
        }
    }
    /**
     * Display a listing of user who are not friend
     *
     */
    public function getAddFriendList()
    {
        $requestedRelations = $this->currentUser()->relations()
            ->typeNotFriendable()
            ->select('friend_id')
            ->get();
        $requestingRelations = $this->currentUser()->relationsFriend()
            ->typeNotFriendable()
            ->select('user_id')
            ->get();
        $users = User::friendable($this->currentUser()->id);
        $requestedLength = count($requestedRelations);
        $requestingLength = count($requestingRelations);

        if ($requestedLength == 0 && $requestingLength == 0) {
            $users = $users->paginate($this->paginationNum);
        } elseif ($requestedLength == 0 || $requestingLength == 0) {
            if ($requestingLength == 0) {
                $users = $users->whereNotIn('id', $requestedRelations)->paginate($this->paginationNum);
            } else {
                $users = $users->whereNotIn('id', $requestingRelations)->paginate($this->paginationNum);
            }
        } else {
            $arr = array_merge($requestedRelations, $requestingRelations);
            $users = $users->whereNotIn('id', $arr)->paginate($this->paginationNum);
        }

        if (count($users) >= 0) {
            return view('app.relations-list', ['userList' => $users, 'action' => 'add-friend']);
        }
        return redirect('error');
    }

    public function addFriend($friendId)
    {
        if ($this->currentUser()->isFriendable($friendId)) {
            $userRelation = $this->currentUser()->relations()->create([
                'friend_id' => $friendId,
                'type' => 'request'
            ]);
            if ($userRelation) {
                return redirect(route('relations.get_add_friend_list'));
            }
            return redirect('error');
        }
        return redirect()->back();
    }

    public function getRequests()
    {
        $requestRelations = $this->currentUser()->relationsFriend()
            ->typeRequest()
            ->select('user_id')
            ->get();
        $requestUsers = [];
        if (count($requestRelations) >= 0) {
            $requestUsers = User::whereIn('id', $requestRelations)->paginate($this->paginationNum);
        } else {
            return redirect('error');
        }
        if (count($requestUsers) >= 0) {
            return view('app.relations-list', ['userList' => $requestUsers, 'action' => 'requests']);
        }
        return redirect('error');
    }

    public function responseRequest($user_id, Request $request)
    {
        $type = isset($request->type) ? strtolower($request->type) : '';
        $arr = ['accept', 'decline'];
        if (in_array($type, $arr) && User::isExistUser($user_id) != null) {
            $relations = $this->currentUser()->relationsFriend()->where('user_id', $user_id)->first();
            if ($relations != null) {
                if ($type == 'accept') {
                    $relations->type = 'friend';
                    if ($relations->save()) {
                        return redirect(route('relations.get_requests'));
                    }
                    return redirect('error');
                } else {
                    if ($relations->delete()) {
                        return redirect(route('relations.get_requests'));
                    }
                    return redirect('error');
                }
            }
            return redirect('error');
        }
        return redirect('error');
    }
}
