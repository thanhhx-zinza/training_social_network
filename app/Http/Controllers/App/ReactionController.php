<?php

namespace App\Http\Controllers\App;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Exceptions\ErrorException;
use App\Models\Reaction;

class ReactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function store(Request $request)
    {
        $type = ['App\Models\Post', 'App\Models\Comment'];
        if (!in_array($request->reaction_table_type, $type)) {
            throw new ErrorException();
        }
        if ($request->reaction_table_type == 'App\Models\Post') {
            $reactions = Post::isPublic()->findOrFail($request->reaction_table_id)->reactions();
        } else {
            $reactions = Comment::findOrFail($request->reaction_table_id)->reactions();
        }
        $reactions = $reactions->likeUser($this->currentUser()->id)->get();
        if ($reactions->count()) {
            throw new ErrorException();
        }
        $this->currentUser()->reactions()->create([
            'reactiontable_id' => $request->reaction_table_id,
            'reactiontable_type' => $request->reaction_table_type,
            'type' => $request->type,
        ]);
        $reactions = Reaction::getReactions($request->reaction_table_id, $request->reaction_table_type);
        return view('app.reaction', [
            'reactions' => $reactions,
            'user' => $this->currentUser(),
            'id' => $request->name,
            'reaction_table_id' => $request->reaction_table_id,
            'reaction_table_type' => $request->reaction_table_type,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $type = ['App\Models\Post', 'App\Models\Comment'];
        if (!in_array($request->reaction_table_type, $type)) {
            throw new ErrorException();
        }
        if ($request->reaction_table_type == 'App\Models\Post') {
            $reactions = Post::isPublic()->findOrFail($request->reaction_table_id)->reactions();
        } else {
            $reactions = Comment::findOrFail($request->reaction_table_id)->reactions();
        }
        $reactions = $reactions->likeUser($this->currentUser()->id)->get();
        if (!count($reactions)) {
            throw new ErrorException();
        }
        $id = $reactions[0]->id;
        $reaction = $this->currentUser()->reactions()->findOrFail($id);
        if (!$reaction->delete()) {
            throw new ErrorException();
        }
        $reactions = Reaction::getReactions($request->reaction_table_id, $request->reaction_table_type);
        return view('app.reaction', [
            'reactions' => $reactions,
            'user' => $this->currentUser(),
            'id' => $request->name,
            'reaction_table_id' => $request->reaction_table_id,
            'reaction_table_type' => $request->reaction_table_type,
        ]);
    }
}
