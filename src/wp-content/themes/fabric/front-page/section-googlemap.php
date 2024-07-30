<div class="front_page_section front_page_section_googlemap<?php
	$fabric_scheme = fabric_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $fabric_scheme ) && ! fabric_is_inherit( $fabric_scheme ) ) {
		echo ' scheme_' . esc_attr( $fabric_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( fabric_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( fabric_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$fabric_css      = '';
		$fabric_bg_image = fabric_get_theme_option( 'front_page_googlemap_bg_image' );
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
	$fabric_anchor_icon = fabric_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$fabric_anchor_text = fabric_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $fabric_anchor_icon ) || ! empty( $fabric_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $fabric_anchor_icon ) ? ' icon="' . esc_attr( $fabric_anchor_icon ) . '"' : '' )
									. ( ! empty( $fabric_anchor_text ) ? ' title="' . esc_attr( $fabric_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$fabric_layout = fabric_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $fabric_layout );
		if ( fabric_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' fabric-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$fabric_css      = '';
			$fabric_bg_mask  = fabric_get_theme_option( 'front_page_googlemap_bg_mask' );
			$fabric_bg_color_type = fabric_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $fabric_bg_color_type ) {
				$fabric_bg_color = fabric_get_theme_option( 'front_page_googlemap_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $fabric_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$fabric_caption     = fabric_get_theme_option( 'front_page_googlemap_caption' );
			$fabric_description = fabric_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $fabric_caption ) || ! empty( $fabric_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $fabric_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $fabric_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $fabric_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $fabric_caption, 'fabric_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $fabric_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $fabric_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $fabric_description ), 'fabric_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $fabric_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$fabric_content = fabric_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $fabric_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $fabric_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $fabric_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $fabric_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $fabric_content, 'fabric_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $fabric_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $fabric_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
				<?php
				if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! fabric_exists_trx_addons() ) {
						fabric_customizer_need_trx_addons_message();
					} else {
						fabric_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
					}
				}
				?>
			</div>
			<?php

			if ( 'columns' == $fabric_layout && ( ! empty( $fabric_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
