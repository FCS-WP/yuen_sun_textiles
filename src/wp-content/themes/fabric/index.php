<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package FABRIC
 * @since FABRIC 1.0
 */

$fabric_template = apply_filters( 'fabric_filter_get_template_part', fabric_blog_archive_get_template() );

if ( ! empty( $fabric_template ) && 'index' != $fabric_template ) {

	get_template_part( $fabric_template );

} else {

	fabric_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$fabric_stickies   = is_home()
								|| ( in_array( fabric_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) fabric_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$fabric_post_type  = fabric_get_theme_option( 'post_type' );
		$fabric_args       = array(
								'blog_style'     => fabric_get_theme_option( 'blog_style' ),
								'post_type'      => $fabric_post_type,
								'taxonomy'       => fabric_get_post_type_taxonomy( $fabric_post_type ),
								'parent_cat'     => fabric_get_theme_option( 'parent_cat' ),
								'posts_per_page' => fabric_get_theme_option( 'posts_per_page' ),
								'sticky'         => fabric_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $fabric_stickies )
															&& count( $fabric_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		fabric_blog_archive_start();

		do_action( 'fabric_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'fabric_action_before_page_author' );
			get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'fabric_action_after_page_author' );
		}

		if ( fabric_get_theme_option( 'show_filters' ) ) {
			do_action( 'fabric_action_before_page_filters' );
			fabric_show_filters( $fabric_args );
			do_action( 'fabric_action_after_page_filters' );
		} else {
			do_action( 'fabric_action_before_page_posts' );
			fabric_show_posts( array_merge( $fabric_args, array( 'cat' => $fabric_args['parent_cat'] ) ) );
			do_action( 'fabric_action_after_page_posts' );
		}

		do_action( 'fabric_action_blog_archive_end' );

		fabric_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'fabric_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
