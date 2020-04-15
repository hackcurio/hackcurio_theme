<meta name="twitter:image" content=<?php echo get_thumbnail($post); ?> />
<?php get_header(); ?>
<div class="content-wrapper">
    <?php while ( have_posts() ) : the_post();
        $active_cat = session_cat(null, $id);
    ?>
    	<div class="content-header">
    		<p class="category-title slash" ><a href=<?php echo get_category_link(get_cat_ID($active_cat)); ?>><?php echo $active_cat; ?></a></p>
    		<p class="entry-title"><?php the_title(); ?></p>
    		<p class="entry-author"><?php echo parse_author($post); ?></p>
    	</div>

        <div class="content single">
        	<div class="content-main">
        		<div class="entry-content">
            		<?php the_content(); ?>
            	</div>
            </div>
            <div class="entry-metadata">
                <p class="entry-author-bio">
                    <?php
                        $name = get_post_meta($id, $meta_key='author_first_name', true) . ' ' . get_post_meta($id, $meta_key='author_last_name', true);

                        $author_bio = get_post_meta($id, $meta_key="author_bio", true);

                        $author_website = esc_url(get_post_meta($id, $meta_key='author_website', true));

                        if ($author_website!='') {
                            echo make_clickable(str_replace($name, '<a href="' . $author_website . '">' . $name . '</a>', $author_bio));
                        }
                        else {
                            echo make_clickable($author_bio);
                        }                      
                    ?>
                        
                </p>
                <p class="entry-citation"><?php echo make_clickable(get_post_meta($id, $meta_key="citation", true)); ?></p>
                <p class="entry-tags"><?php echo make_clickable(get_the_tag_list($before="<span>", $sep="</span>   <span>", $after="</span>")); ?></p>
            </div>
        </div>
    <?php endwhile; ?>

    <div class="content-more">
		Back to <a class="slash" href=<?php echo get_category_link(get_cat_ID($active_cat)); ?>><?php echo $active_cat; ?></a>
    </div>
    <?php get_footer(); ?>
</div>
<?php get_sidebar(); ?>
