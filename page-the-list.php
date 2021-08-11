<meta name="twitter:image" content=<?php echo get_site_icon_url(); ?> />
<?php get_header(); session_cat(null, null, true); ?>
<div class="info-pages the-list-page">
	<?php
		$page = get_page_by_title('The List');
		if ($page):
			echo $page->post_content;
		endif;
	?>
	<br><br><br>
	<p class="the-list-toggle">
		<a class="current-option">By Date</a> | <a>By Author</a> | <a>View All Tags</a>
	</p>
	<div class="the-list-container"></div>
</div>

<?php get_footer(); ?>
<div class="homepage">
	<?php get_sidebar(); ?>
</div>