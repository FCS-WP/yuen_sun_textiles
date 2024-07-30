<?php
/**
 * The template to display the widgets area in the header
 *
 * @package FABRIC
 * @since FABRIC 1.0
 */

// Header sidebar
$fabric_header_name    = fabric_get_theme_option( 'header_widgets' );
$fabric_header_present = ! fabric_is_off( $fabric_header_name ) && is_active_sidebar( $fabric_header_name );
if ( $fabric_header_present ) {
	fabric_storage_set( 'current_sidebar', 'header' );
	$fabric_header_wide = fabric_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $fabric_header_name ) ) {
		dynamic_sidebar( $fabric_header_name );
	}
	$fabric_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $fabric_widgets_output ) ) {
		$fabric_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $fabric_widgets_output );
		$fabric_need_columns   = strpos( $fabric_widgets_output, 'columns_wrap' ) === false;
		if ( $fabric_need_columns ) {
			$fabric_columns = max( 0, (int) fabric_get_theme_option( 'header_columns' ) );
			if ( 0 == $fabric_columns ) {
				$fabric_columns = min( 6, max( 1, fabric_tags_count( $fabric_widgets_output, 'aside' ) ) );
			}
			if ( $fabric_columns > 1 ) {
				$fabric_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $fabric_columns ) . ' widget', $fabric_widgets_output );
			} else {
				$fabric_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $fabric_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'fabric_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $fabric_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $fabric_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'fabric_action_before_sidebar', 'header' );
				fabric_show_layout( $fabric_widgets_output );
				do_action( 'fabric_action_after_sidebar', 'header' );
				if ( $fabric_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $fabric_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'fabric_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
