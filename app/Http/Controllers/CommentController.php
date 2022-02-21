<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = comment::create([
            'user_id' => Auth::User()->id,
            'post_id' => $request->post_id,
            'previous_id' => $request->previous_id,
            'content' => $request->content,
            'level' => $request->level
        ]);
        return redirect()->route('post.index');
    }

    public function edit(Request $request)
    {
        $postList = $this->currentUser()->posts()->newestPosts()->paginate(5);
        $commentEdit = comment::find($request->id);
        if ($postList != null) {
            foreach ($postList as $row) {
                $row->audience = Post::getAudienceValue($row->audience);
            }
            return view('app.post-read', [
                'posts' => $postList,
                'userName' => $this->currentUser()->name,
                'commentEdit' => $commentEdit,
                'edit' => true,
                'editRep' => false
            ]);
        } else {
            return redirect('error');
        }
    }
    public function editRep(Request $request)
    {
        $postList = $this->currentUser()->posts()->newestPosts()->paginate(5);
        $commentEdit = comment::find($request->id);
        if ($postList != null) {
            foreach ($postList as $row) {
                $row->audience = Post::getAudienceValue($row->audience);
            }
            return view('app.post-read', [
                'posts' => $postList,
                'userName' => $this->currentUser()->name,
                'commentEdit' => $commentEdit,
                'edit' => false,
                'editRep' => true
            ]);
        } else {
            return redirect('error');
        }
    }
    public function update(Request $request)
    {
        $comment = Comment::find($request->id);
        $comment->content = $request->content;
        if ($comment->save()) {
            return redirect()->route('post.index');
        }
    }
    public function destroy(Request $request)
    {
        $comment = Comment::find($request->id);
        if ($comment != null
            && $comment->user_id == $this->currentUser()->id
        ) {
            $comment->delete();
            return redirect(route("post.index"));
        } else {
            return redirect('error');
        }
    }
}
