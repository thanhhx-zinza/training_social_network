<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $post = Post::publicPost()->find($request->post_id);
        if ($post) {
            $newComment = $this->currentUser()->comments()->create([
                'post_id' => $post->id,
                'previous_id' => $request->previous_id,
                'content' => $request->content,
                'level' => $request->level
            ]);
            if ($newComment) {
                return redirect()->route('post.index');
            } else {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('error');
        }
    }

    public function edit($id)
    {
        $comment = $this->currentUser()->comments->find($id);
        if ($comment) {
            return view('app.comment.edit', ['comment' => $comment]);
        } else {
            return redirect()->route('error');
        }
    }

    public function update(Request $request, $id)
    {
        $comment = $this->currentUser()->comments->find($id);
        $comment->content = $request->content;
        if ($comment) {
            if ($comment->save()) {
                return redirect()->route('post.index');
            } else {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('error');
        }
    }

    public function destroy($id)
    {
        $comment = $this->currentUser()->comments->find($id);
        if ($comment) {
            if ($comment->delete()) {
                return redirect(route("post.index"));
            } else {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('error');
        }
    }
}
