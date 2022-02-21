<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Auth::User()->post->first();
        $comment = $post->comment;
        $edit = false;
        return view ('app.comment', [
            'post' => $post, 
            'comment' => $comment,
            'edit' => $edit
        ]);
    }

    public function indexHome()
    {
        $post = Post::all();
        return view ('app.commentHome', ['post' => $post]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = comment::create([
            'user_id' => Auth::User()->id,
            'post_id' => $request->post_id,
            'content' => $request->content
        ]);
        return redirect()->route('comment.index', ['comment' => $comment]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $commentEdit = comment::find($request->id);
        $post = Auth::User()->post->first();
        $comment = $post->comment;
        $edit = true;
        return view ('app.comment', [
            'post' => $post, 
            'comment' => $comment,
            'commentEdit' => $commentEdit,
            'edit' => $edit
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $comment = Comment::find($request->id);
        $comment->content = $request->content;
        if ($comment->save()) {
            return redirect()->route('comment.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
