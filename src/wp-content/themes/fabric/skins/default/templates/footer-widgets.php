<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package FABRIC
 * @since FABRIC 1.0.10
 */

// Footer sidebar
$fabric_footer_name    = fabric_get_theme_option( 'footer_widgets' );
$fabric_footer_present = ! fabric_is_off( $fabric_footer_name ) && is_active_sidebar( $fabric_footer_name );
if ( $fabric_footer_present ) {
	fabric_storage_set( 'current_sidebar', 'footer' );
	$fabric_footer_wide = fabric_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $fabric_footer_name ) ) {
		dynamic_sidebar( $fabric_footer_name );
	}
	$fabric_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $fabric_out ) ) {
		$fabric_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $fabric_out );
		$fabric_need_columns = true;   //or check: strpos($fabric_out, 'columns_wrap')===false;
		if ( $fabric_need_columns ) {
			$fabric_columns = max( 0, (int) fabric_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $fabric_columns ) {
				$fabric_columns = min( 4, max( 1, fabric_tags_count( $fabric_out, 'aside' ) ) );
			}
			if ( $fabric_columns > 1 ) {
				$fabric_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $fabric_columns ) . ' widget', $fabric_out );
			} else {
				$fabric_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $fabric_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'fabric_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $fabric_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $fabric_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'fabric_action_before_sidebar', 'footer' );
				fabric_show_layout( $fabric_out );
				do_action( 'fabric_action_after_sidebar', 'footer' );
				if ( $fabric_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $fabric_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'fabric_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
