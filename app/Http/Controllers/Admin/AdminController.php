<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Admin::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::paginate();
        return view('dashboard.admins.index',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admin =new Admin();
        $roles = Role::all();
        return view(
            'dashboard.admins.create',
            compact('admin','roles')
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
            $admin = Admin::create($request->all());
            $admin->roles()->attach($request->roles);
            return redirect()->route('dashboard.admins.index')
                ->with('success','Admin created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $roles = Role::all();
        return view(
            'dashboard.admins.edit',
            compact('admin','roles')
        );

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:11'],
            'password' => ['required', 'string', Password::default(),],
            'roles'=> ['required', 'array']
            ]);

        $admin->update($request->all());
        $admin->roles()->sync($request->roles);
        return redirect()->route('dashboard.admins.index')
            ->with('success','Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Admin::destroy($id);
        return redirect()->route('dashboard.admins.index')
            ->with('success','Admin deleted successfully');
    }
}
