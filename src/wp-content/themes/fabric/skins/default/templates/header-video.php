<?php
/**
 * The template to display the background video in the header
 *
 * @package FABRIC
 * @since FABRIC 1.0.14
 */
$fabric_header_video = fabric_get_header_video();
$fabric_embed_video  = '';
if ( ! empty( $fabric_header_video ) && ! fabric_is_from_uploads( $fabric_header_video ) ) {
	if ( fabric_is_youtube_url( $fabric_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $fabric_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php fabric_show_layout( fabric_get_embed_video( $fabric_header_video ) ); ?></div>
		<?php
	}
}
