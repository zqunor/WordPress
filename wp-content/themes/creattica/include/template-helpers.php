<?php
/**
 * Miscellaneous template functions.
 * These functions are for use throughout the theme's various template files.
 * This file is loaded via the 'after_setup_theme' hook at priority '10'
 *
 * @package    Hoot
 * @subpackage Creattica
 */

/**
 * Display the branding area
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hoot_header_branding' ) ):
function hoot_header_branding() {
	?>
	<div <?php hybridextend_attr( 'header-part', 'primary' ); ?>>
		<div class="grid">
			<div class="grid-span-12">

				<div <?php hybridextend_attr( 'branding' ); ?>>
					<div id="site-logo" class="<?php
						echo 'site-logo-' . hoot_get_mod( 'logo' );
						if ( hoot_get_mod('logo_background_type') == 'accent' )
							echo ' accent-typo with-background';
						elseif ( hoot_get_mod('logo_background_type') == 'background' )
							echo ' with-background';
						?>">
						<?php
						// Display the Image Logo or Site Title
						hoot_logo();
						?>
					</div>
				</div><!-- #branding -->

			</div>
		</div>
		<?php
		if ( !hoot_get_mod('disable_goto_top') && !hoot_get_mod('disable_sticky_leftbar') ) {
			if ( hybridextend_theme_supports( 'hybridextend-scrollpoints', 'goto-top' ) ) {
				$class = ( current_theme_supports( 'hybridextend-waypoints' ) ) ? ' waypoints-goto-top ' : '';
				echo '<div class="fixed-goto-top-wrap' . $class . '"><a href="#page-wrapper" class="fixed-goto-top">'
					. '<i class="fa fa-chevron-up"></i>'
					. '</a></div>';
				global $hybridextend_scroller;
				remove_action( 'wp_footer', array( $hybridextend_scroller, 'goto_top_button' ) );
			}
		}
		?>
	</div>
	<?php
}
endif;

/**
 * Displays the branding logo
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hoot_logo' ) ):
function hoot_logo() {
	$display = '';
	$hoot_logo = hoot_get_mod( 'logo' );

	if ( 'text' == $hoot_logo || 'custom' == $hoot_logo ) {

		$title_icon = hoot_get_mod( 'site_title_icon', NULL );

		$class = ( $title_icon ) ? ' site-logo-with-icon' : '';
		if ( !function_exists( 'hoot_theme_premium' ) ) {
			$class .= ( 'text' == $hoot_logo ) ? ' site-logo-text-' . hoot_get_mod( 'logo_size' ) : '';
		}
		$class = ( empty( $class ) ) ? '' : ' class="' . $class . '"';

		$display .= '<div id="site-logo-' . $hoot_logo . '"' . $class . '>';

			if ( $title_icon )
				$title_icon = '<i class="fa ' . sanitize_html_class( $title_icon ) . '"></i>';

			$display .= '<h1 ' . hybridextend_get_attr( 'site-title' ) . '>' .
						'<a href="' . esc_url( home_url() ) . '" rel="home">' .
						$title_icon;
			$title = '';

			if ( 'text' == $hoot_logo ) {
				$title = get_bloginfo( 'name' );
			} elseif ( 'custom' == $hoot_logo ) {
				$title = hoot_get_custom_text_logo();
			}

			$display .= apply_filters( 'hoot_site_title', $title );
			$display .= '</a></h1>';

			if ( hoot_get_mod( 'show_tagline' ) )
				$display .= hybrid_get_site_description();

		$display .= '</div><!--logotext-->';

	} elseif ( 'mixed' == $hoot_logo || 'mixedcustom' == $hoot_logo ) {

		$logo_image = ( function_exists( 'get_custom_logo' ) ) ?
						get_custom_logo() :
						'<a href="' . esc_url( home_url() ) . '" rel="home" itemprop="url">' .
							'<img src="' . esc_url( hoot_get_mod( 'logo_image' ) ) . '" />' .
						'</a>';
		$has_logo = ( function_exists( 'get_custom_logo' ) ) ? has_custom_logo() : hoot_get_mod( 'logo_image' );

		$class = ( $has_logo ) ? 'site-logo-with-image' : '';
		if ( !function_exists( 'hoot_theme_premium' ) ) {
			$class .= ( 'mixed' == $hoot_logo ) ? ' site-logo-text-' . hoot_get_mod( 'logo_size' ) : '';
		}
		$class = ( empty( $class ) ) ? '' : ' class="' . $class . '"';

		$display .= '<div id="site-logo-' . $hoot_logo . '"' . $class . '>';

			if ( $has_logo )
				$display .= '<div class="site-logo-mixed-image">' .
							$logo_image .
							'</div>';

			$display .= '<div class="site-logo-mixed-text">' .
						'<h1 ' . hybridextend_get_attr( 'site-title' ) . '>' .
						'<a href="' . esc_url( home_url() ) . '" rel="home" itemprop="url">';

			$title = '';
			if ( 'mixed' == $hoot_logo ) {
				$title = get_bloginfo( 'name' );
			} elseif ( 'mixedcustom' == $hoot_logo ) {
				$title = hoot_get_custom_text_logo();
			}

			$display .= apply_filters( 'hoot_site_title', $title ) .
						'</a>' .
						'</h1>';

			if ( hoot_get_mod( 'show_tagline' ) )
				$display .= hybrid_get_site_description();

			$display .= '</div><!--site-logo-mixed-text-->';

		$display .= '</div><!--logotext-->';

	} elseif ( 'image' == $hoot_logo ) {
		$display .= hoot_get_logo_image();
	}

	echo apply_filters( 'hoot_display_logo', $display );
}
endif;

/**
 * Returns the custom text logo
 *
 * @since 1.0
 * @access public
 * @return string
 */
