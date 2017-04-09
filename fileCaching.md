# File Caching Middleware

This middleware saves response bodies to a flat file cache, indexed by the URL path and query string.  It's useful for slower AJAX endpoints with results that seldom change given the same query string.

The `lifespan` setting accepts any string that is accepted by [DateInterval::createFromDateString](https://secure.php.net/manual/en/dateinterval.createfromdatestring.php), such as `2.5 hours`, `5 days`, `1 week`, or `a month`.

Personally, I've seen savings of more than an order of magnitude on slower queries, but little to no effect for queries/endpoints which are already fast.  It's well worth benchmarking each endpoint you apply it to.

For convenience, this middleware sets the `Cache-Status` header to `hit` or `miss` so you can benchmark easily.

## Settings

```
<?php

return [
	'fileCache' => [
		'location' => __DIR__ . '/../cache',
		'lifespan' => '7 days'
	]
];
```

## Thoughts

Currently, the cache is indexed by a combination of only the URL path and query string.  If responses vary by subdomain, HTTP method, or any other URL component you'll want to make those components part of the `$path` variable on line 10.  For instance, if responses vary by method, you could use the following for indexing:

`$path = $request->getUri()->getMethod() .' '. $request->getUri()->getPath() .'?'. $request->getUri()->getQuery();`
