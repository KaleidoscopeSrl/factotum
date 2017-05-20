@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
	<form class="form-horizontal" role="form" method="POST" action="{{ $postUrl }}">
		<div class="row">
			<div class="col-xs-12">
				<h1>{{ $title }}</h1> 
			</div>
			<div class="col-sm-6">
				<div class="panel">
					<div class="panel-heading">@lang('factotum::media.media_preview')</div>
					<div class="panel-body">		
						<img src="<?php echo url( $media->url ); ?>" alt="<?php echo $media->alt_text; ?>" width="100%" />		
					</div>
				</div> 
			</div>
			<div class="col-sm-6">
				<div class="panel">
					<div class="panel-heading">@lang('factotum::media.media_metadata')</div>
					<div class="panel-body">
						{{ csrf_field() }}				
						<?php
						$caption = new stdClass();
						$caption->name      = 'alt_text';
						$caption->label     = Lang::get('factotum::media.media_alternative_text');
						$caption->mandatory = false;
						$caption->type      = 'text';
						PrintField::print_field( $caption, $errors, $media->alt_text );

						$caption = new stdClass();
						$caption->name      = 'caption';
						$caption->label     = Lang::get('factotum::media.media_caption');
						$caption->mandatory = false;
						$caption->type      = 'textarea';
						PrintField::print_field( $caption, $errors, $media->caption );
						?>
					</div>
				</div>
			</div>

			<div class="col-sm-12">
				<div class="panel">
					<div class="panel-heading">@lang('factotum::media.media_description')</div>
					<div class="panel-body">
						<?php
						$caption = new stdClass();
						$caption->name      = 'description';
						$caption->label     = Lang::get('factotum::media.media_description_label');
						$caption->mandatory = false;
						$caption->type      = 'wysiwyg';
						PrintField::print_field( $caption, $errors, $media->description );
						?>
						<div class="form-group">
							<div class="col-md-12">
								<button type="submit" class="btn btn-primary">@lang('factotum::generic.save')</button>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div>
	</form>
</div>
@endsection
