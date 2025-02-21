<?php

// app/Http/Middleware/CheckPermission.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     */

     public function handle($request, Closure $next, $permission)
     {
         if (Auth::check()) {
             $user = Auth::user();

             // Check if the user has the required permission
             if ($user->hasPermission($permission)) {
                 return $next($request);
             }

             // If the user has no permissions, return a custom message
             if (is_null($user->permissions) || empty($user->permissions)) {
                 return redirect('/contact-admin');
                //  return redirect('/contact-admin')->with('error', 'Please contact the administrator for permissions.');
             }
         }

         // Return a 404 Not Found response instead of redirecting
         abort(404);
     }
}
