<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Factotum') }}</title>

	<!-- Styles -->
	<link href="{{ url('/assets/css/factotum/vendor.css') }}?v={{ config('factotum.factotum.css_version') }}" rel="stylesheet">
	<link href="{{ url('/assets/css/factotum/vendor-ui.css') }}?v={{ config('factotum.factotum.css_version') }}" rel="stylesheet">

	@if ( isset($editor) )
	<link href="{{ url('/assets/css/factotum/editor.css') }}?v={{ config('factotum.factotum.css_version') }}" rel="stylesheet">
	@endif

	<link href="{{ url('/assets/css/factotum/main.css') }}?v={{ config('factotum.factotum.css_version') }}" rel="stylesheet">

	<!-- Scripts -->
	<script>
        window.Laravel = <?php echo json_encode([
			'csrfToken' => csrf_token(),
		]); ?>
	</script>

</head>
<body>