@extends('layouts.app')

@section('content')

	<div class="container">
		<h1><?php echo $content->title; ?></h1>

		<p><?php echo $content->content; ?></p>

		<?php if ( isset( $contentList ) && $contentList->count() > 0 ) { ?>
			<?php foreach ( $contentList as $c ) { ?>
				<a href="<?php echo url( Request::path() ) . '/' . $c->url; ?>">
					<h2><?php echo $c->title; ?></h2>
				</a>
				<hr />
			<?php } ?>
		<?php } ?>

		<?php PrintCategories::print_categories( 'news', $content->abs_url ); ?>

		<?php if ( isset($contentList) && $contentList instanceof Illuminate\Pagination\LengthAwarePaginator ) { ?>
			<div class="tac">
				{{ $contentList->links() }}
			</div>
		<?php } ?>

	</div>

@endsection
