@extends('admin.layouts.app')

@section('content')

<div class="container login">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3 ">
			<h1>@lang('factotum::auth.pwd_reset')</h1>
			<div class="panel">
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/auth/password/reset') }}">
						{{ csrf_field() }}

						<input type="hidden" name="token" value="{{ $token }}">

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							<div class="col-sm-12">
								<label for="email" class="control-label">@lang('factotum::auth.email')</label>
								<input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
								@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							<div class="col-sm-12">
								<label for="password" class="control-label">Password</label>
								<input id="password" type="password" class="form-control" name="password" required>
								@if ($errors->has('password'))
									<span class="help-block">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
							<div class="col-sm-12">
								<label for="password-confirm" class="control-label">@lang('factotum::auth.pwd_reset')</label>
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

								@if ($errors->has('password_confirmation'))
									<span class="help-block">
										<strong>{{ $errors->first('password_confirmation') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-12">
								<button type="submit" class="btn btn-primary">
								   @lang('factotum::auth.pwd_reset')
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
