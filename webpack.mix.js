let mix = require('laravel-mix');

mix
	.js('resources/js/app.js', 'public/js')
	.js('resources/js/moderators.js', 'public/js')
	.js('resources/js/stats.js', 'public/js')
	.copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/css')
	.copy('resources/css/hebrewparsetrainer.css', 'public/css')
	.copy('resources/css/fonts/EzraSIL.ttf', 'public/css/fonts')
	.copy('resources/audio', 'public/audio');
