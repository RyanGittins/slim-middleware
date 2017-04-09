<?php

/**
 * Saves response bodies to a flat file cache, indexed by the URL path and query
 * string.  Useful for slower AJAX endpoints with results that seldom change.
 */
$fileCaching = function ($request, $response, $next) use ($app) {
	$settings = $app->settings['fileCache'];

	$path = $request->getUri()->getPath() .'?'. $request->getUri()->getQuery();
	$key  = str_replace(['=','+','/'], ['.','-','_'], base64_encode($path));
	$file = "{$settings['location']}/{$key}";

	// Cache hit
	if(file_exists($file)) {
		$lastCachedTime  = new DateTime(date('Y-m-d H:i:s', filemtime($file)));
		$cacheLifespan   = DateInterval::createFromDateString($settings['lifespan']);
		$cacheExpiration = $lastCachedTime->add($cacheLifespan);
		$now = new DateTime();

		// Make sure cache is fresh
		if($cacheExpiration > $now) {
			$cachedReponse = file_get_contents($file);
			return $response->write($cachedReponse)->withHeader('Cache-Status', 'hit');
		}
	}

	// Cache miss, continue execution and cache response before returning it
	$uncachedResponse = $next($request, $response);
	file_put_contents($file, $uncachedResponse->getBody());
	return $uncachedResponse->withHeader('Cache-Status', 'miss');
};
