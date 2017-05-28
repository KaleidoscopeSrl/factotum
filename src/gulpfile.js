var gulp         = require('gulp'),
	sass         = require('gulp-ruby-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	minifycss    = require('gulp-minify-css'),
	uglify       = require('gulp-uglify'),
	imagemin     = require('gulp-imagemin'),
	rename       = require('gulp-rename'),
	concat       = require('gulp-concat'),
	notify       = require('gulp-notify'),
	cache        = require('gulp-cache'),
	livereload   = require('gulp-livereload'),
	gutil        = require('gulp-util'),
	plumber      = require('gulp-plumber'),
	del          = require('del');


var onError = function (err) {
	console.log(err);
	this.emit("end");
};

var paths = {
	'bootstrap': './bower_components/bootstrap-sass/assets/stylesheets/'
};


// Fonts
gulp.task('fonts', function() {
	return gulp.src('resources/assets/fonts/frontend/**/*')
		.pipe(plumber({ errorHandler: onError }))
		.pipe(gulp.dest('public/assets/fonts/frontend'))
		.pipe(notify({ message: 'Fonts task complete' }));
});

// favicon
gulp.task('favicon', function() {
	return gulp.src([
		'resources/assets/media/frontend/favicon.ico'
	])
		.pipe(plumber({ errorHandler: onError }))
		.pipe(gulp.dest('public/'))
		.pipe(notify({ message: 'favicon complete' }));
});


// Styles
gulp.task('styles', function() {
	return sass('resources/assets/sass/frontend/main.scss', {
		style: 'expanded',
		stopOnError: true,
		emitCompileError: true,
		loadPath: [
			paths.bootstrap,
			'./bower_components/'
		]
	})
		.on('error', onError)
		.pipe(gulp.dest('public/assets/css/frontend'))
		.pipe(rename({ suffix: '.min' }))
		.pipe(minifycss())
		.pipe(gulp.dest('public/assets/css/frontend'))
		.pipe(notify({ message: 'Styles task complete' }));

});

// Images
gulp.task('images', function() {
	return gulp.src('resources/assets/media/frontend/img/**/*')
		.pipe(plumber({ errorHandler: onError }))
		.pipe(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true }))
		.pipe(gulp.dest('public/assets/media/frontend/img'))
		.pipe(notify({ message: 'Images task complete' }));
});


gulp.task('default', [
	'styles',
	'fonts',
	'images',
	'favicon'
]);

// Watch
gulp.task('watch', function() {

	// Watch .scss files
	gulp.watch('resources/assets/sass/frontend/**/*.scss', [ 'styles' ]);

	// Watch image files
	gulp.watch('resources/assets/media/frontend/img/**/*', [ 'images' ]);

	// Watch fonts
	gulp.watch('resources/assets/fonts/frontend/**/*', [ 'fonts' ]);

	// Create LiveReload server
	livereload.listen();

	// Watch any files in dist/, reload on change
	gulp.watch(['resources/views/**']).on('change', livereload.changed);

});
