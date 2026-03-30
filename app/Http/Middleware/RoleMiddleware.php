<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Si els rols venen com una sola cadena separada per comes, la dividim
        if (count($roles) === 1 && str_contains($roles[0], ',')) {
            $roles = explode(',', $roles[0]);
        }

        // Trim spaces from roles
        $roles = array_map('trim', $roles);

        Log::info('RoleMiddleware', [
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role ?? 'null',
            'required_roles' => $roles,
            'match' => in_array(auth()->user()->role ?? 'null', $roles),
        ]);

        if (!auth()->check()) {
            Log::warning('No autenticat');
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            Log::warning('Rol incorrecte');
            abort(403, 'No tens permís per accedir a aquesta pàgina.');
        }

        return $next($request);
    }
}
