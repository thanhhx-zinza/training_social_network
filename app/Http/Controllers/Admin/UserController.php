<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Spatie\Valuestore\Valuestore;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Gate;

class UserController extends BaseAdminController
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
        if (Gate::forUser($this->currentAdmin())->allows('users-list')) {
            $users = User::orderBy("id", "DESC")->paginate($this->paginationNum);
            return view("admin.customer.index", compact("users"));
        }
        return abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::forUser($this->currentAdmin())->allows('users-add')) {
            return view("admin.customer.create-update");
        }
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        if (Gate::forUser($this->currentAdmin())->allows('users-add')) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            if ($user->save()) {
                return redirect()->route("users.index");
            }
            return redirect()->back()->with("message", "Create new fails");
        }
        return abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($user_id)
    {
        if (Gate::forUser($this->currentAdmin())->allows('users-edit')) {
            $user = User::find($user_id);
            if (!empty($user)) {
                return view("admin.customer.create-update", ["user" => $user]);
            }
            return redirect()->back()->with("message", "Can not found");
        }
        return abort(403);
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
        if (Gate::forUser($this->currentAdmin())->allows('users-edit')) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            if ($user->save()) {
                return redirect()->route("users.index");
            }
            return redirect()->back()->with("message", "Update fails");
        }
        return abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Gate::forUser($this->currentAdmin())->allows('users-delete')) {
            if ($user->delete()) {
                return redirect()->back()->with("messageSuccess", "Delete successfully");
            }
            return redirect()->back()->with("message", "Delete fails");
        }
        return abort(403);
    }
}
