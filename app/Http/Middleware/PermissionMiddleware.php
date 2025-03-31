<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\UserPermission;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // ambil URI route tanpa prefix
        $uri = explode('.', trim($request->route()->getName(), '.'));
        $uri = $uri[0];
        if (!$uri) {
            abort(403, 'Invalid route');
        }
        
        // ambil method request & tentuin permission
        $action = $this->determineAction($request->method());
        $permissionCode = strtolower($action . '_' . $uri);
        
        // dd($permissionCode);
        // cek apakah user punya permission itu (case-insensitive)
        $permission = Permission::whereRaw('LOWER(code) = ?', [strtolower($permissionCode)])->first();
        if (!$permission) {
            abort(403, 'Permission not found');
        }

        $hasPermission = UserPermission::where('user_id', $user->id)
            ->where('permission_id', $permission->id)
            ->exists();

        if ($user->roles->pluck('code')->contains(env('APP_HIGHEST_ROLE', 'superadmin'))) {
            return $next($request);
        }

        if (!$hasPermission) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }

    private function determineAction(string $method): string
    {
        return match ($method) {
            'GET'    => 'read',
            'POST'   => 'create',
            'PUT', 'PATCH' => 'update',
            'DELETE' => 'delete',
            default  => 'read',
        };
    }
}
