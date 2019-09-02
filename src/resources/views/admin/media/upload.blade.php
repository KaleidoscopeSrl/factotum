@extends('factotum::admin.layouts.app_no_layout')

@section('content')

<div class="upload_wrapper">

	<h3>Media</h3>

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation">
			<a href="#upload" aria-controls="upload_media" role="tab" data-toggle="tab">Upload</a>
		</li>
		<li role="presentation" class="active">
			<a href="#media_list" aria-controls="list_media" role="tab" data-toggle="tab">Lista</a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane" id="upload">

			<?php
			$fieldId = (isset($field->id) ? $field->id : $field->name);
			?>

			<div class="needsclick dropzone_cont"
                		 id="dropzone_file"
				 data-max-files="{{ $maxFiles }}"
				 data-field_name="{{ $field->name }}"
				 data-accepted-files="{{ $field->allowed_types }}"
				 data-mockfile="mockFile{{ $field->name }}"
				 data-fillable-hidden="{{ $field->name }}_hidden">

				<div class="dz-message needsclick">
					Drop files here or click to upload.
				</div>

				<div class="fallback">
					<input id="{{ $fieldId }}"
						   type="file" class="form-control" accept="image/*" multiple
						   name="{{ $field->name }}" @if ($field->mandatory) required @endif autofocus>
				</div>

			</div>

		</div>

		<div role="tabpanel" class="tab-pane active" id="media_list">

			@if ( count($media) > 0 )
				<div class="form-horizontal">
					<div class="row clearfix" id="media_list_container">

						@foreach ( $media as $m )
							<label for="media_id_{{ $m['id'] }}"
								   class="col col-xs-6 col-sm-3 media_thumb @if( isset($selected) && in_array($m['id'], $selected)) checked @endif"
								    data-filename="{{ $m['filename'] }}"
									data-size="{{ $m['size'] }}"
								    data-last_upload="{{ $m['updated_at'] }}"
								    data-url="{{ $m['url'] }}">

								@if ( $m['thumb'] )
									<img src="{{ $m['thumb'] }}" alt="" />
								@else
									<div class="icon_container">
										<span class="{{ $m['icon'] }}"></span>
									</div>
								@endif

								<div class="specs">
									<span class="filename">{{ $m['filename'] }}</span>
									<span class="size">{{ $m['size'] }}</span>
									<span class="last_upload">Last upload {{ $m['updated_at'] }}</span>
								</div>

								<div class="links">
									<a class="view_media" href="{{ $m['url'] }}" data-lity>VIEW</a> |
									<a href="javascript:void(0);" class="delete_media"
									   data-filename="{{ $m['filename'] }}"
									   data-toggle="confirmation"
									   data-title="{{ Lang::get('factotum::generic.are_sure') }}"
									   data-btn-ok-label="{{ Lang::get('factotum::generic.yes') }}"
									   data-btn-cancel-label="{{ Lang::get('factotum::generic.no')  }}">
										DELETE
									</a>
								</div>

								<div class="checkbox">
									@if ( $field->type == 'gallery' )
										<input type="checkbox" name="selected_images[]" value="{{ $m['id'] }}"
											   @if( isset($selected) && in_array($m['id'], $selected)) checked="checked" @endif
											   id="media_id_{{ $m['id'] }}">
									@else
										<input type="radio" name="selected_images[]" value="{{ $m['id'] }}"
											   @if( isset($selected) && in_array($m['id'], $selected)) checked="checked" @endif
											   id="media_id_{{ $m['id'] }}">
									@endif
									<span class="checkbox-material"><span class="check"></span></span>
								</div>

							</label>
						@endforeach

					</div>
				</div>
			@endif

		</div>
	</div>

	<div class="bnt_container">
		<button name="set_media"
				data-field_name="{{ $field->name }}"
				id="set_media" class="btn" disabled="disabled">{{ $btnLabel }}</button>
	</div>
</div>


<div id="dz_template">
	<div class="dz-preview dz-file-preview">
		<div class="dz-image">
			<img data-dz-thumbnail />
		</div>

		<div class="dz-details">
			<label class="title"></label>
			<div class="dz-error-message"></div>
			<div class="dz-filename"></div>
			<div class="specs"></div>
			<div class="dz-size"><span data-dz-size></span></div>
			<a class="dz-remove" href="javascript:undefined;" data-dz-remove>DELETE</a>
		</div>

		<div class="dz-progress">
			<div class="dz-upload" data-dz-uploadprogress><span class="progress-text"></span></div>
		</div>

		<div class="dz-overlay">
			<div class="centered">
				<label class="title"></label>
				<div class="dz-filename"></div>
				<div class="dz-size"><span data-dz-size></span></div>
				<div class="last_upload">Last upload 00/00/00 00:00</div>
				<div class="links">
					<a class="view" href="" target="_blank">VIEW</a> |
					<a class="dz-remove" href="javascript:undefined;" data-dz-remove>DELETE</a>
				</div>
			</div>
		</div>

		<div class="dz-confirm-delete">
			<div class="centered">
				<div class="question"></div>
				<div class="links">
					<a class="undo" href="javascript:undefined;">UNDO</a> |
					<a class="do_delete" href="javascript:undefined;">DELETE</a>
				</div>
			</div>
		</div>

	</div>

</div>

<script type="text/javascript">
	var mediaOffset = {{ $mediaOffset }},
		fieldName   = "{{ $field->name }}",
		isMultiple  = <?php echo ( $field->type == 'gallery' ? 'true' : 'false'); ?>;
</script>


<div id="single_media_template" class="hidden">

    <label for="media_id_%MEDIA_ID%"
           class="col col-xs-6 col-sm-3 media_thumb"
           data-filename="%MEDIA_FILENAME%"
           data-size="%MEDIA_SIZE%"
           data-last_upload="%MEDIA_LAST_UPLOAD%"
           data-url="%MEDIA_URL%">
		<img src="/assets/media/factotum/img/trans.gif" alt="" id="media_thumb_%MEDIA_ID%" />
		<div class="icon_container hidden">
			<span class="%MEDIA_ICON%"></span>
		</div>

		<div class="specs">
			<span class="filename">%MEDIA_FILENAME%</span>
			<span class="size">%MEDIA_SIZE%</span>
			<span class="last_upload">Last upload %MEDIA_LAST_UPLOAD%</span>
		</div>

		<div class="links">
			<a class="view_media" href="%MEDIA_URL%" data-lity>VIEW</a> |
			<a href="javascript:void(0);" class="delete_media"
			   data-filename="%MEDIA_FILENAME%"
			   data-toggle="confirmation"
			   data-title="{{ Lang::get('factotum::generic.are_sure') }}"
			   data-btn-ok-label="{{ Lang::get('factotum::generic.yes') }}"
			   data-btn-cancel-label="{{ Lang::get('factotum::generic.no')  }}">
				DELETE
			</a>
		</div>

		<div class="checkbox">
			<input type="checkbox" name="selected_images[]" value="%MEDIA_ID%"
				   id="media_id_%MEDIA_ID%">
			<span class="checkbox-material"><span class="check"></span></span>
		</div>

	</label>

</div>

@endsection
