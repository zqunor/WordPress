<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?> class="no-js">

<head>
<?php
// Fire the wp_head action required for hooking in scripts, styles, and other <head> tags.
wp_head();
?>
</head>

<body <?php hybridextend_attr( 'body' ); ?>>

	<div <?php hybridextend_attr( 'page-wrapper' ); ?>>

		<div class="skip-link">
			<a href="#content" class="screen-reader-text"><?php _e( 'Skip to content', 'creattica' ); ?></a>
		</div><!-- .skip-link -->

		<?php
		// Template modification Hook
		do_action( 'hoot_template_site_start' );

		// Displays a friendly note to visitors using outdated browser (Internet Explorer 8 or less)
		hoot_update_browser();
		?>

		<div <?php hybridextend_attr( 'leftbar' ); ?>>
			<div <?php hybridextend_attr( 'leftbar-inner' ); ?>>

				<?php
				// Display Leftbar Top
				get_template_part( 'template-parts/leftbar', 'top' );
				?>

				<header <?php hybridextend_attr( 'header' ); ?>>
					<?php
					// Display Branding
					hoot_header_branding();

					// Display Menu
					hoot_header_aside();
					?>
				</header><!-- #header -->

				<?php
				// Display Leftbar Bottom
				get_template_part( 'template-parts/leftbar', 'bottom' );
				?>

			</div><!-- #leftbar-inner -->
		</div><!-- #leftbar -->

		<div <?php hybridextend_attr( 'main' ); ?>>

			<?php
			// Template modification Hook
			do_action( 'hoot_template_main_wrapper_start' );

			hybridextend_get_sidebar( 'content-top' ); // Loads the template-parts/sidebar-content-top.php template.