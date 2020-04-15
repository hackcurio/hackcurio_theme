<div class="sidebar">
	<ul class="sidebar-list">
		<ul class="sidebar-menu-links"><?php include("nav-menu-links.html"); ?></ul>
		<?php
			$args = array("title_li" => "", "current_category" => get_cat_ID($_SESSION['active_category']));
			wp_list_categories($args);
		?>
	</ul>
</div>
