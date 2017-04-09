<?php

/**
 * Limit endpoint to only running one copy at a time
 */
$endpointLock = function ($request, $response, $next) use ($app) {
	$path = $request->getUri()->getPath();
	$key  = str_replace(['=','+','/'], ['.','-','_'], base64_encode($path));
	$lock = fopen("{$app->settings['lockDirectory']}/{$key}.lock", 'c');
	if(!flock($lock, LOCK_EX | LOCK_NB)) {
		// The endpoint is already in use
		return $response->withStatus(423)->write('This process is already running.');
	}

	// Endpoint not in use, run route
	return $next($request, $response);

	// Process finished, release lock
	flock($lock, LOCK_UN);
	fclose($lock);
};
