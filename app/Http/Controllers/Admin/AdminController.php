<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Admin;
use App\Models\Roles;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Auth;

class AdminController extends BaseAdminController
{
    use AuthorizesRequests;
    private $admin;
    private $role;

    public function __construct(Admin $admin, Roles $role)
    {
        $this->admin = $admin;
        $this->role = $role;
        $this->middleware('checkPermission:admins_list', ['only' => ['index']]);
        $this->middleware('checkPermission:admins_add', ['only' => ['create', 'store']]);
        $this->middleware('checkPermission:admins_edit', ['only' => ['edit', 'update']]);
        $this->middleware('checkPermission:admins_delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $admins = $this->admin->all();
        return view("admin.list-admin.index", compact("admins"));
    }

    public function create()
    {
        $roles = $this->role->all();
        return view("admin.list-admin.create-update", compact("roles"));
    }

    public function store(RegisterAdminRequest $request)
    {
        try {
            DB::beginTransaction();
            $admin = new Admin();
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            if ($admin->save()) {
                $admin->roles()->attach($request->roles);
                DB::commit();
                return redirect()->route("admins.index");
            }
            return redirect()->back()->with("message", "Create new fails");
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error admins send message: '.$e->getMessage(). "---Line:".$e->getLine());
            return view('admin.errors.404');
        }
    }

    public function edit($admin_id)
    {
        if ($this->currentAdmin()->level != 0 && $this->currentAdmin()->id != $admin_id) {
            return redirect()->back()->with("message", "Cant edit others");
        }
        $roles = $this->role->all();
        $admin = $this->admin->find($admin_id);
        $roleOfAdmin = $admin->roles;
        if (!empty($admin)) {
            return view("admin.list-admin.create-update", compact("roles", "admin", "roleOfAdmin"));
        }
        return redirect()->back()->with("message", "Can not found");
    }

    public function update(RegisterRequest $request, Admin $admin)
    {
        try {
            DB::beginTransaction();
            if (empty($admin)) {
                return redirect()->back()->with("message", "Can't find the admin to update");
            }
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            if ($admin->save()) {
                $admin->roles()->sync($request->roles);
                DB::commit();
                return redirect()->route("admins.index");
            }
            return redirect()->back()->with("message", "Update fails");
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error admins send message: '.$e->getMessage(). "---Line:".$e->getLine());
            return view('admin.errors.404');
        }
    }

    public function destroy(Admin $admin)
    {
        if (empty($admin)) {
            return redirect()->back()->with("message", "Can't find the admin to delete");
        }
        if ($this->currentAdmin()->id == $admin->id) {
            return redirect()->back()->with("message", "Cant delete myself");
        }
        if ($admin->delete()) {
            return redirect()->back()->with("messageSuccess", "Delete successfully");
        }
        return redirect()->back()->with("message", "Delete Fail");
    }
}
