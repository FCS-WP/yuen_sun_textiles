<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package FABRIC
 * @since FABRIC 1.0.50
 */

$fabric_template_args = get_query_var( 'fabric_template_args' );
if ( is_array( $fabric_template_args ) ) {
	$fabric_columns    = empty( $fabric_template_args['columns'] ) ? 2 : max( 1, $fabric_template_args['columns'] );
	$fabric_blog_style = array( $fabric_template_args['type'], $fabric_columns );
} else {
	$fabric_template_args = array();
	$fabric_blog_style = explode( '_', fabric_get_theme_option( 'blog_style' ) );
	$fabric_columns    = empty( $fabric_blog_style[1] ) ? 2 : max( 1, $fabric_blog_style[1] );
}
$fabric_blog_id       = fabric_get_custom_blog_id( join( '_', $fabric_blog_style ) );
$fabric_blog_style[0] = str_replace( 'blog-custom-', '', $fabric_blog_style[0] );
$fabric_expanded      = ! fabric_sidebar_present() && fabric_get_theme_option( 'expand_content' ) == 'expand';
$fabric_components    = ! empty( $fabric_template_args['meta_parts'] )
							? ( is_array( $fabric_template_args['meta_parts'] )
								? join( ',', $fabric_template_args['meta_parts'] )
								: $fabric_template_args['meta_parts']
								)
							: fabric_array_get_keys_by_value( fabric_get_theme_option( 'meta_parts' ) );
$fabric_post_format   = get_post_format();
$fabric_post_format   = empty( $fabric_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fabric_post_format );

$fabric_blog_meta     = fabric_get_custom_layout_meta( $fabric_blog_id );
$fabric_custom_style  = ! empty( $fabric_blog_meta['scripts_required'] ) ? $fabric_blog_meta['scripts_required'] : 'none';

if ( ! empty( $fabric_template_args['slider'] ) || $fabric_columns > 1 || ! fabric_is_off( $fabric_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $fabric_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( fabric_is_off( $fabric_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $fabric_custom_style ) ) . "-1_{$fabric_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $fabric_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $fabric_columns )
					. ' post_layout_' . esc_attr( $fabric_blog_style[0] )
					. ' post_layout_' . esc_attr( $fabric_blog_style[0] ) . '_' . esc_attr( $fabric_columns )
					. ( ! fabric_is_off( $fabric_custom_style )
						? ' post_layout_' . esc_attr( $fabric_custom_style )
							. ' post_layout_' . esc_attr( $fabric_custom_style ) . '_' . esc_attr( $fabric_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'fabric_action_show_layout', $fabric_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $fabric_template_args['slider'] ) || $fabric_columns > 1 || ! fabric_is_off( $fabric_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
