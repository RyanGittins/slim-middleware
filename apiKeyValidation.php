<?php

/**
 * Check for invalid API key
 */
$apiKeyValidation = function ($request, $response, $next) use ($app) {
	$key   = $request->getHeader('API-Key')[0];
	$route = $request->getMethod();

	foreach($app->settings['apiKeys'] as $allowedKey => $permissions) {
		if((string)$key === (string)$allowedKey) {
			if(in_array($route, $permissions)) {
				// Valid API key, route allowed
				return $next($request, $response);
			}
			else {
				// Valid API key, route not allowed
				return $response->withStatus(403)->write('Unauthorized Route');
			}
		}
	}

	return $response->withStatus(403)->write('Invalid API Key');
};
