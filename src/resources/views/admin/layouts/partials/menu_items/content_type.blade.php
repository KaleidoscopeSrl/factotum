<li>
	<a href="{{ url('/admin/content-type/list') }}"><i class="fa fa-list-ul" aria-hidden="true"></i> @lang('factotum::navigation.content_type_list')</a>
	<div class="open-submenu"><i class="fa fa-caret-down dropstatus" aria-hidden="true"></i></div>
	<ul class="submenu">
		<li>
			<a href="{{ url('/admin/content-type/list') }}">
				@lang('factotum::navigation.see_all_content_types')
			</a>
		</li>
		<li>
			<a href="{{ url('/admin/content-type/create') }}">
				@lang('factotum::navigation.add_content_type')
			</a>
		</li>
		<li>
			<a href="{{ url('/admin/content-field/list') }}">
				@lang('factotum::navigation.content_field_list')
			</a>
		</li>
	</ul>
</li>