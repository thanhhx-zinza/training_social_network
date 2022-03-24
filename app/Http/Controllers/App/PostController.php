<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Exceptions\ErrorException;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\Storage;
use App\Traits\Post as TraitPost;

class PostController extends Controller
{
    use TraitPost;
    private $audiences = [];
    private $paginationNum = 0;
    private $levelParent = 1;

    public function __construct()
    {
        $this->middleware('verified');
        $this->audiences = Post::getAudiences();
        $settings = Valuestore::make(storage_path('app/settings.json'));
        $this->paginationNum = $settings->get('post_pagination', 0);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postList = $this->currentUser()->posts()->newestPosts()->paginate($this->paginationNum);
        if ($postList->count() > 0) {
            foreach ($postList as $row) {
                $row->audience = Post::getAudienceValue($row->audience);
            }
        }
        return view('app.post-read', [
            'posts' => $postList,
            'user' => $this->currentUser(),
            'paginationNum' => $this->paginationNum,
            'levelParent' => $this->levelParent
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
        if ($request->hasFile('images')) {
            $images = json_encode($this->storeImage($request->images), JSON_FORCE_OBJECT);
        }
        $this->currentUser()->posts()->create([
            'content' => $request->content,
            'audience' => $request->audience,
            'display' => 1,
            "images" => $images ?? ""
        ]);
        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        $post->audience = Post::getAudienceValue($post->audience);
        return view("app.detail-post", [
            'post' => $post,
            'user' => $this->currentUser(),
            'paginationNum' => $this->paginationNum,
            'levelParent' => $this->levelParent,
        ]);
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
        if ($request->hasFile('images') || count($request->preloaded) < count(json_decode($post->images, true))) {
            $imageOld = json_decode($post->images, true);
            if (!empty($imageOld)) {
                $images = $this->handleImageOld($request->images, $imageOld, $request->preloaded);
            } else {
                $images = json_encode($this->storeImage($request->images), JSON_FORCE_OBJECT);
            }
        } else {
            $images = $post->images;
        }
        $post->update([
            'content' => $request->content,
            'audience' => $request->audience,
            "images" => $images
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
        $images = json_decode($post->images);
        if (!empty($images)) {
            foreach ($images as $image) {
                Storage::delete('images-post/'.$image);
            }
        }
        $post->delete();
        return redirect(route("posts.index"));
    }

    /**
     * Display a listing of friends's posts
     *
     * @return \Illuminate\Http\Response
     */
    public function getFriendPosts()
    {
        $friendIds = $this->currentUser()->friends()->pluck(['id']);
        $friendPosts = Post::whereIn('user_id', $friendIds)
            ->isPublic()
            ->newestPosts()
            ->with(['profile', 'reactions'])
            ->paginate($this->paginationNum);
        if ($friendPosts->count() > 0) {
            foreach ($friendPosts as $row) {
                $row->audience = Post::getAudienceValue($row->audience);
            }
            return view('app.post.posts', ['posts' => $friendPosts]);
        }
        return response()->json(['message' => 'Max'], 200);
    }
}
