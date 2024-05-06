const mix = require("laravel-mix");
const path = require("path");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .ts("resources/js/app-tsx.tsx", "public/js").react()
    .webpackConfig({
        resolve: {
            alias: {
                "@": path.resolve("resources/js"),
            },
            fallback: {
                crypto: false,
            },
        },
    })
    .version()
    .sourceMaps();
