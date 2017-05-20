<li>
	<div class="nav-language">
		<i class="fa fa-globe" aria-hidden="true"></i> @lang('factotum::navigation.language')
	</div>
	<div class="open-submenu"><i class="fa fa-caret-down dropstatus" aria-hidden="true"></i></div>
	<ul class="submenu">
		@foreach ($availableLanguages as $language => $languageLabel)
			<li>
				<a href="{{ url('/admin/settings/set-language/' . $language) }}">
					@if ( $currentLanguage == $language )
						{{ $languageLabel }} - @lang('factotum::navigation.current')
					@else
						{{ $languageLabel }}
					@endif
				</a>
			</li>
		@endforeach
	</ul>
</li>