<?php
$fabric_woocommerce_sc = fabric_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $fabric_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$fabric_scheme = fabric_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $fabric_scheme ) && ! fabric_is_inherit( $fabric_scheme ) ) {
			echo ' scheme_' . esc_attr( $fabric_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( fabric_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( fabric_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$fabric_css      = '';
			$fabric_bg_image = fabric_get_theme_option( 'front_page_woocommerce_bg_image' );
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
		$fabric_anchor_icon = fabric_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$fabric_anchor_text = fabric_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $fabric_anchor_icon ) || ! empty( $fabric_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $fabric_anchor_icon ) ? ' icon="' . esc_attr( $fabric_anchor_icon ) . '"' : '' )
											. ( ! empty( $fabric_anchor_text ) ? ' title="' . esc_attr( $fabric_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( fabric_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' fabric-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$fabric_css      = '';
				$fabric_bg_mask  = fabric_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$fabric_bg_color_type = fabric_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $fabric_bg_color_type ) {
					$fabric_bg_color = fabric_get_theme_option( 'front_page_woocommerce_bg_color' );
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
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$fabric_caption     = fabric_get_theme_option( 'front_page_woocommerce_caption' );
				$fabric_description = fabric_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $fabric_caption ) || ! empty( $fabric_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $fabric_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $fabric_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $fabric_caption, 'fabric_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $fabric_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $fabric_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $fabric_description ), 'fabric_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $fabric_woocommerce_sc ) {
						$fabric_woocommerce_sc_ids      = fabric_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$fabric_woocommerce_sc_per_page = count( explode( ',', $fabric_woocommerce_sc_ids ) );
					} else {
						$fabric_woocommerce_sc_per_page = max( 1, (int) fabric_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$fabric_woocommerce_sc_columns = max( 1, min( $fabric_woocommerce_sc_per_page, (int) fabric_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$fabric_woocommerce_sc}"
										. ( 'products' == $fabric_woocommerce_sc
												? ' ids="' . esc_attr( $fabric_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $fabric_woocommerce_sc
												? ' category="' . esc_attr( fabric_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $fabric_woocommerce_sc
												? ' orderby="' . esc_attr( fabric_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( fabric_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $fabric_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $fabric_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
