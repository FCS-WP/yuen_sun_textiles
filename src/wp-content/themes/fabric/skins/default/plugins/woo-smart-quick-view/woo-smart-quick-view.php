<?php
/* WPC Smart Quick View for WooCommerce support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('fabric_quick_view_theme_setup9')) {
	add_action( 'after_setup_theme', 'fabric_quick_view_theme_setup9', 9 );
	function fabric_quick_view_theme_setup9() {
		if (fabric_exists_quick_view()) {
			add_action( 'wp_enqueue_scripts', 'fabric_quick_view_frontend_scripts', 1100 );
			add_filter( 'fabric_filter_merge_styles', 'fabric_quick_view_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'fabric_filter_tgmpa_required_plugins',		'fabric_quick_view_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'fabric_quick_view_tgmpa_required_plugins' ) ) {
	function fabric_quick_view_tgmpa_required_plugins($list=array()) {
		if (fabric_storage_isset( 'required_plugins', 'woocommerce' ) && fabric_storage_get_array( 'required_plugins', 'woocommerce', 'install' ) !== false &&
			fabric_storage_isset('required_plugins', 'woo-smart-quick-view') && fabric_storage_get_array( 'required_plugins', 'woo-smart-quick-view', 'install' ) !== false) {
			$list[] = array(
				'name' 		=> fabric_storage_get_array('required_plugins', 'woo-smart-quick-view', 'title'),
				'slug' 		=> 'woo-smart-quick-view',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'fabric_exists_quick_view' ) ) {
	function fabric_exists_quick_view() {
		return function_exists('woosq_init');
	}
}

// Enqueue custom scripts
if ( ! function_exists( 'fabric_quick_view_frontend_scripts' ) ) {
	function fabric_quick_view_frontend_scripts() {
		if ( fabric_is_on( fabric_get_theme_option( 'debug_mode' ) ) ) {
			$fabric_url = fabric_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.css' );
			if ( '' != $fabric_url ) {
				wp_enqueue_style( 'fabric-woo-smart-quick-view', $fabric_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'fabric_quick_view_merge_styles' ) ) {
	function fabric_quick_view_merge_styles( $list ) {
		$list['plugins/woo-smart-quick-view/woo-smart-quick-view.css'] = true;
		return $list;
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if ( fabric_exists_quick_view() ) {
	require_once fabric_get_file_dir( 'plugins/woo-smart-quick-view/woo-smart-quick-view-style.php' );
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'fabric_quick_view_importer_required_plugins' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'fabric_quick_view_importer_required_plugins', 10, 2 );
    function fabric_quick_view_importer_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'woo-smart-quick-view')!==false && !fabric_exists_quick_view() )
            $not_installed .= '<br>' . esc_html__('WPC Smart Quick View for WooCommerce', 'fabric');
        return $not_installed;
    }
}

// Set plugin's specific importer options
if ( !function_exists( 'fabric_quick_view_importer_set_options' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'fabric_quick_view_importer_set_options' );
    function fabric_quick_view_importer_set_options($options=array()) {
        if ( fabric_exists_quick_view() && in_array('woo-smart-quick-view', $options['required_plugins']) ) {
            $options['additional_options'][] = 'woosq_%';
        }
        return $options;
    }
}