if ( !function_exists( 'hoot_get_custom_text_logo' ) ):
function hoot_get_custom_text_logo() {
	$title = '';
	$logo_custom = apply_filters( 'hoot_logo_custom_text', hybridextend_sortlist( hoot_get_mod( 'logo_custom' ) ) );

	if ( is_array( $logo_custom ) && !empty( $logo_custom ) ) {
		$lcount = 1;
		foreach ( $logo_custom as $logo_custom_line ) {
			if ( !$logo_custom_line['sortitem_hide'] && !empty( $logo_custom_line['text'] ) ) {
				$line_class = 'site-title-line site-title-line' . $lcount;
				$line_class .= ( $logo_custom_line['font'] == 'standard' ) ? ' site-title-body-font' : '';
				$line_class .= ( $logo_custom_line['font'] == 'heading' ) ? ' site-title-heading-font' : '';
				$title .= '<span class="' . $line_class . '">' . esc_html( $logo_custom_line['text'] ) . '</span>';
			}
			$lcount++;
		}

	}
	return $title;
}
endif;

/**
 * Returns the image logo
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hoot_get_logo_image' ) ):
function hoot_get_logo_image() {
	$logo_image = ( function_exists( 'get_custom_logo' ) ) ?
					get_custom_logo() :
					'<a href="' . esc_url( home_url() ) . '" rel="home" itemprop="url">' .
						'<img src="' . esc_url( hoot_get_mod( 'logo_image' ) ) . '" />' .
					'</a>';
	$has_logo = ( function_exists( 'get_custom_logo' ) ) ? has_custom_logo() : hoot_get_mod( 'logo_image' );
	$class = '';
	$class = ( empty( $class ) ) ? '' : ' class="' . $class . '"';
	if ( !empty( $has_logo ) ) {
		return '<div id="site-logo-image" ' . $class . '>'
				. '<h1 ' . hybridextend_get_attr( 'site-title' ) . '>'
				. $logo_image
				. '</h1>'
				.'</div>';
	}
}
endif;

/**
 * Display the primary menu area
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hoot_header_aside' ) ):
function hoot_header_aside() {
	?>
	<div <?php hybridextend_attr( 'header-aside' ); ?>>
		<div class="grid">
			<div class="grid-span-12">
				<?php
				// Loads the template-parts/menu-primary.php template.
				hybridextend_get_menu( 'primary' );
				?>
			</div>
		</div>
	</div>
	<?php
}
endif;

/**
 * Display a friendly reminder to update outdated browser
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hoot_update_browser' ) ):
function hoot_update_browser() {
	$notice = '<!--[if lte IE 9]><p class="chromeframe">' .
			  sprintf( __( 'You are using an outdated browser (IE 8 or before). For a better user experience, we recommend %1supgrading your browser today%2s or %3sinstalling Google Chrome Frame%4s', 'creattica' ), '<a href="http://browsehappy.com/">', '</a>', '<a href="http://www.google.com/chromeframe/?redirect=true">', '</a>' ) .
			  '</p><![endif]-->';
	echo apply_filters( 'hoot_update_browser_notice', $notice );
}
endif;

/**
 * Temporarily remove read more links from excerpts
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hoot_remove_readmore_link' ) ):
function hoot_remove_readmore_link() {
	add_filter( 'hoot_readmore', 'hoot_readmore_empty_string' );
}
endif;
if ( !function_exists( 'hoot_readmore_empty_string' ) ):
function hoot_readmore_empty_string() {
	return '';
}
endif;

/**
 * Reinstate read more links to excerpts
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hoot_reinstate_readmore_link' ) ):
function hoot_reinstate_readmore_link() {
	remove_filter( 'hoot_readmore', 'hoot_readmore_empty_string' );
}
endif;

/**
 * Display title area content
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hoot_display_loop_title_content' ) ):
function hoot_display_loop_title_content( $location = 'pre', $context = '' ) {

	$pre_title_content_post = apply_filters( 'loop_meta_pre_title_content_post', '', $location, $context );
	if ( ( $location == 'pre' && !$pre_title_content_post ) ||
		 ( $location == 'post' && $pre_title_content_post ) ) : 

		$pre_title_content = apply_filters( 'loop_meta_pre_title_content', '', $location, $context );
		if ( !empty( $pre_title_content ) ) :

			$pre_title_content_stretch =  apply_filters( 'loop_meta_pre_title_content_stretch', '', $location, $context ); ?>
			<div id="custom-content-title-area" class="<?php
				echo $location . '-content-title-area ';
				echo ( ($pre_title_content_stretch) ? 'content-title-area-stretch' : 'content-title-area-grid' );
				?>">
				<div class="<?php echo ( ($pre_title_content_stretch) ? 'grid-stretch' : 'grid' ); ?>">
					<div class="grid-span-12">
						<?php echo do_shortcode( $pre_title_content ); ?>
					</div>
				</div>
			</div>
			<?php

		endif;

	endif;
}
endif;

/**
 * Display the meta information HTML for single post/page
 *
 * @since 1.0
 * @access public
 * @param string $args (comma delimited) information to display
 * @param string $context context in which meta blocks are being displayed
 * @return void
 */
