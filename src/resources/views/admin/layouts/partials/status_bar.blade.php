<div class="status-bar @if ( Auth::check() ) logged-in @endif">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-3 col-sm-4">
				<a href="#" id="menu_bars" class="visible-xs three-bars-button">
					<span>menu</span>
				</a>
			</div>
			<div class="col-xs-6 col-sm-4 app_title">
				<a href="{{ url('/') }}">factotum</a>
			</div>
			<div class="col-xs-3 col-sm-4 logout-container">
				@if ( Auth::check() )
					<a class="logout" href="{{ url('/admin/auth/logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> <span class="hidden-xs">Logout</span></a>
				@endif
			</div>

		</div>
	</div>
</div>