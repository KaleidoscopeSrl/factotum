@extends('admin.layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
				<h1>{{ $title }}</h1>
				<div class="panel">
					<div class="panel-body">
						<form class="form-horizontal" role="form" method="POST" action="{{ $postUrl }}">
							{{ csrf_field() }}

							<div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
								<div class="col-sm-12">
									<label for="category_label" class="control-label">@lang('factotum::category.category_label')</label>
									<input id="category_label" type="text" class="form-control"
										   name="label" value="{{ old('label', (isset($category) ? $category->label : null)) }}" required autofocus>

									@if ($errors->has('label'))
									<span class="help-block">
										<strong>{{ $errors->first('label') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
								<div class="col-sm-12">
									<label for="category_name" class="control-label">@lang('factotum::category.category_name')</label>
									<input id="category_name" type="text" class="form-control"
										  name="name" value="{{ old('name', (isset($category) ? $category->name : null)) }}" required autofocus>

									@if ($errors->has('name'))
									<span class="help-block">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
								<div class="col-sm-12">
									<label for="parent_id" class="control-label">@lang('factotum::category.category_parent')</label>
									<?php PrintCategoriesDropdownTree::print_dropdown( $categoriesTree, 'parent_id', old('parent_id', (isset($category) ? $category->parent_id : null)), 'parent_id', 'form-control' ); ?>

									@if ($errors->has('parent_id'))
									<span class="help-block">
										<strong>{{ $errors->first('parent_id') }}</strong>
									</span>
									@endif
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
