<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\PoliceStation;
use App\Models\SubDivision;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function index(Request $request)
    {
        $query = User::query()->with([
            'role',
            'subDivision',
            'policeStation'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Universal Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'LIKE', "%{$search}%")

                ->orWhere('email', 'LIKE', "%{$search}%")

                ->orWhere('mobile', 'LIKE', "%{$search}%")

                ->orWhere('cnic', 'LIKE', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Date Filters
        |--------------------------------------------------------------------------
        */

        if ($request->filled('From')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->From
            );
        }

        if ($request->filled('To')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->To
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            if ($request->status == 'active') {

                $query->where('status', 'Active');

            } elseif ($request->status == 'not active') {

                $query->where('status', 'Not active');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Latest First
        |--------------------------------------------------------------------------
        */

        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'users.index',
            compact('users')
        );
    }

     public function create(): View
    {   $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

    //  Step 1: Validate input
    $validated = $request->validate([
        'cnic'           => 'nullable|string|size:13|unique:users,cnic',
        'name'           => 'required|string|max:50',
        'father_name'    => 'nullable|string|max:50',
        'address'        => 'nullable|string|max:100',
        'dob'            => 'nullable|date',
        'email'          => 'required|email|unique:users,email',
        'mobile'         => 'nullable|string|size:11|unique:users,mobile',
        'profile_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'password'       => 'required|string|min:8|confirmed',
    ]);

    // Step 2: Handle profile image upload (if any)
    if ($request->hasFile('profile_image')) {
        $validated['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
    }

    // Step 3: Create user
    $user = User::create([

        'cnic' => $validated['cnic'] ?? null,

        'name' => $validated['name'],

        'father_name' => $validated['father_name'] ?? null,

        'address' => $validated['address'] ?? null,

        'dob' => $validated['dob'] ?? null,

        'email' => $validated['email'],

        'mobile' => $validated['mobile'],

        'profile_image' => $validated['profile_image'] ?? null,

        'password' => Hash::make($validated['password']),

        'role_id' => 9,

        'status' => 'Not active',

    ]);

    // Step 4: Fire Registered event and log in the user
    // event(new Registered($user));

    if (Auth::check()) {
        return redirect()->route('users.index')->with('success', 'Registration successful. Welcome!');
    }else{
        return redirect()->route('login');
    }



    }
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $policestations = PoliceStation::all();
        $subDivisions = SubDivision::all();
        return view('users.edit', compact('user', 'roles', 'policestations', 'subDivisions'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'cnic' => 'nullable|string|size:13|unique:users,cnic,' . $user->id,

            'name' => 'required|string|max:50',

            'father_name' => 'nullable|string|max:50',

            'address' => 'nullable|string|max:100',

            'dob' => 'nullable|date',

            'email' => 'required|email|unique:users,email,' . $user->id,

            'mobile' => 'nullable|string|size:11|unique:users,mobile,' . $user->id,

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'status' => 'required|in:Active,Not active',

            'role_id' => 'required|integer|exists:roles,id',

            'sub_division_id' => 'nullable|exists:sub_divisions,id',

            'policestation_id' => 'nullable|exists:policestations,id',

            'password' => 'nullable|string|min:8|confirmed',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Profile Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_image')) {

            $validated['profile_image'] = $request
                ->file('profile_image')
                ->store('profile-images', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Handle Password
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['password'])) {

            $validated['password'] = Hash::make(
                $validated['password']
            );

        } else {

            unset($validated['password']);
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Undefined Nullable Fields
        |--------------------------------------------------------------------------
        */

        $validated['cnic'] = $validated['cnic'] ?? null;

        $validated['father_name'] = $validated['father_name'] ?? null;

        $validated['address'] = $validated['address'] ?? null;

        $validated['dob'] = $validated['dob'] ?? null;

        $validated['mobile'] = $validated['mobile'] ?? null;

        $validated['sub_division_id'] = $validated['sub_division_id'] ?? null;

        $validated['policestation_id'] = $validated['policestation_id'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Update User
        |--------------------------------------------------------------------------
        */

        $user->update($validated);

        return redirect()
            ->back()
            ->with(
                'success',
                'User updated successfully.'
            );

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
}
