@extends('admin.layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
   	    	<div class="col-xs-12">
   	    		<h1>@lang('factotum::category.categories_list')</h1>
				@foreach ($contentTypesCategories as $contentType)
				<div class="row">
					<div class="col-sm-6">
						<h3 class="table-subtitle">{{ $contentType->content_type }}</h3>
					</div>
					<div class="col-sm-6 utility_btn">
						@if ( auth()->user()->canConfigure($contentType->id) )
						<a href="{{ url('/admin/category/create/' . $contentType->id) }}"
							   class="btn btn-default btn-info">@lang('factotum::category.add_new_category')</a>
						@endif
					</div>
				</div>

				<table class="table">
					<thead>
					<tr>
						<th width="10%">#</th>
						<th>@lang('factotum::category.title')</th>
						<th>@lang('factotum::category.actions')</th>
					</tr>
					</thead>
					<tbody class="categories_sortable">
						<?php PrintCategoriesTree::print_list( $contentType->categories ); ?>
					</tbody>
				</table>

				@endforeach

            </div>
        </div>
    </div>

	<script type="text/javascript">
		var sortCategoriesURL = '<?php echo url('/admin/category/sort/'); ?>';
	</script>

@endsection