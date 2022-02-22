<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $post_id = $this->currentUser()->posts->find($request->post_id)->id;
        $this->currentUser()->comments()->create([
            'post_id' => $post_id,
            'previous_id' => $request->previous_id,
            'content' => $request->content,
            'level' => $request->level
        ]);
        return redirect()->route('post.index');
    }

    public function edit($id)
    {
        $comment = $this->currentUser()->comments->find($id);
        return view('app.comment.edit', ['comment' => $comment]);
    }
    public function update(Request $request, $id)
    {
        $comment = $this->currentUser()->comments->find($id);
        $comment->content = $request->content;
        if ($comment->save()) {
            return redirect()->route('post.index');
        }
    }
    public function destroy($id)
    {
        $comment = $this->currentUser()->comments->find($id);
        if ($comment != null) {
            $comment->delete();
            return redirect(route("post.index"));
        } else {
            return redirect('error');
        }
    }
}
