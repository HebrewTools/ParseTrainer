<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Login {
	/**
	 * Create a new middleware instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Factory  $auth
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null) {
		if ($request->has('login') && !Auth::check()) {
			return response('Unauthorized.', 401)
				->header('WWW-Authenticate', 'Basic realm="Please enter your email and password"');
		}

		return $next($request);
	}
}
