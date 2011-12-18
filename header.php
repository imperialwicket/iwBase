<?php if ( !defined( 'HABARI_PATH' ) ) { die('No direct access'); } ?>
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="generator" content="Habari">
    <title><?php echo $theme->page_title; ?></title>
    <link rel="Shortcut Icon" href="images/favicon.ico">
	<link rel="apple-touch-icon" href="images/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-icon-114x114.png">
	<link rel="stylesheet" type="text/css" media="screen" href="<?php Site::out_url( 'theme' ); ?>/css/<?php echo $theme->theme_style; ?>">
    <?php $theme->header(); ?>
</head>
<body>
	<header class="main">
	    <h1><a href="<?php Site::out_url( 'habari' ); ?>"><?php Options::out( 'title' ); ?></a></h1>
	    <h3><?php Options::out( 'tagline' ); ?></h3>
    </header>
    <nav class="main">
        <ul id="nav">
	        <li<?php echo ($request->display_home) ? ' class=current' : ''; ?>><a href="<?php Site::out_url( 'habari' ); ?>"><?php _e('Home'); ?></a></li>
	        <?php
	        // List Pages
	        foreach ( $pages as $page ) {
		        echo (isset($post) && $post->slug == $page->slug) ? '<li class="current">' : '<li>';
		        echo '<a href="' . $page->permalink . '" title="' . $page->title . '">' . $page->title . '</a></li>' . "\n";
	        }
	        ?>
        </ul>
    </nav>
    <section class="main">
