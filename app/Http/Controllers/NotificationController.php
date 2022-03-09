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
            case "comment":
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
            case "accept":
                $markRead = $this->notices->getNotices($id);
                if (!empty($markRead->read_at)) {
                    return redirect()->route("relations.myfriend");
                }
                $markRead->read_at = Carbon::now()->toDateTimeString();
                if ($markRead->save()) {
                    return redirect()->route("relations.myfriend");
                }
                return redirect()->route("error");
            case "require":
                $markRead = $this->notices->getNotices($id);
                if (!empty($markRead->read_at)) {
                    return redirect()->route("relations.get_requests");
                }
                $markRead->read_at = Carbon::now()->toDateTimeString();
                if ($markRead->save()) {
                    return redirect()->route("relations.get_requests");
                }
                return redirect()->route("error");
            default:
                return redirect()->route("error");
        }
    }
}
