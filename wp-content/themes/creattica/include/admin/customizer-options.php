<?php
/**
 * Defines customizer options
 *
 * This file is loaded at 'after_setup_theme' hook with 10 priority.
 *
 * @package    Hoot
 * @subpackage Creattica
 */

/**
 * Build the Customizer options (panels, sections, settings)
 *
 * Always remember to mention specific priority for non-static options like:
 *     - options being added based on a condition (eg: if woocommerce is active)
 *     - options which may get removed (eg: logo_size, headings_fontface)
 *     - options which may get rearranged (eg: logo_background_type)
 *     This will allow other options inserted with priority to be inserted at
 *     their intended place.
 *
 * @since 1.0
 * @access public
 * @return array
 */
if ( !function_exists( 'hoot_theme_customizer_options' ) ) :
function hoot_theme_customizer_options() {

	// Stores all the settings to be added
	$settings = array();

	// Stores all the sections to be added
	$sections = array();

	// Stores all the panels to be added
	$panels = array();

	// Theme default colors and fonts
	extract( apply_filters( 'hoot_theme_options_defaults', array(
		'accent_color'         => '#e23348',
		'accent_font'          => '#ffffff',
		'box_background'       => '#ffffff',
		'box_background_patt'  => 'hybrid/extend/images/patterns/4.png',
		'site_background'      => '#ffffff',
	) ) );

	// Directory path for radioimage buttons
	$imagepath =  HYBRIDEXTEND_INCURI . 'admin/images/';

	// Logo Sizes (different range than standard typography range)
	$logosizes = array();
	$logosizerange = range( 14, 110 );
	foreach ( $logosizerange as $isr )
		$logosizes[ $isr . 'px' ] = $isr . 'px';
	$logosizes = apply_filters( 'hoot_theme_options_logosizes', $logosizes);

	// Logo Font Options for Lite version
	$logofont = apply_filters( 'hoot_theme_options_logofont', array(
					'standard' => __('Standard Body Font', 'creattica'),
					'heading' => __('Logo Font  (set in Logo section)', 'creattica'),
					) );

	/*** Add Options (Panels, Sections, Settings) ***/

	/** Section **/

	$section = 'title_tagline';

	$sections[ $section ] = array(
		'title'       => __( 'Setup &amp; Layout', 'creattica' ),
	);

	$settings['site_width'] = array(
		'label'       => __( 'Max. Site Width (pixels)', 'creattica' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'1260' => __('Wide', 'creattica'), // 1260 + 270
			'1080' => __('Standard', 'creattica'), // 1080 + 270
			'780'  => __('Compact', 'creattica'), // 780 + 270 = 1050
		),
		'default'     => '1260',
	);

	$settings['sidebar_desc'] = array(
		'label'       => __( 'Multiple Sidebars', 'creattica' ),
		'section'     => $section,
		'type'        => 'content',
		'content'     => sprintf( __( 'This theme can display different sidebar content on different pages of your site with the %1sCustom Sidebars%2s plugin. Simply install and activate the plugin to use it with this theme. Or if you are using %3sJetpack%4s, you can use the %5s"Widget Visibility"%6s module.', 'creattica' ), '<a href="https://wordpress.org/plugins/custom-sidebars/screenshots/" target="_blank">', '</a>', '<a href="https://wordpress.org/plugins/jetpack/" target="_blank">', '</a>', '<a href="https://jetpack.com/support/widget-visibility/" target="_blank">', '</a>' ),
	);

	$settings['sidebar'] = array(
		'label'       => __( 'Sidebar Layout (Site-wide)', 'creattica' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'wide-right'         => $imagepath . 'sidebar-wide-right.png',
			'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
			'wide-left'          => $imagepath . 'sidebar-wide-left.png',
			'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
			'full-width'         => $imagepath . 'sidebar-full.png',
			'none'               => $imagepath . 'sidebar-none.png',
		),
		'default'     => 'wide-right',
		'description' => __("Set the default sidebar width and position for your site.", 'creattica'),
	);

	$settings['sidebar_pages'] = array(
		'label'       => __( 'Sidebar Layout (for Pages)', 'creattica' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'wide-right'         => $imagepath . 'sidebar-wide-right.png',
			'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
			'wide-left'          => $imagepath . 'sidebar-wide-left.png',
			'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
			'full-width'         => $imagepath . 'sidebar-full.png',
			'none'               => $imagepath . 'sidebar-none.png',
		),
		'default'     => 'wide-right',
	);

	$settings['sidebar_posts'] = array(
		'label'       => __( 'Sidebar Layout (for single Posts)', 'creattica' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'wide-right'         => $imagepath . 'sidebar-wide-right.png',
			'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
			'wide-left'          => $imagepath . 'sidebar-wide-left.png',
			'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
			'full-width'         => $imagepath . 'sidebar-full.png',
			'none'               => $imagepath . 'sidebar-none.png',
		),
		'default'     => 'wide-right',
	);

	$settings['load_minified'] = array(
		'label'       => __( 'Load Minified Styles and Scripts (when available)', 'creattica' ),
		'sublabel'    => __( 'Checking this option reduces data size, hence increasing page load speed.', 'creattica' ),
		'section'     => $section,
		'type'        => 'checkbox',
		// 'default'     => 1,
	);

	$settings['leftbar_menu_superfish'] = array(
		'label'       => __( '[Menu]: Expand Dropdown on Hover', 'creattica' ),
		'sublabel'    => __( 'By default menu dropdowns (sub-menus) expand on clicking.', 'creattica' ),
		'section'     => $section,
		'type'        => 'checkbox',
		// 'default'     => '1',
	);

	$settings['mobile_menu'] = array(
		'label'       => __( '[Mobile Menu]:', 'creattica' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'inline' => __('Inline - Menu Slide Downs to open', 'creattica'),
			'fixed'  => __('Fixed - Menu opens on the left', 'creattica'),
		),
		'default'     => 'fixed',
		'priority'    => '75', // @todo remove
	);

	// $settings['mobile_submenu_click'] = array(
	// 	'label'       => __( "[Mobile Menu]: Submenu opens on 'Click'", 'creattica' ),
	// 	'section'     => $section,
	// 	'type'        => 'checkbox',
	// 	'default'     => 1,
	// 	'priority'    => '75', // @todo remove
	// 	'description' => __( "Uncheck this option to make all Submenus appear in 'Open' state. By default, submenus open on clicking (i.e. single tap on mobile).", 'creattica' ),
	// );

	$settings['leftbar_bottom_mobile_display'] = array(
		'label'       => __( '[Mobile]: Show Leftbar Bottom area on mobile', 'creattica' ),
		'sublabel'    => __( 'By default this area is hidden on mobile.', 'creattica' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'default'     => '1',
	);

	$settings['leftbar_bottom_mobile_location'] = array(
		'label'           => __( '[Mobile]: Leftbar Bottom Area location on mobile', 'creattica' ),
		'sublabel'        => __( 'By default this area is hidden on mobile.', 'creattica' ),
		'section'         => $section,
		'type'            => 'radio',
		'choices'         => array(
			'top'     => __( 'Top (next to header)', 'creattica'),
			'bottom'  => __( 'Bottom (next to footer)', 'creattica'),
		),
		'default'         => 'bottom',
		'active_callback' => 'hoot_callback_leftbar_bottom_mobile_location',
	);

	/** Section **/

	$section = 'logo';

	$sections[ $section ] = array(
		'title'       => __( 'Logo', 'creattica' ),
	);

	$settings['logo_fontface'] = array(
		'label'       => __( 'Logo Font (Free Version)', 'creattica' ),
		'section'     => $section,
		'type'        => 'select',
		'priority'    => 94, // Non static options must have a priority
		'description' => __('The premium version offers complete typography control (color, style, size) for various headings, header, menu, footer, widgets, content sections etc (over 600 Google Fonts to chose from)', 'creattica'),
		'choices'     => array(
			'standard' => __( 'Standard Font (Open Sans)', 'creattica'),
			'cursive'  => __( 'Cursive Font (Pacifico)', 'creattica'),
		),
		'default'     => 'standard',
	);

	$settings['logo_background_type'] = array(
		'label'       => __( 'Logo Background', 'creattica' ),
		'section'     => $section,
		'type'        => 'radio',
		'priority'    => '95', // Non static options must have a priority
		'choices'     => array(
			'transparent' => __('None', 'creattica'),
			'accent'      => __('Accent Color', 'creattica'),
		),
		'default'     => 'accent',
	);

	$settings['logo'] = array(
		'label'       => __( 'Site Logo', 'creattica' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'text'        => __('Default Text (Site Title)', 'creattica'),
			'custom'      => __('Custom Text', 'creattica'),
			'image'       => __('Image Logo', 'creattica'),
			'mixed'       => __('Image &amp; Default Text (Site Title)', 'creattica'),
			'mixedcustom' => __('Image &amp; Custom Text', 'creattica'),
		),
		'default'     => 'text',
		'description' => sprintf( __('Use %sSite Title%s as default text logo', 'creattica'), '<a href="' . esc_url( admin_url('options-general.php') ) . '" target="_blank">', '</a>' ),
	);

	$settings['logo_size'] = array(
		'label'       => __( 'Logo Size', 'creattica' ),
		'section'     => $section,
		'type'        => 'select',
		'priority'    => '105', // Non static options must have a priority
		'choices'     => array(
			'tiny'               => __( 'Tiny', 'creattica'),
			'tiny displayfont'   => __( 'Tiny (emphasized)', 'creattica'),
			'small'              => __( 'Small', 'creattica'),
			'small displayfont'  => __( 'Small (emphasized)', 'creattica'),
			'medium'             => __( 'Medium', 'creattica'),
			'medium displayfont' => __( 'Medium (emphasized)', 'creattica'),
			'large'              => __( 'Large', 'creattica'),
			'large displayfont'  => __( 'Large (emphasized)', 'creattica'),
			'huge'               => __( 'Huge', 'creattica'),
			'huge displayfont'   => __( 'Huge (emphasized)', 'creattica'),
		),
		'default'     => 'medium displayfont',
		'active_callback' => 'hoot_callback_logo_size',
	);

	$settings['site_title_icon'] = array(
		'label'           => __( 'Site Title Icon (Optional)', 'creattica' ),
		'section'         => $section,
		'type'            => 'icon',
		// 'default'         => 'fa-anchor',
		'description'     => __( 'Leave empty to hide icon.', 'creattica' ),
		'active_callback' => 'hoot_callback_site_title_icon',
	);

	$settings['site_title_icon_size'] = array(
		'label'           => __( 'Site Title Icon Size', 'creattica' ),
		'section'         => $section,
		'type'            => 'select',
		'choices'         => $logosizes,
		'default'         => '50px',
		'active_callback' => 'hoot_callback_site_title_icon',
	);

	if ( ! function_exists( 'the_custom_logo' ) )
	$settings['logo_image'] = array(
		'label'           => __( 'Upload Logo', 'creattica' ),
		'section'         => $section,
		'type'            => 'image',
		'priority'        => '125', // Replaced by WP's custom_logo if available // Update in premium if needed
		'active_callback' => 'hoot_callback_logo_image',
	);

	$logo_custom_line_options = array(
		'text' => array(
			'label'       => __( 'Line Text', 'creattica' ),
			'type'        => 'text',
		),
		'size' => array(
			'label'       => __( 'Line Size', 'creattica' ),
			'type'        => 'select',
			'choices'     => $logosizes,
			'default'     => '24px',
		),
		'font' => array(
			'label'       => __( 'Line Font', 'creattica' ),
			'type'        => 'select',
			'choices'     => $logofont,
			'default'     => 'heading',
		),
	);

	$settings['logo_custom'] = array(
		'label'           => __( 'Custom Logo Text', 'creattica' ),
		'section'         => $section,
		'type'            => 'sortlist',
		'choices'         => array(
			'line1' => __('Line 1', 'creattica'),
			'line2' => __('Line 2', 'creattica'),
			'line3' => __('Line 3', 'creattica'),
			'line4' => __('Line 4', 'creattica'),
		),
		'options'         => array(
			'line1' => $logo_custom_line_options,
			'line2' => $logo_custom_line_options,
			'line3' => $logo_custom_line_options,
			'line4' => $logo_custom_line_options,
		),
		'attributes'      => array(
			'inactive' => array( 'line3', 'line4' ),
			'hideable' => true,
			'sortable' => false,
		),
		'active_callback' => 'hoot_callback_logo_custom',
	);

	$settings['show_tagline'] = array(
		'label'           => __( 'Show Tagline', 'creattica' ),
		'sublabel'        => __( 'Display site description as tagline below logo.', 'creattica' ),
		'section'         => $section,
		'type'            => 'checkbox',
		'default'         => 1,
		'active_callback' => 'hoot_callback_show_tagline',
	);

	/** Section **/

	$section = 'colors';

	// Redundant as 'colors' section is added by WP. But we still add it for brevity
	$sections[ $section ] = array(
		'title'       => __( 'Colors', 'creattica' ),
		'description' => __('Control various color options in the premium version for fonts, backgrounds, contrast, highlight, accent etc.', 'creattica'),
	);

	$settings['accent_color'] = array(
		'label'       => __( 'Accent Color', 'creattica' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $accent_color,
	);

	$settings['accent_font'] = array(
		'label'       => __( 'Font Color on Accent Color', 'creattica' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $accent_font,
	);

	if ( current_theme_supports( 'woocommerce' ) ) :
		$settings['woocommerce-colors-plugin'] = array(
			'label'       => __( 'Woocommerce Styling', 'creattica' ),
			'section'     => $section,
			'type'        => 'content',
			'priority'    => '165', // Non static options must have a priority
			'content'     => sprintf( __('Looks like you are using Woocommerce. Install %sthis plugin%s to change colors and styles for WooCommerce elements like buttons etc.', 'creattica'), '<a href="https://wordpress.org/plugins/woocommerce-colors/" target="_blank">', '</a>' ),
		);
	endif;

	/** Section **/

	$section = 'backgrounds';

	$sections[ $section ] = array(
		'title'       => __( 'Backgrounds', 'creattica' ),
		'description' => __('The premium version comes with background options for different sections of your site like header, menu dropdown, content area, logo background, footer etc.', 'creattica'),
	);

	$settings['background'] = array(
		'label'       => __( 'Site Background', 'creattica' ),
		'section'     => $section,
		'type'        => 'betterbackground',
		'default'     => array(
			'color'      => $site_background,
		),
	);

	$settings['box_background'] = array(
		'label'       => __( 'Content Box Background', 'creattica' ),
		'section'     => $section,
		'type'        => 'betterbackground',
		'default'     => array(
			'color'      => $box_background,
			'pattern'    => $box_background_patt,
		),
	);

	/** Section **/

	$section = 'frontpage';

	$sections[ $section ] = array(
		'title'       => __( 'Frontpage - Modules', 'creattica' ),
	);

	$widget_area_options = array(
		'columns' => array(
			'label'   => __( 'Columns', 'creattica' ),
			'type'    => 'select',
			'choices' => array(
				'100'         => __('One Column [100]', 'creattica'),
				'50-50'       => __('Two Columns [50 50]', 'creattica'),
				'33-66'       => __('Two Columns [33 66]', 'creattica'),
				'66-33'       => __('Two Columns [66 33]', 'creattica'),
				'25-75'       => __('Two Columns [25 75]', 'creattica'),
				'75-25'       => __('Two Columns [75 25]', 'creattica'),
				'33-33-33'    => __('Three Columns [33 33 33]', 'creattica'),
				'25-25-50'    => __('Three Columns [25 25 50]', 'creattica'),
				'25-50-25'    => __('Three Columns [25 50 25]', 'creattica'),
				'50-25-25'    => __('Three Columns [50 25 25]', 'creattica'),
				'25-25-25-25' => __('Four Columns [25 25 25 25]', 'creattica'),
			),
		),
		'modulebg' => array(
			'label'       => '',
			'type'        => 'content',
			'content'     => '<div class="button">' . __( 'Module Background', 'creattica' ) . '</div>',
		),
	);

	$settings['frontpage_sections'] = array(
		'label'       => __( 'Frontpage Widget Areas', 'creattica' ),
		'sublabel'    => sprintf( __("<p></p><ul><li>Sort different sections of the Frontpage in the order you want them to appear.</li><li>You can add content to widget areas from the %1sWidgets Management screen%2s.</li><li>You can disable areas by clicking the 'eye' icon. (This will hide them on the Widgets screen as well)</li></ul>", 'creattica'), '<a href="' . esc_url( admin_url('widgets.php') ) . '" target="_blank">', '</a>' ),
		'section'     => $section,
		'type'        => 'sortlist',
		'choices'     => array(
			'slider_html' => __('HTML Slider', 'creattica'),
			'slider_img'  => __('Image Slider', 'creattica'),
			'area_a'      => __('Widget Area A', 'creattica'),
			'area_b'      => __('Widget Area B', 'creattica'),
			'area_c'      => __('Widget Area C', 'creattica'),
			'area_d'      => __('Widget Area D', 'creattica'),
			'area_e'      => __('Widget Area E', 'creattica'),
			'content'     => __('Frontpage Content', 'creattica'),
		),
		'default'     => array(
			// 'content' => array( 'sortitem_hide' => 1, ),
			'area_b'  => array( 'columns' => '50-50' ),
		),
		'options'     => array(
			// 'slider_html' => $widget_area_options,
			// 'slider_img'  => $widget_area_options,
			'area_a'      => $widget_area_options,
			'area_b'      => $widget_area_options,
			'area_c'      => $widget_area_options,
			'area_d'      => $widget_area_options,
			'area_e'      => $widget_area_options,
			'content'     => array(
							'title' => array(
								'label'       => __( 'Title (optional)', 'creattica' ),
								'type'        => 'text',
							),
							'modulebg' => array(
								'label'       => '',
								'type'        => 'content',
								'content'     => '<div class="button">' . __( 'Module Background', 'creattica' ) . '</div>',
							), ),
		),
		'attributes'  => array(
			'hideable'      => true,
			'sortable'      => true,
		),
		// 'description' => sprintf( __('You must first save the changes you make here and refresh this screen for widget areas to appear in the Widgets panel (in customizer). Once you save the settings, you can add content to these widget areas using the %sWidgets Management screen%s.', 'creattica'), '<a href="' . esc_url( admin_url('widgets.php') ) . '" target="_blank">', '</a>' ),
	);

	$settings['frontpage_content_desc'] = array(
		'label'       => __( "Frontpage Content", 'creattica' ),
		'section'     => $section,
		'type'        => 'content',
		'content'     => sprintf( __( "The 'Frontpage Content' module in above list will show<ul style='list-style:disc;margin:1em 0 0 2em;'><li>the <strong>'Blog'</strong> if you have <strong>Your Latest Posts</strong> selectd in %3sReading Settings%4s</li><li>the <strong>Page Content</strong> of the page set as Front page if you have <strong>A static page</strong> selected in %3sReading Settings%4s</li></ul>", 'creattica' ), '<a href="' . esc_url( admin_url('options-reading.php') ) . '" target="_blank">', '</a>', '<a href="' . esc_url( admin_url('options-reading.php') ) . '" target="_blank">', '</a>' ),
	);

	$frontpagemodule_bg = array(
		'area_a'      => __('Widget Area A', 'creattica'),
		'area_b'      => __('Widget Area B', 'creattica'),
		'area_c'      => __('Widget Area C', 'creattica'),
		'area_d'      => __('Widget Area D', 'creattica'),
		'area_e'      => __('Widget Area E', 'creattica'),
		'content'     => __('Frontpage Content', 'creattica'),
		);

	foreach ( $frontpagemodule_bg as $fpgmodid => $fpgmodname ) {

		$settings["frontpage_sectionbg_{$fpgmodid}"] = array(
			'label'       => '', // __( 'Module Background', 'creattica' ),
			'section'     => $section,
			'type'        => 'group',
			'button'      => __( 'Module Background', 'creattica' ),
			'options'     => array(
				'description' => array(
					'label'       => '',
					'type'        => 'content',
					'content'     => '<span class="hoot-module-bg-title">' . $fpgmodname . '</span>',
				),
				'type' => array(
					'label'   => __( 'Background Type', 'creattica' ),
					'type'    => 'radio',
					'choices' => array(
						'none'        => __('None', 'creattica'),
						'highlight'   => __('Highlight Color', 'creattica'),
						'image'       => __('Background Image', 'creattica'),
					),
					// 'default' => ( ( $fpgmodid == 'area_b' ) ? 'image' :
					// 											( ( $fpgmodid == 'area_d' ) ? 'highlight' : 'none' )
					// 			 ),
					'default' => ( ( $fpgmodid == 'area_b' ) ? 'image' : 'none' ),
				),
				'image' => array(
					'label'       => __( "Background Image (Select 'Image' above)", 'creattica' ),
					'type'        => 'image',
					'default' => ( ( $fpgmodid == 'area_b' ) ? HYBRID_PARENT_URI . 'images/modulebg.jpg' : '' ),
				),
				'parallax' => array(
					'label'   => __( 'Apply Parallax Effect to Background Image', 'creattica' ),
					'type'    => 'checkbox',
					'default' => ( ( $fpgmodid == 'area_b' ) ? 1 : 0 ),
				),
			),
		);

	} // end for

	/** Section **/

	$section = 'slider_html';

	$sections[ $section ] = array(
		'title'       => __( 'Frontpage - HTML Slider', 'creattica' ),
	);

	$settings['wt_html_slider_width'] = array(
		'label'       => __( 'Slider Padding', 'creattica' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'boxed'   => __('With Padding', 'creattica'),
			'stretch' => __('Stretched (no padding)', 'creattica'),
		),
		'default'     => 'stretch',
	);

	$settings['wt_html_slider_min_height'] = array(
		'label'       => __( 'Minimum Slider Height (in pixels)', 'creattica' ),
		'section'     => $section,
		'type'        => 'text',
		'priority'    => 775, // Non static options must have a priority
		'default'     => 375,
		'description' => __('<strong>(in pixels)</strong><hr>Leave empty to let the slider height adjust automatically.', 'creattica'),
		'input_attrs' => array(
			'min' => 0,
			'max' => 3,
			'placeholder' => __( '(in pixels)', 'creattica' ),
		),
	);

	$settings['wt_html_slider'] = array(
		'label'       => __( 'Slides', 'creattica' ),
		'section'     => $section,
		'type'        => 'content',
		'priority'    => 775, // Non static options must have a priority
		'content'     => __( 'Premium version of this theme comes with capability to create <strong>Unlimited slides</strong>.', 'creattica' ),
	);

	for ( $slide = 1; $slide <= 4; $slide++ ) {

		$settings["wt_html_slide_{$slide}"] = array(
			'label'       => sprintf( __( 'Slide %s Content', 'creattica' ), $slide),
			'section'     => $section,
			'type'        => 'group',
			'priority'    => 775, // Non static options must have a priority
			'button'      => sprintf( __( 'Edit Slide %s', 'creattica' ), $slide),
			'options'     => array(
				'description' => array(
					'label'       => '',
					'type'        => 'content',
					'content'     => '<span class="hoot-module-bg-title">' . sprintf( __( 'Slide %s Content', 'creattica' ), $slide) . '</span>',
				),
				'image' => array(
					'label'       => __( 'Showcase Image (Right Column)', 'creattica' ),
					'type'        => 'content',
					'description' => __( 'If the page below has a featured image, it will be used as the Showcase Image (image in right column)', 'creattica' ),
				),
				'content' => array(
					'label'       => __( 'Content (Left Column)', 'creattica' ),
					'type'        => 'select',
					'choices'     => array( __( 'Select Page', 'creattica' ) ) + HybridExtend_Options_Helper::pages(),
				),
				'content_bg' => array(
					'label'   => __( 'Content Styling', 'creattica' ),
					'type'    => 'select',
					'default' => 'light-on-dark',
					'choices' => array(
						'dark'          => __('Dark Font', 'creattica'),
						'light'         => __('Light Font', 'creattica'),
						'dark-on-light' => __('Dark Font / Light Background', 'creattica'),
						'light-on-dark' => __('Light Font / Dark Background', 'creattica'),
					),
				),
				'button' => array(
					'label'       => __( 'Button Text', 'creattica' ),
					'type'        => 'text',
				),
				'url' => array(
					'label'       => __( 'Button URL', 'creattica' ),
					'type'        => 'url',
					'description' => __( 'Leave empty if you do not want to show the button.', 'creattica' ),
					'input_attrs' => array(
						'placeholder' => 'http://',
					),
				),
			),
		);

		$settings["wt_html_slide_{$slide}-background"] = array(
			'label'       => sprintf( __( 'Slide %s Background', 'creattica' ), $slide),
			'section'     => $section,
			'type'        => 'betterbackground',
			'priority'    => 775, // Non static options must have a priority
			'default'     => array(
				'color'      => '#dddddd',
			),
			'options'     => array( 'color', 'image', 'pattern' ),
		);

	} // end for

	/** Section **/

	$section = 'slider_img';

	$sections[ $section ] = array(
		'title'       => __( 'Frontpage - Image Slider', 'creattica' ),
	);

	$settings['wt_img_slider_width'] = array(
		'label'       => __( 'Slider Padding', 'creattica' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'boxed'   => __('With Padding', 'creattica'),
			'stretch' => __('Stretched (no padding)', 'creattica'),
		),
		'default'     => 'stretch',
	);

	$settings['wt_img_slider'] = array(
		'label'       => __( 'Slides', 'creattica' ),
		'section'     => $section,
		'type'        => 'content',
		'priority'    => 785, // Non static options must have a priority
		'content'     => __( 'Premium version of this theme comes with capability to create <strong>Unlimited slides</strong>.', 'creattica' ),
	);

	for ( $slide = 1; $slide <= 4; $slide++ ) { 

		$settings["wt_img_slide_{$slide}"] = array(
			'label'       => '',//sprintf( __( 'Slide %s Content', 'creattica' ), $slide),
			'section'     => $section,
			'type'        => 'group',
			'priority'    => 785, // Non static options must have a priority
			'button'      => sprintf( __( 'Edit Slide %s', 'creattica' ), $slide),
			'options'     => array(
				'description' => array(
					'label'       => '',
					'type'        => 'content',
					'content'     => '<span class="hoot-module-bg-title">' . sprintf( __( 'Slide %s Content', 'creattica' ), $slide) . '</span>' . __( '<em>To hide this slide, simply leave the Image empty.</em>', 'creattica' ),
				),
				'image' => array(
					'label'       => __( 'Slide Image', 'creattica' ),
					'type'        => 'image',
					'description' => __( 'The main showcase image.', 'creattica' ),
					'default'     => HYBRID_PARENT_URI . 'images/placeholder' . $slide . '.png',
				),
				'caption' => array(
					'label'       => __( 'Slide Caption (optional)', 'creattica' ),
					'type'        => 'textarea',
					'default'     => __( 'This is a sample description text for the slide.', 'creattica'),
					'description' => __('You can use the <code>&lt;h3&gt;Lorem Ipsum Dolor&lt;/h3&gt;</code> tag to create styled heading.', 'creattica'),
				),
				'caption_bg' => array(
					'label'   => __( 'Caption Styling', 'creattica' ),
					'type'    => 'select',
					'default' => 'light-on-dark',
					'choices' => array(
						'dark'          => __('Dark Font', 'creattica'),
						'light'         => __('Light Font', 'creattica'),
						'dark-on-light' => __('Dark Font / Light Background', 'creattica'),
						'light-on-dark' => __('Light Font / Dark Background', 'creattica'),
					),
				),
				'url' => array(
					'label'       => __( 'Slide Link', 'creattica' ),
					'type'        => 'url',
					'description' => __( 'Leave empty if you do not want to link the slide.', 'creattica' ),
					'input_attrs' => array(
						'placeholder' => 'http://',
					),
				),
				'button' => array(
					'label'       => __( 'Slide Button Text', 'creattica' ),
					'type'        => 'text',
					'description' => __( 'Leave empty if you do not want to show the button and instead link the slide image (if you have a url set in the above field)', 'creattica' ),
				),
			),
		);

	} // end for

	/** Section **/

	$section = 'archives';

	$sections[ $section ] = array(
		'title'       => __( 'Archives (Blog, Cats, Tags)', 'creattica' ),
	);

	$settings['archive_post_content'] = array(
		'label'       => __( 'Post Items Content', 'creattica' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'excerpt' => __('Post Excerpt', 'creattica'),
			'full-content' => __('Full Post Content', 'creattica'),
		),
		'default'     => 'excerpt',
		'description' => __( 'Content to display for each post in the list', 'creattica' ),
	);

	$settings['archive_post_meta'] = array(
		'label'       => __( 'Meta Information for Post List Items', 'creattica' ),
		'sublabel'    => __( 'Check which meta information to display for each post item in the archive list.', 'creattica' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'choices'     => array(
			'author'   => __('Author', 'creattica'),
			'date'     => __('Date', 'creattica'),
			'cats'     => __('Categories', 'creattica'),
			'tags'     => __('Tags', 'creattica'),
			'comments' => __('No. of comments', 'creattica')
		),
		'default'     => 'author, date, cats, comments',
	);

	$settings['excerpt_length'] = array(
		'label'       => __( 'Excerpt Length', 'creattica' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( 'Number of words in excerpt. Default is 105. Leave empty if you dont want to change it.', 'creattica' ),
		'input_attrs' => array(
			'min' => 0,
			'max' => 3,
			'placeholder' => __( 'default: 105', 'creattica' ),
		),
	);

	$settings['read_more'] = array(
		'label'       => __( "'Read More' Text", 'creattica' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( "Replace the default 'Read More' text. Leave empty if you dont want to change it.", 'creattica' ),
		'input_attrs' => array(
			'placeholder' => __( 'default: READ MORE &rarr;', 'creattica' ),
		),
	);

	/** Section **/

	$section = 'singular';

	$sections[ $section ] = array(
		'title'       => __( 'Single (Posts, Pages)', 'creattica' ),
	);

	$settings['page_header_full'] = array(
		'label'       => __( 'Stretch Page Header to Full Width', 'creattica' ),
		'sublabel'    => '<img src="' . $imagepath . 'page-header.png">',
		'section'     => $section,
		'type'        => 'checkbox',
		'choices'     => array(
			'default'    => __('Default (Archives, Blog, Woocommerce etc.)', 'creattica'),
			'posts'      => __('For All Posts', 'creattica'),
			'pages'      => __('For All Pages', 'creattica'),
			'no-sidebar' => __('Always override for full width pages (any page which has no sidebar)', 'creattica'),
		),
		'default'     => 'default, pages, no-sidebar',
		'description' => __('This is the Page Header area containing Page/Post Title and Meta details like author, categories etc.', 'creattica'),
	);

	$settings['post_featured_image'] = array(
		'label'       => __( 'Display Featured Image', 'creattica' ),
		'sublabel'    => __( 'Display featured image at the beginning of post/page content.', 'creattica' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'default'     => 1,
	);

	$settings['post_meta'] = array(
		'label'       => __( 'Meta Information on Posts', 'creattica' ),
		'sublabel'    => __( "Check which meta information to display on an individual 'Post' page", 'creattica' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'choices'     => array(
			'author'   => __('Author', 'creattica'),
			'date'     => __('Date', 'creattica'),
			'cats'     => __('Categories', 'creattica'),
			'tags'     => __('Tags', 'creattica'),
			'comments' => __('No. of comments', 'creattica')
		),
		'default'     => 'author, date, cats, tags, comments',
	);

	$settings['page_meta'] = array(
		'label'       => __( 'Meta Information on Page', 'creattica' ),
		'sublabel'    => __( "Check which meta information to display on an individual 'Page' page", 'creattica' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'choices'     => array(
			'author'   => __('Author', 'creattica'),
			'date'     => __('Date', 'creattica'),
			'comments' => __('No. of comments', 'creattica')
		),
		'default'     => 'author, date, comments',
	);

	$settings['post_meta_location'] = array(
		'label'       => __( 'Meta Information location', 'creattica' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'top'    => __('Top (below title)', 'creattica'),
			'bottom' => __('Bottom (after content)', 'creattica'),
		),
		'default'     => 'top',
	);

	$settings['post_prev_next_links'] = array(
		'label'       => __( 'Previous/Next Posts', 'creattica' ),
		'sublabel'    => __( 'Display links to Prev/Next Post links at the end of post content.', 'creattica' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'default'     => 1,
	);

	$settings['contact-form'] = array(
		'label'       => __( 'Contact Form', 'creattica' ),
		'section'     => $section,
		'type'        => 'content',
		'content'     => sprintf( __('This theme comes bundled with CSS required to style %sContact-Form-7%s forms. Simply install and activate the plugin to add Contact Forms to your pages.', 'creattica'), '<a href="https://wordpress.org/plugins/contact-form-7/" target="_blank">', '</a>'), // @todo update link to docs
	);

	if ( current_theme_supports( 'woocommerce' ) ) :

		/** Section **/

		$section = 'woocommerce';

		$sections[ $section ] = array(
			'title'       => __( 'WooCommerce', 'creattica' ),
			'priority'    => '48', // Non static options must have a priority
		);

		$wooproducts = range( 0, 99 );
		for ( $wpr=0; $wpr < 4; $wpr++ )
			unset( $wooproducts[$wpr] );
		$settings['wooshop_products'] = array(
			'label'       => __( 'Total Products per page', 'creattica' ),
			'section'     => $section,
			'type'        => 'select',
			'priority'    => '895', // Non static options must have a priority
			'choices'     => $wooproducts,
			'default'     => '12',
			'description' => __( 'Total number of products to show on the Shop page', 'creattica' ),
		);

		$settings['wooshop_product_columns'] = array(
			'label'       => __( 'Product Columns', 'creattica' ),
			'section'     => $section,
			'type'        => 'select',
			'priority'    => '895', // Non static options must have a priority
			'choices'     => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
			),
			'default'     => '3',
			'description' => __( 'Number of products to show in 1 row on the Shop page', 'creattica' ),
		);

		$settings['sidebar_wooshop'] = array(
			'label'       => __( 'Sidebar Layout (Woocommerce Shop/Archives)', 'creattica' ),
			'section'     => $section,
			'type'        => 'radioimage',
			'priority'    => '895', // Non static options must have a priority
			'choices'     => array(
				'wide-right'         => $imagepath . 'sidebar-wide-right.png',
				'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
				'wide-left'          => $imagepath . 'sidebar-wide-left.png',
				'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
				'full-width'         => $imagepath . 'sidebar-full.png',
				'none'               => $imagepath . 'sidebar-none.png',
			),
			'default'     => 'wide-right',
			'description' => __("Set the default sidebar width and position for WooCommerce Shop and Archives pages like product categories etc.", 'creattica'),
		);

		$settings['sidebar_wooproduct'] = array(
			'label'       => __( 'Sidebar Layout (Woocommerce Single Product Page)', 'creattica' ),
			'section'     => $section,
			'type'        => 'radioimage',
			'priority'    => '895', // Non static options must have a priority
			'choices'     => array(
				'wide-right'         => $imagepath . 'sidebar-wide-right.png',
				'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
				'wide-left'          => $imagepath . 'sidebar-wide-left.png',
				'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
				'full-width'         => $imagepath . 'sidebar-full.png',
				'none'               => $imagepath . 'sidebar-none.png',
			),
			'default'     => 'wide-right',
			'description' => __("Set the default sidebar width and position for WooCommerce product page", 'creattica'),
		);

	endif;

	/** Section **/

	$section = 'footer';

	$sections[ $section ] = array(
		'title'       => __( 'Footer', 'creattica' ),
	);

	$settings['footer'] = array(
		'label'       => __( 'Footer Layout', 'creattica' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'1-1' => $imagepath . '1-1.png',
			'2-1' => $imagepath . '2-1.png',
			'2-2' => $imagepath . '2-2.png',
			'2-3' => $imagepath . '2-3.png',
			'3-1' => $imagepath . '3-1.png',
			'3-2' => $imagepath . '3-2.png',
			'3-3' => $imagepath . '3-3.png',
			'3-4' => $imagepath . '3-4.png',
			'4-1' => $imagepath . '4-1.png',
		),
		'default'     => '3-1',
		'description' => sprintf( __('You must first save the changes you make here and refresh this screen for footer columns to appear in the Widgets panel (in customizer).<hr> Once you save the settings here, you can add content to footer columns using the %sWidgets Management screen%s.', 'creattica'), '<a href="' . esc_url( admin_url('widgets.php') ) . '" target="_blank">', '</a>' ),
	);

	$settings['site_info'] = array(
		'label'       => __( 'Site Info Text (footer)', 'creattica' ),
		'section'     => $section,
		'type'        => 'textarea',
		'default'     => __( '<!--default-->', 'creattica'),
		'description' => sprintf( __('Text shown in footer. Useful for showing copyright info etc.<hr>Use the <code>&lt;!--default--&gt;</code> tag to show the default Info Text.<hr>Use the <code>&lt;!--year--&gt;</code> tag to insert the current year.<hr>Always use %sHTML codes%s for symbols. For example, the HTML for &copy; is <code>&amp;copy;</code>', 'creattica'), '<a href="http://ascii.cl/htmlcodes.htm" target="_blank">', '</a>' ),
	);


	/*** Return Options Array ***/
	return apply_filters( 'hoot_theme_customizer_options', array(
		'settings' => $settings,
		'sections' => $sections,
		'panels'   => $panels,
	) );

}
endif;

/**
 * Add Options (settings, sections and panels) to HybridExtend_Customize class options object
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hoot_theme_add_customizer_options' ) ) :
function hoot_theme_add_customizer_options() {

	$hybridextend_customize = HybridExtend_Customize::get_instance();

	// Add Options
	$options = hoot_theme_customizer_options();
	$hybridextend_customize->add_options( array(
		'settings' => $options['settings'],
		'sections' => $options['sections'],
		'panels' => $options['panels'],
		) );

}
endif;
add_action( 'init', 'hoot_theme_add_customizer_options', 0 ); // cannot hook into 'after_setup_theme' as this hook is already being executed (this file is loaded at after_setup_theme @priority 10) (hooking into same hook from within while hook is being executed leads to undesirable effects as $GLOBALS[$wp_filter]['after_setup_theme'] has already been ksorted)
// Hence, we hook into 'init' @priority 0, so that settings array gets populated before 'widgets_init' action ( which itself is hooked to 'init' at priority 1 ) for creating widget areas ( settings array is needed for creating defaults when user value has not been stored )

/**
 * Enqueue custom scripts to customizer screen
 *
 * @since 1.0
 * @return void
 */
function hoot_theme_customizer_enqueue_scripts() {
	// Enqueue Styles
	wp_enqueue_style( 'hoot-theme-customize-styles', HYBRIDEXTEND_INCURI . 'admin/css/customize.css', array(),  HYBRIDEXTEND_VERSION );
	// Enqueue Scripts
	wp_enqueue_script( 'hoot-theme-customize-script', HYBRIDEXTEND_INCURI . 'admin/js/customize.js', array( 'jquery', 'wp-color-picker', 'customize-controls', 'hybridextend-customize-script' ), HYBRIDEXTEND_VERSION, true );
}
// Load scripts at priority 12 so that Hoot Customizer Interface (11) / Custom Controls (10) have loaded their scripts
add_action( 'customize_controls_enqueue_scripts', 'hoot_theme_customizer_enqueue_scripts', 12 );

/**
 * Modify default WordPress Settings Sections and Panels
 *
 * @since 1.0
 * @param object $wp_customize
 * @return void
 */
function hoot_customizer_modify_default_options( $wp_customize ) {

	if ( function_exists( 'the_custom_logo' ) ) {
		$wp_customize->get_control( 'custom_logo' )->section = 'logo';
		$wp_customize->get_control( 'custom_logo' )->priority = 125; // Replaces theme's logo_image // Update in premium if needed
		$wp_customize->get_control( 'custom_logo' )->width = 240;
		$wp_customize->get_control( 'custom_logo' )->height = 120;
		// $wp_customize->get_control( 'custom_logo' )->type = 'image'; // Stored value becomes url instead of image ID (fns like the_custom_logo() dont work)
		// Defaults: [type] => cropped_image, [width] => 150, [height] => 150, [flex_width] => 1, [flex_height] => 1, [button_labels] => array(...), [label] => Logo
		$wp_customize->get_control( 'custom_logo' )->active_callback = 'hoot_callback_logo_image';
	}

	if ( function_exists( 'get_site_icon_url' ) )
		$wp_customize->get_control( 'site_icon' )->priority = 10;

	$wp_customize->get_section( 'static_front_page' )->priority = 3;

	// $wp_customize->get_section( 'title_tagline' )->panel = 'general';
	// $wp_customize->get_section( 'title_tagline' )->priority = 1;
	// $wp_customize->get_section( 'colors' )->panel = 'styling';

	// global $wp_version;
	// if ( version_compare( $wp_version, '4.3', '>=' ) ) // 'Creating Default Object from Empty Value' error before 4.3 since 'nav_menus' panel did not exist ( we did have 'nav' section till 4.1.9 i.e. before 4.2 )
	// 	$wp_customize->get_panel( 'nav_menus' )->priority = 999;
	// This will set the priority, however will give a 'Creating Default Object from Empty Value' error first.
	// $wp_customize->get_panel( 'widgets' )->priority = 999;

}
add_action( 'customize_register', 'hoot_customizer_modify_default_options', 100 );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since 1.0
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function hoot_customizer_customize_register( $wp_customize ) {
	// $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'hoot_customizer_customize_register' );

/**
 * Callback Functions for customizer settings
 */

function hoot_callback_logo_size( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'text' || $selector == 'mixed' ) ? true : false;
}
function hoot_callback_site_title_icon( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'text' || $selector == 'custom' ) ? true : false;
}
function hoot_callback_logo_image( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'image' || $selector == 'mixed' || $selector == 'mixedcustom' ) ? true : false;
}
function hoot_callback_logo_custom( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'custom' || $selector == 'mixedcustom' ) ? true : false;
}
function hoot_callback_show_tagline( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'text' || $selector == 'custom' || $selector == 'mixed' || $selector == 'mixedcustom' ) ? true : false;
}
function hoot_callback_leftbar_bottom_mobile_location( $control ) {
	$selector = $control->manager->get_setting('leftbar_bottom_mobile_display')->value();
	return ( !empty( $selector ) ) ? true : false;
}

/**
 * Helper function to return the theme mod value.
 * If no value has been saved, it returns $default provided by the theme.
 * If no $default provided, it checks the default value specified in the customizer settings..
 * 
 * @since 1.0
 * @access public
 * @param string $name
 * @param mixed $default
 * @return mixed
 */
function hoot_get_mod( $name, $default = NULL ) {

	if ( is_customize_preview() ) {

		// We cannot use "if ( !empty( $mod ) )" as this will become false for empty values, and hence fallback to default. isset() is not an option either as $mod is always set. Hence we calculate the default here, and supply it as second argument to get_theme_mod()
		$default = ( $default !== NULL ) ? $default : hybridextend_customize_get_default( $name );
		$mod = get_theme_mod( $name, $default );

		return apply_filters( 'hoot_get_mod_customize', $mod, $name, $default );

	} else {

		/*** Return value if set ***/

		// Cache
		static $mods = NULL;

		// Get the values from database
		if ( !$mods ) {
			$mods = get_theme_mods();
			$mods = apply_filters( 'hoot_get_mod', $mods );
		}

		if ( isset( $mods[$name] ) ) {
			// Filter applied as in get_theme_mod() core function
			$mods[$name] = apply_filters( "theme_mod_{$name}", $mods[$name] );
			// Add exceptions: If a value has been set but is empty, this gives the option to return default values in such cases. Simply return $override as (bool)true.
			$override = apply_filters( 'hoot_get_mod_override_empty_values', false, $name, $mods[$name] );
			if ( $override !== true )
				return $mods[$name];
		}

		/*** Return default if provided ***/
		if ( $default !== NULL )
			return apply_filters( "theme_mod_{$name}", $default );

		/*** Return default theme option value specified in customizer settings ***/
		$default = hybridextend_customize_get_default( $name );
		if ( !empty( $default ) )
			return apply_filters( "theme_mod_{$name}", $default );

	}

	/*** We dont have anything! ***/
	return false;
}