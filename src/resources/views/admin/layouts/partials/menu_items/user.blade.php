<li>
	<a href="{{ url('/admin/user/list') }}"><i class="fa fa-users" aria-hidden="true"></i> @lang('factotum::navigation.user_list')</a>
	<div class="open-submenu"><i class="fa fa-caret-down dropstatus" aria-hidden="true"></i></div>
	<ul class="submenu">
		<li>
			<a href="{{ url('/admin/user/list') }}">
				@lang('factotum::navigation.see_all_users')
			</a>
		</li>
		<li>
			<a href="{{ url('/admin/user/create') }}">
				@lang('factotum::navigation.add_user')
			</a>
		</li>
	</ul>
</li>