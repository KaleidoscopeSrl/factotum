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
                                $contentTypeType = new stdClass();
                                $contentTypeType->name        = 'content_type';
                                $contentTypeType->label       = Lang::get('factotum::content_type.content_type');
                                $contentTypeType->mandatory   = true;
                                $contentTypeType->type        = 'text';
                                $contentTypeType->show_errors = true;
                                PrintField::print_field( $contentTypeType, $errors, isset($contentType) ? $contentType->content_type : null );
                                ?>
                            </div>
                            <div class="col-xs-12">
                                <p>
                                    @lang('factotum::content_type.label')
                                    <strong>
                                        <span id="content_type_template"><?php echo ( isset($contentType) ? $contentType->content_type : '' ); ?></span>.php
                                    </strong>
                                </p>
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
