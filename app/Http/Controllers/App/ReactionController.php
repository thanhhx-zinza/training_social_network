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
        $reaction = $this->currentUser()->reactions()->findOrFail($id);
        $reaction->delete();
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
