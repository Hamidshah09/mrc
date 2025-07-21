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
        if ($user->role !== 'registrar') {
            abort(403, 'Unauthorized: Not a registrar.');
        }

        // Assuming route has a model binding like /records/{record}
        $id = $request->route('id');
        $record = Mrc::findOrFail($id);

        // Check if the record belongs to the registrar
        if ($record->registrar_id !== $user->id) {
            abort(403, 'Unauthorized: You do not own this record.');
        }

        return $next($request);


    }
}
