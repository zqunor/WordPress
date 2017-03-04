<?php
// Let child theme modify template structure
do_action( 'hoot_template_frontpage' );
if ( apply_filters( 'hoot_disable_widgetized_frontpage', false ) )
	return;

// Loads the header.php template.
get_header();

// Template structure
$fpg_sidebar = apply_filters( 'frontpage_sidebar', 'none' );
$fpg_content_context = ( $fpg_sidebar == 'none' ) ? 'none' : '';
$fpg_content_grid = ( $fpg_sidebar == 'none' ) ? 'grid-stretch' : 'grid';
$fpg_content_grid .= ( is_home() ) ? '' : ' main-content-grid';
$fpg_paged_hidemodules = apply_filters( 'fpg_paged_hidemodules', is_paged() );

// Template modification Hook
do_action( 'hoot_template_before_content_grid', 'frontpage.php' );
?>

<div class="<?php echo $fpg_content_grid; ?>">

	<?php
	// Template modification Hook
	do_action( 'hoot_template_before_main', 'frontpage.php' );
	?>

	<main <?php hybridextend_attr( 'frontpage-content', $fpg_content_context ); ?>>

		<?php
		// Template modification Hook
		do_action( 'hoot_template_main_start', 'frontpage.php' );

		// Get Sections List
		$sections = hybridextend_sortlist( hoot_get_mod( 'frontpage_sections' ) );

		// Display Each Section according to ther sort order.
		if ( is_array( $sections ) && !empty( $sections ) ) :
			foreach ( $sections as $key => $section ) :
				if ( empty( $section[ 'sortitem_hide' ] ) ):

					$key = apply_filters( 'frontpage_sections_switch', $key );
					$module_bg = hoot_get_mod( "frontpage_sectionbg_{$key}-type" );
					$module_bg = ( empty( $module_bg ) ) ? 'none' : $module_bg;
					$background_class = 'module-bg-' . $module_bg;
					$background_class .= ( $module_bg == 'highlight' ) ? ' area-highlight' : '';
					$section['columns'] = isset( $section['columns'] ) ? $section['columns'] : '100';

					if ( $fpg_paged_hidemodules && $key != 'content' )
						continue;

					switch( $key ):

						// Display Widget Areas
						case 'area_a': case 'area_b': case 'area_c': case 'area_d': case 'area_e':
							$structure = hoot_col_width_to_span( $section['columns'] );
							$count = count( $structure );
							$displayarea = false;
							for ( $c = 1; $c <= $count ; $c++ ) {
								if ( is_active_sidebar( "hoot-frontpage-{$key}_{$c}" ) ) {
									$displayarea = true;
									break;
								}
							}
							if ( $displayarea ) : ?>
								<div id="frontpage-<?php echo sanitize_html_class( $key ); ?>" <?php hybridextend_attr( 'frontpage-area', $key, 'frontpage-area ' . esc_attr( $background_class ) ); ?>>
									<div class="grid">
										<?php
										for ( $c = 1; $c <= $count ; $c++ ) {
											$area_id = "frontpage-{$key}_{$c}";
											$structurekey = $c - 1;
											?>
											<div id="<?php echo sanitize_html_class( $area_id ); ?>" class="<?php echo $structure[$structurekey]; ?>">
												<?php
												if ( is_active_sidebar( 'hoot-' . $area_id ) )
													dynamic_sidebar( 'hoot-' . $area_id );
												?>
											</div>
											<?php
										}
										?>
									</div>
								</div>
							<?php endif;
							break;

						// Display Page Content
						case 'content':
							?>
							<div id="frontpage-page-content" class="frontpage-area <?php echo esc_attr( $background_class ); ?>">
								<?php
								wp_reset_query();

								if( is_home() ) :

									?><div class="grid hoot-blogposts main-content-grid"><?php

										if ( !empty( $section['title'] ) )
											echo '<div class="grid-span-12"><h3 class="hoot-blogposts-title">' . wp_kses_post( $section['title'] ) . '</h3></div>';

										if ( have_posts() ) :
											?>
											<div class="content <?php echo hoot_main_layout_class( 'content' ); ?>">
												<div id="content-wrap">
													<?php
													while ( have_posts() ) : the_post();
														// Loads the template-parts/content-{$post_type}.php template.
														hybridextend_get_content_template();
													endwhile;
													?>
												</div>
												<?php
												// Loads the template-parts/loop-nav.php template.
												get_template_part( 'template-parts/loop-nav' );
												?>
											</div>
											<?php hybridextend_get_sidebar( 'primary' ); ?>
											<div class="clearfix"></div>
										<?php
										else :
											// Loads the template-parts/error.php template.
											get_template_part( 'template-parts/error' );
										endif;

									?></div><?php

								else :

									?><div class="grid"><div class="grid-span-12"><?php

										if ( !empty( $section['title'] ) )
											echo '<h3 class="hoot-blogposts-title">' . wp_kses_post( $section['title'] ) . '</h3>';

										echo '<div class="entry-content">';
										// Load the static page content
										while ( have_posts() ) : the_post();
											hybridextend_get_content_template();
										endwhile;
										echo '</div>';

									?></div></div><?php

								endif;
								?>

							</div>

							<?php break;

						// Display HTML Slider
						case 'slider_html': 
							$slider_width = hoot_get_mod( 'wt_html_slider_width' );
							$slider_grid = ( 'stretch' == $slider_width ) ? 'grid-stretch' : 'grid'; ?>

							<div id="frontpage-html-slider" class="frontpage-area <?php echo esc_attr( $background_class ); ?>">
								<div class="frontpage-slider <?php echo $slider_grid; ?>">
									<div class="grid-span-12">
										<?php
										$frontpage_slider = apply_filters( 'frontpage_slider' , '', 'wt_cpt_slider_a' );

										if ( !empty( $frontpage_slider ) ) {
											echo $frontpage_slider;
										} else {
											global $hoot_theme;
											$slides = hoot_get_lite_slider( 'html' );

											if ( is_array( $slides ) && !empty( $slides ) ):

												/* Reset any previous slider */
												$hoot_theme->slider = array();
												$hoot_theme->sliderSettings = array(
													'class' => 'fpg-slider',
													'min_height' => intval( hoot_get_mod( 'wt_html_slider_min_height' ) ),
													);

												/* Create slider object */
												foreach ( $slides as $slide ) {
													if ( !empty( $slide['image'] ) || !empty( $slide['content'] ) || !empty( $slide['url'] ) ) {
														$hoot_theme->slider[] = $slide;
													}
												}

												/* Display Slider Template */
												get_template_part( 'template-parts/slider-html' );

											endif;
										}
										?>
									</div>
								</div>
							</div>

							<?php break;

						// Display Image Slider
						case 'slider_img': 
							$slider_width = hoot_get_mod( 'wt_img_slider_width' );
							$slider_grid = ( 'stretch' == $slider_width ) ? 'grid-stretch' : 'grid'; ?>

							<div id="frontpage-img-slider" class="frontpage-area <?php echo esc_attr( $background_class ); ?>">
								<div class="frontpage-slider <?php echo $slider_grid; ?>">
									<div class="grid-span-12">
										<?php
										$frontpage_slider = apply_filters( 'frontpage_slider' , '', 'wt_cpt_slider_b' );

										if ( !empty( $frontpage_slider ) ) {
											echo $frontpage_slider;
										} else {
											global $hoot_theme;
											$slides = hoot_get_lite_slider( 'image' );

											if ( is_array( $slides ) && !empty( $slides ) ):

												/* Reset any previous slider */
												$hoot_theme->slider = array();
												$hoot_theme->sliderSettings = array( 'class' => 'fpg-slider' );

												/* Create slider object */
												foreach ( $slides as $slide ) {
													if ( !empty( $slide['image'] ) ) {
														$hoot_theme->slider[] = $slide;
													}
												}

												/* Display Slider Template */
												get_template_part( 'template-parts/slider-image' );

											endif;
										}
										?>
									</div>
								</div>
							</div>

							<?php break;

						default:
							// Allow mods to display content
							do_action( 'frontpage_sections', $key, $sections, $background_class );

					endswitch;

				endif;
			endforeach;
		endif;

		// Template modification Hook
		do_action( 'hoot_template_main_end', 'frontpage.php' );
		?>

	</main><!-- #content -->

	<?php
	// Template modification Hook
	do_action( 'hoot_template_after_main', 'frontpage.php' );
	?>

	<?php
	if ( $fpg_sidebar !== 'none' ) {
		hybridextend_get_sidebar( 'primary' ); // Loads the template-parts/sidebar-primary.php template.
	}
	?>

</div><!-- .grid -->

<?php get_footer(); // Loads the footer.php template. ?>