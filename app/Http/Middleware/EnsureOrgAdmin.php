<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class EnsureOrgAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
       if (!$user || !$user->isAdmin()) {
            abort(403, 'Organization admin access required.');
        }
        return $next($request);
    }
}
