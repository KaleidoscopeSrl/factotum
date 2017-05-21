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
								$roleName = new stdClass();
								$roleName->name        = 'role';
								$roleName->label       = Lang::get('factotum::role.role');
								$roleName->mandatory   = true;
								$roleName->type        = 'text';
								$roleName->show_errors = true;
								PrintField::print_field( $roleName, $errors, isset($role) ? $role->role : null );
								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<?php
								$backendAccess = new stdClass();
								$backendAccess->name        = 'backend_access';
								$backendAccess->mandatory   = false;
								$backendAccess->type        = 'checkbox';
								$backendAccess->show_errors = true;
								$backendAccess->options     = '1:' . Lang::get('factotum::role.access_backend');
								PrintField::print_field( $backendAccess, $errors, isset($role) ? $role->backend_access : null );
								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<?php
								$manageContentType = new stdClass();
								$manageContentType->name        = 'manage_content_types';
								$manageContentType->mandatory   = false;
								$manageContentType->type        = 'checkbox';
								$manageContentType->show_errors = true;
								$manageContentType->options     = '1:' . Lang::get('factotum::role.manage_content_types');
								PrintField::print_field( $manageContentType, $errors, isset($role) ? $role->manage_content_types : null );
								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<?php
								$manageUsers = new stdClass();
								$manageUsers->name        = 'manage_users';
								$manageUsers->mandatory   = false;
								$manageUsers->type        = 'checkbox';
								$manageUsers->show_errors = true;
								$manageUsers->options = '1:' . Lang::get('factotum::role.manage_users');
								PrintField::print_field( $manageUsers, $errors, isset($role) ? $role->manage_users : null );
								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<?php
								$manageMedia = new stdClass();
								$manageMedia->name        = 'manage_media';
								$manageMedia->mandatory   = false;
								$manageMedia->type        = 'checkbox';
								$manageMedia->show_errors = true;
								$manageMedia->options = '1:' . Lang::get('factotum::role.manage_media');
								PrintField::print_field( $manageMedia, $errors, isset($role) ? $role->manage_media : null );
								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<?php
								$manageCategories = new stdClass();
								$manageCategories->name        = 'manage_categories';
								$manageCategories->mandatory   = false;
								$manageCategories->type        = 'checkbox';
								$manageCategories->show_errors = true;
								$manageCategories->options = '1:' . Lang::get('factotum::role.manage_categories');
								PrintField::print_field( $manageCategories, $errors, isset($role) ? $role->manage_categories : null );
								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<?php
								$manageSettings = new stdClass();
								$manageSettings->name        = 'manage_settings';
								$manageSettings->mandatory   = false;
								$manageSettings->type        = 'checkbox';
								$manageSettings->show_errors = true;
								$manageSettings->options = '1:' . Lang::get('factotum::role.manage_settings');
								PrintField::print_field( $manageSettings, $errors, isset($role) ? $role->manage_settings : null );
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
