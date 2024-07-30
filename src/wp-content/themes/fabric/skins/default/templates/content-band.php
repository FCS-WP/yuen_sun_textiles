<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package FABRIC
 * @since FABRIC 1.71.0
 */

$fabric_template_args = get_query_var( 'fabric_template_args' );
if ( ! is_array( $fabric_template_args ) ) {
	$fabric_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$fabric_columns       = 1;

$fabric_expanded      = ! fabric_sidebar_present() && fabric_get_theme_option( 'expand_content' ) == 'expand';

$fabric_post_format   = get_post_format();
$fabric_post_format   = empty( $fabric_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fabric_post_format );

if ( is_array( $fabric_template_args ) ) {
	$fabric_columns    = empty( $fabric_template_args['columns'] ) ? 1 : max( 1, $fabric_template_args['columns'] );
	$fabric_blog_style = array( $fabric_template_args['type'], $fabric_columns );
	if ( ! empty( $fabric_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $fabric_columns > 1 ) {
	    $fabric_columns_class = fabric_get_column_class( 1, $fabric_columns, ! empty( $fabric_template_args['columns_tablet']) ? $fabric_template_args['columns_tablet'] : '', ! empty($fabric_template_args['columns_mobile']) ? $fabric_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $fabric_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $fabric_post_format ) );
	fabric_add_blog_animation( $fabric_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$fabric_hover      = ! empty( $fabric_template_args['hover'] ) && ! fabric_is_inherit( $fabric_template_args['hover'] )
							? $fabric_template_args['hover']
							: fabric_get_theme_option( 'image_hover' );
	$fabric_components = ! empty( $fabric_template_args['meta_parts'] )
							? ( is_array( $fabric_template_args['meta_parts'] )
								? $fabric_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $fabric_template_args['meta_parts'] ) )
								)
							: fabric_array_get_keys_by_value( fabric_get_theme_option( 'meta_parts' ) );
	fabric_show_post_featured( apply_filters( 'fabric_filter_args_featured',
		array(
			'no_links'   => ! empty( $fabric_template_args['no_links'] ),
			'hover'      => $fabric_hover,
			'meta_parts' => $fabric_components,
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $fabric_template_args['thumb_size'] )
								? $fabric_template_args['thumb_size']
								: fabric_get_thumb_size( 
								in_array( $fabric_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( fabric_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $fabric_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$fabric_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$fabric_show_title = get_the_title() != '';
		$fabric_show_meta  = count( $fabric_components ) > 0 && ! in_array( $fabric_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $fabric_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'fabric_filter_show_blog_categories', $fabric_show_meta && in_array( 'categories', $fabric_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'fabric_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						fabric_show_post_meta( apply_filters(
															'fabric_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $fabric_hover, 1
															)
											);
						?>
					</div>
					<?php
					$fabric_components = fabric_array_delete_by_value( $fabric_components, 'categories' );
					do_action( 'fabric_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'fabric_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'fabric_action_before_post_title' );
					if ( empty( $fabric_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'fabric_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $fabric_template_args['excerpt_length'] ) && ! in_array( $fabric_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$fabric_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'fabric_filter_show_blog_excerpt', empty( $fabric_template_args['hide_excerpt'] ) && fabric_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				fabric_show_post_content( $fabric_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'fabric_filter_show_blog_meta', $fabric_show_meta, $fabric_components, 'band' ) ) {
			if ( count( $fabric_components ) > 0 ) {
				do_action( 'fabric_action_before_post_meta' );
				fabric_show_post_meta(
					apply_filters(
						'fabric_filter_post_meta_args', array(
							'components' => join( ',', $fabric_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'fabric_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'fabric_filter_show_blog_readmore', ! $fabric_show_title || ! empty( $fabric_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $fabric_template_args['no_links'] ) ) {
				do_action( 'fabric_action_before_post_readmore' );
				fabric_show_post_more_link( $fabric_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'fabric_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $fabric_template_args ) ) {
	if ( ! empty( $fabric_template_args['slider'] ) || $fabric_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
