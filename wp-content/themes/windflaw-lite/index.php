<?php
get_header();

if(is_home() || is_archive()){
	do_action('windflaw_archive_page_header');
	do_action('windflaw_post_list');
}
else if(is_search()){
	do_action('windflaw_archive_page_header');
	get_template_part('content', 'search');
}
else{
	while(have_posts()){
		the_post();
		get_template_part('content');
	}
}

get_footer();
?>