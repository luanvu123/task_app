<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentHeadMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isDepartmentHead()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chỉ trưởng phòng mới có quyền thực hiện hành động này.'
                ], 403);
            }

            abort(403, 'Chỉ trưởng phòng mới có quyền thực hiện hành động này.');
        }

        return $next($request);
    }
}
