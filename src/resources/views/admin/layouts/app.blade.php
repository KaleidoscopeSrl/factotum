@include('admin.layouts.partials.header')

@include('admin.layouts.partials.menu')

@include('admin.layouts.partials.session_messages')

@include('admin.layouts.partials.status_bar')

<div class="wrapper @if (Auth::check() ) logged-in @endif">
	@yield('content')
</div>

@include('admin.layouts.partials.footer')
