@extends('factotum::admin.layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">

			<h1>{{ $title }}</h1>

			<div class="panel">
				<div class="panel-body">

					<form class="form-horizontal" role="form" method="POST" action="{{ $postUrl }}" enctype="multipart/form-data">

						{{ csrf_field() }}

						<div class="row">
							<div class="col-md-6">
								<?php
								$firstName = new stdClass();
								$firstName->name        = 'first_name';
								$firstName->label       = Lang::get('factotum::user.first_name');
								$firstName->mandatory   = true;
								$firstName->type        = 'text';
								$firstName->show_errors = true;
								PrintField::print_field( $firstName, $errors, isset($user) ? $user->profile->first_name : null );
								?>
							</div>
							<div class="col-md-6">
								<?php
								$lastName = new stdClass();
								$lastName->name        = 'last_name';
								$lastName->label       = Lang::get('factotum::user.last_name');
								$lastName->mandatory   = true;
								$lastName->type        = 'text';
								$lastName->show_errors = true;
								PrintField::print_field( $lastName, $errors, isset($user) ? $user->profile->last_name : null );
								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<?php
								$email = new stdClass();
								$email->name      = 'email';
								$email->label     =  Lang::get('factotum::user.email');
								$email->mandatory = true;
								$email->type      = 'email';
								$email->show_errors = true;
								PrintField::print_field( $email, $errors, isset($user) ? $user->email : null );
								?>
							</div>
							<div class="col-md-6">
								<?php
								$roleField = new stdClass();
								$roleField->name      = 'role_id';
								$roleField->label     =  Lang::get('factotum::user.role');
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
						</div>
                            
						<div class="row">
							<div class="col-md-6">
								<?php
								$password = new stdClass();
								$password->name      = 'password';
								$password->label     = 'Password';
								$password->mandatory = ( isset($user) ? false : true );
								$password->type      = 'password';
								$password->show_errors = true;
								PrintField::print_field( $password, $errors );
								?>
							</div>
							<div class="col-md-6">
								<?php
								$passwordConfirmation = new stdClass();
								$passwordConfirmation->name      = 'password_confirmation';
								$passwordConfirmation->label     =  Lang::get('factotum::user.confirm_password');
								$passwordConfirmation->mandatory = ( isset($user) ? false : true );
								$passwordConfirmation->type      = 'password';
								$passwordConfirmation->show_errors = true;
								PrintField::print_field( $passwordConfirmation, $errors );
								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<?php if ( isset($user->avatar) && $user->avatar ) { ?>
									<img src="<?php echo $user->avatar; ?>" alt="User Avatar" />
								<?php } ?>

								<div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
									<div class="col-sm-12">
										<label for="avatar" class="control-label">Avatar</label>
										<input id="avatar" type="file" class="form-control"
											   name="avatar" value="{{ old('avatar', (isset($user) ? $user->avatar : null)) }}">
									</div>
								</div>
							</div>
						</div>

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
@endsection
