<?php
// 1. Back-end

// Define metadata fields for media uploads
function media_metadata( $form_fields, $post ) {
	$form_fields['video-title'] = array(
		'label' => 'Video Title',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'video_title', true )
	);

	$form_fields['canonical-url'] = array(
		'label' => 'Canonical URL',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'canonical_url', true )
	);

	$form_fields['permission-status'] = array(
		'label' => 'Permission Status',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'permission_status', true )
	);

	$form_fields['thumbnail-url'] = array(
		'label' => 'Thumbnail URL',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'thumbnail_url', true )
	);

	return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'media_metadata', 10, 2 );

function save_media_metadata( $post, $attachment ) {

	error_log($post['post_title']);

	if( isset( $attachment['video-title'] ) ) {
        update_post_meta( $post['ID'], 'video_title', $attachment['video-title'] );
	};

    if( isset( $attachment['canonical-url'] ) )
		update_post_meta( $post['ID'], 'canonical_url', esc_url( $attachment['canonical-url'] ) );

    if( isset( $attachment['permission-status'] ) )
        update_post_meta( $post['ID'], 'permission_status', $attachment['permission-status'] );

	return $post;
}
add_filter( 'attachment_fields_to_save', 'save_media_metadata', 10, 2 );

// Add title column to media library (list view only)
// First add the column
function video_title_column( $cols ) {
    $cols["video_title"] = "Title";
    return $cols;
}

// Then display title
function video_title_value( $column_name, $id ) {
    $meta = get_post_meta($id);

    if ( isset( $meta['video_title'])) {
    	$value = implode('', $meta['video_title']);
    } elseif ( isset($meta['_wp_attached_file'])) {
    	$value = explode('/', $meta['_wp_attached_file'][0])[2];
    } else {
    	$value = 'untitled';
    }
    echo $value;
}

// Hook actions to admin_init
function hook_new_media_columns() {
    add_filter( 'manage_media_columns', 'video_title_column' );
    add_action( 'manage_media_custom_column', 'video_title_value', 10, 2 );
}
add_action( 'admin_init', 'hook_new_media_columns' );

// Add custom meta box for entry (article) metadata
function add_entry_meta_box()
{
    add_meta_box("entry-meta-box", "Entry Metadata", "entry_meta_box_markup", "post", "normal", "high", null);
}

add_action("add_meta_boxes", "add_entry_meta_box");

function entry_metadata( $post )
{
	$form_fields = array();

	$form_fields['text_excerpt'] = 'Text Excerpt';

	$form_fields['author_first_name'] = 'Author First Name';

	$form_fields['author_last_name'] = 'Author Last Name';

	$form_fields['additional_authors'] = 'Additional Authors (comma-separated)';

	$form_fields['author_website'] = 'Author Website';

	$form_fields['additional_author_websites'] = 'Additional Author Websites (comma-separated; same order as additional authors)';

	$form_fields['author_bio'] = 'Author Bio';

	$form_fields['citation'] = 'Citation';

	// $form_fields['feature_in_homepage_slideshow'] = 'Feature in Homepage Slideshow';

	return $form_fields;
}

function entry_meta_box_markup($post)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");

    $fields = entry_metadata($post);

    // $feature = get_post_meta($post->ID, 'feature_in_homepage_slideshow', true);
    // if (empty($feature)) {
    // 	update_post_meta($post->ID, 'feature_in_homepage_slideshow', 'No');
    // }

    foreach ( array_keys($fields) as $field ) {

    	$label = $fields[$field];

    	?>
		    <div>
		        <label for="<?php echo $field; ?>"><?php echo $label; ?></label>
		        <br>
		        <textarea name="<?php echo $field; ?>" rows="2" cols="60"><?php echo htmlentities(get_post_meta($post->ID, $field, true)); ?></textarea>
		    </div>
		    <br>
    	<?php
    }
  
}

