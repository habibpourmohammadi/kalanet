<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\Role\StoreRequest;
use App\Http\Requests\Admin\User\Role\UpdateRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $roles = Role::query()->when($search, function ($roles) use ($search) {
            return $roles->where("name", "like", "%$search%")->orWhere("description", "like", "%$search%")->get();
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
        return view("admin.user.role.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $inputs = $request->validated();

        Role::create([
            "name" => $inputs["name"],
            "description" => $inputs["description"],
        ]);

        return to_route("admin.accessManagement.role.index")->with("swal-success", "نقش جدید شما با موفقیت ایجاد شد");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view("admin.user.role.edit", compact("role"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Role $role)
    {
        $inputs = $request->validated();

        $role->update([
            "name" => $inputs["name"],
            "description" => $inputs["description"],
        ]);

        return to_route("admin.accessManagement.role.index")->with("swal-success", "نقش مورد نظر با موفقیت ویرایش شد");
    }
}
