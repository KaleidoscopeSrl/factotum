@extends('frontend.layouts.app')

@section('content')

	<h1><?php echo $content['title']; ?></h1>

	<?php echo $content['content']; ?>

@endsection
