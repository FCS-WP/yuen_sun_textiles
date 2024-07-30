<?php
/**
 * Required plugins
 *
 * @package FABRIC
 * @since FABRIC 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$fabric_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'fabric' ),
	'page_builders' => esc_html__( 'Page Builders', 'fabric' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'fabric' ),
	'socials'       => esc_html__( 'Socials and Communities', 'fabric' ),
	'events'        => esc_html__( 'Events and Appointments', 'fabric' ),
	'content'       => esc_html__( 'Content', 'fabric' ),
	'other'         => esc_html__( 'Other', 'fabric' ),
);
$fabric_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'fabric' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'fabric' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $fabric_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'fabric' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'fabric' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $fabric_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'fabric' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'fabric' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $fabric_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'fabric' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'fabric' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $fabric_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'fabric' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'fabric' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'woocommerce.png',
		'group'       => $fabric_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'fabric' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'fabric' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'elegro-payment.png',
		'group'       => $fabric_theme_required_plugins_groups['ecommerce'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'fabric' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'fabric' ),
		'required'    => false,
		'logo'        => 'instagram-feed.png',
		'group'       => $fabric_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'fabric' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'fabric' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $fabric_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'fabric' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'booked.png',
		'group'       => $fabric_theme_required_plugins_groups['events'],
	),
	'quickcal'                     => array(
		'title'       => esc_html__( 'QuickCal', 'fabric' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'quickcal.png',
		'group'       => $fabric_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'fabric' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'the-events-calendar.png',
		'group'       => $fabric_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'fabric' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'fabric' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $fabric_theme_required_plugins_groups['content'],
	),

	'latepoint'                  => array(
		'title'       => esc_html__( 'LatePoint', 'fabric' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => fabric_get_file_url( 'plugins/latepoint/latepoint.png' ),
		'group'       => $fabric_theme_required_plugins_groups['events'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'fabric' ),
		'description' => '',
		'required'    => false,
		'logo'        => fabric_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $fabric_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'fabric' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => fabric_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $fabric_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'                  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'fabric' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => fabric_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $fabric_theme_required_plugins_groups['ecommerce'],
	),
	'woo-smart-quick-view'                  => array(
		'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'fabric' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => fabric_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
		'group'       => $fabric_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'fabric' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => fabric_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $fabric_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'fabric' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'essential-grid.png',
		'group'       => $fabric_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'fabric' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $fabric_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'fabric' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'fabric' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $fabric_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'fabric' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'fabric' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $fabric_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'fabric' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'fabric' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $fabric_theme_required_plugins_groups['other'],
	),
);

if ( FABRIC_THEME_FREE ) {
	unset( $fabric_theme_required_plugins['js_composer'] );
	unset( $fabric_theme_required_plugins['booked'] );
	unset( $fabric_theme_required_plugins['quickcal'] );
	unset( $fabric_theme_required_plugins['the-events-calendar'] );
	unset( $fabric_theme_required_plugins['calculated-fields-form'] );
	unset( $fabric_theme_required_plugins['essential-grid'] );
	unset( $fabric_theme_required_plugins['revslider'] );
	unset( $fabric_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $fabric_theme_required_plugins['trx_updater'] );
	unset( $fabric_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
fabric_storage_set( 'required_plugins', $fabric_theme_required_plugins );
