<?php
/* Template name: Blank */

get_header();

while (have_posts()){
	the_post();
	get_template_part('content', 'page');
}

get_footer();
?>