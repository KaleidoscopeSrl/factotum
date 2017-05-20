@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel">

				<div class="panel-heading">@lang('factotum::tools/resize_media.tool_name')</div>

				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ $postUrl }}">
						{{ csrf_field() }}
						<p>@lang('factotum::tools/resize_media.tool_description_1')</p>
						<p>@lang('factotum::tools/resize_media.tool_description_2')</p>
						<p>@lang('factotum::tools/resize_media.tool_description_3')</p>



						<div class="form-group">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-primary">@lang('factotum::tools/resize_media.tool_action')</button>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection
