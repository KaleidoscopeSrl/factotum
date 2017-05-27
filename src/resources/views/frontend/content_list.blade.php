@extends('frontend.layouts.app')

@section('content')

	<h1><?php echo $content['title']; ?></h1>

	<?php echo $content['content']; ?>

	<?php if ( isset( $contentList ) && count($contentList) > 0 ) { ?>
		<?php foreach ( $contentList as $c ) { ?>
			<a href="<?php echo url( Request::path() ) . '/' . $c['url']; ?>">
				<h2><?php echo $c['title']; ?></h2>
			</a>
			<hr />
		<?php } ?>
	<?php } ?>

	<?php PrintCategories::print_categories( 'news', $content['abs_url'] ); ?>

	<?php if ( isset($contentList) && $contentList instanceof Illuminate\Pagination\LengthAwarePaginator ) { ?>
		{{ $contentList->links() }}
	<?php } ?>

@endsection
