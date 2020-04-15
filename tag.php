<?php get_header(); session_cat(null, null, true); ?>
<div class="content-wrapper">
	<div class="content-header">
		<h3 class="category-header">
			<?php echo single_tag_title($prefix="Tag: "); ?>
		</h3>
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