if ( !function_exists( 'hoot_meta_info_blocks' ) ):
function hoot_meta_info_blocks( $args = '', $context = '' ) {

	if ( !is_array( $args ) )
		$args = array_map( 'trim', explode( ',', $args ) );

	$display = array();
	foreach ( array( 'author', 'date', 'cats', 'tags', 'comments' ) as $key ) {
		if ( in_array( $key, $args ) )
			$display[ $key ] = true;
	}

	if ( is_page() ) {
		if ( isset( $display['cats'] ) ) unset( $display['cats'] );
		if ( isset( $display['tags'] ) ) unset( $display['tags'] );
	}

	if ( !empty( $display['author'] ) )
		$display['publisher'] = true;

	$display = apply_filters( 'hoot_meta_info_blocks_display', $display, $context );

	if ( empty( $display ) ) {
		echo '<div class="entry-byline empty"></div>';
		return;
	}
	?>

	<div class="entry-byline">

		<?php
		$blocks = array();

		if ( !empty( $display['author'] ) ) :
			$blocks['author']['label'] = __( 'By:', 'creattica' );
			ob_start();
			the_author_posts_link();
			$blocks['author']['content'] = '<span ' . hybridextend_get_attr( 'entry-author' ) . '>' . ob_get_clean() . '</span>';
		endif;

		if ( !empty( $display['date'] ) ) :
			$blocks['date']['label'] = __( 'On:', 'creattica' );
			$blocks['date']['content'] = '<time ' . hybridextend_get_attr( 'entry-published' ) . '>' . get_the_date() . '</time>';
		endif;

		if ( !empty( $display['cats'] ) ) :
			$category_list = get_the_category_list(', ');
			if ( !empty( $category_list ) ) :
				$blocks['cats']['label'] = __( 'In:', 'creattica' );
				$blocks['cats']['content'] = $category_list;
			endif;
		endif;

		if ( !empty( $display['tags'] ) && get_the_tags() ) :
			$blocks['tags']['label'] = __( 'Tagged:', 'creattica' );
			$blocks['tags']['content'] = ( ! get_the_tags() ) ? __( 'No Tags', 'creattica' ) : get_the_tag_list( '', ', ', '' );
		endif;

		if ( !empty( $display['comments'] ) && comments_open() ) :
			$blocks['comments']['label'] = __( 'With:', 'creattica' );
			ob_start();
			comments_popup_link(__( '0 Comments', 'creattica' ),
								__( '1 Comment', 'creattica' ),
								__( '% Comments', 'creattica' ), 'comments-link', '' );
			$blocks['comments']['content'] = ob_get_clean();
		endif;

		if ( $edit_link = get_edit_post_link() ) :
			$blocks['editlink']['label'] = '';
			$blocks['editlink']['content'] = '<a href="' . $edit_link . '">' . __( 'Edit This', 'creattica' ) . '</a>';
		endif;

		$blocks = apply_filters( 'hoot_meta_info_blocks', $blocks, $context );

		foreach ( $blocks as $key => $block ) {
			if ( !empty( $block['content'] ) ) {
				echo ' <div class="entry-byline-block entry-byline-' . $key . '">';
					if ( !empty( $block['label'] ) )
						echo ' <span class="entry-byline-label">' . $block['label'] . '</span> ';
					echo $block['content'];
				echo ' </div>';
			}
		}

		if ( !empty( $display['publisher'] ) ) {
			static $microdatapublisher;
			if ( empty( $microdatapublisher ) ) {
				$pname = get_bloginfo();
				if ( function_exists( 'get_custom_logo' ) ) {
					$iid = get_theme_mod( 'custom_logo' );
					if ( !empty( $iid ) ) {
						$isrc = wp_get_attachment_image_src( $iid, 'full' );
						if( empty( $isrc ) ) $isrc = wp_get_attachment_image_src( $iid, 'full', true );
						if ( !empty( $isrc[0] ) ) {
							$ilogo = $isrc[0];
							$iwidth = ( empty( $isrc[1] ) ) ? '' : $isrc[1];
							$iheight = ( empty( $isrc[2] ) ) ? '' : $isrc[2];
						}
					}
				}
				if ( empty( $ilogo ) )
					$ilogo = $iwidth = $iheight = '';
				$microdatapublisher =
					'<span class="entry-publisher" itemprop="publisher" itemscope="itemscope" itemtype="http://schema.org/Organization">' .
						'<meta itemprop="name" content="' . $pname . '">' .
						'<span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">' .
							'<meta itemprop="url" content="' . $ilogo . '">' .
							'<meta itemprop="width" content="' . $iwidth . '">' .
							'<meta itemprop="height" content="' . $iheight . '">' .
						'</span>' .
					'</span>';
			}
			echo apply_filters( 'entry-byline-block-publisher', $microdatapublisher );
		}
		?>

	</div><!-- .entry-byline -->

	<?php
}
endif;

