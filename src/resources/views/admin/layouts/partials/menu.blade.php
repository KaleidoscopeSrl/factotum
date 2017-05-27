@if ( Auth::check() )

	<div class="admin-menu">

		@include('factotum::admin.layouts.partials.user')

		<nav>
			<ul role="menu">

				<li>
					<a href="{{ url('/admin/') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>
				</li>

				@include('factotum::admin.layouts.partials.menu_items.languages')

				@foreach ($contentTypes as $contentType)
					@if ( auth()->user()->canEdit($contentType->id) || auth()->user()->canPublish($contentType->id) )
						<li>
							<a href="{{ url('/admin/content/list/' . $contentType->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i> {{ $contentType->content_type }}</a>
						</li>
					@endif
				@endforeach

				@include('factotum::admin.layouts.partials.menu_items.media')
				@include('factotum::admin.layouts.partials.menu_items.category')

				@include('factotum::admin.layouts.partials.menu_items.content_type')

				@include('factotum::admin.layouts.partials.menu_items.user')

				@include('factotum::admin.layouts.partials.menu_items.settings')
				@include('factotum::admin.layouts.partials.menu_items.tools')

			</ul>
		</nav>
	</div>

@endif