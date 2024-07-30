<?php
/**
 * The template to display default site header
 *
 * @package FABRIC
 * @since FABRIC 1.0
 */

$fabric_header_css   = '';
$fabric_header_image = get_header_image();
$fabric_header_video = fabric_get_header_video();
if ( ! empty( $fabric_header_image ) && fabric_trx_addons_featured_image_override( is_singular() || fabric_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$fabric_header_image = fabric_get_current_mode_image( $fabric_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $fabric_header_image ) || ! empty( $fabric_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $fabric_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $fabric_header_image ) {
		echo ' ' . esc_attr( fabric_add_inline_css_class( 'background-image: url(' . esc_url( $fabric_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( fabric_is_on( fabric_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight fabric-full-height';
	}
	$fabric_header_scheme = fabric_get_theme_option( 'header_scheme' );
	if ( ! empty( $fabric_header_scheme ) && ! fabric_is_inherit( $fabric_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $fabric_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $fabric_header_video ) ) {
		get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( fabric_is_on( fabric_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