/**
 * Display the post thumbnail image
 *
 * @since 1.0
 * @access public
 * @param string $classes additional classes
 * @param string $size span or column size or actual image size name. Default is content width span.
 * @param bool $miscrodata true|false Add microdata or not
 * @param bool $crop true|false|null Using null will return closest matched image irrespective of its crop setting
 * @return void
 */
if ( !function_exists( 'hoot_post_thumbnail' ) ):
function hoot_post_thumbnail( $classes = '', $size = '', $microdata = false, $crop = NULL ) {

	/* Add custom Classes if any */
	$custom_class = '';
	if ( !empty( $classes ) ) {
		$classes = explode( " ", $classes );
		foreach ( $classes as $class ) {
			$custom_class .= ' ' . sanitize_html_class( $class );
		}
	}

	/* Calculate the size to display */
	$thumbnail_size = hoot_thumbnail_size( $size, $crop );

	/* Finally display the image */
	if ( $microdata ) {
		$iid = get_post_thumbnail_id();
		if ( !empty( $iid ) ) {
			$isrc = wp_get_attachment_image_src( $iid, $thumbnail_size );
			if( empty( $isrc ) ) $isrc = wp_get_attachment_image_src( $iid, $thumbnail_size, true );
			if ( !empty( $isrc[0] ) ) {
				$iwidth = ( empty( $isrc[1] ) ) ? '' : $isrc[1];
				$iheight = ( empty( $isrc[2] ) ) ? '' : $isrc[2];
				echo apply_filters( 'hoot_post_thumbnail_microdata',
					'<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject" class="entry-featured-img-wrap">' .
					'<meta itemprop="url" content="' . $isrc[0] . '">' .
					'<meta itemprop="width" content="' . $iwidth . '">' .
					'<meta itemprop="height" content="' . $iheight . '">'
					, $isrc[0], $iwidth, $iheight );
				$microdatadisplay = true;
			}
		}
	}
	if ( empty( $microdatadisplay ) )
		echo '<div class="entry-featured-img-wrap">';
	the_post_thumbnail( $thumbnail_size, array( 'class' => "attachment-$thumbnail_size $custom_class", 'itemscope' => '' ) );
	echo '</div>';

}
endif;

