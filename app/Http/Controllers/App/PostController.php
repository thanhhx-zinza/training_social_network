<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Exceptions\ErrorException;
use App\Models\Reaction;

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
        $postList = $this->currentUser()->posts()->newestPosts()->paginate(5);
        if ($postList->count() > 0) {
            foreach ($postList as $row) {
                $row->audience = Post::getAudienceValue($row->audience);
            }
        }
        return view('app.post-read', [
            'posts' => $postList,
            'user' => $this->currentUser(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.post-create-update', ['user' => $this->currentUser(), 'audiences' => $this->audiences]);
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
            throw new ErrorException();
        }
        $this->currentUser()->posts()->create([
            'content' => $request->content,
            'audience' => $request->audience,
            'display' => 1,
        ]);
        return redirect()->route('posts.index');
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
            'user' => $this->currentUser(),
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
            || $post->user_id !== $this->currentUser()->id
        ) {
            throw new ErrorException();
        }
        $post->update([
            'content' => $request->content,
            'audience' => $request->audience,
        ]);
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->user_id != $this->currentUser()->id) {
            throw new ErrorException();
        }
        $post->delete();
        return redirect(route("posts.index"));
    }
}
