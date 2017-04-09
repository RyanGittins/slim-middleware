<?php

/**
 * Requires the endpoint to be called via XHR/AJAX
 */
$requireXHR = function ($request, $response, $next) {
	if($request->isXhr()) {
		return $next($request, $response);
	}
	else {
		return $response->withStatus(403)->write('XHR/AJAX Required');
	}
};