/**
 * Get the thumbnail size
 *
 * @since 1.0
 * @access public
 * @param string $size span or column size or actual image size name. Default is content width span.
 * @param bool $crop true|false|null Using null will return closest matched image irrespective of its crop setting
 * @return void
 */
if ( !function_exists( 'hoot_thumbnail_size' ) ):
function hoot_thumbnail_size( $size = '', $crop = NULL ) {

	/* Calculate the size to display */
	if ( !empty( $size ) ) {
		if ( 0 === strpos( $size, 'span-' ) || 0 === strpos( $size, 'column-' ) )
			$thumbnail_size = hybridextend_get_image_size_name( $size, $crop );
		else
			$thumbnail_size = $size;
	} else {
		$size = 'span-' . hoot_main_layout( 'content' );
		$thumbnail_size = hybridextend_get_image_size_name( $size, $crop );
	}

	/* Let child themes filter the size name */
	$thumbnail_size = apply_filters( 'hoot_post_thumbnail' , $thumbnail_size, $size, $crop );

	return $thumbnail_size;
}
endif;

/**
 * Utility function to extract border class for widget based on user option.
 *
 * @since 1.0
 * @access public
 * @param string $val string value separated by spaces
 * @param int $index index for value to extract from $val
 * @prefix string $prefix prefixer for css class to return
 * @return void
 */
if ( !function_exists( 'hoot_widget_border_class' ) ):
function hoot_widget_border_class( $val, $index=0, $prefix='' ) {
	$val = explode( " ", trim( $val ) );
	if ( isset( $val[ $index ] ) )
		return $prefix . trim( $val[ $index ] );
	else
		return '';
}
endif;

/**
 * Utility function to map footer sidebars structure to CSS span architecture.
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hoot_footer_structure' ) ):
function hoot_footer_structure() {
	$footers = hoot_get_mod( 'footer' );
	$structure = array(
				'1-1' => array( 12, 12, 12, 12 ),
				'2-1' => array(  6,  6, 12, 12 ),
				'2-2' => array(  4,  8, 12, 12 ),
				'2-3' => array(  8,  4, 12, 12 ),
				'3-1' => array(  4,  4,  4, 12 ),
				'3-2' => array(  6,  3,  3, 12 ),
				'3-3' => array(  3,  6,  3, 12 ),
				'3-4' => array(  3,  3,  6, 12 ),
				'4-1' => array(  3,  3,  3,  3 ),
				);
	if ( isset( $structure[ $footers ] ) )
		return $structure[ $footers ];
	else
		return array( 12, 12, 12, 12 );
}
endif;

/**
 * Get footer column option.
 *
 * @since 1.0
 * @access public
 * @return int
 */
function hoot_get_footer_columns() {
	$footers = hoot_get_mod( 'footer' );
	$columns = ( $footers ) ? intval( substr( $footers, 0, 1 ) ) : false;
	$columns = ( is_numeric( $columns ) && 0 < $columns ) ? $columns : false;
	return $columns;
}

/**
 * Utility function to map 2 column widths to CSS span architecture.
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hoot_col_width_to_span' ) ):
function hoot_col_width_to_span( $col_width ) {
	$return = array();
	switch( $col_width ):
		case '100':
			$return[0] = 'grid-span-12';
			break;
		case '50-50': default:
			$return[0] = 'grid-span-6';
			$return[1] = 'grid-span-6';
			break;
		case '33-66':
			$return[0] = 'grid-span-4';
			$return[1] = 'grid-span-8';
			break;
		case '66-33':
			$return[0] = 'grid-span-8';
			$return[1] = 'grid-span-4';
			break;
		case '25-75':
			$return[0] = 'grid-span-3';
			$return[1] = 'grid-span-9';
			break;
		case '75-25':
			$return[0] = 'grid-span-9';
			$return[1] = 'grid-span-3';
			break;
		case '33-33-33':
			$return[0] = 'grid-span-4';
			$return[1] = 'grid-span-4';
			$return[2] = 'grid-span-4';
			break;
		case '25-25-50':
			$return[0] = 'grid-span-3';
			$return[1] = 'grid-span-3';
			$return[2] = 'grid-span-6';
			break;
		case '25-50-25':
			$return[0] = 'grid-span-3';
			$return[1] = 'grid-span-6';
			$return[2] = 'grid-span-3';
			break;
		case '50-25-25':
			$return[0] = 'grid-span-6';
			$return[1] = 'grid-span-3';
			$return[2] = 'grid-span-3';
			break;
		case '25-25-25-25':
			$return[0] = 'grid-span-3';
			$return[1] = 'grid-span-3';
			$return[2] = 'grid-span-3';
			$return[3] = 'grid-span-3';
			break;
	endswitch;
	return $return;
}
endif;

/**
 * Wrapper function for hoot_main_layout() to get the class names for current context.
 * Can only be used after 'posts_selection' action hook i.e. in 'wp' hook or later.
 *
 * @since 1.0
 * @access public
 * @param string $context content|primary-sidebar|sidebar|sidebar-primary
 * @return string
 */
