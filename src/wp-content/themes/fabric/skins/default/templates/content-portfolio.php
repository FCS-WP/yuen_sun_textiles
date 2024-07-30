<?php
/**
 * The Portfolio template to display the content
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

$fabric_post_format = get_post_format();
$fabric_post_format = empty( $fabric_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fabric_post_format );

?><div class="
<?php
if ( ! empty( $fabric_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( fabric_is_blog_style_use_masonry( $fabric_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $fabric_columns ) : esc_attr( $fabric_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $fabric_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $fabric_columns )
		. ( 'portfolio' != $fabric_blog_style[0] ? ' ' . esc_attr( $fabric_blog_style[0] )  . '_' . esc_attr( $fabric_columns ) : '' )
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

	$fabric_hover   = ! empty( $fabric_template_args['hover'] ) && ! fabric_is_inherit( $fabric_template_args['hover'] )
								? $fabric_template_args['hover']
								: fabric_get_theme_option( 'image_hover' );

	if ( 'dots' == $fabric_hover ) {
		$fabric_post_link = empty( $fabric_template_args['no_links'] )
								? ( ! empty( $fabric_template_args['link'] )
									? $fabric_template_args['link']
									: get_permalink()
									)
								: '';
		$fabric_target    = ! empty( $fabric_post_link ) && false === strpos( $fabric_post_link, home_url() )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$fabric_components = ! empty( $fabric_template_args['meta_parts'] )
							? ( is_array( $fabric_template_args['meta_parts'] )
								? $fabric_template_args['meta_parts']
								: explode( ',', $fabric_template_args['meta_parts'] )
								)
							: fabric_array_get_keys_by_value( fabric_get_theme_option( 'meta_parts' ) );

	// Featured image
	fabric_show_post_featured( apply_filters( 'fabric_filter_args_featured',
        array(
			'hover'         => $fabric_hover,
			'no_links'      => ! empty( $fabric_template_args['no_links'] ),
			'thumb_size'    => ! empty( $fabric_template_args['thumb_size'] )
								? $fabric_template_args['thumb_size']
								: fabric_get_thumb_size(
									fabric_is_blog_style_use_masonry( $fabric_blog_style[0] )
										? (	strpos( fabric_get_theme_option( 'body_style' ), 'full' ) !== false || $fabric_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( fabric_get_theme_option( 'body_style' ), 'full' ) !== false || $fabric_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => fabric_is_blog_style_use_masonry( $fabric_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $fabric_components,
			'class'         => 'dots' == $fabric_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $fabric_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $fabric_post_link )
												? '<a href="' . esc_url( $fabric_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $fabric_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $fabric_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $fabric_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!