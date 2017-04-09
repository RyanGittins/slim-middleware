# Slim 3 Middleware

This repository contains middleware meant to be used in [Slim micro framework](https://www.slimframework.com/) projects.  Each middleware in this repo is implemented as a closure but could easily be adapted to be invokable class middleware should the need arise.  See [here](https://www.slimframework.com/docs/concepts/middleware.html) for more on Slim middleware.

Additionally, each middleware has an accompanying markdown file with a description of the middleware, any special settings it requires, and some thoughts or caveats.

## Settings

Throughout the middleware, you may notice references to `$app->settings`.  This is *not* a standard, built-in way of accessing settings in Slim but I typically include the following line in my `index.php` for a little syntactic sugar:

`$app->settings = $app->getContainer()->get('settings');`

This makes accessing settings much less cumbersome and more uniform across the entire project.
