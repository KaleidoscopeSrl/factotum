@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel">

				<div class="panel-body">

					<p>@lang('factotum::tools/resize_media.tool_action_text_1')</p>
					<p>
						@lang('factotum::tools/resize_media.tool_action_text_2')
						<a href="javascript:history.go(-1);">
							@lang('factotum::tools/resize_media.tool_action_text_3')
						</a>
					</p>
					<div class="resize_media_bar">
						<div class="bar"></div>
						<div class="percentage"></div>
					</div>

					<button id="resize-media-stop" class="btn btn-primary">@lang('factotum::tools/resize_media.tool_abort')</button>

					<h3 class="title">@lang('factotum::tools/resize_media.tool_debugging_title')</h3>

					<p>
						@lang('factotum::tools/resize_media.tool_total_images'): {{ $count }}<br>
						@lang('factotum::tools/resize_media.tool_images_resized'): <span class="resize_media_success">0</span><br>
						@lang('factotum::tools/resize_media.tool_resize_failures'): <span class="resize_media_failure">0</span>
					</p>

					<div class="message" style="display: none;"></div>

					<ol class="resize_media_debuglist">
						<li style="display: none;"></li>
					</ol>

				</div>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var resizableMedia = [<?php echo $resizableMedia; ?>];
</script>

@endsection
