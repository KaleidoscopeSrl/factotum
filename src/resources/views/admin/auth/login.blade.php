@extends('factotum::admin.layouts.app')

@section('content')

<div class="container login">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3 ">
			<h1>Login</h1>
			<div class="panel">
			
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/auth/login') }}">
						{{ csrf_field() }}

						<div class="row">

							<div class="col-sm-12">
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

							<div class="col-sm-12">
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

						</div>

						<div class="row">
							<div class="col-sm-6">
								<?php
								$remember = new stdClass();
								$remember->name        = 'remember';
								$remember->mandatory   = false;
								$remember->type        = 'checkbox';
								$remember->show_errors = true;
								$remember->options     = '1:' . Lang::get('factotum::auth.remember_me');
								PrintField::print_field( $remember, $errors, isset($role) ? $role->backend_access : null );
								?>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 pwd-recover">
										<a class="btn btn-link " href="{{ url('/admin/auth/password/reset') }}">@lang('factotum::auth.forgot')</a>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12 login-btn">
								<button type="submit" class="btn btn-primary">Login</button>
							</div>
						</div>
								
						<div class="col-md-12 register-btn">
							@lang('factotum::auth.not_a_user') <a href="{{ url('/admin/user/register') }}">@lang('factotum::auth.register')</a>
						</div> 
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
