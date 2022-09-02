<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use \App\Models\UserExtension;

class ExtensionsAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $extension){
      if (!$request->user()->hasExtension($extension)) {
          abort(405);
      }
      return $next($request);
    }
}
