<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Post;
use App\Models\User;
use Spatie\Valuestore\Valuestore;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Exceptions\ErrorException;
use App\Traits\Post as TraitPost;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class PostController extends BaseAdminController
{
    use TraitPost;
    private $paginationNum = 0;

    public function __construct()
    {
        $this->audiences = Post::getAudiences();
        $settings = Valuestore::make(storage_path('app/settings.json'));
        $this->paginationNum = $settings->get('post_pagination', 0);
        $this->middleware('checkPermission:posts_list', ['only' => ['index']]);
        $this->middleware('checkPermission:posts_add', ['only' => ['create', 'store']]);
        $this->middleware('checkPermission:posts_edit', ['only' => ['edit', 'update']]);
        $this->middleware('checkPermission:posts_delete', ['only' => ['destroy']]);
    }

    public function index($user_id)
    {
        $user = User::find($user_id);
        if (empty($user)) {
            return redirect()->route("error.404");
        }
        $postList = $user->posts()->newestPosts()->paginate($this->paginationNum);
        if ($postList->count() > 0) {
            foreach ($postList as $row) {
                $row->audience = Post::getAudienceValue($row->audience);
            }
        }
        return view('admin.posts.list-post', [
            'posts' => $postList,
            'paginationNum' => $this->paginationNum,
            "user" => $user,
        ]);
    }

    public function edit($user_id, $post_id)
    {
        return view('admin.posts.edit', [
            'user' => !empty(User::find($user_id)) ? User::find($user_id) : "",
            'audiences' => $this->audiences,
            'post' => !empty(Post::find($post_id)) ? Post::find($post_id) : "",
        ]);
    }

    public function update(PostRequest $request, User $user, Post $post)
    {
        if (!Post::checkAudience($request->audience)
            || $post->user_id !== $user->id
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
        return redirect()->route('users.posts.index', ["user" => $user->id]);
    }

    public function destroy(User $user, Post $post)
    {
        if ($post->user_id != $user->id) {
            throw new ErrorException();
        }
        $images = json_decode($post->images);
        if (!empty($images)) {
            foreach ($images as $image) {
                Storage::delete('images-post/'.$image);
            }
        }
        $post->delete();
        return redirect()->route('users.posts.index', ["user" => $user->id]);
    }
}
