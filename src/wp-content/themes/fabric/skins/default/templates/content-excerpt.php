<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package FABRIC
 * @since FABRIC 1.0
 */

$fabric_template_args = get_query_var( 'fabric_template_args' );
$fabric_columns = 1;
if ( is_array( $fabric_template_args ) ) {
	$fabric_columns    = empty( $fabric_template_args['columns'] ) ? 1 : max( 1, $fabric_template_args['columns'] );
	$fabric_blog_style = array( $fabric_template_args['type'], $fabric_columns );
	if ( ! empty( $fabric_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $fabric_columns > 1 ) {
	    $fabric_columns_class = fabric_get_column_class( 1, $fabric_columns, ! empty( $fabric_template_args['columns_tablet']) ? $fabric_template_args['columns_tablet'] : '', ! empty($fabric_template_args['columns_mobile']) ? $fabric_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $fabric_columns_class ); ?>">
		<?php
	}
} else {
	$fabric_template_args = array();
}
$fabric_expanded    = ! fabric_sidebar_present() && fabric_get_theme_option( 'expand_content' ) == 'expand';
$fabric_post_format = get_post_format();
$fabric_post_format = empty( $fabric_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fabric_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $fabric_post_format ) );
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
			'thumb_size' => ! empty( $fabric_template_args['thumb_size'] )
							? $fabric_template_args['thumb_size']
							: fabric_get_thumb_size( strpos( fabric_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $fabric_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$fabric_template_args
	) );

	// Title and post meta
	$fabric_show_title = get_the_title() != '';
	$fabric_show_meta  = count( $fabric_components ) > 0 && ! in_array( $fabric_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $fabric_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'fabric_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'fabric_action_before_post_title' );
				if ( empty( $fabric_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'fabric_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'fabric_filter_show_blog_excerpt', empty( $fabric_template_args['hide_excerpt'] ) && fabric_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'fabric_filter_show_blog_meta', $fabric_show_meta, $fabric_components, 'excerpt' ) ) {
				if ( count( $fabric_components ) > 0 ) {
					do_action( 'fabric_action_before_post_meta' );
					fabric_show_post_meta(
						apply_filters(
							'fabric_filter_post_meta_args', array(
								'components' => join( ',', $fabric_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'fabric_action_after_post_meta' );
				}
			}

			if ( fabric_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'fabric_action_before_full_post_content' );
					the_content( '' );
					do_action( 'fabric_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'fabric' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'fabric' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				fabric_show_post_content( $fabric_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'fabric_filter_show_blog_readmore',  ! isset( $fabric_template_args['more_button'] ) || ! empty( $fabric_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $fabric_template_args['no_links'] ) ) {
					do_action( 'fabric_action_before_post_readmore' );
					if ( fabric_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						fabric_show_post_more_link( $fabric_template_args, '<p>', '</p>' );
					} else {
						fabric_show_post_comments_link( $fabric_template_args, '<p>', '</p>' );
					}
					do_action( 'fabric_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $fabric_template_args ) ) {
	if ( ! empty( $fabric_template_args['slider'] ) || $fabric_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
