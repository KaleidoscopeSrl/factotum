@extends('factotum::admin.layouts.app')

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

                        <?php
                        $email = new stdClass();
                        $email->name        = 'email';
                        $email->label       =  Lang::get('factotum::auth.email');
                        $email->mandatory   = true;
                        $email->type        = 'email';
                        $email->show_errors = true;
                        PrintField::print_field( $email, $errors, old('email') ? old('email') : null );
                        ?>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary">@lang('factotum::auth.reset_password_link')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
