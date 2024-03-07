<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\Role\StoreRequest;
use App\Http\Requests\Admin\User\Role\Permissions\StoreRequets as StorePermissionsRequest;
use App\Http\Requests\Admin\User\Role\UpdateRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);

        $search = request()->search;

        $roles = Role::query()->when($search, function ($roles) use ($search) {
            return $roles->where("name", "like", "%$search%")->get();
        }, function ($roles) {
            return $roles->get();
        });

        return view("admin.user.role.index", compact("roles"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        return view("admin.user.role.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Role::class);

        $inputs = $request->validated();

        Role::create([
            "name" => $inputs["name"],
        ]);

        return to_route("admin.accessManagement.role.index")->with("swal-success", "نقش جدید شما با موفقیت ایجاد شد");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $this->authorize('update', [$role]);

        if ($role->name === "admin") {
            abort(404);
        }

        return view("admin.user.role.edit", compact("role"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Role $role)
    {
        $this->authorize('update', [$role]);

        if ($role->name === "admin") {
            abort(404);
        }

        $inputs = $request->validated();

        $role->update([
            "name" => $inputs["name"],
        ]);

        return to_route("admin.accessManagement.role.index")->with("swal-success", "نقش مورد نظر با موفقیت ویرایش شد");
    }



    public function destroy(Role $role)
    {
        $this->authorize('delete', [$role]);

        if ($role->name === "admin") {
            abort(404);
        }

        $role->delete();
        return back()->with("swal-success", "نقش مورد نظر با موفقیت حذف شد");
    }


    public function permissionsPage(Role $role)
    {
        $this->authorize('update', [$role]);

        if ($role->name === "admin") {
            abort(404);
        }

        $permissions = Permission::all();
        return view("admin.user.role.permission.create", compact("role", "permissions"));
    }

    public function permissionsStore(StorePermissionsRequest $request, Role $role)
    {
        $this->authorize('update', [$role]);

        if ($role->name === "admin") {
            abort(404);
        }

        $permissions = $request->permissions;

        $role->syncPermissions($permissions);

        return to_route("admin.accessManagement.role.index")->with("swal-success", "مجوز های نقش مورد نظر با موفقیت ویرایش شد");
    }
}
