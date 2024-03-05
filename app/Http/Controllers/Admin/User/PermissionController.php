<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $permissions = Permission::query()->when($search, function ($permissions) use ($search) {
            return $permissions->where("name", "like", "%$search%")->orWhere("name", "like", "%$search%")->get();
        }, function ($permissions) {
            return $permissions->get();
        });

        return view("admin.user.permission.index", compact("permissions"));
    }
}
