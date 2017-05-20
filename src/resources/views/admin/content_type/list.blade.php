@extends('admin.layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-6">
				<h1>@lang('factotum::content_type.content_type_list')</h1>
			</div>
			<div class="col-sm-6 utility_btn">
			  <div class="btn-group" role="group">
				  <a href="{{ url('/admin/content-type/create') }}" class="btn btn-default btn-info">@lang('factotum::content_type.add_new_content_type')</a>
			  </div>
			</div>
			<div class="col-xs-12">
				<table class="table">
					<thead>
						<tr>
							<th width="10%">#</th>
							<th width="70%">@lang('factotum::content_type.content_type')</th>
							<th width="20%">@lang('factotum::content_type.actions')</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($contentTypes as $contentType)
						<tr>
							<th scope="row">{{ $contentType->id }}</th>
							<td>
								@if ( $contentType->editable || (!$contentType->editable && auth()->user()->isAdmin()) )
									<a href="{{ url('/admin/content-type/detail/' . $contentType->id) }}">{{ $contentType->content_type }}</a>
								@else
									{{ $contentType->content_type }}
								@endif
							</td>
							<td>
								@if ( $contentType->editable || (!$contentType->editable && auth()->user()->isAdmin()) )
								<a href="{{ url('/admin/content-type/edit/' . $contentType->id) }}" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								@endif
								@if ( $contentType->editable || (!$contentType->editable && auth()->user()->isAdmin()) )
								<a href="{{ url('/admin/content-type/delete/' . $contentType->id) }}" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
								@endif
							</td>
						</tr>
					@endforeach
					</tbody>					
				</table>
			</div>
		</div>
	</div>

@endsection
