<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Roles;
use Spatie\Valuestore\Valuestore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends BaseAdminController
{
    private $permission;
    private $role;
    private $paginationNum = 0;

    public function __construct(Roles $role, Permission $permission)
    {
        $settings = Valuestore::make(storage_path('app/settings.json'));
        $this->paginationNum = $settings->get('post_pagination', 0);
        $this->role = $role;
        $this->permission = $permission;
    }


    public function index()
    {
        $roles = $this->role->paginate($this->paginationNum);
        return view("admin.roles.index", compact("roles"));
    }

    public function create()
    {
        $permissions = $this->permission->getParentOfPermission();
        return view("admin.roles.create-update", compact("permissions"));
    }

    public function store(RoleRequest $request)
    {
        try {
            DB::beginTransaction();
            $role = $this->role->create([
                "name" => $request->name,
            ]);
            $role->permissions()->attach($request->permission);
            DB::commit();
            return redirect()->route("roles.index");
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error roles send message: '.$e->getMessage(). "---Line:".$e->getLine());
            return view('admin.errors.404');
        }
    }

    public function edit($role_id)
    {
        $permissions = $this->permission->getParentOfPermission();
        $roles = $this->role->find($role_id);
        if (empty($roles)) {
            return redirect()->back()->with("message", "Can not found");
        }
        $permissionChecked = $roles->permissions;
        return view("admin.roles.create-update", compact("permissions", "permissionChecked", "roles"));
    }

    public function update(RoleRequest $request, Roles $role)
    {
        try {
            DB::beginTransaction();
            if (empty($role)) {
                return redirect()->back()->with("message", "Can't find the role need update");
            }
            $role->update([
                "name" => $request->name,
            ]);
            $role->permissions()->sync($request->permission);
            DB::commit();
            return redirect()->route("roles.index")->with("messageSuccess", "Update Success");
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error roles send message: '.$e->getMessage(). "---Line:".$e->getLine());
            return view('admin.errors.404');
        }
    }

    public function destroy(Roles $role)
    {
        try {
            DB::beginTransaction();
            if (empty($role)) {
                return redirect()->back()->with("message", "Can't find the role need delete");
            }
            $role->permissions()->detach();
            if ($role->delete()) {
                DB::commit();
                return redirect()->route("roles.index")->with("messageSuccess", "Delete Success");
            }
            return redirect()->route("roles.index")->with("message", "Delete Fails");
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error roles send message: '.$e->getMessage(). "---Line:".$e->getLine());
            return view('admin.errors.404');
        }
    }
}
