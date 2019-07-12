let mix = require('laravel-mix');

mix.js('src/resources/assets/js/*', 'src/public/js')
   .css('src/resources/assets/css/*', 'src/public/css');
