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
        return view('app.comment', [
        'post' => $post,
                                    'user' => $this->currentUser(),
        ]);
    }

    public function edit($post_id, $comment_id)
    {
        $comment = $this->currentUser()->comments->find($comment_id);
        $post = Post::find($post_id);
        return view('app.comment.edit', ['comment' => $comment, 'post' => $post]);
    }

    public function update(CommentRequest $request, $post_id, $comment_id)
    {
        $comment = $this->currentUser()->comments->find($comment_id);
        $comment->content = $request->content;
        $comment->save();
        $post = Post::find($post_id);
        return view('app.comment', [
        'post' => $post,
                                    'user' => $this->currentUser(),
        ]);
    }

    public function destroy($post_id, $comment_id)
    {
        $post = Post::isPublic()->find($post_id);
        $comment = $this->currentUser()->comments->find($comment_id);
        $comment->delete();
        return view('app.comment', [
        'post' => $post,
                                    'user' => $this->currentUser(),
        ]);
    }
}
