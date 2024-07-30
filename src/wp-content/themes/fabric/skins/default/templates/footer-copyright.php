<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package FABRIC
 * @since FABRIC 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$fabric_copyright_scheme = fabric_get_theme_option( 'copyright_scheme' );
if ( ! empty( $fabric_copyright_scheme ) && ! fabric_is_inherit( $fabric_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $fabric_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$fabric_copyright = fabric_get_theme_option( 'copyright' );
			if ( ! empty( $fabric_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$fabric_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $fabric_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$fabric_copyright = fabric_prepare_macros( $fabric_copyright );
				// Display copyright
				echo wp_kses( nl2br( $fabric_copyright ), 'fabric_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
