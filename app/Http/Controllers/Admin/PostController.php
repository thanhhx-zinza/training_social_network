<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;

class PostController extends AdminController
{
    private $paginationNum = 0;

    public function __construct()
    {
        $this->audiences = Post::getAudiences();
        $settings = Valuestore::make(storage_path('app/settings.json'));
        $this->paginationNum = $settings->get('post_pagination', 0);
    }

    public function index($user_id)
    {
        $postList = User::find($user_id)->posts()->newestPosts()->paginate($this->paginationNum);
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
}
