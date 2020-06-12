<!DOCTYPE html>
<html lang="en">
<head>
	@include('layouts.metatags', ['content' => ( isset($content) ? $content : null), 'metatags' => ( isset($metatags) ? $metatags : null )] )

	<!-- Styles -->
	<link href="/assets/css/main.css" rel="stylesheet">

	<!-- Scripts -->
	<script>
		window.Laravel = <?php echo json_encode([ 'csrfToken' => csrf_token() ]); ?>
	</script>
</head>
<body<?php echo ( isset($errorCode) ? ' class="error_' . $errorCode . '"' : '' ); ?>>

	@yield('content')

	@if ( session('message') )
		<div class="toast toast-success" role="alert">
			{{ session('message') }}

			<button>
				<i class="fi flaticon-trash"></i>
			</button>
		</div>
	@endif

	@if ( session('error') )
		<div class="toast toast-error" role="alert">
			{{ session('v') }}

			<button>
				<i class="fi flaticon-trash"></i>
			</button>
		</div>
	@endif

</body>
</html>