@extends('factotum::admin.layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel">

				<div class="panel-heading">@lang('factotum::tools/sitemap_settings.tool_name')</div>
				
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ $postUrl }}">
						{{ csrf_field() }}
						<p>@lang('factotum::tools/sitemap_settings.tool_description_1')</p>
						<p>@lang('factotum::tools/sitemap_settings.tool_description_2')</p>
						<div class="row">
							@foreach ($listContentType as $contentType)
							<div class="col-sm-12">
								<?php
								$tmpContentType = new stdClass();
								$tmpContentType->name        = 'contentType_'.$contentType->content_type;
								$tmpContentType->mandatory   = false;
								$tmpContentType->type        = 'checkbox';
								$tmpContentType->show_errors = true;
								$tmpContentType->options     = $contentType->content_type.':'.$contentType->content_type;
								PrintField::print_field( $tmpContentType, $errors, in_array($contentType->content_type, $settings) ? true : false );
								?>
							</div>
							@endforeach
							<div class="col-sm-12">
								<button type="submit" class="btn btn-primary">@lang('factotum::tools/sitemap_settings.tool_action')</button>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection
