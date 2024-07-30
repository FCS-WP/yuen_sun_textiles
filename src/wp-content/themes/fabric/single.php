<?php
/**
 * The template to display single post
 *
 * @package FABRIC
 * @since FABRIC 1.0
 */

// Full post loading
$full_post_loading          = fabric_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = fabric_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = fabric_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$fabric_related_position   = fabric_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$fabric_posts_navigation   = fabric_get_theme_option( 'posts_navigation' );
$fabric_prev_post          = false;
$fabric_prev_post_same_cat = fabric_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( fabric_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	fabric_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'fabric_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $fabric_posts_navigation ) {
		$fabric_prev_post = get_previous_post( $fabric_prev_post_same_cat );  // Get post from same category
		if ( ! $fabric_prev_post && $fabric_prev_post_same_cat ) {
			$fabric_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $fabric_prev_post ) {
			$fabric_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $fabric_prev_post ) ) {
		fabric_sc_layouts_showed( 'featured', false );
		fabric_sc_layouts_showed( 'title', false );
		fabric_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $fabric_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/content', 'single-' . fabric_get_theme_option( 'single_style' ) ), 'single-' . fabric_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $fabric_related_position, 'inside' ) === 0 ) {
		$fabric_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'fabric_action_related_posts' );
		$fabric_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $fabric_related_content ) ) {
			$fabric_related_position_inside = max( 0, min( 9, fabric_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $fabric_related_position_inside ) {
				$fabric_related_position_inside = mt_rand( 1, 9 );
			}

			$fabric_p_number         = 0;
			$fabric_related_inserted = false;
			$fabric_in_block         = false;
			$fabric_content_start    = strpos( $fabric_content, '<div class="post_content' );
			$fabric_content_end      = strrpos( $fabric_content, '</div>' );

			for ( $i = max( 0, $fabric_content_start ); $i < min( strlen( $fabric_content ) - 3, $fabric_content_end ); $i++ ) {
				if ( $fabric_content[ $i ] != '<' ) {
					continue;
				}
				if ( $fabric_in_block ) {
					if ( strtolower( substr( $fabric_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$fabric_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $fabric_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $fabric_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$fabric_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $fabric_content[ $i + 1 ] && in_array( $fabric_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$fabric_p_number++;
					if ( $fabric_related_position_inside == $fabric_p_number ) {
						$fabric_related_inserted = true;
						$fabric_content = ( $i > 0 ? substr( $fabric_content, 0, $i ) : '' )
											. $fabric_related_content
											. substr( $fabric_content, $i );
					}
				}
			}
			if ( ! $fabric_related_inserted ) {
				if ( $fabric_content_end > 0 ) {
					$fabric_content = substr( $fabric_content, 0, $fabric_content_end ) . $fabric_related_content . substr( $fabric_content, $fabric_content_end );
				} else {
					$fabric_content .= $fabric_related_content;
				}
			}
		}

		fabric_show_layout( $fabric_content );
	}

	// Comments
	do_action( 'fabric_action_before_comments' );
	comments_template();
	do_action( 'fabric_action_after_comments' );

	// Related posts
	if ( 'below_content' == $fabric_related_position
		&& ( 'scroll' != $fabric_posts_navigation || fabric_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || fabric_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'fabric_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $fabric_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $fabric_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $fabric_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $fabric_prev_post ) ); ?>"
			<?php do_action( 'fabric_action_nav_links_single_scroll_data', $fabric_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
