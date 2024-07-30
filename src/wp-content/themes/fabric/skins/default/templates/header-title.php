<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package FABRIC
 * @since FABRIC 1.0
 */

// Page (category, tag, archive, author) title

if ( fabric_need_page_title() ) {
	fabric_sc_layouts_showed( 'title', true );
	fabric_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								fabric_show_post_meta(
									apply_filters(
										'fabric_filter_post_meta_args', array(
											'components' => join( ',', fabric_array_get_keys_by_value( fabric_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', fabric_array_get_keys_by_value( fabric_get_theme_option( 'counters' ) ) ),
											'seo'        => fabric_is_on( fabric_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$fabric_blog_title           = fabric_get_blog_title();
							$fabric_blog_title_text      = '';
							$fabric_blog_title_class     = '';
							$fabric_blog_title_link      = '';
							$fabric_blog_title_link_text = '';
							if ( is_array( $fabric_blog_title ) ) {
								$fabric_blog_title_text      = $fabric_blog_title['text'];
								$fabric_blog_title_class     = ! empty( $fabric_blog_title['class'] ) ? ' ' . $fabric_blog_title['class'] : '';
								$fabric_blog_title_link      = ! empty( $fabric_blog_title['link'] ) ? $fabric_blog_title['link'] : '';
								$fabric_blog_title_link_text = ! empty( $fabric_blog_title['link_text'] ) ? $fabric_blog_title['link_text'] : '';
							} else {
								$fabric_blog_title_text = $fabric_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $fabric_blog_title_class ); ?>">
								<?php
								$fabric_top_icon = fabric_get_term_image_small();
								if ( ! empty( $fabric_top_icon ) ) {
									$fabric_attr = fabric_getimagesize( $fabric_top_icon );
									?>
									<img src="<?php echo esc_url( $fabric_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'fabric' ); ?>"
										<?php
										if ( ! empty( $fabric_attr[3] ) ) {
											fabric_show_layout( $fabric_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $fabric_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $fabric_blog_title_link ) && ! empty( $fabric_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $fabric_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $fabric_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'fabric_action_breadcrumbs' );
						$fabric_breadcrumbs = ob_get_contents();
						ob_end_clean();
						fabric_show_layout( $fabric_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
