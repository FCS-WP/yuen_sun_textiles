<?php
/**
 * The template to display the socials in the footer
 *
 * @package FABRIC
 * @since FABRIC 1.0.10
 */


// Socials
if ( fabric_is_on( fabric_get_theme_option( 'socials_in_footer' ) ) ) {
	$fabric_output = fabric_get_socials_links();
	if ( '' != $fabric_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php fabric_show_layout( $fabric_output ); ?>
			</div>
		</div>
		<?php
	}
}
