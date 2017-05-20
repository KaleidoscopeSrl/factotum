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

	mix.scripts([
		// jQuery + Bootstrap
		'./bower_components/jquery/dist/jquery.min.js',
		'./bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js',

		// Froala
		'./bower_components/froala-wysiwyg-editor/js/froala_editor.min.js',
		'./node_modules/codemirror/lib/codemirror.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/align.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/char_counter.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/code_beautifier.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/code_view.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/colors.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/emoticons.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/entities.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/file.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/font_family.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/font_size.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/fullscreen.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/image.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/image_manager.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/inline_style.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/line_breaker.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/link.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/lists.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/paragraph_format.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/paragraph_style.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/quick_insert.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/quote.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/table.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/save.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/url.min.js',
		'./bower_components/froala-wysiwyg-editor/js/plugins/video.min.js',
		'./bower_components/froala-wysiwyg-editor/js/languages/it.js',

		// jQuery Plugins
		'./bower_components/datetimepicker/build/jquery.datetimepicker.full.min.js',
		'./bower_components/jquery-ui/ui/widget.js',
		'./bower_components/jquery-ui/ui/data.js',
		'./bower_components/jquery-ui/ui/scroll-parent.js',
		'./bower_components/jquery-ui/ui/widgets/mouse.js',
		'./bower_components/jquery-ui/ui/widgets/sortable.js',
		'./bower_components/jquery-ui/ui/widgets/progressbar.js',
		// './bower_components/searchable-list/sol-2.0.0.js',
		'./bower_components/select2/dist/js/select2.js',

		'./bower_components/dropzone/dist/dropzone.js',


		// Content Type
		'resources/assets/js/factotum/content-type/main.js',

		// Content Field
		'factotum/content-field/main.js',
		'factotum/content-field/options.js',
		'factotum/content-field/files.js',
		'factotum/content-field/images.js',
		'factotum/content-field/linked-content.js',

		// Content
		'factotum/content/main.js',

		// Category
		'factotum/category/main.js',

		// Tools
		'factotum/tools/resize-media.js',

		// Utilities
		'factotum/utility.js'

	], 'public/assets/js/factotum/main.js');

	mix.copy( './bower_components/font-awesome/fonts/**', 'public/assets/fonts/factotum/');
	mix.copy( './bower_components/jquery-ui/themes/base/images/**', 'public/assets/css/factotum/images/');
	mix.copy( './resources/assets/media/factotum/**/*', 'public/assets/media/factotum/img/');
	mix.copy( './resources/assets/fonts/factotum/**/*', 'public/assets/fonts/factotum/');

	mix.sass( 'factotum/main.scss', 'resources/assets/css/factotum/main.css')

	.styles([
		// Froala
		'./bower_components/froala-wysiwyg-editor/css/froala_editor.css',
		'./bower_components/froala-wysiwyg-editor/css/froala_style.css',
		'./node_modules/codemirror/lib/codemirror.css',
		'./bower_components/froala-wysiwyg-editor/css/plugins/char_counter.css',
		'./bower_components/froala-wysiwyg-editor/css/plugins/code_view.css',
		'./bower_components/froala-wysiwyg-editor/css/plugins/colors.css',
		'./bower_components/froala-wysiwyg-editor/css/plugins/emoticons.css',
		'./bower_components/froala-wysiwyg-editor/css/plugins/file.css',
		'./bower_components/froala-wysiwyg-editor/css/plugins/fullscreen.css',
		'./bower_components/froala-wysiwyg-editor/css/plugins/image.css',
		'./bower_components/froala-wysiwyg-editor/css/plugins/image_manager.css',
		'./bower_components/froala-wysiwyg-editor/css/plugins/line_breaker.css',
		'./bower_components/froala-wysiwyg-editor/css/plugins/quick_insert.css',
		'./bower_components/froala-wysiwyg-editor/css/plugins/table.css',
		'./bower_components/froala-wysiwyg-editor/css/plugins/video.css',

		// Bootstrap and Plugins
		'./bower_components/datetimepicker/build/jquery.datetimepicker.min.css',
		'./bower_components/select2/dist/css/select2.css',

		'factotum/main.css'
	], 'public/assets/css/factotum/main.css');

});
