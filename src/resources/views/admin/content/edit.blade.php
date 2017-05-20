@extends('admin.layouts.app')

@section('content')

<form 
	class="form-horizontal" 
	role="form" 
	method="POST" 
	action="{{ $postUrl }}"
	enctype="multipart/form-data" 
	id="edit_content_form">

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h1>{{ $title }} </h1>
			</div>
			<div class="col-md-8">
				{{ csrf_field() }}	
				<div class="panel">
					<div class="panel-body">

						<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
							<div class="col-sm-12">
								<label for="field_label" class="control-label">@lang('factotum::content.title')</label>
								<input id="title" type="text" class="form-control" name="title" value="{{ old('title', (isset($content) ? $content->title : null)) }}" required autofocus>
								@if ($errors->has('title'))
								<span class="help-block">
									<strong>{{ $errors->first('title') }}</strong>
								</span>
								@endif

								<?php if ( $contentType->content_type == 'page' ) { ?>
								<div class="form-group{{ $errors->has('abs_url') ? ' has-error' : '' }}">
									<div class="col-md-12">
										<input id="abs_url" type="hidden" class="form-control" readonly
										name="abs_url" data-baseurl="{{ url( ( $currentLanguage != config('factotum.main_site_language') ? $currentLanguage : '') ) }}"
										value="{{ old('abs_url', (isset($content) ? $content->abs_url : null)) }}" required>
										<a href="{{ old('abs_url', (isset($content) ? $content->abs_url : null)) }}" class="page_link">{{ old('abs_url', (isset($content) ? $content->abs_url : null)) }}</a>

										@if ($errors->has('abs_url'))
										<span class="help-block">
											<strong>{{ $errors->first('abs_url') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
							<div class="col-md-12">
								<label for="url" class="control-label">URL</label>
								<input id="url" type="text" class="form-control"
								name="url" value="{{ old('url', (isset($content) ? $content->url : null)) }}" required autofocus>

								@if ($errors->has('url'))
								<span class="help-block">
									<strong>{{ $errors->first('url') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<?php if ( $contentType->content_type == 'page' ) { ?>

						<div class="form-group{{ $errors->has('show_in_menu') ? ' has-error' : '' }}">
							<div class="col-md-12">
								<label for="show_in_menu" class="control-label">@lang('factotum::content.show_in_menu')</label>
								<input type="radio" name="show_in_menu" id="show_in_menu_yes" value="1"
								<?php echo ( old('show_in_menu', (isset($content) ? $content->show_in_menu : null)) == 1 ? 'checked="checked"' : ''); ?>/>
								<label for="show_in_menu_yes">@lang('factotum::content.yes')</label>

								<input type="radio" name="show_in_menu" id="show_in_menu_no" value="0"
								<?php echo ( old('show_in_menu', (isset($content) ? $content->show_in_menu : null)) == 0 ? 'checked="checked"' : ''); ?>/>
								<label for="show_in_menu_no">@lang('factotum::content.no')</label>

								@if ($errors->has('show_in_menu'))
								<span class="help-block">
									<strong>{{ $errors->first('show_in_menu') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<?php } ?>

						<?php if ( $contentType->content_type != 'page' && isset($categoriesTree) ) { ?>

						<div class="form-group<?php echo ($errors->has('categories') ? ' has-error' : '' ); ?>">
							<div class="col-md-12">
								<label for="categories" class="control-label">@lang('factotum::content.categories')</label>
								<?php PrintCategoriesDropdownTree::print_dropdown( $categoriesTree, 'categories', old('categories', (isset($contentCategories) ? $contentCategories : null)), 'categories', 'form-control multiselect', true ); ?>

								@if ($errors->has('categories'))
								<span class="help-block">
									<strong>{{ $errors->first('categories') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<?php } ?>

						<!-- Main Content -->
						<div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
							<div class="col-md-12">
								<label for="content" class="control-label">@lang('factotum::content.content')</label>
								<textarea name="content" id="content" class="form-control wysiwyg"
								rows="5">{{ old('content', (isset($content) ? $content->content : null)) }}</textarea>

								@if ($errors->has('content'))
								<span class="help-block">
									<strong>{{ $errors->first('content') }}</strong>
								</span>
								@endif
							</div>
						</div>
					</div>
				</div>

				<?php if ( count($contentFields) > 0 ) { ?>
				<div class="panel">

					<?php if ( $contentType->content_type == 'page') { ?>
						<div class="panel-heading">@lang('factotum::content.page_operations')</div>
					<?php } else { ?>
						<div class="panel-heading">@lang('factotum::content.additional_fields')</div>
					<?php } ?>

						<div class="panel-body">
						<?php
						if ( count($contentFields) > 0 ) {
							foreach ($contentFields as $field) {
								PrintField::print_field( $field, $errors, (isset($additionalValues->{$field->name}) ? $additionalValues->{$field->name} : null) );
							}
						}
						?>

						<?php if ( $contentType->content_type == 'page' ) { ?>

						<div class="form-group" id="form-group-link">
							<div class="col-md-12">
								<label for="" class="control-label">@lang('factotum::content.link')</label>
								<input id="link" type="text" class="form-control" name="link"
								value="{{ old('link', (isset($content) ? $content->link : null)) }}" autofocus>
							</div>
						</div>

						<div class="form-group" id="form-group-link_title">
							<div class="col-md-12">
								<label for="link_title" class="control-label">@lang('factotum::content.link_title')</label>
								<input id="link_title" type="text" class="form-control" name="link_title"
								value="{{ old('link_title', (isset($content) ? $content->link_title : null)) }}" autofocus>
							</div>
						</div>

						<div class="form-group" id="form-group-link_open_in">
							<div class="col-md-12">
								<label for="link_open_in" class="control-label">@lang('factotum::content.link_open_in')</label>
								<div class="select-wrapper">
									<select name="link_open_in" id="link_open_in" class="form-control multiple" autofocus>
										<option value="_self" <?php echo ( old('link_open_in', (isset($content) ? $content->link_open_in : null)) == '_self' ? 'selected' : ''); ?>>@lang('factotum::content.same_page')</option>
										<option value="_blank" <?php echo ( old('link_open_in', (isset($content) ? $content->link_open_in : null)) == '_blank' ? 'selected' : ''); ?>>@lang('factotum::content.new_page')</option>
										<option value="popup" <?php echo ( old('link_open_in', (isset($content) ? $content->link_open_in : null)) == 'popup' ? 'selected' : ''); ?>>@lang('factotum::content.popup')</option>
									</select>
								</div>
							</div>
						</div>

						<?php } ?>
					</div>
				</div>
			<?php } ?>

		</div>

		<div class="col-md-4">
			<div class="panel">
				<div class="panel-body">
				<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
					<div class="col-md-12">
						<label for="status" class="control-label">@lang('factotum::content.status')</label>
						<div class="select-wrapper">
							<select name="status" id="status" class="form-control multiple" required autofocus>
								@foreach ($statuses as $status => $label)
								<option value="{{ $status }}"
								<?php echo ( old('status', (isset($content) ? $content->status : null)) == $status ? 'selected' : ''); ?>>{{ $label }}</option>
								@endforeach
							</select>
						</div>

						@if ($errors->has('status'))
						<span class="help-block">
							<strong>{{ $errors->first('status') }}</strong>
						</span>
						@endif
					</div>
				</div>

				<?php if ( $contentType->content_type == 'page' ) { ?>
				<div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
					<div class="col-md-12">
						<label for="parent_id" class="control-label">@lang('factotum::content.parent_content')</label>
						<?php PrintContentsDropdownTree::print_dropdown( $contentsTree, 'parent_id', old('parent_id', (isset($content) ? $content->parent_id : null)), 'parent_id', 'form-control', false, false, ( isset($content) ? $content->id : null) ); ?>

						@if ($errors->has('parent_id'))
						<span class="help-block">
							<strong>{{ $errors->first('parent_id') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<?php } ?>
				<div class="form-group">
					<div class="col-xs-12">
						<button type="submit" class="btn btn-primary">@lang('factotum::generic.save')</button>
					</div>
				</div>
				</div>
			</div>

			<div class="panel">
				<div class="panel-heading">SEO</div>
				<div class="panel-body">
					
					<div class="form-group{{ $errors->has('seo_description') ? ' has-error' : '' }}">
						<div class="col-md-12">
							<label for="seo_description" class="control-label">@lang('factotum::content.seo_description')</label>
							<input id="seo_description" type="text" class="form-control" maxlength="160"
							name="seo_description" value="{{ old('seo_description', (isset($content) ? $content->seo_description : null)) }}" autofocus>

							@if ($errors->has('seo_description'))
							<span class="help-block">
								<strong>{{ $errors->first('seo_description') }}</strong>
							</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('seo_canonical_url') ? ' has-error' : '' }}">
						<div class="col-md-12">
							<label for="seo_canonical_url" class="control-label">@lang('factotum::content.seo_canonical_url')</label>
							<input id="seo_canonical_url" type="text" class="form-control"
							name="seo_canonical_url" value="{{ old('seo_canonical_url', (isset($content) ? $content->seo_canonical_url : null)) }}" autofocus>

							@if ($errors->has('seo_canonical_url'))
							<span class="help-block">
								<strong>{{ $errors->first('seo_canonical_url') }}</strong>
							</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('seo_robots_indexing') ? ' has-error' : '' }}">
						<div class="col-md-12">
							<label for="seo_robots_indexing" class="control-label">@lang('factotum::content.seo_robots_indexing') *</label>
							<div class="row">
								<div class="form-control" style="border: none; box-shadow: none;">
									<input type="radio" id="seo_robots_indexing_index" name="seo_robots_indexing" value="index"
									<?php echo ( old('seo_robots_indexing', (isset($content) ? $content->seo_robots_indexing : 'index')) == 'index' ? 'checked' : ''); ?>>
									<label for="seo_robots_indexing_index">Index</label>

									<input type="radio" id="seo_robots_indexing_noindex" name="seo_robots_indexing" value="noindex"
									<?php echo ( old('seo_robots_indexing', (isset($content) ? $content->seo_robots_indexing : null)) == 'noindex' ? 'checked' : ''); ?>>
									<label for="seo_robots_indexing_noindex"> No Index</label>
								</div>

								@if ($errors->has('seo_robots_indexing'))
								<span class="help-block">
									<strong>{{ $errors->first('seo_robots_indexing') }}</strong>
								</span>
								@endif
							</div>
						</div>
					</div>

					<div class="form-group{{ $errors->has('seo_robots_following') ? ' has-error' : '' }}">
						<div class="col-md-12">

							<label for="seo_robots_following" class="control-label">@lang('factotum::content.seo_robots_following') *</label>
							<div class="row">
								<div class="form-control" style="border: none; box-shadow: none;">
									<input type="radio" id="seo_robots_following_follow" name="seo_robots_following" value="follow"
										<?php echo ( old('seo_robots_following', (isset($content) ? $content->seo_robots_following : 'follow')) == 'follow' ? 'checked' : ''); ?>> 
										<label for="seo_robots_following_follow">@lang('factotum::content.seo_robots_following_follow')</label>
										<input type="radio" id="seo_robots_following_nofollow" name="seo_robots_following" value="nofollow"
										<?php echo ( old('seo_robots_following', (isset($content) ? $content->seo_robots_following : null)) == 'nofollow' ? 'checked' : ''); ?> > <label for="seo_robots_following_nofollow">@lang('factotum::content.seo_robots_following_nofollow')</label>
								</div>
							</div>

							@if ($errors->has('seo_robots_following'))
							<span class="help-block">
								<strong>{{ $errors->first('seo_robots_following') }}</strong>
							</span>
							@endif
						</div>
					</div>

				</div>
			</div>
			<div class="panel">
				<div class="panel-heading">Facebook</div>
				<div class="panel-body">
					<div class="form-group{{ $errors->has('fb_title') ? ' has-error' : '' }}">
						<div class="col-md-12">
							<label for="field_label" class="control-label">@lang('factotum::content.fb_title')</label>
							<input id="fb_title" type="text" class="form-control"
							name="fb_title" value="{{ old('fb_title', (isset($content) ? $content->fb_title : null)) }}" autofocus>

							@if ($errors->has('fb_title'))
							<span class="help-block">
								<strong>{{ $errors->first('fb_title') }}</strong>
							</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('fb_description') ? ' has-error' : '' }}">
						<div class="col-md-12">
							<label for="fb_description" class="control-label">@lang('factotum::content.fb_description')</label>
							<input id="fb_description" type="text" class="form-control" maxlength="160"
							name="fb_description" value="{{ old('fb_description', (isset($content) ? $content->fb_description : null)) }}" autofocus>

							@if ($errors->has('fb_description'))
							<span class="help-block">
								<strong>{{ $errors->first('fb_description') }}</strong>
							</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('fb_image') ? ' has-error' : '' }}">
						<div class="col-md-12">
							<label for="fb_image" class="control-label">@lang('factotum::content.fb_image')</label>
							<div class="needsclick dropzone_cont"
							data-max-files="1"
							data-field_id="fb_image"
							data-accepted-files=".jpg,.png"
							data-mockfile="mockFile_fb_image"
							data-fillable-hidden="fb_image_hidden">

								<div class="dz-message needsclick">
									@lang('factotum::content.dropzone')
								</div>

								<div class="fallback">
									<input id="fb_image" type="file" class="form-control" accept="image/*" multiple
									name="fb_image" autofocus>
								</div>

								<?php
								$fbImage = old('fb_image', (isset($content->fb_image) ? $content->fb_image : null));

								if ( ( isset($fbImage) && is_array($fbImage) && count($fbImage) > 0 ) ) {
									$filename = substr( $fbImage['url'], 0, strlen($fbImage['url']) - 4) . '-thumb';
									$ext = substr( $fbImage['url'], strlen($fbImage['url']) - 3, 3);
									?>

									<script type="text/javascript">
										var mockFile_fb_image = {
											name: '<?php echo $fbImage['filename']; ?>',
											size: <?php echo Storage::size( $fbImage['url'] ); ?>,
											type: '<?php echo $fbImage['mime_type']; ?>',
											thumb: '<?php echo asset( $filename . '.' . $ext ); ?>'
										};
									</script>

									<?php } ?>

									<input type="hidden" id="fb_image_hidden"
									name="fb_image_hidden"
									value="<?php echo ( isset($fbImage) && is_array($fbImage) ? $fbImage['id'] : '' ); ?>" />

								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection
