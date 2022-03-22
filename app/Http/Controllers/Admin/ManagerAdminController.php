<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\RegisterRequest;
use App\Models\Admin;
use Hash;

class ManagerAdminController extends AdminController
{
    private $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function index()
    {
        $admins = $this->admin->getListAdmin();
        return view("admin.list-admin.index", compact("admins"));
    }

    public function create()
    {
        return view("admin.list-admin.create-update");
    }

    public function store(RegisterRequest $request)
    {
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        if ($admin->save()) {
            return redirect()->route("admin.subAdmin.index");
        }
        return redirect()->back()->with("message", "Create new fails");
    }

    public function edit($admin_id)
    {
        $admin = $this->admin->find($admin_id);
        if (!empty($admin)) {
            return view("admin.list-admin.create-update", ["admin" => $admin]);
        }
        return redirect()->back()->with("message", "Can not found");
    }

    public function update(RegisterRequest $request, Admin $admin)
    {
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        if ($admin->save()) {
            return redirect()->route("admin.subAdmin.index");
        }
        return redirect()->back()->with("message", "Update fails");
    }

    public function destroy(Admin $admin)
    {
        if ($admin->delete()) {
            return redirect()->back()->with("messageSuccess", "Delete successfully");
        }
        return redirect()->back()->with("message", "Delete fails");
    }
}
