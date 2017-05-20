<li>
	<a href="{{ url('/admin/capability/list') }}"><i class="fa fa-list-ul" aria-hidden="true"></i> @lang('factotum::navigation.capability_list')</a>
	<div class="open-submenu"><i class="fa fa-caret-down dropstatus" aria-hidden="true"></i></div>
	<ul class="submenu">
		<li>
			<a href="{{ url('/admin/capability/list') }}">
				@lang('factotum::navigation.see_all_capabilities')
			</a>
		</li>
		<li>
			<a href="{{ url('/admin/capability/create') }}">
				@lang('factotum::navigation.add_capability')
			</a>
		</li>
	</ul>
</li>