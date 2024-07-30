<?php
/**
 * The template to display the site logo in the footer
 *
 * @package FABRIC
 * @since FABRIC 1.0.10
 */

// Logo
if ( fabric_is_on( fabric_get_theme_option( 'logo_in_footer' ) ) ) {
	$fabric_logo_image = fabric_get_logo_image( 'footer' );
	$fabric_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $fabric_logo_image['logo'] ) || ! empty( $fabric_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $fabric_logo_image['logo'] ) ) {
					$fabric_attr = fabric_getimagesize( $fabric_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $fabric_logo_image['logo'] ) . '"'
								. ( ! empty( $fabric_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $fabric_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'fabric' ) . '"'
								. ( ! empty( $fabric_attr[3] ) ? ' ' . wp_kses_data( $fabric_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $fabric_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $fabric_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
