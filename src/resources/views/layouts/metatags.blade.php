@if ( isset($metatags) )

	@if ( $metatags['title'] != '' )
		<title>{{ $metatags['title'] }} - {{ config('app.name', 'Factotum') }}</title>
		<meta property="og:title" content="{{ $metatags['title'] }} - {{ config('app.name', 'Factotum') }}" />
		<meta name="twitter:title" content="{{ $metatags['title'] }} - {{ config('app.name', 'Factotum') }}" >
	@endif

	@if ( $metatags['description'] != '' )
		<meta name="description" content="{{ $metatags['description'] }}">
		<meta property="og:description" content="{{ $metatags['description'] }}" />
		<meta name="twitter:description" content="{{ $metatags['description'] }}" />
	@endif

@elseif ( isset($content) )

	@if ( $content->seo_title != '' )
		<title>{{ $content->seo_title }} - {{ config('app.name', 'Factotum') }}</title>
	@elseif ( $content->title != '' )
		<title>{{ $content->title }} - {{ config('app.name', 'Factotum') }}</title>
	@endif

	@if ( $content->seo_description != '' )
		<meta name="description" content="{{ $content->seo_description }}">
	@endif

	@if ( $content->seo_canonical_url != '' )
		<link rel="canonical" href="{{ $content->seo_canonical_url }}" />
	@endif


	@if ( $content->fb_title != '' )
		<meta property="og:title" content="{{ $content->fb_title }} - {{ config('app.name', 'Factotum') }}" />
		<meta name="twitter:title" content="{{ $content->fb_title }} - {{ config('app.name', 'Factotum') }}" >
	@endif


	@if ( $content->fb_description != '' )
		<meta property="og:description" content="{{ $content->fb_description }}" />
		<meta name="twitter:description" content="{{ $content->fb_description }}" />
	@endif

	@php
	$index  = ( $content->seo_robots_indexing  != '' ? $content->seo_robots_indexing  : 'index' );
	$follow = ( $content->seo_robots_following != '' ? $content->seo_robots_following : 'follow');
	@endphp

	<meta name="robots" content="{{ $index }},{{ $follow }}" />

@elseif ( isset($productCategory) )

	<title>{{ $productCategory->label }} - {{ config('app.name', 'Factotum') }}</title>
	<meta property="og:title" content="{{ $productCategory->label }} - {{ config('app.name', 'Factotum') }}" />
	<meta name="twitter:title" content="{{ $productCategory->label }} - {{ config('app.name', 'Factotum') }}" >

	@if ( $productCategory->description != '' )
		<meta name="description" content="{{ $productCategory->description }}">
		<meta property="og:description" content="{{ $productCategory->description }}" />
		<meta name="twitter:description" content="{{ $productCategory->description }}" />
	@endif

@endif





@if ( isset($currentLanguage) )
	<meta property="og:locale" content="{{ str_replace('-', '_', $currentLanguage) }}" />
@else
	<meta property="og:locale" content="{{ str_replace('-', '_', config('factotum.main_site_language') ) }}" />
@endif


<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta property="og:type" content="article" />
<meta property="og:url" content="{{ url(Request::path()) }}" />
<meta property="og:site_name" content="{{ config('app.name') }}" />

<meta name="twitter:card" content="summary" />