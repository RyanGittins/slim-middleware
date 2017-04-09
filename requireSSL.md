# Require SSL Middleware

This middleware simply rejects requests which aren't made over HTTPS.  It's based on the [`is_ssl()`](https://core.trac.wordpress.org/browser/tags/3.2.1/wp-includes/functions.php#L3612) function in WordPress's core.

## Settings

This middleware currently requires no settings.

## Thoughts

I'm not sure how foolproof this method of enforcing an SSL connection is, but I get the distinct feeling that the fine folks over at WordPress have done their homework.
