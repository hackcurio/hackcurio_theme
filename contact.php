<?php get_header(); ?>
<div class="info-pages">
	<?php
		$page = get_page_by_title('Contact');
		if ($page):
			echo $page->post_content;
		endif;
	?>
</div>
<?php get_footer(); ?>
