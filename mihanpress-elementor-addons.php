<?php
/**
 * Plugin Name: افزودنی های المنتور میهن پرس
 * Plugin URI: https://www.zhaket.com/web/mihanwp-wordpress-theme/
 * Description: افزودنی های المنتور برای قالب میهن پرس.
 * Author URI:  https://www.zhaket.com/store/web/thunder-wp/
 * Version:     1.6.2
 * Author:      Thunder WP
 * Text Domain: mihanpress-elementor-addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Include autoloader file
 *
 * @since 1.0.0
 */
require_once plugin_dir_path( __FILE__ ) . 'autoload.php';

/**
 * Main MihanPress Addons Class
 *
 * The init class that runs the MihanPress Addons plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * @since 1.0.0
 */
final class MP_Elementor_Addons {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.6.2';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';


	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		/** Load translation */
		add_action( 'init', array( $this, 'i18n' ) );

		/** Init Plugin */
		add_action( 'plugins_loaded', array( $this, 'init' ) );

		/** Adds MihanPress Category to Elementor Elements */
		add_action( 'elementor/elements/categories_registered', array( $this, 'add_elementor_widget_categories' ) );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 */
	public function i18n() {
		load_plugin_textdomain( 'mihanpress-elementor-addons' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/** Check if Elementor installed and activated */
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		/** Check for required Elementor version */
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		/** Check for required PHP version */
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		/** Run Plugin Codes */
		require_once plugin_dir_path( __FILE__ ) . 'plugin.php';
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			esc_html__( '"%1$s" برای اجرا شدن نیاز به نصب و فعالسازی %2$s دارد.', 'mihanpress-elementor-addons' ),
			'<strong>' . esc_html__( 'افزودنی های المنتور برای قالب میهن پرس', 'mihanpress-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'المنتور', 'mihanpress-elementor-addons' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}


	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have minimum version of Elementor installed or activated.
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			esc_html__( '"%1$s" برای اجرا شدن نیاز به "%2$s" ورژن %3$s یا بالاتر دارد.', 'mihanpress-elementor-addons' ),
			'<strong>' . esc_html__( 'افزودنی های المنتور برای قالب میهن پرس', 'mihanpress-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'المنتور', 'mihanpress-elementor-addons' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}


	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have minimum version of PHP.
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			esc_html__( 'نسخه "%2$s" با افزونه "%1$s" سازگار نمیباشد. حداقل ورژن موردنیاز : "%3$s".', 'mihanpress-elementor-addons' ),
			'<strong>' . esc_html__( 'افزودنی های المنتور برای قالب میهن پرس', 'mihanpress-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'mihanpress-elementor-addons' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Adds MihanPress Category to Elementor Elements
	 *
	 * @since 1.0.0
	 */
	public function add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'mihanpress-category',
			array(
				'title' => esc_html__( 'میهن پرس', 'mihanpress-elementor-addons' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}
}

// Instantiate NP_Elementor_Addons.
new MP_Elementor_Addons();
