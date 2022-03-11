<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NoticesController extends Controller
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Notification $notices, $id)
    {
        $markRead = $notices->getNotices($id);
        if (empty($markRead)) {
            return redirect()->route("error");
        }
        switch ($markRead->notifiable_type) {
            case "App\Models\Comment":
                $post = $this->post->getPostIsExitComment($id);
                $redirect = "posts/".$post->id;
                return $this->redirectToNoticesDetail($markRead, $redirect);
            case "App\Models\Reaction":
                $post = $this->post->getPostIsExitReaction($id);
                $redirect = "posts/".$post->id;
                return $this->redirectToNoticesDetail($markRead, $redirect);
            case "App\Models\Relation":
                if ($markRead->action == "require") {
                    $redirect = "/relations/requests";
                } elseif ($markRead->action == "accept") {
                    $redirect = "/relations/myfriend";
                } else {
                    $redirect = "/";
                }
                return $this->redirectToNoticesDetail($markRead, $redirect);
            default:
                return redirect()->route("error");
        }
    }

    private function redirectToNoticesDetail($markRead, $redirect)
    {
        if (!empty($markRead->read_at)) {
            return redirect($redirect);
        }
        $markRead->read_at = Carbon::now()->toDateTimeString();
        if ($markRead->save()) {
            return redirect($redirect);
        }
        return redirect()->route("error");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
