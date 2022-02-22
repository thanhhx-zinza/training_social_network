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
        $unableAddFriendRelations = $this->currentUser()
            ->relations()
            ->unableAddFriendRelations()
            ->select('friend_id')
            ->get();
        if ($unableAddFriendRelations != null) {
            $ableAddFriendUsers = User::ableAddFriendUsers($this->currentUser()->id);
            if (count($unableAddFriendRelations) == 0) {
                $ableAddFriendUsers = $ableAddFriendUsers->paginate(9);
            } elseif (count($unableAddFriendRelations) > 0) {
                $ableAddFriendUsers = $ableAddFriendUsers->whereNotIn('id', $unableAddFriendRelations)->paginate(9);
            } else {
                return redirect('error');
            }
            if ($ableAddFriendUsers != null) {
                return view('app.relations-list', ['userList' => $ableAddFriendUsers, 'action' => 'add-friend']);
            }
            return redirect('error');
        }
        return redirect('error');
    }

    public function addFriend($friendId)
    {
        if (User::checkAbleAddFriend($friendId, $this->currentUser())) {
            $userRelation = $this->currentUser()->relations()->create([
                'friend_id' => $friendId,
                'type_user' => 'request',
                'type_friend' => 'response'
            ]);
            if ($userRelation) {
                return redirect(route('relations.get_add_friend'));
            }
            return redirect('error');
        }
        return redirect()->back();
    }

    public function getRequests()
    {
        $requestRelations = $this->currentUser()->relationsFriend()
            ->getRequestRelations()
            ->select('user_id')
            ->get();
        if ($requestRelations != null) {
            $requestUsers = [];
            if (count($requestRelations) >= 0) {
                $requestUsers = User::whereIn('id', $requestRelations)->paginate(9);
            } elseif (count($requestRelations) < 0) {
                return redirect('error');
            }
            if ($requestUsers != null) {
                return view('app.relations-list', ['userList' => $requestUsers, 'action' => 'requests']);
            }
            return redirect('error');
        }
        return redirect('error');
    }

    public function responseRequest($user_id, Request $request)
    {
        $type = isset($request->type) ? strtolower($request->type) : '';
        $arr = ['accept', 'decline'];
        if ($type !== ''
            && in_array($type, $arr)
            && User::checkExistUser($user_id) != null
        ) {
            $relations = $this->currentUser()->relationsFriend()->where('user_id', $user_id)->first();
            if ($relations != null) {
                $relations->type_user = ($type == 'accept') ? 'friend' : 'follow';
                $relations->type_friend = ($type == 'accept') ? 'friend' : 'decline';
                if ($relations->save()) {
                    return redirect(route('relations.get_requests'));
                }
                return redirect('error');
            }
            return redirect('error');
        }
        return redirect('error');
    }
}
