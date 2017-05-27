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
								$roleField = new stdClass();
								$roleField->name      = 'reassigned_role';
								$roleField->label     =  Lang::get('factotum::role.reassign');;
								$roleField->mandatory = true;
								$roleField->type      = 'select';
								$roleField->show_errors = true;
								$options = array();
								foreach ($roles as $role) {
									$options[] =  $role->id . ':' . $role->role;
								}
								$roleField->options = join(';', $options);
								PrintField::print_field( $roleField, $errors );
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
