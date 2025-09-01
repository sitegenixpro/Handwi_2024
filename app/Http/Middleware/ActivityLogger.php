<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class ActivityLogger
{
    public function handle(Request $request, Closure $next)
    {
        
        $response = $next($request);

        // Define any paths to exclude from logging
        $excludedPaths = [
            'favicon.ico',
            'sanctum/csrf-cookie',
            'broadcasting/auth',
            'api/ping',
            'admin/ping',
        ];

        foreach ($excludedPaths as $path) {
            if ($request->is($path)) {
                return $response;
            }
        }

        // Log everything else
        $action = match ($request->method()) {
            'POST' => 'Created',
            'PUT', 'PATCH' => 'Updated',
            'DELETE' => 'Deleted',
            'GET' => 'Viewed',
            default => ucfirst($request->method()),
        };
        
        $description = $action . ' ' . str_replace('-', ' ', str_replace('/', ' → ', $request->path()));
        
        ActivityLog::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'activity' => $description,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return $response;
    }
}

