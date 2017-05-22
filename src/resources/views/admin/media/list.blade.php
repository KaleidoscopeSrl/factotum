@extends('factotum::admin.layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
				<h1>@lang('factotum::media.media_list')</h1>
				<table class="table">
					<thead>
					   <tr>
						   <th width="10%">#</th>
						   <th>@lang('factotum::media.media_file')</th>
						   <th>@lang('factotum::media.media_mime_type')</th>
						   <th width="20%">@lang('factotum::media.actions')</th>
					   </tr> 
					</thead> 
					<tbody>
					@foreach ( $media as $file )
						<tr>
							<th scope="row">{{ $file->id }}</th>
							<td>
								<a href="{{ url('/admin/media/edit/' . $file->id) }}">{{ $file->filename }}</a>
							</td>
							<td>{{ $file->mime_type }}</td>
							<td>
								<a href="{{ url('/admin/media/edit/' . $file->id . ( isset($_GET['page']) ? '?page=' . $_GET['page'] : '') ) }}" class="edit">
									<i class="fa fa-pencil" aria-hidden="true"></i>
								</a>

								<a href="{{ url('/admin/media/delete/' . $file->id . ( isset($_GET['page']) ? '?page=' . $_GET['page'] : '') ) }}"
								   class="delete"
								   data-toggle="confirmation"
								   data-title="@lang('factotum::generic.are_sure')"
								   data-btn-ok-label="@lang('factotum::generic.yes')"
								   data-btn-cancel-label="@lang('factotum::generic.no')">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</a>
							</td>
						</tr>
					@endforeach	
					</tbody>
				</table>
				<div style="text-align: center;">
					{{ $media->links() }}
				</div>
			</div>
		</div>
	</div>

@endsection
