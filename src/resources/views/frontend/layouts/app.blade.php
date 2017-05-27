<!DOCTYPE html>
<html lang="en">
	<head>
		@include('factotum::frontend.layouts.metatags', array('content' => $content))

		<!-- Styles -->
		<link href="/assets/css/frontend/main.css" rel="stylesheet">

		<!-- Scripts -->
		<script>
			window.Laravel = <?php echo json_encode([ 'csrfToken' => csrf_token() ]); ?>
		</script>
	</head>
	<body>
		@yield('content')
	</body>
</html>