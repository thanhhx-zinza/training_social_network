<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;

class CustomerPostController extends Controller
{
    private $paginationNum = 0;

    public function __construct()
    {
        $this->audiences = Post::getAudiences();
        $settings = Valuestore::make(storage_path('app/settings.json'));
        $this->paginationNum = $settings->get('post_pagination', 0);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $postList = User::find($id)->posts()->newestPosts()->paginate($this->paginationNum);
        if ($postList->count() > 0) {
            foreach ($postList as $row) {
                $row->audience = Post::getAudienceValue($row->audience);
            }
        }
        return view('admin.customer.list-post', [
            'posts' => $postList,
            'paginationNum' => $this->paginationNum,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
