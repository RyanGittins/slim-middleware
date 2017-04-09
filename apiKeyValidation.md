# API Key Validation Middleware

This middleware performs API key validation.  **It is assumed that the API key is present when this middleware runs.**  You can check for its presence with the accompanying API Key Check middleware.

This middleware enforces method-level permissions on a per-key basis.  For instance, you can have one API key which only has access to GET routes, while another has access to GET, POST, and DELETE routes.  This allows for convenient management of API keys with varying levels of permissions given RESTful API design.  

## Settings

```
<?php

return [
	'apiKeys' => [
		'hYi1ZbkH94GJZxFp' => ['GET'],
		'TPXQyln9UalZnnTL' => ['GET', 'POST', 'PUT'],
		'j3GZyP4QTUKVPMuR' => ['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'PATH', 'OPTIONS']
	]
];
```

## Thoughts

This middleware is meant to be use in conjunction with the accompanying API Key Check middleware.  I understand the case for combining these two middleware into one, as they are not quite standalone this way.

Additionally, this middleware assumes the relevant header is present and called `API-Key`.  You may wish to extract that hardcoded string into a setting, especially if that header is accessed in multiple places in your project.
