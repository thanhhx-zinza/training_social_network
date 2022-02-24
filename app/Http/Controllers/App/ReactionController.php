<?php

namespace App\Http\Controllers\App;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Reaction;

class ReactionController extends Controller
{
    public function store(Request $request)
    {
        $post = Post::find($request->post_id);
        $comment = Post::find($request->comment_id);
        if ($request->post_id != -1) {
            $reactions = $post->reactions();
        } else {
            $reactions = $comment->reactions();
        }
        $reactions = $reactions->UserLiked($this->currentUser()->id)->get();
        if (count($reactions)) {
            return redirect()->route('error');
        } else {
            $reaction = $this->currentUser()->reactions()->create([
                'post_id' => $request->post_id,
                'type' => $request->type,
                'comment_id' => $request->comment_id,
            ]);
            if ($reaction) {
                return redirect()->route('posts.index');
            } else {
                return redirect()->route('error');
            }
        }
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::find($request->post_id);
        $comment = Post::find($request->comment_id);
        if ($request->post_id != -1) {
            $reactions = $post->reactions();
        } else {
            $reactions = $comment->reactions();
        }
        $reactions = $reactions->UserLiked($this->currentUser()->id)->get();
        if (count($reactions)) {
            $id = $reactions[0]->id;
            $reaction = $this->currentUser()->reactions->find($id);
            if ($reaction && $reaction->delete()) {
                return redirect()->route("posts.index");
            } else {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('error');
        }
    }
}
