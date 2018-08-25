const elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

	/**
	 *
	 * SCRIPTS
	 *
	 */

	// Vendors (just jQuery and Bootstrap)
	mix.scripts([
		'./node_modules/jquery/dist/jquery.min.js',
		'./node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
		'./node_modules/moment/min/moment-with-locales.js',
	], './public/assets/js/factotum/vendor.js');

	// Vendors UI (all the UI stuff)
	mix.scripts([
		'./node_modules/jquery-datetimepicker/build/jquery.datetimepicker.full.min.js',
		'./node_modules/jquery-ui/ui/widget.js',
		'./node_modules/jquery-ui/ui/data.js',
		'./node_modules/jquery-ui/ui/scroll-parent.js',
		'./node_modules/jquery-ui/ui/widgets/mouse.js',
		'./node_modules/jquery-ui/ui/widgets/sortable.js',
		//'./node_modules/jquery-ui/ui/widgets/selectable.js',
		'./node_modules/jquery-ui/ui/widgets/progressbar.js',

		'./node_modules/select2/dist/js/select2.js',
		'./node_modules/dropzone/dist/dropzone.js',
		'./node_modules/bootstrap-confirmation2/bootstrap-confirmation.js',
		'./node_modules/lity/dist/lity.js',
	], './public/assets/js/factotum/vendor-ui.js');

	// Froala (editor)
	mix.scripts([
		'./node_modules/froala-editor/js/froala_editor.min.js',
		'./node_modules/codemirror/lib/codemirror.js',
		'./node_modules/froala-editor/js/plugins/align.min.js',
		'./node_modules/froala-editor/js/plugins/char_counter.min.js',
		'./node_modules/froala-editor/js/plugins/code_beautifier.min.js',
		'./node_modules/froala-editor/js/plugins/code_view.min.js',
		'./node_modules/froala-editor/js/plugins/colors.min.js',
		'./node_modules/froala-editor/js/plugins/emoticons.min.js',
		'./node_modules/froala-editor/js/plugins/entities.min.js',
		'./node_modules/froala-editor/js/plugins/file.min.js',
		'./node_modules/froala-editor/js/plugins/font_family.min.js',
		'./node_modules/froala-editor/js/plugins/font_size.min.js',
		'./node_modules/froala-editor/js/plugins/fullscreen.min.js',
		'./node_modules/froala-editor/js/plugins/image.min.js',
		'./node_modules/froala-editor/js/plugins/image_manager.min.js',
		'./node_modules/froala-editor/js/plugins/inline_style.min.js',
		'./node_modules/froala-editor/js/plugins/line_breaker.min.js',
		'./node_modules/froala-editor/js/plugins/link.min.js',
		'./node_modules/froala-editor/js/plugins/lists.min.js',
		'./node_modules/froala-editor/js/plugins/paragraph_format.min.js',
		'./node_modules/froala-editor/js/plugins/paragraph_style.min.js',
		'./node_modules/froala-editor/js/plugins/quick_insert.min.js',
		'./node_modules/froala-editor/js/plugins/quote.min.js',
		'./node_modules/froala-editor/js/plugins/table.min.js',
		'./node_modules/froala-editor/js/plugins/save.min.js',
		'./node_modules/froala-editor/js/plugins/url.min.js',
		'./node_modules/froala-editor/js/plugins/video.min.js',
		'./node_modules/froala-editor/js/languages/it.js',
	], './public/assets/js/factotum/editor.js');


	// Dashboard
	mix.scripts([
		'./node_modules/chart.js/Chart.js',
		'factotum/dashboard/analytics_utility.js',
		'factotum/dashboard/analytics_auth.js',
		'factotum/dashboard/analytics_week_over_week.js',
		'factotum/dashboard/analytics_year_over_year.js',
		'factotum/dashboard/analytics_top_browsers.js',
		'factotum/dashboard/analytics_top_countries.js',
		'factotum/dashboard/analytics_active_users.js',
		'factotum/dashboard/main.js',
	], './public/assets/js/factotum/dashboard.js');

	// Content Field
	mix.scripts([
		'factotum/content-field/main.js',
		'factotum/content-field/options.js',
		'factotum/content-field/files.js',
		'factotum/content-field/images.js',
		'factotum/content-field/linked-content.js',
	], './public/assets/js/factotum/content-field.js');

	// All the other scripts
	mix.scripts([
		// Content Type
		'resources/assets/js/factotum/content-type/main.js',

		// Content
		'factotum/content/main.js',

		// Media
		'factotum/media/upload.js',

		// Category
		'factotum/category/main.js',

		// Tools
		'factotum/tools/resize-media.js',

		// Utilities
		'factotum/utility.js'

	], './public/assets/js/factotum/main.js');

	// All the other scripts
	mix.scripts([
		// Media
		'factotum/media/upload.js',

		// Utilities
		'factotum/utility.js'

	], './public/assets/js/factotum/upload.js');


	// Assets to copy
	mix.copy( './node_modules/font-awesome/fonts/**',           'public/assets/fonts/factotum/');
	mix.copy( './node_modules/jquery-ui/themes/base/images/**', 'public/assets/css/factotum/images/');
	mix.copy( './resources/assets/media/factotum/**/*',         'public/assets/media/factotum/img/');
	mix.copy( './resources/assets/fonts/factotum/**/*',         'public/assets/fonts/factotum/');







	/**
	 *
	 * STYLES
	 *
	 */


	// Vendor (just Bootstrap v3)
	mix.sass( 'factotum/vendor.scss', 'public/assets/css/factotum/vendor.css');


	// Vendor UI
	mix
		.sass( 'factotum/vendor-ui.scss', 'resources/assets/css/factotum/vendor-ui.css')
		.styles([
			// UI Stuff
			'./node_modules/jquery-datetimepicker/build/jquery.datetimepicker.min.css',
			'./node_modules/select2/dist/css/select2.css',
			'./node_modules/lity/dist/lity.css',

			// VENDORS MODIFIED
			'resources/assets/css/factotum/vendor-ui.css'
		], 'public/assets/css/factotum/vendor-ui.css');


	// Froala (the editor)
	mix	.styles([
		'./node_modules/froala-editor/css/froala_editor.css',
		'./node_modules/froala-editor/css/froala_style.css',
		'./node_modules/codemirror/lib/codemirror.css',
		'./node_modules/froala-editor/css/plugins/char_counter.css',
		'./node_modules/froala-editor/css/plugins/code_view.css',
		'./node_modules/froala-editor/css/plugins/colors.css',
		'./node_modules/froala-editor/css/plugins/emoticons.css',
		'./node_modules/froala-editor/css/plugins/file.css',
		'./node_modules/froala-editor/css/plugins/fullscreen.css',
		'./node_modules/froala-editor/css/plugins/image.css',
		'./node_modules/froala-editor/css/plugins/image_manager.css',
		'./node_modules/froala-editor/css/plugins/line_breaker.css',
		'./node_modules/froala-editor/css/plugins/quick_insert.css',
		'./node_modules/froala-editor/css/plugins/table.css',
		'./node_modules/froala-editor/css/plugins/video.css'
	], 'public/assets/css/factotum/editor.css');


	// Main
	mix.sass( 'factotum/main.scss', 'public/assets/css/factotum/main.css');


});
