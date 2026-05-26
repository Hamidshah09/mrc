<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        if (Auth::user()->status !== 'Active') {
            Auth::logout();
            return redirect()->route('inactive')->with('message', 'Your account is not activated yet. Please contact the administrator.');
        }


        $request->session()->regenerate();

        $role = Auth::user()->role->role;
        
        switch ($role) {

            case 'Operator':

                return redirect()->route(
                    'operator.complaints.index'
                );

            case 'AC':

                return redirect()->route(
                    'ac.dashboard'
                );

            case 'Magistrate':

                return redirect()->route(
                    'magistrate.dashboard'
                );

            case 'ADCG':

                return redirect()->route(
                    'adcg.dashboard'
                );

            case 'admin':

                return redirect()->route(
                    'dashboard'
                );
            case 'domicile':
                return redirect()->route('domicile.index');
            case 'surety':
                return redirect()->route('surety.index');

            default:

                Auth::logout();

                abort(403, 'Role not configured.');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
