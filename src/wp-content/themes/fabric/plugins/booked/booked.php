<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'fabric_booked_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'fabric_booked_theme_setup9', 9 );
	function fabric_booked_theme_setup9() {
		if ( fabric_exists_booked() ) {
			add_action( 'wp_enqueue_scripts', 'fabric_booked_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_booked', 'fabric_booked_frontend_scripts', 10, 1 );
			add_action( 'wp_enqueue_scripts', 'fabric_booked_frontend_scripts_responsive', 2000 );
			add_action( 'trx_addons_action_load_scripts_front_booked', 'fabric_booked_frontend_scripts_responsive', 10, 1 );
			add_filter( 'fabric_filter_merge_styles', 'fabric_booked_merge_styles' );
			add_filter( 'fabric_filter_merge_styles_responsive', 'fabric_booked_merge_styles_responsive' );
		}
		if ( is_admin() ) {
			add_filter( 'fabric_filter_tgmpa_required_plugins', 'fabric_booked_tgmpa_required_plugins' );
			add_filter( 'fabric_filter_theme_plugins', 'fabric_booked_theme_plugins' );
		}
	}
}


// Filter to add in the required plugins list
if ( ! function_exists( 'fabric_booked_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('fabric_filter_tgmpa_required_plugins',	'fabric_booked_tgmpa_required_plugins');
	function fabric_booked_tgmpa_required_plugins( $list = array() ) {
		if ( fabric_storage_isset( 'required_plugins', 'booked' ) && fabric_storage_get_array( 'required_plugins', 'booked', 'install' ) !== false && fabric_is_theme_activated() ) {
			$path = fabric_get_plugin_source_path( 'plugins/booked/booked.zip' );
			if ( ! empty( $path ) || fabric_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => fabric_storage_get_array( 'required_plugins', 'booked', 'title' ),
					'slug'     => 'booked',
					'source'   => ! empty( $path ) ? $path : 'upload://booked.zip',
					'version'  => '2.4.3.1',
					'required' => false,
				);
			}
		}
		return $list;
	}
}


// Filter theme-supported plugins list
if ( ! function_exists( 'fabric_booked_theme_plugins' ) ) {
	//Handler of the add_filter( 'fabric_filter_theme_plugins', 'fabric_booked_theme_plugins' );
	function fabric_booked_theme_plugins( $list = array() ) {
		return fabric_add_group_and_logo_to_slave( $list, 'booked', 'booked-' );
	}
}


// Check if plugin installed and activated
if ( ! function_exists( 'fabric_exists_booked' ) ) {
	function fabric_exists_booked() {
		return class_exists( 'booked_plugin' );
	}
}


// Return a relative path to the plugin styles depend the version
if ( ! function_exists( 'fabric_booked_get_styles_dir' ) ) {
	function fabric_booked_get_styles_dir( $file ) {
		$base_dir = 'plugins/booked/';
		return $base_dir
				. ( defined( 'BOOKED_VERSION' ) && version_compare( BOOKED_VERSION, '2.4', '<' ) && fabric_get_folder_dir( $base_dir . 'old' )
					? 'old/'
					: ''
					)
				. $file;
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'fabric_booked_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'fabric_booked_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_booked', 'fabric_booked_frontend_scripts', 10, 1 );
	function fabric_booked_frontend_scripts( $force = false ) {
		fabric_enqueue_optimized( 'booked', $force, array(
			'css' => array(
				'fabric-booked' => array( 'src' => fabric_booked_get_styles_dir( 'booked.css' ) ),
			)
		) );
	}
}


// Enqueue responsive styles for frontend
if ( ! function_exists( 'fabric_booked_frontend_scripts_responsive' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'fabric_booked_frontend_scripts_responsive', 2000 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_booked', 'fabric_booked_frontend_scripts_responsive', 10, 1 );
	function fabric_booked_frontend_scripts_responsive( $force = false ) {
		fabric_enqueue_optimized_responsive( 'booked', $force, array(
			'css' => array(
				'fabric-booked-responsive' => array( 'src' => fabric_booked_get_styles_dir( 'booked-responsive.css' ), 'media' => 'all' ),
			)
		) );
	}
}


// Merge custom styles
if ( ! function_exists( 'fabric_booked_merge_styles' ) ) {
	//Handler of the add_filter('fabric_filter_merge_styles', 'fabric_booked_merge_styles');
	function fabric_booked_merge_styles( $list ) {
		$list[ fabric_booked_get_styles_dir( 'booked.css' ) ] = false;
		return $list;
	}
}


// Merge responsive styles
if ( ! function_exists( 'fabric_booked_merge_styles_responsive' ) ) {
	//Handler of the add_filter('fabric_filter_merge_styles_responsive', 'fabric_booked_merge_styles_responsive');
	function fabric_booked_merge_styles_responsive( $list ) {
		$list[ fabric_booked_get_styles_dir( 'booked-responsive.css' ) ] = false;
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( fabric_exists_booked() ) {
	$fabric_fdir = fabric_get_file_dir( fabric_booked_get_styles_dir( 'booked-style.php' ) );
	if ( ! empty( $fabric_fdir ) ) {
		require_once $fabric_fdir;
	}
}
