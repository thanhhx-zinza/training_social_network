<?php

namespace App\Http\Controllers\App;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use \stdClass;

class PostController extends Controller
{
    private $audiences = [];

    public function __construct()
    {
        $this->audiences = Post::getAudiences();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postList = Post::where('display', '=', '1')
            ->where('users_id', '=', $this->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        $posts = [];
        if ($postList != null) {
            foreach ($postList as $row) {
                $k = new stdClass();
                $k->id = $row->id;
                $k->content = $row->content;
                $k->audience = Post::getAudienceValue($row->audience);
                $k->userName = $row->getUser->name;
                $posts[] = $k;
            }
            return view('app.post-read', ['posts' => $posts]);
        } else {
            return view('app.error');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.post-create-update', ['user' => $this->user(), 'audiences' => $this->audiences]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        if (!Post::checkAudience($request->audience)) {
            return redirect()->back()->withInput();
        }
        $post = new Post();
        $post->users_id = $this->user()->id;
        $post->content = $request->content;
        $post->audience = $request->audience;
        $post->display = 1;
        if ($post->save()) {
            return redirect(route('home.index'));
        } else {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('app.post-create-update', [
            'user' => $this->user(),
            'audiences' => $this->audiences,
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        if (!Post::checkAudience($request->audience)
            || $post->users_id !== $this->user()->id
        ) {
            return redirect()->back()->withInput();
        }
        $post->content = $request->content;
        $post->audience = $request->audience;
        if ($post->save()) {
            return redirect(route('post.index'));
        } else {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
