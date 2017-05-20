@if ( Auth::check() )

	<div class="admin-menu">

		@include('admin.layouts.partials.user')

		<nav>
			<ul role="menu">
				@include('admin.layouts.partials.menu_items.languages')
				@include('admin.layouts.partials.menu_items.user')
				@include('admin.layouts.partials.menu_items.role')
				@include('admin.layouts.partials.menu_items.capability')
				@include('admin.layouts.partials.menu_items.content_type')
				@include('admin.layouts.partials.menu_items.content_field')
				@include('admin.layouts.partials.menu_items.media')
				@include('admin.layouts.partials.menu_items.category')
				@include('admin.layouts.partials.menu_items.settings')
				@include('admin.layouts.partials.menu_items.tools')

				@foreach ($contentTypes as $contentType)
					@if ( auth()->user()->canEdit($contentType->id) || auth()->user()->canPublish($contentType->id) )
						<li>
							<a href="{{ url('/admin/content/list/' . $contentType->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i> {{ $contentType->content_type }}</a>
						</li>
					@endif
				@endforeach

			</ul>
		</nav>
	</div>

@endif