<meta name="twitter:image" content=<?php echo get_attachment_url_by_title("Homepage Screenshot"); ?> />
<?php get_header(); ?>
<div class="homepage-wrapper">
	<div class="intro-wrapper">
		<!-- <div class="slideshow-container">
			<?php 
				$args = array(
					'post_type' => 'post',
					'meta_query' => array(array(
						'key' => 'feature_in_homepage_slideshow',
						'value' => 'Yes'))
				);

				$query = new WP_Query($args);
				$features = $query->posts;

				foreach($features as $feature) {
					$url = str_replace('200x150', '640x360', get_thumbnail($feature));
					echo '<a href="' . get_permalink($feature) . '">
							<div class="slides fade">
					 		  	<img src="' . $url . '">
					 		  </div>
					 	  </a>';
				}
			?>
		</div> -->

		<div class="homepage-description">
			<?php
				$page = get_page_by_title('Home');
				if ($page):
					echo $page->post_content;
				endif;
			?>
		</div>
<!-- 	</div> -->

<!-- 	<div class="dots">
		<span class="dot"></span> 
		<span class="dot"></span>
	</div> -->

		<div class="category-entry-grid homepage">
			<?php
				$args = array('meta_key' => 'post_featured_on_homepage',
							  'meta_value' => 'hackcur.io',
							  'meta_compare' => 'LIKE');
				$categories = get_categories($args);
				foreach($categories as $category) {
					echo '<div class="grid-item homepage">
							<a class="category-entry homepage" href="' . get_category_link($category) . '">
									<img class="category-entry-thumb homepage" src=' . get_thumbnail(get_featured_post($category)) . '>
									<div class="category-title-box homepage">
										<p class="category-title homepage slash">' . get_cat_name($category->term_id) . '</p>
									</div>
								</a>
							</div>';
				};
			?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
<div class="homepage">
	<?php get_sidebar(); ?>
</div>
