<?php
/**
 * The "Style 2" template to display the content of the single post or attachment:
 * featured image placed to the post header and title placed inside content
 *
 * @package FABRIC
 * @since FABRIC 1.75.0
 */
?>
<article id="post-<?php the_ID(); ?>"
	<?php
	post_class( 'post_item_single'
		. ' post_type_' . esc_attr( get_post_type() ) 
		. ' post_format_' . esc_attr( str_replace( 'post-format-', '', get_post_format() ) )
	);
	fabric_add_seo_itemprops();
	?>
>
<?php

	do_action( 'fabric_action_before_post_data' );

	fabric_add_seo_snippets();

	// Single post thumbnail and title
	if ( apply_filters( 'fabric_filter_single_post_header', is_singular( 'post' ) || is_singular( 'attachment' ) ) ) {
		ob_start();
		?>
		<div class="post_header_wrap post_header_wrap_in_content post_header_wrap_style_<?php
			echo esc_attr( fabric_get_theme_option( 'single_style' ) );
		?>">
			<?php
			// Post title and meta
			fabric_show_post_title_and_meta( array( 
				'author_avatar' => false,
				'show_labels'   => false,
				'share_type'    => 'list',	// block - icons with bg, list - small icons without background
				'split_meta_by' => 'share',
				'add_spaces'    => true,
			) );
			?>
		</div>
		<?php
		$fabric_post_header = ob_get_contents();
		ob_end_clean();
		if ( strpos( $fabric_post_header, 'post_title' ) !== false	|| strpos( $fabric_post_header, 'post_meta' ) !== false ) {
			fabric_show_layout( $fabric_post_header );
		}
	}

	do_action( 'fabric_action_before_post_content' );

	// Post content
	$fabric_share_position = fabric_array_get_keys_by_value( fabric_get_theme_option( 'share_position' ) );
	?>
	<div class="post_content post_content_single entry-content<?php
		if ( in_array( 'left', $fabric_share_position ) ) {
			echo ' post_info_vertical_present' . ( in_array( 'top', $fabric_share_position ) ? ' post_info_vertical_hide_on_mobile' : '' );
		}
	?>" itemprop="mainEntityOfPage">
		<?php
		if ( in_array( 'left', $fabric_share_position ) ) {
			?><div class="post_info_vertical<?php
				if ( fabric_get_theme_option( 'share_fixed' ) > 0 ) {
					echo ' post_info_vertical_fixed';
				}
			?>"><?php
				fabric_show_post_meta(
					apply_filters(
						'fabric_filter_post_meta_args',
						array(
							'components'      => 'share',
							'class'           => 'post_share_vertical',
							'share_type'      => 'block',
							'share_direction' => 'vertical',
						),
						'single',
						1
					)
				);
			?></div><?php
		}
		the_content();
		?>
	</div><!-- .entry-content -->
	<?php
	do_action( 'fabric_action_after_post_content' );
	
	// Post footer: Tags, likes, share, author, prev/next links and comments
	do_action( 'fabric_action_before_post_footer' );
	?>
	<div class="post_footer post_footer_single entry-footer">
		<?php
		fabric_show_post_pagination();
		if ( is_single() && ! is_attachment() ) {
			fabric_show_post_footer();
		}
		?>
	</div>
	<?php
	do_action( 'fabric_action_after_post_footer' );
	?>
</article>
