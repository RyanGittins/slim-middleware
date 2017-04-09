<?php

/**
 * Check for missing API key
 */
$apiKeyCheck = function ($request, $response, $next) {
	$keyHeaderExists = $request->hasHeader('API-Key');
	if(!$keyHeaderExists) {
		return $response->withStatus(400)->write('Missing API Key');
	}

	return $next($request, $response);
};
