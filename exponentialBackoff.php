<?php

/**
 * Runs the app repeatedly with decreasing frequency depending
 * on whether or not the app returns a 200 (miss, increase interval)
 * or a 201 (hit, reset interval)
 */
$exponentialBackoff = function ($request, $response, $next) use ($app) {
	$settings = $app->settings['exponentialBackoff'];

	// Start the interval at the minimum
	$interval = $settings['min'];

	while(true) {
		// Run app and get status
		$status = $next($request, $response)->getStatusCode();

		if($status == 201) {
			// Hit!
			$interval = $settings['min'];
		}
		elseif($status == 200) {
			// Miss
			$interval = min($settings['max'], $interval * $settings['multiplier']);
		}
		else {
			// Error.  System could be offline, log and treat like a miss
			$interval = min($settings['max'], $interval * $settings['multiplier']);
		}

		sleep($interval);
	}
};
