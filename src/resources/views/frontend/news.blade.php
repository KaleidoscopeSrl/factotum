@extends('frontend.layouts.app')

@section('content')

	<div class="container">
		<h1><?php echo $content->title; ?></h1>
		<h4><?php echo $content->news_subtitle; ?></h4>
		<p><?php echo $content->content; ?></p>
	</div>

@endsection
