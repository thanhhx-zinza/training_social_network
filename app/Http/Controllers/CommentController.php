<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $post_id)
    {
        $post = Post::isPublic()->find($post_id);
        if ($post) {
            $newComment = $this->currentUser()->comments()->create([
                'post_id' => $post->id,
                'previous_id' => $request->previous_id,
                'content' => $request->content,
                'level' => $request->level
            ]);
            if ($newComment) {
                return redirect()->route('posts.index');
            } else {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('error');
        }
    }

    public function edit($post_id, $comment_id)
    {
        $comment = $this->currentUser()->comments->find($comment_id);
        if ($comment) {
            $post = Post::find($post_id);
            return view('app.comment.edit', ['comment' => $comment, 'post' => $post]);
        } else {
            return redirect()->route('error');
        }
    }

    public function update(Request $request, $comment_id)
    {
        $comment = $this->currentUser()->comments->find($comment_id);
        if ($comment) {
            $comment->content = $request->content;
            if ($comment->save()) {
                return redirect()->route('posts.index');
            } else {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('error');
        }
    }

    public function destroy($comment_id)
    {
        $comment = $this->currentUser()->comments->find($comment_id);
        if ($comment && $comment->delete()) {
            return redirect()->route("posts.index");
        } else {
            return redirect()->route('error');
        }
    }
}
