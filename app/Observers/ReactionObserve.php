<?php

namespace App\Observers;

use App\Observers\Observer;
use App\Models\Reaction;
use Auth;
class ReactionObserve extends Observer
{
    /**
     * Handle the Reaction "created" event.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return void
     */
    public function created(Reaction $reaction)
    {
        if ($this->checkSettingNotifi()) {
            $reaction->notification()->create([
                'users_id_to' => Auth::id(),
                'user_id_from'=> $reaction->user_id,
                "action" => $reaction->type,
                "data" => Auth::user()->name." just like you ",
            ]);
        }
    }
    /**
     * Handle the Reaction "updated" event.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return void
     */
    public function updated(Reaction $reaction)
    {
        //
    }

    /**
     * Handle the Reaction "deleted" event.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return void
     */
    public function deleted(Reaction $reaction)
    {
        //
    }

    /**
     * Handle the Reaction "restored" event.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return void
     */
    public function restored(Reaction $reaction)
    {
        //
    }

    /**
     * Handle the Reaction "force deleted" event.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return void
     */
    public function forceDeleted(Reaction $reaction)
    {
        //
    }
}