function save_entry_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "post";
    if($slug != $post->post_type)
        return $post_id;

    $fields = entry_metadata($post);

    foreach ( array_keys($fields) as $field ) {

    	$value = "";

		if(isset($_POST[$field])) {
			$value = $_POST[$field];
		};

		update_post_meta($post_id, $field, $value);
    }
}

add_action("save_post", "save_entry_meta_box", 10, 3);

// Custom category metadata
function add_category_metadata( $term ) {
	if (current_filter() == 'category_edit_form_fields') {
		$category_author = get_term_meta($term->term_id, 'category_author', true);
        $post_featured_on_homepage = get_term_meta($term->term_id, 'post_featured_on_homepage', true);
        ?>
        <tr class="form-field">
            <th valign="top" scope="row"><label for="term_fields[category_author]"><?php _e('Category Description Author'); ?></label></th>
            <td>
                <input type="text" id="term_fields[category_author]" name="term_fields[category_author]" value="<?php echo esc_attr($category_author); ?>">
            </td>
        </tr>
        <tr class="form-field">
            <th valign="top" scope="row"><label for="term_fields[post_featured_on_homepage]"><?php _e('Post Thumbnail to Feature on Homepage'); ?></label></th>
            <td>
                <input type="text" id="term_fields[post_featured_on_homepage]" name="term_fields[post_featured_on_homepage]" value="<?php echo esc_attr($post_featured_on_homepage); ?>">
                <p class="description"><?php _e('Please enter the URL of a post'); ?></p>
            </td>
        </tr>
	<?php } elseif (current_filter() == 'category_add_form_fields') {
        ?>
        <div class="form-field">
            <label for="term_fields[category_author]"><?php _e('Category Description Author'); ?></label>
            <input type="text" id="term_fields[category_author]" name="term_fields[category_author]" value="">
        </div>
        <div class="form-field">
            <label for="term_fields[post_featured_on_homepage]"><?php _e('Post Thumbnail to Feature on Homepage'); ?></label>
            <input type="text" id="term_fields[post_featured_on_homepage]" name="term_fields[post_featured_on_homepage]" value="">
            <p class="description"><?php _e('Please enter the URL of a post'); ?></p>
        </div>
    <?php
    }
}

add_filter( 'category_add_form_fields', 'add_category_metadata', 10, 2 );
add_filter( 'category_edit_form_fields', 'add_category_metadata', 10, 2 );

function save_category_metadata( $term_id ) {
	if (!isset($_POST['term_fields'])) {
        return;
    }

    foreach ($_POST['term_fields'] as $key => $value) {
        update_term_meta($term_id, $key, sanitize_text_field($value));
    }
}

add_filter( 'edited_category', 'save_category_metadata', 10, 2 );
add_filter( 'created_category', 'save_category_metadata', 10, 2 );

function filter_posts_by_author() {
	$params = array(
		'name' => 'author',
		'show_option_all' => 'All authors'
	);
 
	if ( isset($_GET['post']) )
		$params['selected'] = $_GET['user'];
 
	wp_dropdown_users( $params );
}
add_action('restrict_manage_posts', 'filter_posts_by_author');

// 2. Front-end

