### Themes 2

Our themes package enhances any Laravel 4 application (in fact, it doesn't even require you use Laravel 4!) to add theming functionality and a whole lot more:

1. Any number of theme locations.
2. Support for theme "areas" (such as "backend" or "frontend" themes, you can choose anything).
3. Unlimited theme inheritence; you can make an unlimited chain of themes which inherit off another theme. Views and assets cascade throughout theme inheritence.
4. Fallback theme support; nominate a theme which views and assets fallback to if they cannot be found in the active theme hierarchy.
5. Asset compilation (LESS, SASS, SCSS, CoffeeScript etc), minification and compression into one asset (configurable per environment).
6. Powerful, dynamically generated static asset cache; assets are cached when compiled to static files, which is blazingly fast. We **don't** serve assets through frameworks/controllers as this adds significant overhead.
7. Theme publishing (publish your own packages / extensions with support for any theme in them and publish them from within the [Artisan CLI in Laravel 4](http://four.laravel.com/docs/artisan)). Of course, this can work outside of Laravel as well.

> It's a bit like performance enhancing drugs for athletes. Except good. Think good thoughts.