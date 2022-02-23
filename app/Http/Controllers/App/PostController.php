<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;

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
        if ($postList != null) {
            foreach ($postList as $row) {
                $row->audience = Post::getAudienceValue($row->audience);
            }
            return view('app.post-read', [
                'posts' => $postList,
                'userName' => $this->currentUser()->name,
            ]);
        } else {
            return redirect('error');
        }
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
            return redirect()->back()->withInput();
        }
        $post = new Post();
        $post->user_id = $this->currentUser()->id;
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
    public function edit($id)
    {
        $post = Post::find($id);
        if ($post != null) {
            return view('app.post-create-update', [
                'user' => $this->currentUser(),
                'audiences' => $this->audiences,
                'post' => $post
            ]);
        } else {
            return redirect('error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        if ($post != null) {
            if (!Post::checkAudience($request->audience)
                || $post->user_id !== $this->currentUser()->id
            ) {
                return redirect()->back()->withInput();
            }
            $post->content = $request->content;
            $post->audience = $request->audience;
            if ($post->save()) {
                return redirect(route('posts.index'));
            } else {
                return redirect()->back()->withInput();
            }
        } else {
            return redirect('error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post != null
            && $post->user_id == $this->currentUser()->id
        ) {
            $post->delete();
            return redirect(route("posts.index"));
        } else {
            return redirect('error');
        }
    }
}
