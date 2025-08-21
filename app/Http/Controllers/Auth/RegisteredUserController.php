<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
    $query = User::query();

    // Apply search by type
    if ($request->filled('search') && $request->filled('search_type')) {
        $searchType = $request->input('search_type');
        $searchValue = $request->input('search');

        if (in_array($searchType, ['cnic', 'name', 'license_number', 'email'])) {
            $query->where($searchType, 'LIKE', '%' . $searchValue . '%');
        }
    }

    // Apply date range filters
    if ($request->filled('From')) {
        $query->whereDate('created_at', '>=', $request->input('From'));
    }

    if ($request->filled('To')) {
        $query->whereDate('created_at', '<=', $request->input('To'));
    }

    // Apply status filter
    if ($request->filled('status')) {
        if ($request->input('status') === 'active') {
            $query->where('status', 'Active');
        } elseif ($request->input('status') === 'not active') {
            $query->where('status', 'Not active');
        }
    }

    // Fetch results with pagination and keep query params
    $users = $query->paginate(10)->withQueryString();

    return view('users.index', compact('users'));
}

     public function create(): View
    {
        return view('auth.register');
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
        'cnic'           => 'required|string|size:13|unique:users,cnic',
        'name'           => 'required|string|max:50',
        'father_name'    => 'required|string|max:50',
        'address'        => 'required|string|max:100',
        'dob'            => 'required|date',
        'email'          => 'required|email|unique:users,email',
        'mobile'         => 'required|string|size:11|unique:users,mobile',
        'license_number' => 'required|string',
        'profile_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'password'       => 'required|string|min:8|confirmed',
    ]);

    // Step 2: Handle profile image upload (if any)
    if ($request->hasFile('profile_image')) {
        $validated['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
    }

    // Step 3: Create user
    $user = User::create([
        'cnic'           => $validated['cnic'],
        'name'           => $validated['name'],
        'father_name'    => $validated['father_name'],
        'address'        => $validated['address'],
        'dob'            => $validated['dob'],
        'email'          => $validated['email'],
        'mobile'         => $validated['mobile'],
        'license_number' => $validated['license_number'],
        'profile_image'  => $validated['profile_image'] ?? null,
        'password'       => Hash::make($validated['password']),
        'status'         => 'Not Active', // or 'Active' if auto-approved
        'role'           => 'registrar',   // default role
    ]);

    // Step 4: Fire Registered event and log in the user
    event(new Registered($user));

    if (Auth::check()) {
        return redirect()->route('dashboard')->with('success', 'Registration successful. Welcome!');
    }else{
        return redirect()->route('login');
    }



    }
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Validate the input
        $validated = $request->validate([
            'cnic'           => 'required|string|size:13|unique:users,cnic,' . $user->id,
            'name'           => 'required|string|max:50',
            'father_name'    => 'required|string|max:50',
            'address'        => 'required|string|max:100',
            'dob'            => 'required|date',
            'email'          => 'required|email|unique:users,email,' . $user->id,
            'mobile'         => 'required|string|size:11|unique:users,mobile,' . $user->id,
            'license_number' => 'required|string,' . $user->id,
            'profile_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'       => 'string|in:Active,Not active',
            'role'         => 'string|in:registrar,admin,operator', // Add this
            'password'       => 'nullable|string|min:8|confirmed', // Add this line
        ]);

        // Handle profile image upload (if any)
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }

        // Handle password (only if provided)
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        // Update user
        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
}
