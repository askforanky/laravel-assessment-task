const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.scripts(
    [
        "resources/js/jquery.min.js",
        "resources/js/bootstrap.min.js",
        "resources/js/jquery-ui.min.js",
        "resources/js/snackbar.min.js",
        "resources/js/jquery.multiselect.js",
        "resources/js/app.js",
    ],
    "public/js/app.js"
).styles(
    [
        "resources/css/bootstrap.min.css",
        "resources/css/jquery-ui.min.css",
        "resources/css/snackbar.min.css",
        "resources/css/jquery.multiselect.css",
        "resources/css/app.css",
    ],
    "public/css/app.css"
);
