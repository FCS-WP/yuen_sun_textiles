<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'fabric_cf7_get_css' ) ) {
	add_filter( 'fabric_filter_get_css', 'fabric_cf7_get_css', 10, 2 );
	function fabric_cf7_get_css( $css, $args ) {
		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS

        .sc_item_filters_tabs {
			{$fonts['h6_font-family']}
        }
		
		/* Title */
		h1.sc_item_title { {$fonts['h1_line-height']} }
		h2.sc_item_title { {$fonts['h2_line-height']} }
		h3.sc_item_title { {$fonts['h3_line-height']} }
		h4.sc_item_title { {$fonts['h4_line-height']} }
		h5.sc_item_title { {$fonts['h5_line-height']} }
		h6.sc_item_title { {$fonts['h6_line-height']} }
CSS;
		}

		return $css;
	}
}
