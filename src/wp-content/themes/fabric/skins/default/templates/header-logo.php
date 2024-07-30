<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package FABRIC
 * @since FABRIC 1.0
 */

$fabric_args = get_query_var( 'fabric_logo_args' );

// Site logo
$fabric_logo_type   = isset( $fabric_args['type'] ) ? $fabric_args['type'] : '';
$fabric_logo_image  = fabric_get_logo_image( $fabric_logo_type );
$fabric_logo_text   = fabric_is_on( fabric_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$fabric_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $fabric_logo_image['logo'] ) || ! empty( $fabric_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $fabric_logo_image['logo'] ) ) {
			if ( empty( $fabric_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($fabric_logo_image['logo']) && (int) $fabric_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$fabric_attr = fabric_getimagesize( $fabric_logo_image['logo'] );
				echo '<img src="' . esc_url( $fabric_logo_image['logo'] ) . '"'
						. ( ! empty( $fabric_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $fabric_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $fabric_logo_text ) . '"'
						. ( ! empty( $fabric_attr[3] ) ? ' ' . wp_kses_data( $fabric_attr[3] ) : '' )
						. '>';
			}
		} else {
			fabric_show_layout( fabric_prepare_macros( $fabric_logo_text ), '<span class="logo_text">', '</span>' );
			fabric_show_layout( fabric_prepare_macros( $fabric_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
