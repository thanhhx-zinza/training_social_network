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
        $post = Post::isPublic()->find($request->post_id);
        if ($request->post_id != -1 && !$post) {
            return redirect()->route('error');
        } elseif ($post) {
            $reaction = $post->reactions;
        } else {
            $reaction = Comment::find($request->comment_id)->reactions;
        }
        if (!count($reaction)) {
            $newReaction = $this->currentUser()->reactions()->create([
                'post_id' => $request->post_id,
                'type' => $request->type,
                'comment_id' => $request->comment_id,
            ]);
            if ($newReaction) {
                return redirect()->route('posts.index');
            } else {
                return redirect()->route('error');
            }
        } elseif ($request->type != $reaction[0]->type) {
            $reaction = $this->currentUser()->reactions->find($reaction[0]->id);
            if ($reaction) {
                $reaction->type = $request->type;
                $reaction->post_id = $request->post_id;
                $reaction->comment_id = $request->comment_id;
                if ($reaction->save()) {
                    return redirect()->route("posts.index");
                } else {
                    return redirect()->route('error');
                }
            } else {
                return redirect()->route('error');
            }
        } else {
            $reaction = $this->currentUser()->reactions->find($reaction[0]->id);
            if ($reaction && $reaction->delete()) {
                return redirect()->route("posts.index");
            } else {
                return redirect()->route('error');
            }
        }
    }

    public function update(Request $request, $id)
    {
        $reaction = $this->currentUser()->reactions->find($id);
        if ($reaction) {
            $reaction->type = $request->type;
            $reaction->post_id = $request->post_id;
            $reaction->comment_id = $request->comment_id;
            if ($reaction->save()) {
                return redirect()->route("posts.index");
            } else {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('error');
        }
    }

    public function destroy($id)
    {
        $reaction = $this->currentUser()->reactions->find($id);
        if ($reaction && $reaction->delete()) {
            return redirect()->route("posts.index");
        } else {
            return redirect()->route('error');
        }
    }
}
