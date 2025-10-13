<?php

namespace App\Http\Middleware;

use App\Models\Mrc;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if user is a registrar
        if ($user->role->role == 'registrar' or $user->role->role == 'verifier' or $user->role->role == 'admin') {
            // Assuming route has a model binding like /records/{record}
            $id = $request->route('id');
            $record = Mrc::findOrFail($id);

            // Check if the record belongs to the registrar
            if ($record->registrar_id !== $user->id) {
                abort(403, 'Unauthorized: You do not own this record.');
            }

            return $next($request);    
        }else{
            abort(403, 'Unauthorized: You are Not a registrar or varifier.');
        }

        


    }
}
