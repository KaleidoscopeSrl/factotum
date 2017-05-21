@extends('factotum::admin.layouts.app')

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
								<?php
								$contentFieldLabel = new stdClass();
								$contentFieldLabel->name        = 'label';
								$contentFieldLabel->label       = Lang::get('factotum::content_field.field_label');
								$contentFieldLabel->mandatory   = true;
								$contentFieldLabel->type        = 'text';
								$contentFieldLabel->id          = 'field_label';
								$contentFieldLabel->show_errors = true;
								PrintField::print_field( $contentFieldLabel, $errors, old('label', (isset($contentField) ? $contentField->label : null)) );
								?>
							</div>
							<div class="col-md-6">
								<?php
								$contentFieldName = new stdClass();
								$contentFieldName->name        = 'name';
								$contentFieldName->label       = Lang::get('factotum::content_field.field_name');
								$contentFieldName->mandatory   = true;
								$contentFieldName->type        = 'text';
								$contentFieldName->id          = 'field_name';
								$contentFieldName->show_errors = true;
								PrintField::print_field( $contentFieldName, $errors, old('label', (isset($contentField) ? $contentField->name : null)) );
								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<?php
								$contentFieldType = new stdClass();
								$contentFieldType->name        = 'type';
								$contentFieldType->id          = 'field_type';
								$contentFieldType->label       = Lang::get('factotum::content_field.field_type');
								$contentFieldType->mandatory   = true;
								$contentFieldType->type        = 'select';
								$contentFieldType->show_errors = true;
								$opts = array();
								foreach ($fieldTypes as $ind => $lab) {
									$opts[] =  $ind . ':' . $lab;
								}
								$contentFieldType->options = join(';', $opts);
								PrintField::print_field( $contentFieldType, $errors, old('type', (isset($contentField) ? $contentField->type : null)) );
								?>
							</div>
							<div class="col-md-6">
								<?php
								$contentFieldHint = new stdClass();
								$contentFieldHint->name        = 'hint';
								$contentFieldHint->label       = Lang::get('factotum::content_field.field_hint');
								$contentFieldHint->mandatory   = false;
								$contentFieldHint->type        = 'text';
								$contentFieldHint->show_errors = true;
								PrintField::print_field( $contentFieldHint, $errors, old('hint', (isset($contentField) ? $contentField->hint : null)) );
								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<?php
								$mandatory = new stdClass();
								$mandatory->name        = 'mandatory';
								$mandatory->mandatory   = false;
								$mandatory->type        = 'checkbox';
								$mandatory->show_errors = true;
								$mandatory->options     = '1:' . Lang::get('factotum::content_field.mandatory');
								PrintField::print_field( $mandatory, $errors, isset($contentField) ? $contentField->mandatory : null );
								?>
							</div>
						</div>

						<?php
						$contentFieldNameHidden = new stdClass();
						$contentFieldNameHidden->name        = 'name';
						$contentFieldNameHidden->label       = null;
						$contentFieldNameHidden->mandatory   = false;
						$contentFieldNameHidden->type        = 'hidden';
						$contentFieldNameHidden->id          = 'field_name_hidden';
						$contentFieldNameHidden->show_errors = false;
						PrintField::print_field( $contentFieldNameHidden, $errors, old('name', (isset($contentField) ? $contentField->name : null)) );
						?>

						@include('factotum::admin.content_field.partials.options')

						@include('factotum::admin.content_field.partials.files')

						@include('factotum::admin.content_field.partials.images')

						@include('factotum::admin.content_field.partials.linked_content')


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

@include('factotum::admin.content_field.partials.jquery_helper')

@endsection
