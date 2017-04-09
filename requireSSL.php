<?php

/**
 * Requires the endpoint to be called with SSL
 *
 * Adapted from WordPress's core is_ssl() function
 * https://core.trac.wordpress.org/browser/tags/3.2.1/wp-includes/functions.php#L3612
 */

$requireSSL = function ($request, $response, $next) {
	if(isset($_SERVER['HTTPS'])) {
		$https = strtolower($_SERVER['HTTPS']);
		if($https == 'on' || $https == '1') {
			return $next($request, $response);
		}
	} elseif(isset($_SERVER['SERVER_PORT']) && ($_SERVER['SERVER_PORT'] == '443')) {
		return $next($request, $response);
	}

	return $response->withStatus(403)->write('SSL Required');
};
