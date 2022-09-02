<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExtensionAccessEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $extension){
      if (!$request->user()->isExtensionActivated($extension)) {
          abort(406);
      }
      return $next($request);
    }
}
