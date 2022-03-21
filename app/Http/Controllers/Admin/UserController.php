<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Spatie\Valuestore\Valuestore;
use Illuminate\Http\Request;
use Hash;

class UserController extends AdminController
{
    private $paginationNum = 0;

    public function __contructor()
    {
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
        $users = User::orderBy("id", "DESC")->paginate($this->paginationNum);
        return view("admin.customer.index", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.customer.create-update");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($user->save()) {
            return redirect()->route("users.index");
        }
        return redirect()->back()->with("message", "Create new fails");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($user_id)
    {
        $user = User::find($user_id);
        if (!empty($user)) {
            return view("admin.customer.create-update", ["user" => $user]);
        }
        return redirect()->back()->with("message", "Can not found");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegisterRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($user->save()) {
            return redirect()->route("users.index");
        }
        return redirect()->back()->with("message", "Update fails");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return redirect()->back()->with("messageSuccess", "Delete successfully");
        }
        return redirect()->back()->with("message", "Delete fails");
    }
}
