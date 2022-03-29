<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Permission;
use App\Models\Roles;
use App\Models\User;
use Spatie\Valuestore\Valuestore;
use Illuminate\Http\Request;

class PermissionController extends BaseAdminController
{
    public function create()
    {
        return view("admin.permissions.create");
    }

    public function store(PermissionRequest $request)
    {
        $permission = Permission::create([
            "name" => $request->module_parent,
            "parent_id" => 0,
        ]);
        foreach ($request->module_childrent as $item) {
            Permission::create([
                'name' => $item,
                'parent_id' => $permission->id,
                'key_code' => $permission->name."_".$item,
            ]);
        }
        return redirect()->back()->with("message", "Create Permission Success");
    }
}
