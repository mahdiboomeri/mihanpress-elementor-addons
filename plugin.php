<?php

namespace MihanpressElementorAddons;

use Elementor\Controls_Manager;

/**
 * Class Plugin
 *
 * Main Plugin class
 *
 * @since 1.0.0
 */
class Plugin {


	/**
	 * The single instance of the class.
	 *
	 * @since 1.0.0
	 * @var null instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Register widgets scripts
	 *
	 * @since 1.0.0
	 */
	public function widget_scripts() {
		wp_register_script( 'mihanpress-type-effect', plugins_url( '/assets/js/type-effect.min.js', __FILE__ ), false, '1.0.0', true );
		wp_register_script( 'mihanpress-countdown', plugins_url( '/assets/js/timezz.min.js', __FILE__ ), false, '5.0.0', true );
		wp_register_script( 'mihanpress-pie-chart', plugins_url( '/assets/js/easypiechart.min.js', __FILE__ ), false, '2.1.7', true );
		wp_register_script( 'mihanpress-particles', plugins_url( '/assets/js/particles.min.js', __FILE__ ), false, '2.0.0', true );
		wp_register_script( 'mihanpress-mixitup-js', plugins_url( '/assets/js/mixitup.min.js', __FILE__ ), false, '3.3.1', true );
		wp_register_script( 'mihanpress-backend-elementor', plugins_url( '/assets/js/backend-editor.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );

		$handles = array(
			'mihanpress-type-effect',
			'mihanpress-countdown',
			'mihanpress-pie-chart',
			'mihanpress-particles',
			'mihanpress-mixitup-js',
			'mihanpress-backend-elementor',
		);
		$handles = apply_filters( 'mihanpress_elementor_defer_scripts', $handles );

		foreach ( $handles as $handle ) {
			wp_script_add_data( $handle, 'defer', true );
		}
	}

	/**
	 * Load widgets files
	 *
	 * @since 1.0.0
	 */
	private function include_widgets_files() {
		require_once plugin_dir_path( __FILE__ ) . 'widgets/type-effect.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/dual-color-heading.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/information-boxes.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/collapsible.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/dynamic-carousel.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/portfolio-filter.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/testimonial-carousel.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/posts/posts.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/posts/static-posts.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/countdown.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/pie-chart.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/price-table.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/call-to-action.php';
	}

	/**
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 */
	public function register_widgets() {
		/** Its is now safe to include Widgets files */
		$this->include_widgets_files();

		/** Register Widgets */
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Type_Effect() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Dual_Heading() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Information_Boxes() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Collapsible() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Dynamic_Carousel() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Portfolio_Filter() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Testimonial_Carousel() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Posts() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Static_Posts() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Countdown() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Pie_Chart() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Price_Table() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_To_Action() );
	}

	/**
	 * Includes custom controls files
	 *
	 * @since 1.0.0
	 */
	public function include_custom_controls_files() {
		require_once plugin_dir_path( __FILE__ ) . 'widgets/shape-background/shape-bg.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/particles/particles.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/button.php';
		require_once plugin_dir_path( __FILE__ ) . 'widgets/image.php';
	}


	/**
	 * Register new controls to existing widget.
	 *
	 * @since 1.0.0
	 */
	public function register_custom_controls() {
		/** Its is now safe to include Widgets files */
		$this->include_custom_controls_files();

		/** Register Widgets */
		new \MihanpressElementorAddons\Widgets\Particles();
		new \MihanpressElementorAddons\Widgets\Shape_BG();
		new \MihanpressElementorAddons\Widgets\Button_Extra();
		new \MihanpressElementorAddons\Widgets\Image_Extra();
	}



	/**
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		/** Register widget scripts */
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_scripts' ) );

		/** Register widgets */
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );

		/** Register custom controls to existing widgets */
		$this->register_custom_controls();
	}
}

// Instantiate Plugin Class
Plugin::instance();
