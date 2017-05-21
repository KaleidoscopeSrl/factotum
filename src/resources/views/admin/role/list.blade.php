@extends('factotum::admin.layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row">
		<div class="col-xs-12">
				<div class="row ">
					<div class="col-sm-6">
						<h1>@lang('factotum::role.role_list')</h1>
					</div>
					<div class="col-sm-6 utility_btn">
						<div class="btn-group" role="group">
							<a href="{{ url('/admin/role/create') }}" class="btn btn-default btn-info">@lang('factotum::role.add_new_role')</a>
						</div>
					</div>
				</div>

				<table class="table">
					<thead>
						<tr>
							<th width="10%">#</th>
							<th width="70%">@lang('factotum::role.role')</th>
							<th width="20%">@lang('factotum::role.actions')</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($roles as $role)
						<tr>
							<th scope="row">{{ $role->id }}</th>
							<td>
								@if ( $role->editable || (!$role->editable && auth()->user()->isAdmin()) )
									<a href="{{ url('/admin/role/edit/' . $role->id) }}">{{ $role->role }}</a>
								@else
									{{ $role->role }}
								@endif
							</td>
							<td>
								@if ( $role->editable || (!$role->editable && auth()->user()->isAdmin()) )
								<a href="{{ url('/admin/role/edit/' . $role->id) }}" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								@endif
								@if ( $role->editable || (!$role->editable && auth()->user()->isAdmin()) )
								<a href="{{ url('/admin/role/delete/' . $role->id) }}" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
