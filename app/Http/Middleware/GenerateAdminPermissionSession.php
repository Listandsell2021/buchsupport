<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class GenerateAdminPermissionSession
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!hasAdminPermissions() && auth('admin')->check()) {
            setAdminPermissions(getAuthAdmin()->permissions->pluck('permission')->toArray());
        }

        return $next($request);
    }
}
