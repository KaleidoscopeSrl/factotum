@extends('factotum::admin.layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-6">
				<h1>@lang('factotum::user.user_list')</h1>
			</div>
			<div class="col-sm-6 utility_btn">
				<div class="btn-group" role="group">
					<a href="{{ url('/admin/user/create') }}" class="btn btn-default btn-info">@lang('factotum::user.add_new_user')</a>
				</div>
			</div>
			<div class="col-xs-12">
				<table class="table">
					<thead>
						<tr>
							<th width="10%">#</th>
							<th width="15%">@lang('factotum::user.first_name')</th>
							<th width="15%">@lang('factotum::user.last_name')</th>
							<th width="40%">Email</th>
							<th width="20%">@lang('factotum::user.actions')</th>
						</tr>
					</thead>

					@foreach ($users as $user)
						<tr>
							<th scope="row">{{ $user->id }}</th>
							<td  width="50px">{{ $user->profile->first_name }}</td>
							<td>{{ $user->profile->last_name }}</td>
							<td  width="50px">
								@if ( $user->editable || (!$user->editable && auth()->user()->isAdmin()) )
									<a href="{{ url('/admin/user/edit/' . $user->id) }}">{{ $user->email }}</a>
								@else
									{{ $user->email }}
								@endif
								
							</td>
							<td>
								@if ( $user->editable || (!$user->editable && auth()->user()->isAdmin()) )
									<a href="{{ url('/admin/user/edit/' . $user->id) }}" class="edit">
										<i class="fa fa-pencil" aria-hidden="true"></i>
									</a>
								@endif
								@if ( $user->editable || (!$user->editable && auth()->user()->isAdmin()) )
									<a href="{{ url('/admin/user/delete/' . $user->id) }}" class="delete"
									   data-toggle="confirmation"
									   data-title="@lang('factotum::generic.are_sure')"
									   data-btn-ok-label="@lang('factotum::generic.yes')"
									   data-btn-cancel-label="@lang('factotum::generic.no')">
										<i class="fa fa-trash" aria-hidden="true"></i>
									</a>
								@endif
							</td>
						</tr>
					@endforeach

				</table>
			</div>
		</div>
	</div>

@endsection
