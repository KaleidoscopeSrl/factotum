@extends('admin.layouts.app')

<!-- Main Content -->
@section('content')
<div class="container login">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h1>@lang('factotum::auth.pwd_reset')</h1>
            <div class="panel">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/auth/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            

                            <div class="col-sm-12">
                                <label for="email" class="control-label">@lang('factotum::auth.email')</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary">
                                    @lang('factotum::auth.reset_password_link')
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
