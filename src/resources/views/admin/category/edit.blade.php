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
								<div class="col col-xs-12">
									<?php
									$categoryLabel = new stdClass();
									$categoryLabel->name        = 'label';
									$categoryLabel->label       = Lang::get('factotum::category.category_label');
									$categoryLabel->mandatory   = true;
									$categoryLabel->type        = 'text';
									$categoryLabel->show_errors = true;
									PrintField::print_field( $categoryLabel, $errors, isset($category) ? $category->label : null );
									?>
								</div>
								<div class="col col-xs-12">
									<?php
									$categoryName = new stdClass();
									$categoryName->name        = 'name';
									$categoryName->label       = Lang::get('factotum::category.category_name');
									$categoryName->mandatory   = true;
									$categoryName->type        = 'text';
									$categoryName->show_errors = true;
									PrintField::print_field( $categoryName, $errors, isset($category) ? $category->name : null );
									?>
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
