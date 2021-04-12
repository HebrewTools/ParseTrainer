let mix = require('laravel-mix');

mix
	.js('resources/assets/js/app.js', 'public/js')
	.js('resources/assets/js/moderators.js', 'public/js')
	.copy('vendor/twbs/bootstrap/dist/css/bootstrap.min.css', 'public/css')
	.copy('resources/assets/css/hebrewparsetrainer.css', 'public/css')
	.copy('resources/assets/css/fonts/EzraSIL.ttf', 'public/css/fonts')
	.copy('resources/assets/audio', 'public/audio');
