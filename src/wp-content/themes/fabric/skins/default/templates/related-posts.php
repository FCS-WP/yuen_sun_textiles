<?php
/**
 * The default template to displaying related posts
 *
 * @package FABRIC
 * @since FABRIC 1.0.54
 */

$fabric_link        = get_permalink();
$fabric_post_format = get_post_format();
$fabric_post_format = empty( $fabric_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fabric_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $fabric_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php
	fabric_show_post_featured(
		array(
			'thumb_size' => apply_filters( 'fabric_filter_related_thumb_size', fabric_get_thumb_size( (int) fabric_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
		)
	);
	?>
	<div class="post_header entry-header">
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $fabric_link ); ?>"><?php
			if ( '' == get_the_title() ) {
				esc_html_e( '- No title -', 'fabric' );
			} else {
				the_title();
			}
		?></a></h6>
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			?>
			<span class="post_date"><a href="<?php echo esc_url( $fabric_link ); ?>"><?php echo wp_kses_data( fabric_get_date() ); ?></a></span>
			<?php
		}
		?>
	</div>
</div>
