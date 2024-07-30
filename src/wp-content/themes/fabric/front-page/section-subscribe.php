<div class="front_page_section front_page_section_subscribe<?php
	$fabric_scheme = fabric_get_theme_option( 'front_page_subscribe_scheme' );
	if ( ! empty( $fabric_scheme ) && ! fabric_is_inherit( $fabric_scheme ) ) {
		echo ' scheme_' . esc_attr( $fabric_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( fabric_get_theme_option( 'front_page_subscribe_paddings' ) );
	if ( fabric_get_theme_option( 'front_page_subscribe_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$fabric_css      = '';
		$fabric_bg_image = fabric_get_theme_option( 'front_page_subscribe_bg_image' );
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
	$fabric_anchor_icon = fabric_get_theme_option( 'front_page_subscribe_anchor_icon' );
	$fabric_anchor_text = fabric_get_theme_option( 'front_page_subscribe_anchor_text' );
if ( ( ! empty( $fabric_anchor_icon ) || ! empty( $fabric_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_subscribe"'
									. ( ! empty( $fabric_anchor_icon ) ? ' icon="' . esc_attr( $fabric_anchor_icon ) . '"' : '' )
									. ( ! empty( $fabric_anchor_text ) ? ' title="' . esc_attr( $fabric_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_subscribe_inner
	<?php
	if ( fabric_get_theme_option( 'front_page_subscribe_fullheight' ) ) {
		echo ' fabric-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$fabric_css      = '';
			$fabric_bg_mask  = fabric_get_theme_option( 'front_page_subscribe_bg_mask' );
			$fabric_bg_color_type = fabric_get_theme_option( 'front_page_subscribe_bg_color_type' );
			if ( 'custom' == $fabric_bg_color_type ) {
				$fabric_bg_color = fabric_get_theme_option( 'front_page_subscribe_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_subscribe_content_wrap content_wrap">
			<?php
			// Caption
			$fabric_caption = fabric_get_theme_option( 'front_page_subscribe_caption' );
			if ( ! empty( $fabric_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_subscribe_caption front_page_block_<?php echo ! empty( $fabric_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $fabric_caption, 'fabric_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$fabric_description = fabric_get_theme_option( 'front_page_subscribe_description' );
			if ( ! empty( $fabric_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_subscribe_description front_page_block_<?php echo ! empty( $fabric_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $fabric_description ), 'fabric_kses_content' ); ?></div>
				<?php
			}

			// Content
			$fabric_sc = fabric_get_theme_option( 'front_page_subscribe_shortcode' );
			if ( ! empty( $fabric_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_subscribe_output front_page_block_<?php echo ! empty( $fabric_sc ) ? 'filled' : 'empty'; ?>">
				<?php
					fabric_show_layout( do_shortcode( $fabric_sc ) );
				?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
