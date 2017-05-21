@include('factotum::admin.layouts.partials.header')

@include('factotum::admin.layouts.partials.menu')

@include('factotum::admin.layouts.partials.session_messages')

@include('factotum::admin.layouts.partials.status_bar')

<div class="wrapper @if (Auth::check() ) logged-in @endif">
	@yield('content')
</div>

@include('factotum::admin.layouts.partials.footer')
