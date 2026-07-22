<?php
/**
 * Bootstrap do tema Objetivo São Carlos.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'OBJETIVO_THEME_VERSION', '1.0.6' );
define( 'OBJETIVO_THEME_DIR', get_template_directory() );
define( 'OBJETIVO_THEME_URI', get_template_directory_uri() );

require_once OBJETIVO_THEME_DIR . '/inc/setup.php';
require_once OBJETIVO_THEME_DIR . '/inc/meta-boxes.php';
require_once OBJETIVO_THEME_DIR . '/inc/cpt.php';
require_once OBJETIVO_THEME_DIR . '/inc/segmento-meta.php';
require_once OBJETIVO_THEME_DIR . '/inc/customizer.php';
require_once OBJETIVO_THEME_DIR . '/inc/woocommerce.php';
require_once OBJETIVO_THEME_DIR . '/inc/activation.php';
require_once OBJETIVO_THEME_DIR . '/inc/elementor.php';
