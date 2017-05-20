@extends('admin.layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
				<h1>@lang('factotum::tools.tools')</h1>
                <div class="btn-group" role="group">
                    <a href="{{ url('/admin/tools/resize-media') }}" class="btn btn-default btn-info">@lang('factotum::tools/resize_media.tool_name')</a>
                </div>
            </div>
        </div>
    </div>

@endsection
