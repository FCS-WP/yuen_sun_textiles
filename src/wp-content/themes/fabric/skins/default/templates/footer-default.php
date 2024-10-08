<?php
/**
 * The template to display default site footer
 *
 * @package FABRIC
 * @since FABRIC 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$fabric_footer_scheme = fabric_get_theme_option( 'footer_scheme' );
if ( ! empty( $fabric_footer_scheme ) && ! fabric_is_inherit( $fabric_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $fabric_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
