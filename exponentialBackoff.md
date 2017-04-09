# Exponential Backoff Middleware

This middleware is useful for endpoints which should be polled repeatedly.  When you apply it to a route, this middleware expects the route to return a 200 status code (for a miss) or a 201 (for a hit).  Simply put, a "hit" means we want to start running that route more frequently (as there is some work to be done) and a "miss" means we checked too soon, and that we should increase our wait time before checking again.

For instance, this could be applied to an endpoint that checks a queue for work.  When the endpoint successfully finds a work item in the queue, it signals a hit and the work queue will be checked more frequently.  When the work queue is empty, this middleware will back off and check the queue less and less frequently.  The idea is that work queues tend to fill up in batches, so this middleware will try to accommodate these ebbs and flows.

With the example settings below, an activity log could look like the following:

    Miss.  New interval: 5 seconds
    Miss.  New interval: 10 seconds
    Miss.  New interval: 20 seconds
    Hit!   New interval: 5 seconds
    Miss.  New interval: 10 seconds
    Miss.  New interval: 20 seconds
    Miss.  New interval: 40 seconds
    Miss.  New interval: 60 seconds
    Miss.  New interval: 60 seconds
    Miss.  New interval: 60 seconds
    Hit!   New interval: 5 seconds
    Hit!   New interval: 5 seconds
    Miss.  New interval: 10 seconds
    Miss.  New interval: 20 seconds

## Settings

```
<?php

return [
	'exponentialBackoff' => [
		'min' => 5,
		'max' => 60,
		'multiplier' => 2
	]
];

```

## Thoughts

By default, the minimum and maximum sleep times are in *seconds*.  If you need a finer degree of control consider changing the call to function [`sleep()`](https://secure.php.net/manual/en/function.sleep.php) to [`usleep()`](https://secure.php.net/manual/en/function.usleep.php) and setting `min` and `max` to some number of *microseconds* instead.

This middleware could also be easily modified to have an end condition, simply by catching a different status code returned by the route's `$response` object.  As it currently stands, applying this middleware would make an endpoint run indefinitely.  This is by design and is the desired behavior for a worker which checks a queue for jobs.
