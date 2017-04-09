# API Key Check Middleware

This middleware requires the presence of a header called `API-Key`.  It returns a 400 error if that header is missing.  It does **not** validate the API key if it is present.  That is handled by the accompanying API Key Validation middleware in this repo.

## Settings

This middleware currently requires no settings.

## Thoughts

This middleware is quite small and could easily be merged into the accompanying API Key Validation middleware.  I keep them separate because they return separate errors and are a bit more atomic this way, but I see the case for merging their functionality.

While the current implementation relies on no settings, you may want to consider extracting the name of the header containing the API key if you use the same header name in multiple places throughout your project.  Currently, it just uses the hardcoded `API-Key` header.
