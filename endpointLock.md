# Endpoint Lock Middleware

This middleware is meant to be applied to long-running processes or daemons.  It limits the endpoint to only one user at a time, returning an error on subsequent attempts.  It accomplishes this by using a [special lock file](https://secure.php.net/manual/en/function.flock.php) specific to the endpoint to which it's applied.

This is useful if you have an endpoint responsible for doing some long-term polling which you're keeping alive via cron or some other means.  The heartbeat from the cron job will repeatedly attempt to start the process, and the middleware will ensure that only one worker exists at a time.

## Settings

```
<?php

return [
	'lockDirectory' => __DIR__ . '/../locks'
];

```

## Thoughts

**Make sure your lock directory is writable by the web server!**

Also, bear in mind that the locks are only indexed by the path.  This means that the same endpoint with differing HTTP methods or query strings will share the same lock.  If this is not the behavior you desire, consider adding the relevant parts of the URL to the `$path` variable on line 7.  For instance, if you want method-specific endpoint locks, you could accomplish that by changing line 7 to the following:

`$path = $request->getUri()->getMethod() .' '. $request->getUri()->getPath();`

This middleware could easily be modified to allow some other number of simultaneous users, simply by incrementing and decrementing a counter stored in the lock file as connections are made and closed.
