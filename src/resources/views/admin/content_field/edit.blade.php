@extends('admin.layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
				<h1>{{ $title }}</h1>
				<div class="panel">
					<div class="panel-body">
						<form class="form-horizontal" role="form" method="POST" action="{{ $postUrl }}">
							{{ csrf_field() }}

							<div class="row">
								<div class="col-md-6">
									<div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
										<div class="col-sm-12">
											<label for="field_label" class="control-label">@lang('factotum::content_field.field_label')</label>
											<input id="field_label" type="text" class="form-control"
												   name="label" value="{{ old('label', (isset($contentField) ? $contentField->label : null)) }}" required autofocus>

											@if ($errors->has('label'))
												<span class="help-block">
												<strong>{{ $errors->first('label') }}</strong>
											</span>
											@endif

										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
										<div class="col-sm-12">
											<label class="control-label">@lang('factotum::content_field.field_name')</label>
											<input id="field_name" type="text" class="form-control" readonly
												  name="name" value="{{ old('name', (isset($contentField) ? $contentField->name : null)) }}" required autofocus>

											@if ($errors->has('name'))
												<span class="help-block">
												<strong>{{ $errors->first('name') }}</strong>
											</span>
											@endif

										</div>
									</div>
								</div>
							</div>	
							
							<div class="row">
								<div class="col-md-6">
									<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
										<div class="col-sm-12">
											<label for="field_type" class="control-label">@lang('factotum::content_field.field_type')</label>
											<div class="select-wrapper">
												<select name="type" id="field_type" class="form-control" required autofocus>
													@foreach ($fieldTypes as $fieldTypeInd => $fieldType)
														<option value="{{ $fieldTypeInd }}"
														<?php echo ( old('type', (isset($contentField) ? $contentField->type : null)) == $fieldTypeInd ? 'selected' : ''); ?>>{{ $fieldType }}</option>
													@endforeach
												</select>
											</div>

											@if ($errors->has('type'))
												<span class="help-block">
												<strong>{{ $errors->first('type') }}</strong>
											</span>
											@endif

										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group{{ $errors->has('hint') ? ' has-error' : '' }}">
										<div class="col-sm-12">
											<label for="hint" class="control-label">@lang('factotum::content_field.field_hint')</label>
											<input id="hint" type="text" class="form-control"
												   name="hint" value="{{ old('hint', (isset($contentField) ? $contentField->hint : null)) }}" autofocus>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group{{ $errors->has('mandatory') ? ' has-error' : '' }}">
										<div class="col-sm-12">
											<div class="form-control" style="border: none; box-shadow: none;">
												<div class="checkbox">
													<label for="mandatory" class="control-label">
														<input type="checkbox" id="mandatory"
														name="mandatory" value="1"
														<?php echo (isset($contentField) && $contentField->mandatory ? ' checked' : ''); ?>>
														<span class="checkbox-material"><span class="check"></span></span> @lang('factotum::content_field.mandatory')
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<input type="hidden"
								   id="field_name_hidden"
								   name="name" value="{{ old('name', (isset($contentField) ? $contentField->name : null)) }}">
							

@include('admin.content_field.partials.options')

@include('admin.content_field.partials.files')

@include('admin.content_field.partials.images')

@include('admin.content_field.partials.linked_content')


							<div class="form-group">
								<div class="col-md-12">
									<button type="submit" class="btn btn-primary">@lang('factotum::generic.save')</button>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@include('admin.content_field.partials.jquery_helper')

@endsection
