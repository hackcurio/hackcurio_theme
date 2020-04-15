<?php get_header(); ?>
<?php 
	$args = array(
		'name' => 'about',
		'post_type' => 'page',
		'post_status' => 'publish',
		'numberposts' => 1
	);

	$post = get_posts($args);
	if ($post):
		echo $post->post_content;
	endif;
?>
<?php get_footer(); ?>
