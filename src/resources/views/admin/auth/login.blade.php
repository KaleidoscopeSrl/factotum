@extends('admin.layouts.app')

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
								<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
									<div class="col-xs-12">
									<label for="email" class="control-label">
									@lang('factotum::auth.email')</label>
										<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

										@if ($errors->has('email'))
											<span class="help-block">
												<strong>{{ $errors->first('email') }}</strong>
											</span>
										@endif
									</div>
								</div>
							</div>

							<div class="col-sm-12">	
								<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
									<div class="col-xs-12">
									<label for="password" class="control-label">Password</label>
										<input id="password" type="password" class="form-control" name="password" required>

										@if ($errors->has('password'))
											<span class="help-block">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif
									</div>
								</div>
							</div>

						</div>

						<div class="col-sm-6"> 
							<div class="form-group">
								<div class="col-sm-12">
									<div class="checkbox">
										<label for="remember" class="control-label">
											<input type="checkbox" name="remember" id="remember">
											<span class="checkbox-material"><span class="check"></span></span> @lang('factotum::auth.remember_me')
										</label>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-6"> 
							<div class="form-group">
								<div class="col-sm-12 pwd-recover">
									<a class="btn btn-link " href="{{ url('/admin/auth/password/reset') }}">@lang('factotum::auth.forgot')</a>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12 login-btn">
								<button type="submit" class="btn btn-primary">
									Login
								</button>
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
