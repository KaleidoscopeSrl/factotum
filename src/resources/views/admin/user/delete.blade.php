@extends('factotum::admin.layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">

			<h1>{{ $title }}</h1>

			<div class="panel">
				<div class="panel-body">

					<form class="form-horizontal" role="form" method="POST" action="">
						{{ csrf_field() }}

						<div class="row">
							<div class="col-md-6">
								<?php
								$userField = new stdClass();
								$userField->name      = 'reassigned_user';
								$userField->label     =  Lang::get('factotum::user.reassign');
								$userField->mandatory = true;
								$userField->type      = 'select';
								$userField->show_errors = true;
								$options = array();
								foreach ($users as $u) {
									$options[] =  $u->id . ':' . $u->profile->first_name . ' ' . $u->profile->last_name;
								}
								$userField->options = join(';', $options);
								PrintField::print_field( $userField, $errors );
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
