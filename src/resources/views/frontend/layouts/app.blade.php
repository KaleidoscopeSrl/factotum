<!DOCTYPE html>
<html lang="en">
	<head>
		@include('frontend.layouts.metatags', array('content' => ( isset($content) ? $content : null)) )

		<!-- Styles -->
		<link href="/assets/css/main.css" rel="stylesheet">

		<!-- Scripts -->
		<script>
			window.Laravel = <?php echo json_encode([ 'csrfToken' => csrf_token() ]); ?>
		</script>
	</head>
	<body<?php echo ( isset($errorCode) ? ' class="error_' . $errorCode . '"' : '' ); ?>>
		@yield('content')
	</body>
</html>