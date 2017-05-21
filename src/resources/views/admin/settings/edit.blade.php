@extends('factotum::admin.layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-xs-12">

            	<h1>@lang('factotum::settings.title')</h1>

                <div class="panel">

                    <div class="panel-body">
                        <form 
                        	class="form-horizontal" 
                        	role="form" 
                        	method="POST" 
                        	action="{{ $postUrl }}"
							enctype="multipart/form-data" 
							id="edit_content_form">

                            {{ csrf_field() }}

							<?php if ( count($availableLanguages) > 0 ) { ?>

								<?php foreach ( $availableLanguages as $lang => $label ) { ?>

								<div class="form-group{{ $errors->has('page_' . $lang . 'homepage') ? ' has-error' : '' }}">
									<div class="col-sm-12">
										<label for="page__<?php echo $lang; ?>_homepage" class="control-label">@lang('factotum::settings.choose') (<?php echo $lang; ?>) Homepage</label>
										<div class="select-wrapper">
											<select name="page_<?php echo $lang; ?>_homepage"
													id="page_<?php echo $lang; ?>_homepage" class="form-control" required autofocus>

												<option value="">@lang('factotum::settings.select_homepage')</option>

												<?php if ( $contents[$lang]->count() > 0 ) { ?>
													<?php foreach ( $contents[$lang] as $c ) { ?>
													<option value="<?php echo $c->id; ?>" <?php echo ( $c->is_home ? ' selected="selected"' : ''); ?>>
														<?php echo $c->title; ?>
													</option>
													<?php } ?>
												<?php } ?>
											</select>
										</div>
										@if ($errors->has('page_homepage'))
											<span class="help-block">
												<strong>{{ $errors->first('page_homepage') }}</strong>
											</span>
										@endif
									</div>
								</div>

								<?php } ?>

							<?php } ?>

							<div class="form-group">
								<div class="col-md-12">
									<label for="page_homepage" class="control-label">@lang('factotum::settings.current_language')</label>
									{{ $currentLanguage }}
								</div>
							</div>

                            <div class="form-group">
                                <div class="col-md-6 ">
                                    <button type="submit" class="btn btn-primary">@lang('factotum::generic.save')</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
