<?php
/**
 * The template to display Admin notices
 *
 * @package FABRIC
 * @since FABRIC 1.0.1
 */

$fabric_theme_slug = get_option( 'template' );
$fabric_theme_obj  = wp_get_theme( $fabric_theme_slug );
?>
<div class="fabric_admin_notice fabric_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$fabric_theme_img = fabric_get_file_url( 'screenshot.jpg' );
	if ( '' != $fabric_theme_img ) {
		?>
		<div class="fabric_notice_image"><img src="<?php echo esc_url( $fabric_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'fabric' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="fabric_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'fabric' ),
				$fabric_theme_obj->get( 'Name' ) . ( FABRIC_THEME_FREE ? ' ' . __( 'Free', 'fabric' ) : '' ),
				$fabric_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="fabric_notice_text">
		<p class="fabric_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $fabric_theme_obj->description ) );
			?>
		</p>
		<p class="fabric_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'fabric' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="fabric_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=fabric_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'fabric' );
			?>
		</a>
	</div>
</div>
