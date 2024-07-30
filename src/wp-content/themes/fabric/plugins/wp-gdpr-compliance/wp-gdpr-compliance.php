<?php
/* WP GDPR Compliance support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'fabric_wp_gdpr_compliance_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'fabric_wp_gdpr_compliance_theme_setup9', 9 );
	function fabric_wp_gdpr_compliance_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'fabric_filter_tgmpa_required_plugins', 'fabric_wp_gdpr_compliance_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'fabric_wp_gdpr_compliance_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('fabric_filter_tgmpa_required_plugins',	'fabric_wp_gdpr_compliance_tgmpa_required_plugins');
	function fabric_wp_gdpr_compliance_tgmpa_required_plugins( $list = array() ) {
		if ( fabric_storage_isset( 'required_plugins', 'wp-gdpr-compliance' ) && fabric_storage_get_array( 'required_plugins', 'wp-gdpr-compliance', 'install' ) !== false ) {
			$path = fabric_get_plugin_source_path( 'plugins/wp-gdpr-compliance/wp-gdpr-compliance.zip' );
			if ( ! empty( $path ) || fabric_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => fabric_storage_get_array( 'required_plugins', 'wp-gdpr-compliance', 'title' ),
					'slug'     => 'wp-gdpr-compliance',
					'source'   => ! empty( $path ) ? $path : 'upload://wp-gdpr-compliance.zip',
					'version'  => '2.0.23',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'fabric_exists_wp_gdpr_compliance' ) ) {
	function fabric_exists_wp_gdpr_compliance() {
//		Old way (before v.2.0)
//		Attention! In the v.2.0 and v.2.0.1 this check throw fatal error in their autoloader!
//		return class_exists( 'WPGDPRC\WPGDPRC' );
//		New way (to avoid error in wp_gdpr_compliance autoloader)
//		Check constants:	before v.2.0						after v.2.0
		return defined( 'WP_GDPR_C_ROOT_FILE' ) || defined( 'WPGDPRC_ROOT_FILE' );
	}
}
