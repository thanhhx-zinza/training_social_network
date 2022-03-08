<?php

namespace App\Observers;

use App\Models\Relation;
use App\Models\User;
use App\Notifications\NotificationFeedBackAddFriend;
use Auth;

class FriendObserve
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Handle the Relation "created" event.
     *
     * @param  \App\Models\Relation  $relation
     * @return void
     */
    public function created(Relation $relation)
    {
        $userRequest = $this->user->find($relation->friend_id);
        $relation->id = $relation->getIdRequestAddFriend();
        if (empty($userRequest)) {
            return;
        }
        $isNoti = $userRequest->setting()->first();
        if ($isNoti->is_noti != 1) {
            return;
        }
        $relation->notification()->create([
            'action' => "require",
            'users_id_to' => Auth::id(),
            "data" => Auth::user()->name." just send addfriend",
            'user_id_from' => $relation->friend_id,
            "notifiable_id" => $relation->getIdRequestAddFriend(),
        ]);
    }

    public function updated(Relation $relation)
    {
        $userRequest = $this->user->find($relation->user_id);
        $relation->id = $relation->getIdRequestAddFriend();
        if (empty($userRequest)) {
            return;
        }
        $isNoti = $userRequest->setting()->first();
        if ($isNoti->is_noti != 1) {
            return;
        }
        if ($relation->isDirty('type')) {
            $relation->notification()->create([
            'action' => "accept",
            "data" => Auth::user()->name." just accept addfriend",
            'users_id_to' => Auth::id(),
            'user_id_from' => $relation->user_id,
            "notifiable_id" => $relation->getIdRequestAddFriend(),
            ]);
        }
    }
    /**
     * Handle the Relation "deleted" event.
     *
     * @param  \App\Models\Relation  $relation
     * @return void
     */
    public function deleted(Relation $relation)
    {
        $userRequest = $this->user->find($relation->user_id);
        $relation->id = $relation->getIdRequestAddFriend();
        if (empty($userRequest)) {
            return;
        }
        $isNoti = $userRequest->setting()->first();
        if ($isNoti->is_noti != 1) {
            return;
        }
        $relation->id = $relation->getIdRequestAddFriend();
        $relation->notification()->create([
        'action' => "reject",
        "data" => Auth::user()->name." just reject addfriend",
        'users_id_to' => Auth::id(),
        'user_id_from' => $relation->user_id,
        "notifiable_id" => $relation->getIdRequestAddFriend(),
        ]);
    }
    /**
     * Handle the Relation "restored" event.
     *
     * @param  \App\Models\Relation  $relation
     * @return void
     */
    public function restored(Relation $relation)
    {
        //
    }

    /**
     * Handle the Relation "force deleted" event.
     *
     * @param  \App\Models\Relation  $relation
     * @return void
     */
    public function forceDeleted(Relation $relation)
    {
        //
    }
}
