<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Models\SubDivision;
use App\Models\PoliceStation;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * User Listing
     */
    public function index()
    {
        $users = User::with([
                'role',
                'subDivision',
                'policeStation'
            ])
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Create Form
     */
    public function create()
    {
        $roles = Role::orderBy('role')->get();

        $subDivisions = SubDivision::orderBy('name')->get();

        return view('admin.users.create', compact(
            'roles',
            'subDivisions'
        ));
    }

    /**
     * Store User
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|max:255',

            'mobile' => 'required|max:20|unique:users,mobile',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|confirmed|min:6',

            'role_id' => 'required|exists:roles,id',

            'status' => 'required|in:Active,Not Active',

            'sub_division_id' => 'nullable|exists:sub_divisions,id',

            'policestation_id' => 'nullable|exists:policestations,id',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Profile Image
        |--------------------------------------------------------------------------
        */

        $imageName = null;

        if ($request->hasFile('profile_image')) {

            $imageName = time() . '_' . uniqid() . '.' .
                $request->profile_image->extension();

            $request->profile_image->storeAs(
                'profile-images',
                $imageName,
                'public'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create User
        |--------------------------------------------------------------------------
        */

        User::create([

            'name' => $request->name,

            'mobile' => $request->mobile,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'role_id' => $request->role_id,

            'status' => $request->status,

            'sub_division_id' => $request->sub_division_id,

            'policestation_id' => $request->policestation_id,

            'profile_image' => $imageName,

        ]);

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User created successfully.'
            );
    }
}