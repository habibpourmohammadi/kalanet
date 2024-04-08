<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('index', Permission::class);

        $search = request()->search;

        $permissions = Permission::query()->when($search, function ($permissions) use ($search) {
            return $permissions->where("name", "like", "%$search%")->orWhere("description", "like", "%$search%")->get();
        }, function ($permissions) {
            return $permissions->get();
        });

        return view("admin.user.permission.index", compact("permissions"));
    }
}
