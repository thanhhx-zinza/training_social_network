<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Relation;
use App\Models\User;
use Illuminate\Http\Request;

class RelationController extends Controller
{
    /**
     * Display a listing of user who are not friend
     *
     */
    public function getAddFriend()
    {
        $relations = $this->currentUser()->relations()->select('friend_id')->get();
        $addFriendUsers = [];
        if (count($relations) == 0) {
            $addFriendUsers = User::where('id', '!=', $this->currentUser()->id)
                ->where('is_added', 1)
                ->paginate(9);
        } elseif (count($relations) > 0) {
            $addFriendUsers = User::where('id', '!=', $this->currentUser()->id)
                ->where('is_added', 1)
                ->whereNotIn('id', $relations)
                ->paginate(9);
        }
        if ($addFriendUsers != null) {
            return view('app.relations-list', ['userList' => $addFriendUsers, 'action' => 'add-friend']);
        } else {
            return redirect('error');
        }
    }

    /**
     * Add friend
     *
     */
    public function addFriend($friendId)
    {
        User::checkExistUser($friendId);
        $userRelation = new Relation();
        $userRelation->user_id = $this->currentUser()->id;
        $userRelation->friend_id = $friendId;
        $userRelation->type_user = 'request';
        $userRelation->type_friend = 'response';
        if ($userRelation->save()) {
            return redirect(route('relations.get_add_friend'));
        } else {
            return redirect('error');
        }
    }

    /**
     * Get add friend requests
     */
    public function getRequests()
    {
        $relations = Relation::where('friend_id', $this->currentUser()->id)
            ->select('user_id')
            ->where('type_friend', 'response')
            ->where('type_user', 'request')
            ->paginate(9);
        $requestUsers = [];
        if (count($relations) > 0) {
            $requestUsers = User::where('id', '!=', $this->currentUser()->id)
                ->whereIn('id', $relations)
                ->paginate(9);
        }
        if ($requestUsers != null) {
            return view('app.relations-list', ['userList' => $requestUsers, 'action' => 'requests']);
        } else {
            return redirect('error');
        }
    }

    public function responseRequest($user_id, Request $request)
    {
        $type = isset($request->type) ? strtolower($request->type) : '';
        $arr = ['accept', 'decline'];
        if ($type !== '' && in_array($type, $arr)) {
            $relations = Relation::where('user_id', $user_id)
                ->where('friend_id', $this->currentUser()->id)
                ->firstOrFail();
            $relations->type_user = ($type == 'accept') ? 'friend' : 'follow';
            $relations->type_friend = ($type == 'accept') ? 'friend' : 'decline';
            if ($relations->save()) {
                return redirect(route('relations.get_requests'));
            } else {
                return redirect('error');
            }
        } else {
            return redirect('error');
        }
    }
}
