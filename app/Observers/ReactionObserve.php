<?php

namespace App\Observers;

use App\Models\Reaction;
use App\Models\User;
use Auth;

class ReactionObserve
{
    protected $user;
    function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Handle the Reaction "created" event.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return void
     */
    public function saved(Reaction $reaction)
    {
        $userRequest = $this->user->find($reaction->user_id);
        if (!$userRequest) return;
        $isNoti = $userRequest->setting()->get()->toArray();
        if ($isNoti[0]['is_noti'] == 1) {
            $reaction->notification()->create([
                'users_id_to' => Auth::id(),
                'user_id_from' => $reaction->user_id,
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
