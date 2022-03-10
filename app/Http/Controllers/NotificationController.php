<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificationController extends Controller
{
    protected $notices;
    protected $post;

    public function __construct(Post $post, Notification $notices)
    {
        $this->notices = $notices;
        $this->post = $post;
    }

    public function detailNotices($action, $id)
    {
        switch (strtolower($action)) {
            case "like":
                return $this->redirectToPostFromReaction($id);
            case "comment":
                return $this->redirectToPostFromComment($id);
            case "accept":
                return $this->redirectToMyFriends($id);
            case "require":
                return $this->redirectToRequireAddFriend($id);
            default:
                return redirect()->route("error");
        }
    }

    public function redirectToPostFromComment($id)
    {
        $markRead = $this->notices->getNotices($id);
        $post = $this->post->getPostIsExitComment($id);
        if (empty($post)) {
            return redirect()->back();
        }
        if (!empty($markRead->read_at)) {
            return redirect()->route("posts.show", ["post" => $post->id]);
        }
        $markRead->read_at = Carbon::now()->toDateTimeString();
        if ($markRead->save()) {
            return redirect()->route("posts.show", ["post" => $post->id]);
        }
        return redirect()->route("error");
    }

    public function redirectToPostFromReaction($id)
    {
        $markRead = $this->notices->getNotices($id);
        $post = $this->post->getPostIsExitReaction($id);
        if (empty($post)) {
            return redirect()->back();
        }
        if (!empty($markRead->read_at)) {
            return redirect()->route("posts.show", ["post" => $post->id]);
        }
        $markRead->read_at = Carbon::now()->toDateTimeString();
        if ($markRead->save()) {
            return redirect()->route("posts.show", ["post" => $post->id]);
        }
        return redirect()->route("error");
    }

    public function redirectToRequireAddFriend($id)
    {
        $markRead = $this->notices->getNotices($id);
        if (!empty($markRead->read_at)) {
            return redirect()->route("relations.get_requests");
        }
        $markRead->read_at = Carbon::now()->toDateTimeString();
        if ($markRead->save()) {
            return redirect()->route("relations.get_requests");
        }
        return redirect()->route("error");
    }

    public function redirectToMyFriends($id)
    {
        $markRead = $this->notices->getNotices($id);
        if (!empty($markRead->read_at)) {
            return redirect()->route("relations.myfriend");
        }
        $markRead->read_at = Carbon::now()->toDateTimeString();
        if ($markRead->save()) {
            return redirect()->route("relations.myfriend");
        }
        return redirect()->route("error");
    }
}
