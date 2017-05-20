<li>
	<a href="{{ url('/admin/role/list') }}"><i class="fa fa-pencil" aria-hidden="true"></i> @lang('factotum::navigation.role_list')</a>
	<div class="open-submenu"><i class="fa fa-caret-down dropstatus" aria-hidden="true"></i></div>
	<ul class="submenu">
		<li>
			<a href="{{ url('/admin/role/list') }}">
				@lang('factotum::navigation.see_all_roles')
			</a>
		</li>
		<li>
			<a href="{{ url('/admin/role/create') }}">
				@lang('factotum::navigation.add_role')
			</a>
		</li>
	</ul>
</li>