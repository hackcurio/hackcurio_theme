<meta name="twitter:image" content=<?php echo get_site_icon_url(); ?> />
<?php get_header(); session_cat(null, null, true); ?>
<div class="info-pages">
	<?php
		$page = get_page_by_title('About');
		if ($page):
			echo $page->post_content;
		endif;
	?>
</div>
<?php get_footer(); ?>
<div class="homepage">
	<?php get_sidebar(); ?>
</div>