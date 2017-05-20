@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-6">
			<h1>{{ $contentType->content_type }}</h1>
		</div>
		<div class="col-sm-6 utility_btn">
			<div class="btn-group" role="group">
				<a href="{{ url('/admin/content/create/' . $contentTypeId) }}" class="btn btn-default btn-info">
					@lang('factotum::content.add_new') {{ $contentType->content_type }}
				</a>
			</div>
		</div>
		<div class="col-xs-12">
			<table class="table">
				<thead>
					<tr>
						<th width="10%">#</th>
						<th width="70%">@lang('factotum::content.title')</th>
						<th width="20%">@lang('factotum::content.actions')</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="contents_sortable">
					<?php PrintContentsTree::print_list($contents); ?>
				</tbody>
			</table>
			<div style="text-align: center;">
				{{ $contents->links() }}
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var sortContentsURL = '<?php echo url( '/admin/content/sort/' . $contentTypeId ); ?>';
</script>

@endsection