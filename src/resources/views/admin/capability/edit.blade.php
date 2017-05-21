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

							<div class="col-xs-12">
								<?php
									$roleField = new stdClass();
									$roleField->name      = 'role_id';
									$roleField->label     =  Lang::get('factotum::capability.role');
									$roleField->mandatory = true;
									$roleField->type      = 'select';
									$roleField->show_errors = true;
									$options = array();
									foreach ($roles as $role) {
										$options[] =  $role->id . ':' . $role->role;
									}
									$roleField->options = join(';', $options);
									PrintField::print_field( $roleField, $errors, isset($user) ? $user->role_id : null );
								?>
							</div>

							<div class="col-xs-12">
								<?php
								$contentTypeField = new stdClass();
								$contentTypeField->name      = 'content_type_id';
								$contentTypeField->label     =  Lang::get('factotum::capability.content_type');
								$contentTypeField->mandatory = true;
								$contentTypeField->type      = 'select';
								$contentTypeField->show_errors = true;
								$options = array();
								foreach ($contentTypes as $contentType) {
									$options[] =  $contentType->id . ':' . $contentType->content_type;
								}
								$contentTypeField->options = join(';', $options);
								PrintField::print_field( $contentTypeField, $errors, isset($capability) ? $capability->content_type_id : null );
								?>
							</div>

						</div>

						<div class="row">

							<div class="col-xs-12">
								<?php
								$configure = new stdClass();
								$configure->name        = 'configure';
								$configure->mandatory   = false;
								$configure->type        = 'checkbox';
								$configure->show_errors = true;
								$configure->options     = '1:' . Lang::get('factotum::capability.configure');
								PrintField::print_field( $configure, $errors, isset($capability) ? $capability->configure : null );
								?>
							</div>

						</div>

						<div class="row">

							<div class="col-xs-12">
								<?php
								$edit = new stdClass();
								$edit->name        = 'edit';
								$edit->mandatory   = false;
								$edit->type        = 'checkbox';
								$edit->show_errors = true;
								$edit->options     = '1:' . Lang::get('factotum::capability.edit');
								PrintField::print_field( $edit, $errors, isset($capability) ? $capability->edit : null );
								?>
							</div>

						</div>

						<div class="row">

							<div class="col-xs-12">
								<?php
								$publish = new stdClass();
								$publish->name        = 'publish';
								$publish->mandatory   = false;
								$publish->type        = 'checkbox';
								$publish->show_errors = true;
								$publish->options     = '1:' . Lang::get('factotum::capability.publish');
								PrintField::print_field( $publish, $errors, isset($capability) ? $capability->publish : null );
								?>
							</div>

						</div>

						<div class="form-group">
							<div class="col-sm-12">
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