if ( !function_exists( 'hoot_main_layout_class' ) ):
function hoot_main_layout_class( $context ) {
	return hoot_main_layout( $context, 'class' );
}
endif;

/**
 * Utility function to return layout size or classes for the context.
 * Can only be used after 'posts_selection' action hook i.e. in 'wp' hook or later.
 *
 * @since 1.0
 * @access public
 * @param string $context content|primary-sidebar|sidebar|sidebar-primary
 * @param string $return class|size return class name or just the span size integer
 * @return string
 */
if ( !function_exists( 'hoot_main_layout' ) ):
function hoot_main_layout( $context, $return = 'size' ) {

	// Set layout
	global $hoot_theme;
	if ( !isset( $hoot_theme->currentlayout ) )
		hoot_set_main_layout();

	$span_sidebar = $hoot_theme->currentlayout['sidebar'];
	$span_content = $hoot_theme->currentlayout['content'];
	$layout_class = ' layout-' . $hoot_theme->currentlayout['layout'];

	// Return Class or Span Size for the Content/Sidebar
	if ( $context == 'content' ) {

		if ( $return == 'class' ) {
			$extra_class = ( empty( $span_sidebar ) ) ? ' no-sidebar' : ' has-sidebar';
			return ' grid-span-' . $span_content . $extra_class . $layout_class . ' ';
		} elseif ( $return == 'size' ) {
			return intval( $span_content );
		}

	} elseif ( $context == 'sidebar' ||  $context == 'sidebar-primary' || $context == 'primary-sidebar' || $context == 'secondary-sidebar' || $context == 'sidebar-secondary' ) {

		if ( $return == 'class' ) {
			if ( !empty( $span_sidebar ) )
				return ' grid-span-' . $span_sidebar . $layout_class . ' ';
			else
				return '';
		} elseif ( $return == 'size' ) {
			return intval( $span_sidebar );
		}

	}

	return '';

}
endif;

