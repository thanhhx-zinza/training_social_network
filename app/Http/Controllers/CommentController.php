<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $post_id)
    {
        $post = Post::isPublic()->find($post_id);
        if (!$post) {
            return redirect()->route('error');
        }
        $newComment = $this->currentUser()->comments()->create([
            'post_id' => $post->id,
            'previous_id' => $request->previous_id,
            'content' => $request->content,
            'level' => $request->level
        ]);
        if (!$newComment) {
            return redirect()->route('error');
        }
        return redirect()->route('posts.index');
    }

    public function edit($post_id, $comment_id)
    {
        $comment = $this->currentUser()->comments->find($comment_id);
        if (!$comment) {
            return redirect()->route('error');
        }
        $post = Post::find($post_id);
        return view('app.comment.edit', ['comment' => $comment, 'post' => $post]);
    }

    public function update(CommentRequest $request, $post_id, $comment_id)
    {
        $post = Post::isPublic()->find($post_id);
        if (!$post) {
            return redirect()->route('error');
        }
        $comment = $this->currentUser()->comments->find($comment_id);
        if (!$comment) {
            return redirect()->route('error');
        }
        $comment->content = $request->content;
        if (!$comment->save()) {
            return redirect()->route('error');
        }
        return redirect()->route('posts.index');
    }

    public function destroy($post_id, $comment_id)
    {
        $post = Post::isPublic()->find($post_id);
        if (!$post) {
            return redirect()->route('error');
        }
        $comment = $this->currentUser()->comments->find($comment_id);
        if (!$comment || !$comment->delete()) {
            return redirect()->route('error');
        }
        return redirect()->route("posts.index");
    }
}
