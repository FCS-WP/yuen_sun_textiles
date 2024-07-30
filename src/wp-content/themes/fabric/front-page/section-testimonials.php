<div class="front_page_section front_page_section_testimonials<?php
	$fabric_scheme = fabric_get_theme_option( 'front_page_testimonials_scheme' );
	if ( ! empty( $fabric_scheme ) && ! fabric_is_inherit( $fabric_scheme ) ) {
		echo ' scheme_' . esc_attr( $fabric_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( fabric_get_theme_option( 'front_page_testimonials_paddings' ) );
	if ( fabric_get_theme_option( 'front_page_testimonials_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$fabric_css      = '';
		$fabric_bg_image = fabric_get_theme_option( 'front_page_testimonials_bg_image' );
		if ( ! empty( $fabric_bg_image ) ) {
			$fabric_css .= 'background-image: url(' . esc_url( fabric_get_attachment_url( $fabric_bg_image ) ) . ');';
		}
		if ( ! empty( $fabric_css ) ) {
			echo ' style="' . esc_attr( $fabric_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$fabric_anchor_icon = fabric_get_theme_option( 'front_page_testimonials_anchor_icon' );
	$fabric_anchor_text = fabric_get_theme_option( 'front_page_testimonials_anchor_text' );
if ( ( ! empty( $fabric_anchor_icon ) || ! empty( $fabric_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_testimonials"'
									. ( ! empty( $fabric_anchor_icon ) ? ' icon="' . esc_attr( $fabric_anchor_icon ) . '"' : '' )
									. ( ! empty( $fabric_anchor_text ) ? ' title="' . esc_attr( $fabric_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_testimonials_inner
	<?php
	if ( fabric_get_theme_option( 'front_page_testimonials_fullheight' ) ) {
		echo ' fabric-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$fabric_css      = '';
			$fabric_bg_mask  = fabric_get_theme_option( 'front_page_testimonials_bg_mask' );
			$fabric_bg_color_type = fabric_get_theme_option( 'front_page_testimonials_bg_color_type' );
			if ( 'custom' == $fabric_bg_color_type ) {
				$fabric_bg_color = fabric_get_theme_option( 'front_page_testimonials_bg_color' );
			} elseif ( 'scheme_bg_color' == $fabric_bg_color_type ) {
				$fabric_bg_color = fabric_get_scheme_color( 'bg_color', $fabric_scheme );
			} else {
				$fabric_bg_color = '';
			}
			if ( ! empty( $fabric_bg_color ) && $fabric_bg_mask > 0 ) {
				$fabric_css .= 'background-color: ' . esc_attr(
					1 == $fabric_bg_mask ? $fabric_bg_color : fabric_hex2rgba( $fabric_bg_color, $fabric_bg_mask )
				) . ';';
			}
			if ( ! empty( $fabric_css ) ) {
				echo ' style="' . esc_attr( $fabric_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_testimonials_content_wrap content_wrap">
			<?php
			// Caption
			$fabric_caption = fabric_get_theme_option( 'front_page_testimonials_caption' );
			if ( ! empty( $fabric_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_testimonials_caption front_page_block_<?php echo ! empty( $fabric_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $fabric_caption, 'fabric_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$fabric_description = fabric_get_theme_option( 'front_page_testimonials_description' );
			if ( ! empty( $fabric_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_testimonials_description front_page_block_<?php echo ! empty( $fabric_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $fabric_description ), 'fabric_kses_content' ); ?></div>
				<?php
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_testimonials_output">
				<?php
				if ( is_active_sidebar( 'front_page_testimonials_widgets' ) ) {
					dynamic_sidebar( 'front_page_testimonials_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! fabric_exists_trx_addons() ) {
						fabric_customizer_need_trx_addons_message();
					} else {
						fabric_customizer_need_widgets_message( 'front_page_testimonials_caption', 'ThemeREX Addons - Testimonials' );
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