/**
 * Utility function to calculate and set main (content+aside) layout according to the sidebar layout
 * set by user for the current view.
 * Can only be used after 'posts_selection' action hook i.e. in 'wp' hook or later.
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hoot_set_main_layout' ) ):
function hoot_set_main_layout() {

	// Apply full width for front page
	if ( is_front_page() && !is_home() ) {
		$sidebar = 'full-width';
	}
	// Apply Sidebar Layout for Posts
	elseif ( is_singular( 'post' ) ) {
		$sidebar = hoot_get_mod( 'sidebar_posts' );
	}
	// Check for attachment before page (to handle images attached to a page - true for is_page and is_attachment)
	// Apply 'Full Width'
	elseif ( is_attachment() ) {
		$sidebar = 'none';
	}
	elseif ( is_page() ) {
		if ( hybridextend_is_404() )
			// Apply 'Full Width' if this page is being displayed as a custom 404 page
			$sidebar = 'none';
		else
			// Apply Sidebar Layout for Pages
			$sidebar = hoot_get_mod( 'sidebar_pages' );
	}
	// Apply Sidebar Layout for Site
	else {
		$sidebar = hoot_get_mod( 'sidebar' );
	}

	// Allow for custom manipulation of the layout by child themes
	$sidebar = apply_filters( 'hoot_main_layout', $sidebar );

	// Save the layout for current view
	hoot_set_current_layout( $sidebar );

}
endif;

/**
 * Utility function to calculate and set main (content+aside) layout according to the sidebar layout
 * set by user for the current view.
 * Can only be used after 'posts_selection' action hook i.e. in 'wp' hook or later.
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hoot_set_current_layout' ) ):
function hoot_set_current_layout( $sidebar ) {
	$spans = apply_filters( 'hoot_main_layout_spans', array(
		'none' => array(
			'content' => 9,
			'sidebar' => 0,
		),
		'full' => array(
			'content' => 12,
			'sidebar' => 0,
		),
		'full-width' => array(
			'content' => 12,
			'sidebar' => 0,
		),
		'narrow-right' => array(
			'content' => 9,
			'sidebar' => 3,
		),
		'wide-right' => array(
			'content' => 8,
			'sidebar' => 4,
		),
		'narrow-left' => array(
			'content' => 9,
			'sidebar' => 3,
		),
		'wide-left' => array(
			'content' => 8,
			'sidebar' => 4,
		),
		'narrow-left-left' => array(
			'content' => 6,
			'sidebar' => 3,
		),
		'narrow-left-right' => array(
			'content' => 6,
			'sidebar' => 3,
		),
		'narrow-right-left' => array(
			'content' => 6,
			'sidebar' => 3,
		),
		'narrow-right-right' => array(
			'content' => 6,
			'sidebar' => 3,
		),
		'default' => array(
			'content' => 8,
			'sidebar' => 4,
		),
	) );

	/* Set the layout for current view */
	global $hoot_theme;
	$hoot_theme->currentlayout['layout'] = $sidebar;
	if ( isset( $spans[ $sidebar ] ) ) {
		$hoot_theme->currentlayout['content'] = $spans[ $sidebar ]['content'];
		$hoot_theme->currentlayout['sidebar'] = $spans[ $sidebar ]['sidebar'];
	} else {
		$hoot_theme->currentlayout['content'] = $spans['default']['content'];
		$hoot_theme->currentlayout['sidebar'] = $spans['default']['sidebar'];
	}

}
endif;

/**
 * Utility function to determine the location of page header
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hoot_page_header_attop' ) ):
function hoot_page_header_attop() {

	$full = array_map( 'trim', explode( ',', hoot_get_mod( 'page_header_full' ) ) );

	/* Override For Full Width Pages (including 404 page) */
	if ( in_array( 'no-sidebar', $full ) ) {
		$sidebar_size = hoot_main_layout( 'primary-sidebar' );
		if ( empty( $sidebar_size ) || hybridextend_is_404() )
			return apply_filters( 'hoot_page_header_attop', true, 'no-sidebar', $full );
	}

	/* For Posts */
	if ( is_singular( 'post' ) ) {
		if ( in_array( 'posts', $full ) )
			return apply_filters( 'hoot_page_header_attop', true, 'posts', $full );
		else
			return apply_filters( 'hoot_page_header_attop', false, 'posts', $full );
	}

	/* For Pages */
	if ( is_page() ) {
		if ( in_array( 'pages', $full ) )
			return apply_filters( 'hoot_page_header_attop', true, 'pages', $full );
		else
			return apply_filters( 'hoot_page_header_attop', false, 'pages', $full );
	}

	/* Default */
	if ( in_array( 'default', $full ) )
		return apply_filters( 'hoot_page_header_attop', true, 'default', $full );
	else
		return apply_filters( 'hoot_page_header_attop', false, 'default', $full );

}
endif;

