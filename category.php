<meta name="twitter:image" content=<?php echo get_thumbnail($post); ?> />
<?php get_header(); ?>
<div class="content-wrapper">
	<div class="content-header">
		<p class="category-title slash" ><a href=<?php echo get_category_link(get_cat_ID($cat)); ?>><?php echo session_cat( $cat ); ?></a></p>
		<div class="category-description">
			<?php echo category_description( $cat );
				  $category_author = get_term_meta($cat, 'category_author', true);
				  if ($category_author) { echo '– ' . $category_author; };
			?>
		</div>
	</div>
	<div class="content content-main category">
		<div class="category-entry-grid">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="grid-item">
				<div class="category-entry">
					<a href="<?php the_permalink(); ?>">
						<img class="category-entry-thumb" src=<?php echo get_thumbnail($post); ?>>
						<div class="category-entry-info">
							<p class="category-entry-title"><?php the_title(); ?></p>
						</div>
					</a>
					<p class="entry-tags category"><?php echo get_the_tag_list($before="<span>", $sep="</span>   <span>", $after="</span>"); ?></p>
				</div>
			</div>
			<?php endwhile; else: ?>
			<?php endif; ?>
		</div>
	</div>
	<?php get_footer(); ?>
</div>
<?php get_sidebar(); ?>
