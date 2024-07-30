<?php
/**
 * The template to display default site footer
 *
 * @package FABRIC
 * @since FABRIC 1.0.10
 */

$fabric_footer_id = fabric_get_custom_footer_id();
$fabric_footer_meta = get_post_meta( $fabric_footer_id, 'trx_addons_options', true );
if ( ! empty( $fabric_footer_meta['margin'] ) ) {
	fabric_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( fabric_prepare_css_value( $fabric_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $fabric_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $fabric_footer_id ) ) ); ?>
						<?php
						$fabric_footer_scheme = fabric_get_theme_option( 'footer_scheme' );
						if ( ! empty( $fabric_footer_scheme ) && ! fabric_is_inherit( $fabric_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $fabric_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'fabric_action_show_layout', $fabric_footer_id );
	?>
</footer><!-- /.footer_wrap -->