/**
 * Utility function to create slider slides array for lite version
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hoot_get_lite_slider' ) ):
function hoot_get_lite_slider( $type ) {
	$slides = $data = array();
	switch ( $type ) {

		case 'html':
			for ( $i = 1; $i <= 4;  $i++ ) {
				$id = intval( hoot_get_mod( "wt_html_slide_{$i}-content" ) );
				if ( !empty( $id ) ) {
					$postobj = get_post( $id );
					$size = hybridextend_get_image_size_name('span-6');
					$data[$i]['title'] = ( !empty( $postobj->post_title ) ) ? $postobj->post_title : '';
					$data[$i]['content'] = ( !empty( $postobj->post_content ) ) ? apply_filters( 'the_content', $postobj->post_content ) : '';
					if ( has_post_thumbnail ( $id ) ) {
						$isrc = wp_get_attachment_image_src( get_post_thumbnail_id($id), $size );
						if( empty( $isrc ) ) $isrc = wp_get_attachment_image_src( get_post_thumbnail_id($id), $size, true );
						$data[$i]['image'] = $isrc[0];
					} else $data[$i]['image'] = '';
				}
			}
			for ( $i = 1; $i <= 4;  $i++ ) { 
				if ( !empty( $data[$i] ) ) {
					$slides[ $i ]['image'] = esc_url( $data[$i]['image'] );
					$slides[ $i ]['content'] = '<h4>' . esc_html( $data[$i]['title'] ) . '</h4>' . $data[$i]['content'];
					// $slides[ $i ]['image'] = hoot_get_mod( "wt_html_slide_{$i}-image" );
					// $slides[ $i ]['content'] = hoot_get_mod( "wt_html_slide_{$i}-content" );
					$slides[ $i ]['content_bg'] = hoot_get_mod( "wt_html_slide_{$i}-content_bg" );
					$slides[ $i ]['button'] = hoot_get_mod( "wt_html_slide_{$i}-button" );
					$slides[ $i ]['url'] = hoot_get_mod( "wt_html_slide_{$i}-url" );
					$slides[ $i ]['background']['color'] = hoot_get_mod( "wt_html_slide_{$i}-background-color" );
					$slides[ $i ]['background']['type'] = hoot_get_mod( "wt_html_slide_{$i}-background-type" );
					$slides[ $i ]['background']['pattern'] = hoot_get_mod( "wt_html_slide_{$i}-background-pattern" );
					$slides[ $i ]['background']['image'] = hoot_get_mod( "wt_html_slide_{$i}-background-image" );
					// $slides[ $i ]['background']['repeat'] = hoot_get_mod( "wt_html_slide_{$i}-background-repeat" );
					// $slides[ $i ]['background']['position'] = hoot_get_mod( "wt_html_slide_{$i}-background-position" );
					// $slides[ $i ]['background']['attachment'] = hoot_get_mod( "wt_html_slide_{$i}-background-attachment" );
				}
			}
			break;

		case 'image':
		case 'img':
			for ( $i = 1; $i <= 4;  $i++ ) { 
				$slides[ $i ]['image'] = hoot_get_mod( "wt_img_slide_{$i}-image" );
				$slides[ $i ]['caption'] = hoot_get_mod( "wt_img_slide_{$i}-caption" );
				$slides[ $i ]['caption_bg'] = hoot_get_mod( "wt_img_slide_{$i}-caption_bg" );
				$slides[ $i ]['url'] = hoot_get_mod( "wt_img_slide_{$i}-url" );
				$slides[ $i ]['button'] = hoot_get_mod( "wt_img_slide_{$i}-button" );
			}
			break;

	}
	return apply_filters( 'hoot_get_lite_slider_slides', $slides, $data );
}
endif;

/**
 * Display function to render posts for Jetpack's infinite scroll module
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hoot_jetpack_infinitescroll_render' ) ):
function hoot_jetpack_infinitescroll_render(){
	while ( have_posts() ) : the_post();
		// Loads the template-parts/content-{$post_type}.php template.
		hybridextend_get_content_template();
	endwhile;
}
endif;

/**
 * Hide title area on static frontpage (not using Widgetized Template)
 * @todo: Redundant
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hoot_hide_loop_meta_static_frontpage' ) ) :
function hoot_hide_loop_meta_static_frontpage( $display ) {
	if ( is_front_page() )
		return 'hide';
	else
		return $display;
}
endif;
add_filter( 'loop_meta_display_title', 'hoot_hide_loop_meta_static_frontpage' );

/**
 * Return Skype contact button code
 * Ref: https://www.skype.com/en/developer/create-contactme-buttons/
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hoot_get_skype_button_code' ) ) :
function hoot_get_skype_button_code( $username ) {
	static $script = false;
	static $id = 1;
	$code = '';
	$action = apply_filters( 'hoot_skype_button_action', 'call' );

	if ( !$script )
		$code .= '<script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>';

	$code .= '<div id="SkypeButton_Call_' . $username . '_' . $id . '" class="hoot-skype-call-button">';
	$code .= '<script type="text/javascript">';
	$code .=  'Skype.ui({'
			. '"name": "' . $action . '",' // dropdown (doesnt work well), call, chat
			. '"element": "SkypeButton_Call_' . $username . '_' . $id . '",'
			. '"participants": ["' . $username . '"],'
			//. '"imageColor": "white",' // omit for blue
			. '"imageSize": 24' // 10, 12, 14, 16 (omit), 24, 32
			. '});';
	$code .= '</script>';
	$code .= '</div>';

	$code = apply_filters( 'hoot_get_skype_button_code', $code, $script, $id, $action );
	$script = true;
	$id++;
	return $code;
}
endif;
