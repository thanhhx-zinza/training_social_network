<?php

namespace App\Observers;

use App\Models\Relation;
use App\Notifications\NotificationFeedBackAddFriend;
use Auth;
use App\Observers\Observer;

class FriendObserve extends Observer
{
    /**
     * Handle the Relation "created" event.
     *
     * @param  \App\Models\Relation  $relation
     * @return void
     */
    public function created(Relation $relation)
    {
        if ($this->checkSettingNotifi()) {
            $relation->notification()->create([
                'action' => "require",
                'users_id_to' => Auth::id(),
                "data" => Auth::user()->name." just send addfriend",
                'user_id_from' => $relation->friend_id,
                "notiable_id" => $relation->id,
            ]);
        }

       // $relation->notify(new NotificationFeedBackAddFriend($relation));
    }

    public function saved(Relation $relation)
    {
        $relation->typeNoti = "accept";
        $relation->notify(new NotificationFeedBackAddFriend($relation));
    }
    /**
     * Handle the Relation "updated" event.
     *
     * @param  \App\Models\Relation  $relation
     * @return void
     */
    public function updated(Relation $relation)
    {
        //
    }

    /**
     * Handle the Relation "deleted" event.
     *
     * @param  \App\Models\Relation  $relation
     * @return void
     */
    public function deleted(Relation $relation)
    {
        $relation->typeNoti = 'reject';
        $relation->notify(new NotificationFeedBackAddFriend($relation));
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
