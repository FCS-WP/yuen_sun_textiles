<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package FABRIC
 * @since FABRIC 1.0
 */

$fabric_template_args = get_query_var( 'fabric_template_args' );

if ( is_array( $fabric_template_args ) ) {
	$fabric_columns    = empty( $fabric_template_args['columns'] ) ? 2 : max( 1, $fabric_template_args['columns'] );
	$fabric_blog_style = array( $fabric_template_args['type'], $fabric_columns );
    $fabric_columns_class = fabric_get_column_class( 1, $fabric_columns, ! empty( $fabric_template_args['columns_tablet']) ? $fabric_template_args['columns_tablet'] : '', ! empty($fabric_template_args['columns_mobile']) ? $fabric_template_args['columns_mobile'] : '' );
} else {
	$fabric_template_args = array();
	$fabric_blog_style = explode( '_', fabric_get_theme_option( 'blog_style' ) );
	$fabric_columns    = empty( $fabric_blog_style[1] ) ? 2 : max( 1, $fabric_blog_style[1] );
    $fabric_columns_class = fabric_get_column_class( 1, $fabric_columns );
}
$fabric_expanded   = ! fabric_sidebar_present() && fabric_get_theme_option( 'expand_content' ) == 'expand';

$fabric_post_format = get_post_format();
$fabric_post_format = empty( $fabric_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fabric_post_format );

?><div class="<?php
	if ( ! empty( $fabric_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( fabric_is_blog_style_use_masonry( $fabric_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $fabric_columns ) : esc_attr( $fabric_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $fabric_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $fabric_columns )
				. ' post_layout_' . esc_attr( $fabric_blog_style[0] )
				. ' post_layout_' . esc_attr( $fabric_blog_style[0] ) . '_' . esc_attr( $fabric_columns )
	);
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
								: explode( ',', $fabric_template_args['meta_parts'] )
								)
							: fabric_array_get_keys_by_value( fabric_get_theme_option( 'meta_parts' ) );

	fabric_show_post_featured( apply_filters( 'fabric_filter_args_featured',
		array(
			'thumb_size' => ! empty( $fabric_template_args['thumb_size'] )
				? $fabric_template_args['thumb_size']
				: fabric_get_thumb_size(
					'classic' == $fabric_blog_style[0]
						? ( strpos( fabric_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $fabric_columns > 2 ? 'big' : 'huge' )
								: ( $fabric_columns > 2
									? ( $fabric_expanded ? 'square' : 'square' )
									: ($fabric_columns > 1 ? 'square' : ( $fabric_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( fabric_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $fabric_columns > 2 ? 'masonry-big' : 'full' )
								: ($fabric_columns === 1 ? ( $fabric_expanded ? 'huge' : 'big' ) : ( $fabric_columns <= 2 && $fabric_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $fabric_hover,
			'meta_parts' => $fabric_components,
			'no_links'   => ! empty( $fabric_template_args['no_links'] ),
        ),
        'content-classic',
        $fabric_template_args
    ) );

	// Title and post meta
	$fabric_show_title = get_the_title() != '';
	$fabric_show_meta  = count( $fabric_components ) > 0 && ! in_array( $fabric_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $fabric_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'fabric_filter_show_blog_meta', $fabric_show_meta, $fabric_components, 'classic' ) ) {
				if ( count( $fabric_components ) > 0 ) {
					do_action( 'fabric_action_before_post_meta' );
					fabric_show_post_meta(
						apply_filters(
							'fabric_filter_post_meta_args', array(
							'components' => join( ',', $fabric_components ),
							'seo'        => false,
							'echo'       => true,
						), $fabric_blog_style[0], $fabric_columns
						)
					);
					do_action( 'fabric_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'fabric_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'fabric_action_before_post_title' );
				if ( empty( $fabric_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'fabric_action_after_post_title' );
			}

			if( !in_array( $fabric_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'fabric_filter_show_blog_readmore', ! $fabric_show_title || ! empty( $fabric_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $fabric_template_args['no_links'] ) ) {
						do_action( 'fabric_action_before_post_readmore' );
						fabric_show_post_more_link( $fabric_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'fabric_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $fabric_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('fabric_filter_show_blog_excerpt', empty($fabric_template_args['hide_excerpt']) && fabric_get_theme_option('excerpt_length') > 0, 'classic')) {
			fabric_show_post_content($fabric_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $fabric_template_args['more_button'] )) {
			if ( empty( $fabric_template_args['no_links'] ) ) {
				do_action( 'fabric_action_before_post_readmore' );
				fabric_show_post_more_link( $fabric_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'fabric_action_after_post_readmore' );
			}
		}
		$fabric_content = ob_get_contents();
		ob_end_clean();
		fabric_show_layout($fabric_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
