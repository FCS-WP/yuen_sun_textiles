<?php
/**
 * The Header: Logo and main menu
 *
 * @package FABRIC
 * @since FABRIC 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( fabric_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'fabric_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'fabric_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('fabric_action_body_wrap_attributes'); ?>>

		<?php do_action( 'fabric_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'fabric_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('fabric_action_page_wrap_attributes'); ?>>

			<?php do_action( 'fabric_action_page_wrap_start' ); ?>

			<?php
			$fabric_full_post_loading = ( fabric_is_singular( 'post' ) || fabric_is_singular( 'attachment' ) ) && fabric_get_value_gp( 'action' ) == 'full_post_loading';
			$fabric_prev_post_loading = ( fabric_is_singular( 'post' ) || fabric_is_singular( 'attachment' ) ) && fabric_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $fabric_full_post_loading && ! $fabric_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="fabric_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'fabric_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'fabric' ); ?></a>
				<?php if ( fabric_sidebar_present() ) { ?>
				<a class="fabric_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'fabric_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'fabric' ); ?></a>
				<?php } ?>
				<a class="fabric_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'fabric_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'fabric' ); ?></a>

				<?php
				do_action( 'fabric_action_before_header' );

				// Header
				$fabric_header_type = fabric_get_theme_option( 'header_type' );
				if ( 'custom' == $fabric_header_type && ! fabric_is_layouts_available() ) {
					$fabric_header_type = 'default';
				}
				get_template_part( apply_filters( 'fabric_filter_get_template_part', "templates/header-" . sanitize_file_name( $fabric_header_type ) ) );

				// Side menu
				if ( in_array( fabric_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'fabric_action_after_header' );

			}
			?>

			<?php do_action( 'fabric_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( fabric_is_off( fabric_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $fabric_header_type ) ) {
						$fabric_header_type = fabric_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $fabric_header_type && fabric_is_layouts_available() ) {
						$fabric_header_id = fabric_get_custom_header_id();
						if ( $fabric_header_id > 0 ) {
							$fabric_header_meta = fabric_get_custom_layout_meta( $fabric_header_id );
							if ( ! empty( $fabric_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$fabric_footer_type = fabric_get_theme_option( 'footer_type' );
					if ( 'custom' == $fabric_footer_type && fabric_is_layouts_available() ) {
						$fabric_footer_id = fabric_get_custom_footer_id();
						if ( $fabric_footer_id ) {
							$fabric_footer_meta = fabric_get_custom_layout_meta( $fabric_footer_id );
							if ( ! empty( $fabric_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'fabric_action_page_content_wrap_class', $fabric_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'fabric_filter_is_prev_post_loading', $fabric_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( fabric_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'fabric_action_page_content_wrap_data', $fabric_prev_post_loading );
			?>>
				<?php
				do_action( 'fabric_action_page_content_wrap', $fabric_full_post_loading || $fabric_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'fabric_filter_single_post_header', fabric_is_singular( 'post' ) || fabric_is_singular( 'attachment' ) ) ) {
					if ( $fabric_prev_post_loading ) {
						if ( fabric_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'fabric_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$fabric_path = apply_filters( 'fabric_filter_get_template_part', 'templates/single-styles/' . fabric_get_theme_option( 'single_style' ) );
					if ( fabric_get_file_dir( $fabric_path . '.php' ) != '' ) {
						get_template_part( $fabric_path );
					}
				}

				// Widgets area above page
				$fabric_body_style   = fabric_get_theme_option( 'body_style' );
				$fabric_widgets_name = fabric_get_theme_option( 'widgets_above_page' );
				$fabric_show_widgets = ! fabric_is_off( $fabric_widgets_name ) && is_active_sidebar( $fabric_widgets_name );
				if ( $fabric_show_widgets ) {
					if ( 'fullscreen' != $fabric_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					fabric_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $fabric_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'fabric_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $fabric_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'fabric_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'fabric_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="fabric_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( fabric_is_singular( 'post' ) || fabric_is_singular( 'attachment' ) )
							&& $fabric_prev_post_loading 
							&& fabric_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'fabric_action_between_posts' );
						}

						// Widgets area above content
						fabric_create_widgets_area( 'widgets_above_content' );

						do_action( 'fabric_action_page_content_start_text' );
