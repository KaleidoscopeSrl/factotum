@extends('factotum::admin.layouts.app')

@section('content')

<form class="form-horizontal" role="form" method="POST" action="{{ $postUrl }}"
	  enctype="multipart/form-data" id="edit_content_form">
	{{ csrf_field() }}

	<div class="container-fluid">

		<div class="row">

			<div class="col-sm-12">
				<h1>{{ $title }} </h1>
			</div>

			<div class="col-md-8">

				<div class="panel">
					<div class="panel-body">

						<div class="row">
							<div class="col-xs-12">
								<?php
								$contentTitle = new stdClass();
								$contentTitle->name        = 'title';
								$contentTitle->label       = Lang::get('factotum::content.title');
								$contentTitle->mandatory   = true;
								$contentTitle->type        = 'text';
								$contentTitle->show_errors = true;
								PrintField::print_field( $contentTitle, $errors, isset($content) ? $content->title : null );
								?>
							</div>

							@if ( $contentType->content_type == 'page' )
								<div class="col-xs-12">
									<?php
									$absUrl = new stdClass();
									$absUrl->name        = 'abs_url';
									$absUrl->label       = null;
									$absUrl->mandatory   = true;
									$absUrl->type        = 'hidden';
									$absUrl->readonly    = true;
									$absUrl->data_attrs  = array(
										'baseurl' => url( ( $currentLanguage != config('factotum.main_site_language') ? $currentLanguage : '') )
									);
									$absUrl->show_errors = true;
									PrintField::print_field( $absUrl, $errors, old('abs_url', (isset($content) ? $content->abs_url : null)) );
									?>
									<a href="{{ old('abs_url', (isset($content) ? $content->abs_url : null)) }}" class="page_link">{{ old('abs_url', (isset($content) ? $content->abs_url : null)) }}</a>
								</div>
							@endif
						</div>

						<div class="row">
							<div class="col-xs-12">
								<?php
								$url = new stdClass();
								$url->name        = 'url';
								$url->label       = 'URL';
								$url->mandatory   = true;
								$url->type        = 'text';
								$url->show_errors = true;
								PrintField::print_field( $url, $errors, old('url', (isset($content) ? $content->url : null)) );
								?>
							</div>
							@if ( $contentType->content_type == 'page' )
								<div class="col-xs-12">
									<?php
									$showInMenu = new stdClass();
									$showInMenu->name      = 'show_in_menu';
									$showInMenu->label     =  Lang::get('factotum::content.show_in_menu');
									$showInMenu->mandatory = false;
									$showInMenu->type      = 'radio';
									$showInMenu->show_errors = true;
									$options = array(
										0 => Lang::get('factotum::content.no'),
										1 => Lang::get('factotum::content.yes')
									);
									$opts = array();
									foreach ($options as $ind => $lab) {
										$opts[] =  $ind . ':' . $lab;
									}
									$showInMenu->options = join(';', $opts);
									PrintField::print_field( $showInMenu, $errors, old('show_in_menu', (isset($content) ? $content->show_in_menu : null)) );
									?>
								</div>
							@endif
						</div>

						@if ( $contentType->content_type != 'page' && isset($categoriesTree) )
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
						@endif


						<!-- Main Content -->
						<div class="row">
							<div class="col-xs-12">
								<?php
								$contentText = new stdClass();
								$contentText->name        = 'content';
								$contentText->label       = Lang::get('factotum::content.content');
								$contentText->mandatory   = false;
								$contentText->type        = 'wysiwyg';
								$contentText->show_errors = true;
								PrintField::print_field( $contentText, $errors, old('content', (isset($content) ? $content->content : null)) );
								?>
							</div>
						</div>

					</div>
				</div>

				@if ( count($contentFields) > 0 )
				<div class="panel">

					@if ( $contentType->content_type == 'page' )
						<div class="panel-heading">@lang('factotum::content.page_operations')</div>
					@else
						<div class="panel-heading">@lang('factotum::content.additional_fields')</div>
					@endif

						<div class="panel-body">

							@if ( count($contentFields) > 0 )
								@foreach ($contentFields as $field)
									<?php PrintField::print_field( $field, $errors, (isset($additionalValues->{$field->name}) ? $additionalValues->{$field->name} : null) ); ?>
								@endforeach
							@endif

							@if ( $contentType->content_type == 'page' )
								<?php
								$contentLink = new stdClass();
								$contentLink->name        = 'link';
								$contentLink->label       = Lang::get('factotum::content.link');
								$contentLink->mandatory   = false;
								$contentLink->type        = 'text';
								$contentLink->show_errors = true;
								PrintField::print_field( $contentLink, $errors, old('link', (isset($content) ? $content->link : null)) );
								?>

								<div id="form-group-link_title">
									<?php
									$contentLinkTitle = new stdClass();
									$contentLinkTitle->name        = 'link_title';
									$contentLinkTitle->label       = Lang::get('factotum::content.link_title');
									$contentLinkTitle->mandatory   = false;
									$contentLinkTitle->type        = 'text';
									$contentLinkTitle->show_errors = true;
									PrintField::print_field( $contentLinkTitle, $errors, old('link_title', (isset($content) ? $content->link_title : null)) );
									?>
								</div>

								<div id="form-group-link_open_in">
									<?php
									$contentLinkOpen = new stdClass();
									$contentLinkOpen->name        = 'link_open_in';
									$contentLinkOpen->label       = Lang::get('factotum::content.link_open_in');
									$contentLinkOpen->mandatory   = false;
									$contentLinkOpen->type        = 'select';
									$contentLinkOpen->show_errors = true;
									$options = array(
										'_self'  => Lang::get('factotum::content.same_page'),
										'_blank' => Lang::get('factotum::content.new_page'),
										'popup'  => Lang::get('factotum::content.popup'),
									);
									$opts = array();
									foreach ($options as $ind => $lab) {
										$opts[] =  $ind . ':' . $lab;
									}
									$contentLinkOpen->options = join(';', $opts);
									PrintField::print_field( $contentLinkOpen, $errors, old('link_open_in', (isset($content) ? $content->link_open_in : null)) );
									?>
								</div>
							@endif

						</div>
				</div>
				@endif

			</div>

			<div class="col-md-4">

				<div class="panel">
					<div class="panel-body">

						<?php
						$contentStatus = new stdClass();
						$contentStatus->name        = 'status';
						$contentStatus->label       = Lang::get('factotum::content.status');
						$contentStatus->mandatory   = true;
						$contentStatus->type        = 'select';
						$contentStatus->show_errors = true;
						$contentStatus->options     = $statuses;
						$opts = array();
						foreach ($statuses as $ind => $lab) {
							$opts[] =  $ind . ':' . $lab;
						}
						$contentStatus->options = join(';', $opts);
						PrintField::print_field( $contentStatus, $errors, old('status', (isset($content) ? $content->status : null)) );
						?>

						@if ( $contentType->content_type == 'page' )
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
						@endif

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
						<div class="row">
							<div class="col-xs-12">
								<?php
								$seoDescription = new stdClass();
								$seoDescription->name        = 'seo_description';
								$seoDescription->label       = Lang::get('factotum::content.seo_description');
								$seoDescription->mandatory   = false;
								$seoDescription->type        = 'text';
								$seoDescription->show_errors = true;
								$seoDescription->maxlength   = 160;
								PrintField::print_field( $seoDescription, $errors, old('seo_description', (isset($content) ? $content->seo_description : null)) );
								?>
							</div>
							<div class="col-xs-12">
								<?php
								$seoCanonicalUrl = new stdClass();
								$seoCanonicalUrl->name        = 'seo_canonical_url';
								$seoCanonicalUrl->label       = Lang::get('factotum::content.seo_canonical_url');
								$seoCanonicalUrl->mandatory   = false;
								$seoCanonicalUrl->type        = 'text';
								$seoCanonicalUrl->show_errors = true;
								PrintField::print_field( $seoCanonicalUrl, $errors, old('seo_canonical_url', (isset($content) ? $content->seo_canonical_url : null)) );
								?>
							</div>
							<div class="col-xs-12">
								<?php
								$seoRobotIndexing = new stdClass();
								$seoRobotIndexing->name      = 'seo_robots_indexing';
								$seoRobotIndexing->label     =  Lang::get('factotum::content.seo_robots_indexing');
								$seoRobotIndexing->mandatory = false;
								$seoRobotIndexing->type      = 'radio';
								$seoRobotIndexing->show_errors = true;
								$options = array(
									'index'   => 'Index',
									'noindex' => 'No Index'
								);
								$opts = array();
								foreach ($options as $ind => $lab) {
									$opts[] =  $ind . ':' . $lab;
								}
								$seoRobotIndexing->options = join(';', $opts);
								PrintField::print_field( $seoRobotIndexing, $errors, old('seo_robots_indexing', (isset($content) ? $content->seo_robots_indexing : 'index')) );
								?>
							</div>
							<div class="col-xs-12">
								<?php
								$seoRobotFollowing = new stdClass();
								$seoRobotFollowing->name      = 'seo_robots_following';
								$seoRobotFollowing->label     =  Lang::get('factotum::content.seo_robots_following');
								$seoRobotFollowing->mandatory = false;
								$seoRobotFollowing->type      = 'radio';
								$seoRobotFollowing->show_errors = true;
								$options = array(
									'follow'   => Lang::get('factotum::content.seo_robots_following_follow'),
									'nofollow' => Lang::get('factotum::content.seo_robots_following_nofollow')
								);
								$opts = array();
								foreach ($options as $ind => $lab) {
									$opts[] =  $ind . ':' . $lab;
								}
								$seoRobotFollowing->options = join(';', $opts);
								PrintField::print_field( $seoRobotFollowing, $errors, old('seo_robots_following', (isset($content) ? $content->seo_robots_following : 'follow')) );
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="panel">
					<div class="panel-heading">Facebook</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12">
								<?php
								$fbTitle = new stdClass();
								$fbTitle->name        = 'fb_title';
								$fbTitle->label       = Lang::get('factotum::content.fb_title');
								$fbTitle->mandatory   = false;
								$fbTitle->type        = 'text';
								$fbTitle->show_errors = true;
								PrintField::print_field( $fbTitle, $errors, old('fb_title', (isset($content) ? $content->fb_title : null)) );
								?>
							</div>
							<div class="col-xs-12">
								<?php
								$fbDescription = new stdClass();
								$fbDescription->name        = 'fb_description';
								$fbDescription->label       = Lang::get('factotum::content.fb_description');
								$fbDescription->mandatory   = false;
								$fbDescription->type        = 'text';
								$fbDescription->show_errors = true;
								$fbDescription->maxlength  = 160;
								PrintField::print_field( $fbDescription, $errors, old('fb_description', (isset($content) ? $content->fb_description : null)) );
								?>
							</div>
							<div class="col-xs-12">
								<?php
								$fbImage = new stdClass();
								$fbImage->name          = 'fb_image';
								$fbImage->label         = Lang::get('factotum::content.fb_image');
								$fbImage->mandatory     = false;
								$fbImage->type          = 'image_upload';
								$fbImage->id            = 'fb_image';
								$fbImage->show_errors   = true;
								$fbImage->allowed_types = '.jpg,.png';
								PrintField::print_field( $fbImage, $errors, old('fb_image', (isset($content) ? $content->fb_image : null)) );
								?>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>

</form>

<script type="text/javascript">
	var editingContent = <?php echo (isset($content) ? 'true' : 'false'); ?>;
</script>

@endsection
