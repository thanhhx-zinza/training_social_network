<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Jobs\GetPointPost;
use App\Models\Post;
use Spatie\Valuestore\Valuestore;

class CommentController extends Controller
{
    private $paginationNum = 0;
    private $levelParent = 1;

    public function __construct()
    {
        $settings = Valuestore::make(storage_path('app/settings.json'));
        $this->paginationNum = $settings->get('post_pagination', 0);
    }

    public function store(CommentRequest $request, $post_id)
    {
        $post = Post::isPublic()->findOrFail($post_id);
        $newComment = $this->currentUser()->comments()->create([
            'post_id' => $post->id,
            'previous_id' => $request->previous_id,
            'content' => $request->content,
            'level' => $request->level
        ]);
        if (!$newComment) {
            throw new ErrorException();
        }
        GetPointPost::dispatch($post_id, 'comment');
        return view('app.comment', [
            'post' => $post,
            'user' => $this->currentUser(),
            'paginationNum' => $this->paginationNum,
            'levelParent' => $this->levelParent
        ]);
    }

    public function edit($post_id, $comment_id)
    {
        $comment = $this->currentUser()->comments()->findOrFail($comment_id);
        $post = Post::isPublic()->findOrFail($post_id);
        return view('app.comment.edit', [
            'comment' => $comment,
            'post' => $post
        ]);
    }

    public function update(CommentRequest $request, $post_id, $comment_id)
    {
        $comment = $this->currentUser()->comments()->findOrFail($comment_id);
        $comment->content = $request->content;
        if (!($comment->save())) {
            throw new ErrorException();
        }
        $post = Post::isPublic()->findOrFail($post_id);
        return view('app.comment', [
            'post' => $post,
            'user' => $this->currentUser(),
            'paginationNum' => $this->paginationNum,
            'levelParent' => $this->levelParent
        ]);
    }

    public function destroy($post_id, $comment_id)
    {
        $post = Post::isPublic()->findOrFail($post_id);
        $comment = $this->currentUser()->comments()->findOrFail($comment_id);
        $comment->delete();
        return view('app.comment', [
            'post' => $post,
            'user' => $this->currentUser(),
            'paginationNum' => $this->paginationNum,
            'levelParent' => $this->levelParent
        ]);
    }
}
