@if ( $paginator->hasPages() )

	<ul class="pagination">

		@if ( $paginator->onFirstPage() )
			<li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
				<i class="fi flaticon-left-arrow"></i>
			</li>
		@else
			<li>
				<a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
					<i class="fi flaticon-left-arrow"></i>
				</a>
			</li>
		@endif


		@foreach ($elements as $element)

			@if ( is_string($element) )
				<li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
			@endif

			@if ( is_array($element) )
				@foreach ( $element as $page => $url )
					@if ($page == $paginator->currentPage())
						<li class="active" aria-current="page"><span>{{ $page }}</span></li>
					@else
						<li><a href="{{ $url }}">{{ $page }}</a></li>
					@endif
				@endforeach
			@endif

		@endforeach

		{{-- Next Page Link --}}
		@if ($paginator->hasMorePages())
			<li>
				<a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
					<i class="fi flaticon-next"></i>
				</a>
			</li>
		@else
			<li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
				<span aria-hidden="true">
					<i class="fi flaticon-next"></i>
				</span>
			</li>
		@endif
	</ul>

@endif
