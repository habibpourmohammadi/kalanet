<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\SetRoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $search = request()->search;
        $users = User::query()->when($search, function ($users) use ($search) {
            return $users->where("name", "like", "%$search%")->orWhere("email", "like", "%$search%")->orWhere("created_at", "like", "%$search%")->get();
        }, function ($users) {
            return $users->get();
        });
        return view("admin.user.user.index", compact("users"));
    }

    public function changeStatus(User $user)
    {
        $this->authorize('update', [$user]);

        if ($user->activation == "deactive") {
            $user->update([
                "activation" => "active"
            ]);

            return back()->with("swal-success", "وضعیت کاربر مورد نظر با موفقیت به (فعال) تغییر یافت");
        } else {
            $user->update([
                "activation" => "deactive"
            ]);

            return back()->with("swal-success", "وضعیت کاربر مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        }
    }

    public function setRolePage(User $user)
    {
        $this->authorize('update', [$user]);

        $roles = Role::all();
        return view("admin.user.user.set-role", compact("user", "roles"));
    }

    // Set roles for a user
    public function setRole(SetRoleRequest $request, User $user)
    {
        $this->authorize('update', [$user]);

        // Retrieve roles from the request
        $roles = $request->roles;

        // Check if user has admin role and the admin role is being removed
        if ($user->hasRole("admin") && !in_array("admin", $roles ?? [])) {
            return back()->with("swal-error", "لطفا دوباره تلاش کنید !");
        }
        // Check if user doesn't have admin role and admin role is being added
        elseif (!$user->hasRole("admin") && in_array("admin", $roles ?? [])) {
            return back()->with("swal-error", "لطفا دوباره تلاش کنید !");
        }

        // Sync the roles for the user
        $user->syncRoles($roles);

        // Redirect back with success message
        return to_route("admin.user.index")->with("swal-success", "نقش های کاربر مورد نظر با موفقیت ویرایش شد");
    }
}
