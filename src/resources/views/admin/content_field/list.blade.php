@extends('factotum::admin.layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">		
				<h1>@lang('factotum::content_field.content_field_list')</h1>

				@foreach ($contentTypes as $contentType)
					<div class="row">
						<div class="col-sm-6">
							<h3 class="table-subtitle">{{ $contentType->content_type }}</h3>
						</div>
						<div class="col-sm-6 utility_btn">
							@if ( auth()->user()->canConfigure($contentType->id) )
								<a href="{{ url('/admin/content-field/create/' . $contentType->id) }}"
								   class="btn btn-default btn-info">@lang('factotum::generic.add_new') {{ $contentType->content_type }} @lang('factotum::content_field.field')</a>
							@endif
						</div>
					</div>

					<table class="table">

					@if ($contentType->content_fields)
						<thead>
							<tr>
								<th width="10%">#</th>
								<th width="70%">@lang('factotum::content_field.title')</th>
								<th width="20%">@lang('factotum::content_field.actions')</th>
								<th></th>
							</tr>
						</thead>
						<tbody class="content_fields_sortable">
							@foreach ($contentType->content_fields as $field)
							<tr data-id_item="<?php echo $field->id; ?>">
								<td width="10%"><strong>{{ $field->id }}</strong></td>
								<td width="70%">{{ $field->label }}</td>
								<td width="20%">
									@if ( auth()->user()->canConfigure($contentType->id) )
										<a href="{{ url('/admin/content-field/edit/' . $contentType->id . '/' . $field->id ) }}" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									@endif
									@if ( auth()->user()->canConfigure($contentType->id) )
										<a href="{{ url('/admin/content-field/delete/' . $field->id ) }}" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
									@endif
								</td>
								<td class="sort">
									<i class="fa fa-sort" aria-hidden="true"></i>
								</td>
							</tr>
							@endforeach
						</tbody>
					@endif
					</table>

				@endforeach

			</div>
		</div>
	</div>

	<script type="text/javascript">
		var sortContentFieldsURL = '<?php echo url('/admin/content-field/sort/'); ?>';
	</script>

@endsection