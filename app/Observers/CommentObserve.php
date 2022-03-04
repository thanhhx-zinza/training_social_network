<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\Post;
use App\Observers\Observer;
use App\Notifications\NotificationComment;
use Auth;
class CommentObserve extends Observer
{
    /**
     * Handle the Comment "created" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        if ($this->checkSettingNotifi()) {
            $idUserFrom = Post::find($comment->post_id)->user_id;
            $comment->notification()->create([
                'users_id_to' => Auth::id(),
                'user_id_from'=> $idUserFrom,
                "action" => "comment",
                "data" => Auth::user()->name." just comment post for you with ".$comment->content,
            ]);
        }
    }

    /**
     * Handle the Comment "updated" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "restored" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }
}
