<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package FABRIC
 * @since FABRIC 1.0
 */

if ( fabric_sidebar_present() ) {
	
	$fabric_sidebar_type = fabric_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $fabric_sidebar_type && ! fabric_is_layouts_available() ) {
		$fabric_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $fabric_sidebar_type ) {
		// Default sidebar with widgets
		$fabric_sidebar_name = fabric_get_theme_option( 'sidebar_widgets' );
		fabric_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $fabric_sidebar_name ) ) {
			dynamic_sidebar( $fabric_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$fabric_sidebar_id = fabric_get_custom_sidebar_id();
		do_action( 'fabric_action_show_layout', $fabric_sidebar_id );
	}
	$fabric_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $fabric_out ) ) {
		$fabric_sidebar_position    = fabric_get_theme_option( 'sidebar_position' );
		$fabric_sidebar_position_ss = fabric_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $fabric_sidebar_position );
			echo ' sidebar_' . esc_attr( $fabric_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $fabric_sidebar_type );

			$fabric_sidebar_scheme = apply_filters( 'fabric_filter_sidebar_scheme', fabric_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $fabric_sidebar_scheme ) && ! fabric_is_inherit( $fabric_sidebar_scheme ) && 'custom' != $fabric_sidebar_type ) {
				echo ' scheme_' . esc_attr( $fabric_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="fabric_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'fabric_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $fabric_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$fabric_title = apply_filters( 'fabric_filter_sidebar_control_title', 'float' == $fabric_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'fabric' ) : '' );
				$fabric_text  = apply_filters( 'fabric_filter_sidebar_control_text', 'above' == $fabric_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'fabric' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $fabric_title ); ?>"><?php echo esc_html( $fabric_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'fabric_action_before_sidebar', 'sidebar' );
				fabric_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $fabric_out ) );
				do_action( 'fabric_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'fabric_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
