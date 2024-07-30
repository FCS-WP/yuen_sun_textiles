<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package FABRIC
 * @since FABRIC 1.0
 */

							do_action( 'fabric_action_page_content_end_text' );
							
							// Widgets area below the content
							fabric_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'fabric_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'fabric_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'fabric_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'fabric_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$fabric_body_style = fabric_get_theme_option( 'body_style' );
					$fabric_widgets_name = fabric_get_theme_option( 'widgets_below_page' );
					$fabric_show_widgets = ! fabric_is_off( $fabric_widgets_name ) && is_active_sidebar( $fabric_widgets_name );
					$fabric_show_related = fabric_is_single() && fabric_get_theme_option( 'related_position' ) == 'below_page';
					if ( $fabric_show_widgets || $fabric_show_related ) {
						if ( 'fullscreen' != $fabric_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $fabric_show_related ) {
							do_action( 'fabric_action_related_posts' );
						}

						// Widgets area below page content
						if ( $fabric_show_widgets ) {
							fabric_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $fabric_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'fabric_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'fabric_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! fabric_is_singular( 'post' ) && ! fabric_is_singular( 'attachment' ) ) || ! in_array ( fabric_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="fabric_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'fabric_action_before_footer' );

				// Footer
				$fabric_footer_type = fabric_get_theme_option( 'footer_type' );
				if ( 'custom' == $fabric_footer_type && ! fabric_is_layouts_available() ) {
					$fabric_footer_type = 'default';
				}
				get_template_part( apply_filters( 'fabric_filter_get_template_part', "templates/footer-" . sanitize_file_name( $fabric_footer_type ) ) );

				do_action( 'fabric_action_after_footer' );

			}
			?>

			<?php do_action( 'fabric_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'fabric_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'fabric_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>