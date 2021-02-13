<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main widegt class
 *
 * @since 1.0.0
 */
class Dynamic_Carousel extends Widget_Base {

	use \MihanpressElementorAddons\Traits\Helper;

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'mp_dynamic_carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return esc_html__( 'اسلایدر داینامیک', 'mihanpress-elementor-addons' );
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.0.0
	 */
	public function get_categories() {
		return array( 'mihanpress-category' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 */
	public function get_icon() {
		return 'eicon-post-slider';
	}

	/**
	 * Retrieve the list of widget scripts
	 *
	 * @since 1.0.0
	 */
	public function get_script_depends() {
		return array( 'mihanpress-flickity-carousel-js', 'mihanpress-backend-elementor' );
	}

	/**
	 * Retrieve the list of widget styles
	 *
	 * @since 1.0.0
	 */
	public function get_style_depends() {
		return array( 'mihanpress-flickity-carousel' );
	}

	/**
	 * Register the widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 */
	protected function _register_controls() {
		/**
		 * ------------------------------- Query Tab -------------------------------
		 */
		$this->query_section( $this );

		$this->start_controls_section(
			'carousel',
			array(
				'label' => esc_html__( 'اسلایدر', 'mihanpress-elementor-addons' ),
			)
		);

		/**
		 * ------------------------------- Carousel Controls -------------------------------
		 */
		$this->carousel_controls( $this );

		$this->end_controls_section();

		/**
		 * ------------------------------- Template Tab -------------------------------
		 */

		$this->post_layout_section( $this );

		/**
		 * -------------------------------Thumbnail Tab -------------------------------
		 */
		$this->post_thumbnail_section( $this );

		/**
		 * ------------------------------- Metadata Tab -------------------------------
		 */
		$this->post_metadata_section( $this );

		/**
		 * ------------------------------- Style Tab -------------------------------
		 */
		$this->post_style_section( $this );

		/**
		 * ------------------------------- Carousel Nav Style Section -------------------------------
		 */
		$this->carousel_navigation_style_section( $this );
	}

	/**
	 * Render the widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section <?php echo $this->get_carousel_attributes( $this, $settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php

			$args  = $this->get_query_args( $settings );
			$query = new \WP_Query( $args );
			while ( $query->have_posts() ) {
				$query->the_post();

				$settings_output = $this->get_post_layout_variables( $this, $settings, false );
				if ( 'block' === $settings['post_layout'] ) {
					include plugin_dir_path( __FILE__ ) . 'posts/layouts/block.php';
				} elseif ( 'row' === $settings['post_layout'] ) {
					include plugin_dir_path( __FILE__ ) . 'posts/layouts/row.php';
				} else {
					include plugin_dir_path( __FILE__ ) . 'posts/layouts/image-card.php';
				}
			}
			/** Restore original Post Data */
			wp_reset_postdata();
			?>
		</section>

		<?php
	}
}
