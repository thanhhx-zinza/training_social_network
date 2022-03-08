<?php
 
namespace App\Http\ViewComposers;

use App\Models\Post;
use Illuminate\View\View;
use Auth;

class NotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $notifications = Auth::user()->notifications()->get();
            $post = new Post();
            foreach ($notifications as $noti) {
                $noti->idPost = "";
                if ($noti->action == "comment") {
                    $detailPost = $post->getPostIsExitComment($noti->notifiable_id);
                    if (!empty($detailPost)) {
                        $noti->idPost = $detailPost;
                    }
                } elseif ($noti->action == "like") {
                    $detailPost = $post->getPostIsExitReaction($noti->notifiable_id);
                    if (!empty($detailPost)) {
                        $noti->idPost = $detailPost;
                    }
                }
            }
            $view->with('notifications', $notifications);
        }
    }
}
