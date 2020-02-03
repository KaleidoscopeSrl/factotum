var gulp         = require('gulp'),
	sass         = require('gulp-ruby-sass'),
	minifycss    = require('gulp-minify-css'),
	imagemin     = require('gulp-imagemin'),
	rename       = require('gulp-rename'),
	notify       = require('gulp-notify'),
	livereload   = require('gulp-livereload'),
	plumber      = require('gulp-plumber');


var onError = function (err) {
	console.log(err);
	this.emit("end");
};

var paths = {
	'bootstrap': './node_modules/bootstrap-sass/assets/stylesheets/'
};

// Fonts
gulp.task('fonts', function() {
	return gulp.src('resources/assets/fonts/**/*')
		.pipe(plumber({ errorHandler: onError }))
		.pipe(gulp.dest('public/assets/fonts'))
		.pipe(notify({ message: 'Fonts task complete' }));
});

// Favicon
gulp.task('favicon', function() {
	return gulp.src([
		'resources/assets/media/favicon.ico'
	])
		.pipe(plumber({ errorHandler: onError }))
		.pipe(gulp.dest('public/'))
		.pipe(notify({ message: 'favicon complete' }));
});


// Styles
gulp.task('styles', function() {
	return sass('resources/assets/sass/main.scss', {
		style: 'expanded',
		stopOnError: true,
		emitCompileError: true,
		loadPath: [
			paths.bootstrap
		]
	})
		.on('error', onError)
		.pipe(gulp.dest('public/assets/css'))
		.pipe(rename({ suffix: '.min' }))
		.pipe(minifycss())
		.pipe(gulp.dest('public/assets/css'))
		.pipe(notify({ message: 'Styles task complete' }));

});

// Images
gulp.task('images', function() {
	return gulp.src('resources/assets/media/img/**/*')
		.pipe(plumber({ errorHandler: onError }))
		.pipe(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true }))
		.pipe(gulp.dest('public/assets/media/img'))
		.pipe(notify({ message: 'Images task complete' }));
});


gulp.task('default', [
	'fonts',
	'styles',
	'images',
	'favicon'
]);

// Watch
gulp.task('watch', function() {

	// Watch .scss files
	gulp.watch('resources/assets/sass/**/*.scss', [ 'styles' ]);

	// Watch image files
	gulp.watch('resources/assets/media/img/**/*', [ 'images' ]);

	// Watch fonts
	gulp.watch('resources/assets/fonts/**/*', [ 'fonts' ]);

	// Create LiveReload server
	livereload.listen();

	// Watch any files in dist/, reload on change
	gulp.watch(['resources/views/**']).on('change', livereload.changed);

});
