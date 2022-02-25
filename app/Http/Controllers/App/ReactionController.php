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
        if ($request->type == 'like_post') {
            $reactions = Post::isPublic()->find($request->reaction_table_id)->reactions();
        } else {
            $reactions = Comment::find($request->reaction_table_id)->reactions();
        }
        $reactions = $reactions->likeUser($this->currentUser()->id)->get();
        if (count($reactions)) {
            return redirect()->route('error');
        }
        $reaction = $this->currentUser()->reactions()->create([
                'reactiontable_id' => $request->reaction_table_id,
                'reactiontable_type' => $request->reaction_table_type,
                'type' => $request->type
        ]);
        if (!$reaction) {
            return redirect()->route('error');
        }
        return redirect()->route('posts.index');
    }

    public function destroy(Request $request, $id)
    {
        if ($request->type == 'like_post') {
            $reactions = Post::isPublic()->find($request->reaction_table_id)->reactions();
        } else {
            $reactions = Comment::find($request->reaction_table_id)->reactions();
        }
        $reactions = $reactions->likeUser($this->currentUser()->id)->get();
        if (!count($reactions)) {
            return redirect()->route('error');
        }
        $id = $reactions[0]->id;
        $reaction = $this->currentUser()->reactions->find($id);
        if (!$reaction || !$reaction->delete()) {
            return redirect()->route('error');
        }
        return redirect()->route('posts.index');
    }
}
