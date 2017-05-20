@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-6">
			<h1>@lang('factotum::capability.capabilities_list')</h1>
		</div>
		<div class="col-sm-6 utility_btn">
			<div class="btn-group" role="group">
				<a href="{{ url('/admin/capability/create') }}" class="btn btn-default btn-info">@lang('factotum::capability.add_new_capability')</a>
			</div>
		</div>
		<div class="col-xs-12">
			<table class="table">
				<thead>
					<tr>
						<th width="10%">#</th>
						<th>@lang('factotum::capability.role')</th>
						<th>@lang('factotum::capability.content_type')</th>
						<th width="20%">@lang('factotum::capability.actions')</th>
					</tr>
				</thead>

				@foreach ($capabilities as $capability)
				<tr>
					<th scope="row">{{ $capability->id }}</th>
					<td>
						<a href="{{ url('/admin/capability/edit/' . $capability->id) }}">
							{{ $capability->role->role }}
						</a>
					</td>
					<td>
						{{ $capability->content_type->content_type }}
					</td>
					<td>
						<a href="{{ url('/admin/capability/edit/' . $capability->id) }}" class="edit">
							<i class="fa fa-pencil" aria-hidden="true"></i>
						</a>
						<a href="{{ url('/admin/capability/delete/' . $capability->id) }}" class="delete">
							<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
					</td>
				</tr>
				@endforeach

			</table>
		</div>
	</div>
</div>

@endsection
