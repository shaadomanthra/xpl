let mix = require('laravel-mix');

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
mix.copy('node_modules/font-awesome/fonts', 'public/fonts');

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles(['public/css/app.css','public/css/bootstrap.min.css',
    'public/css/home.css'
], 'public/css/styles.css');

mix.styles(['public/css/app.css','public/css/bootstrap.min.css',
    'public/css/home.css','public/css/highlight/an-old-hope.css'
], 'public/css/styles2.css');

mix.styles(['public/assetsfront/vendor/hs-mega-menu/dist/hs-mega-menu.min.css',
    'public/assetsfront/vendor/fancybox/dist/jquery.fancybox.min.css','public/assetsfront/vendor/aos/dist/aos.css'
], 'public/css/front.css');

mix.js(['public/js/jquery.js',
    'public/js/global.js'
], 'public/js/script_j.js');

mix.js([
	'public/js/bootstrap.min.js',
    'public/js/global.js'
], 'public/js/script_b.js');

mix.js(['public/js/app.js',
    'public/js/global.js','public/js/questions.js'
], 'public/js/script.js');