// Load style sheet and fonts
function load_styles() {
	wp_register_style( 'custom_style', get_stylesheet_uri() );
	wp_enqueue_style( 'custom_style' );
	wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Space+Mono:400,700', false );
	wp_enqueue_style( 'custom-google-fonts-2', 'https://fonts.googleapis.com/css?family=Work+Sans', false );
	// Remove margin-top reserved for footer when wp_head() is called
	remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action( 'wp_enqueue_scripts', 'load_styles' );

function get_thumbnail( $post ) {
	$attachments = get_posts(array('post_type' => 'attachment',
							      'post_parent' => $post->ID));
	if (!empty($attachments)) {
		$attachment = $attachments[0]->ID;
		return get_post_meta($attachment)['thumbnail_url'][0];
	}
	else {
		return get_site_icon_url();
	}
}

function get_attachment_url_by_title( $title ) {
	$attachment = get_page_by_title($title, OBJECT, 'attachment');
	  if ( $attachment ){
	    $attachment_url = $attachment->guid;
	  } 
	  else {
	    return 'image-not-found';
	  }
	  return $attachment_url;
}

// Get featured post from category on homepage
function get_featured_post ( $category ) {
	$meta = get_term_meta($category->term_id);
	$url = $meta['post_featured_on_homepage'][0];
	return get_post(url_to_postid($url));
}

// Wrap oembeds in a video-container
function wrap_oembed($html, $url, $attr, $post_id) {
  return '<div class="video-container">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'wrap_oembed', 99, 4);

// Remove related videos from youtube embeds
function remove_youtube_rel( $cache, $url, $attr, $post_ID ) {
	
	if ( strstr( $cache, 'youtube.com/embed/' ) ) {
		$cache = str_replace( '?feature=oembed', '?feature=oembed&rel=0', $cache );
	}
	
	return $cache;
}
add_filter( 'embed_oembed_html', 'remove_youtube_rel', 10, 4 );

// Maintain state for currently "active" category
function session_cat($cat=null, $post_id=null, $reset=false) {
	// set active to $cat if passed
	if (isset($cat)) {
		$_SESSION['active_category'] = get_cat_name($cat);
	}
	// if post passed...
	elseif (isset($post_id)) {
		$categories = get_the_category($post_id);
		// if the post has multiple categories and one of these is already current, keep that one
		if (count($categories) > 1 && isset($_SESSION['active_category']) && in_array($_SESSION['active_category'], array_column($categories, 'name'))) {
			return $_SESSION['active_category'];
		}
		// else set to first category of post
		$_SESSION['active_category'] = get_the_category($post_id)[0]->name;
	}
	// initialize if no parameters passed and (not set or reset is true)
	elseif (!isset($_SESSION) || !isset($_SESSION['active_category']) || $reset===true) {
		$_SESSION['active_category'] = null;
	}
	// else, pass through (and always return value)
	return $_SESSION['active_category'];
}

function start_session() {
    if(!session_id()) {
        session_start();
    }
}
add_action('init', 'start_session', 1);

function get_published_posts() {
	$args = array('post_status' => 'publish', 'numberposts' => -1);
	$published_posts = get_posts($args);
	return $published_posts;
}

// Format author name for display
function parse_author($post, $the_list=false) {

    if ($the_list===true) {
    	if ($post->author_first_name != '') {
    		$author = "{$post->author_last_name}, {$post->author_first_name}";
    	}
    	else {
    		$author = "{$post->author_last_name}";
    	}
    	$sep = ', & ';
    }
    else {
    	$author = "{$post->author_first_name} {$post->author_last_name}";
    	$sep = ' and ';
    };

    if (!empty($post->additional_authors)) {
        $aa = explode(',', $post->additional_authors);

        for ($i = 0; $i < count($aa) - 1; $i++) {
        	$a = trim($aa[$i]);
            $author .= ", {$a}";
        }

        $last = end($aa);

        $author .= "{$sep}{$last}";
    };
    return $author;
}

function load_scripts() {
	wp_enqueue_script( 'hamburger', get_template_directory_uri() . '/scripts/hamburger.js', array( 'jquery' ) );
	wp_enqueue_script( 'the-list-toggle', get_template_directory_uri() . '/scripts/the-list-toggle.js', array( 'jquery' ) );

	$published_posts = get_published_posts();
	
	foreach ( $published_posts as $post ) {
		$post->url = get_permalink($post);
		$category = get_the_category($post->ID)[0];
		$post->category_name = $category->name;
		$post->category_url = get_category_link($category->term_id);
		$post->author_last_name = get_post_meta($post->ID, 'author_last_name', true);
		$post->parsed_author = parse_author($post, $the_list=true);
	};

	wp_localize_script( 'the-list-toggle', 'published_posts', $published_posts );
	// wp_enqueue_script( 'slideshow', get_template_directory_uri() . '/scripts/slideshow.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'load_scripts' );

?>
