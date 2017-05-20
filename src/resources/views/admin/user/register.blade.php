@extends('admin.layouts.app')

@section('content')

<div class="container login">
	<div class="row">

		<div class="col-sm-6 col-sm-offset-3">
			<h1>Register</h1>

			<div class="panel">
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/register') }}">

						{{ csrf_field() }}

						<div class="row">
							<div class="col-xs-12">
								<?php
								$firstName = new stdClass();
								$firstName->name        = 'first_name';
								$firstName->label       = Lang::get('factotum::user.first_name');
								$firstName->mandatory   = true;
								$firstName->type        = 'text';
								$firstName->show_errors = true;
								PrintField::print_field( $firstName, $errors, old('first_name') ? old('first_name') : null );
								?>
							</div>
							<div class="col-xs-12">
								<?php
								$lastName = new stdClass();
								$lastName->name        = 'last_name';
								$lastName->label       = Lang::get('factotum::user.last_name');
								$lastName->mandatory   = true;
								$lastName->type        = 'text';
								$lastName->show_errors = true;
								PrintField::print_field( $lastName, $errors, old('last_name') ? old('last_name') : null );
								?>
							</div>
							<div class="col-xs-12">
								<?php
								$email = new stdClass();
								$email->name        = 'email';
								$email->label       =  Lang::get('factotum::user.email');
								$email->mandatory   = true;
								$email->type        = 'email';
								$email->show_errors = true;
								PrintField::print_field( $email, $errors, old('email') ? old('email') : null );
								?>
							</div>
							<div class="col-xs-12">
								<?php
								$password = new stdClass();
								$password->name        = 'password';
								$password->label       = 'Password';
								$password->mandatory   = true;
								$password->type        = 'password';
								$password->show_errors = true;
								PrintField::print_field( $password, $errors );
								?>
							</div>
							<div class="col-xs-12">
								<?php
								$passwordConfirmation = new stdClass();
								$passwordConfirmation->name        = 'password_confirmation';
								$passwordConfirmation->label       =  Lang::get('factotum::user.confirm_password');
								$passwordConfirmation->mandatory   = true;
								$passwordConfirmation->type        = 'password';
								$passwordConfirmation->show_errors = true;
								PrintField::print_field( $passwordConfirmation, $errors );
								?>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-primary">@lang('factotum::generic.register')</button>
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>

	</div>
</div>

@endsection
