<?php
/**
 * Footer callout
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get post ID
$post_id = get_the_ID();

// Get content
if ( $post_id && $meta = get_post_meta( $post_id, 'ofc_meta_callout_text', true ) ) {

	// Return content defined in meta
	$get_content = $meta;

} else {

	// Get content from theme mod
	$get_content = get_theme_mod( 'ofc_callout_text', 'Lorem ipsum dolor sit amet consectetur ni adipiscing elit.' );

}

// Get post content
$content 	= $get_content;

// Get ID
$get_id = get_theme_mod( 'ofc_callout_page_id' );

// Get the template
$template = get_theme_mod( 'ofc_callout_template' );
if ( ! empty( $template ) ) {
    $get_id = $template;
}

// Check if page is Elementor page
$elementor  = get_post_meta( $get_id, '_elementor_edit_mode', true );

// Get button
$button = get_theme_mod( 'ofc_callout_button', true );

// Get button url
if ( $post_id && $meta = get_post_meta( $post_id, 'ofc_meta_callout_button_url', true ) ) {
	$button_url = $meta;
} else {
	$button_url = get_theme_mod( 'ofc_callout_button_url', '#' );
}

// Get button text
if ( $post_id && $meta = get_post_meta( $post_id, 'ofc_meta_callout_button_txt', true ) ) {
	$button_text = $meta;
} else {
	$button_text = get_theme_mod( 'ofc_callout_button_txt', 'Get In Touch' );
}

// If button is defined set target and rel
if ( $button ) {

	// Button target
	$target	= get_theme_mod( 'ofc_callout_button_target', 'blank' );
	$target	= ( 'blank' == $target ) ? ' target="_blank"' : '';

	// Button rel
	$rel = get_theme_mod( 'ofc_callout_button_rel', false );
	$rel = $rel ? $rel : '';

	if ( $rel == 'nofollow' ) {
		$rel = ' rel="nofollow"';
	}
	else if ( $rel == 'noopnoref' ) {
		$rel = ' rel="noopener noreferrer"';
	}
	else if ( $rel == 'nofnopnorr' ) {
		$rel = ' rel="nofollow noopener noreferrer"';
	}
	else {
		$rel = '';
	}

}

// Translate theme mods
$content 		= oceanwp_tm_translation( 'ofc_callout_text', $content );
$button_url 	= oceanwp_tm_translation( 'ofc_callout_button_url', $button_url );
$button_text 	= oceanwp_tm_translation( 'ofc_callout_button_txt', $button_text );

// Button classes
$classes = array( 'footer-callout-button', 'clr' );

// Custom classes
$custom_classes = get_theme_mod( 'ofc_callout_button_classes' );
if ( ! empty( $custom_classes ) ) {
	$classes[] = $custom_classes;
}

// Turn classes into space seperated string
$classes = implode( ' ', $classes ); ?>
	
<div id="footer-callout-wrap" class="clr">

	<div id="footer-callout" class="container clr">

		<div id="footer-callout-left" class="footer-callout-content clr <?php if ( ! $button ) echo 'full-width'; ?>">

			<?php
			// If Elementor
		    if ( class_exists( 'Elementor\Plugin' ) && $elementor ) {

		        echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $get_id );

		    }

		    // If Beaver Builder
		    else if ( class_exists( 'FLBuilder' ) && ! empty( $get_id ) ) {

		        echo do_shortcode( '[fl_builder_insert_layout id="' . $get_id . '"]' );

		    }

		    // Else
		    else {

		        // Display template content
		        echo do_shortcode( $content );

		    } ?>

		</div><!-- #footer-callout-left -->

		<?php
		// Display footer callout button if callout button & text options are not blank in the admin
		if ( $button ) : ?>

			<div id="footer-callout-right" class="<?php echo esc_attr( $classes ); ?>">

				<a href="<?php echo esc_url( $button_url ); ?>" class="callout-button" <?php echo $target; ?><?php echo $rel; ?>><?php echo esc_html( $button_text ); ?></a>
					
					<?php
					// Display screen reader text
					if ( $target == ' target="_blank"' ) {
						echo '<span class="screen-reader-text">'. esc_attr__( 'Opens in a new tab', 'ocean-footer-callout' ) .'</span>';
					}
					?>

			</div><!-- #footer-callout-right -->

		<?php endif; ?>

	</div><!-- #footer-callout -->

</div><!-- #footer-callout-wrap -->	