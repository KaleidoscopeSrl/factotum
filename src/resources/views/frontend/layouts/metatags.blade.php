<title><?php echo ( isset($content) ? $content->title : ''); ?> - {{ config('app.name', 'Factotum') }}</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<?php if ( $content->seo_description != '' ) { ?>
<meta name="description" content="<?php echo $content->seo_description; ?>">
<?php } ?>

<?php if ( $content->seo_canonical_url != '' ) { ?>
<link rel="canonical" href="<?php echo $content->seo_canonical_url; ?>" />
<?php } ?>

<meta name="twitter:card" content="summary" />
<meta property="og:locale" content="<?php echo str_replace('-', '_', $currentLanguage); ?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php echo url(Request::path()); ?>" />
<meta property="og:site_name" content="<?php echo config('app.name'); ?>" />

<?php if ( $content->fb_title != '' ) { ?>
<meta property="og:title" content="<?php echo $content->fb_title; ?> - {{ config('app.name', 'Factotum') }}" />
<meta name="twitter:title" content="<?php echo $content->fb_title; ?> - {{ config('app.name', 'Factotum') }}" >
<?php } ?>

<?php if ( $content->fb_description != '' ) { ?>
<meta property="og:description" content="<?php echo $content->fb_description; ?>" />
<meta name="twitter:description" content="<?php echo $content->fb_description; ?>" />
<?php } ?>

<?php if ( $content->seo_canonical_url != '' ) { ?>
<link rel="canonical" href="<?php echo $content->seo_canonical_url; ?>" />
<?php } ?>

<meta name="robots" content="<?php
echo ($content->seo_robots_indexing != '' ? $content->seo_robots_indexing : 'index') .
	($content->seo_robots_following != '' ? ',' . $content->seo_robots_following : ''); ?>" />