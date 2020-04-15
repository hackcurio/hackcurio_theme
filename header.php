<!doctype html>
<html>
<head>
	<title>
		<?php echo get_bloginfo('name') . ': ' . get_bloginfo('description');?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<?php wp_head(); ?> 
</head>
<body <?php body_class(); ?>>

<div class="header">
	<div id="logo">
		<a href=<?php echo get_home_url() ?>><img src=<?php echo get_attachment_url_by_title('Hackcurio Logo (animated)') ?>></a>
	</div>
	<nav class="menu-links"><?php include("nav-menu-links.html"); ?></nav>
	<div id="hamburger">
		<a href="javascript:;">&#9776;</a>
	</div>
</div>
