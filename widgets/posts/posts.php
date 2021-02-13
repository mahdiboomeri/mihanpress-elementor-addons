<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main widegt class
 *
 * @since 1.0.0
 */
class Posts extends Widget_Base {

	use \MihanpressElementorAddons\Traits\Helper;

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'mp_posts';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return esc_html__( 'پست ها', 'mihanpress-elementor-addons' );
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
		return 'eicon-post-list';
	}

	/**
	 * Retrieve the list of widget scripts
	 *
	 * @since 1.0.0
	 */
	public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			return array( 'mihanpress-masonry', 'mihanpress-backend-elementor' );
		} elseif ( 'yes' === $this->get_settings_for_display( 'masonry' ) ) {
			return array( 'mihanpress-masonry', 'mihanpress-backend-elementor' );
		} else {
			return array();
		}
	}

	/**
	 * Register the widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 */
	protected function _register_controls() {
		/**
		 * ------------------------------- Template Tab -------------------------------
		 */

		$this->post_layout_section( $this );

		/**
		 * ------------------------------- Query Tab -------------------------------
		 */
		$this->query_section( $this );

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
	}

	/**
	 * Render the widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 */
	protected function render() {
		global $mihanpress_options;

		$settings = $this->get_settings_for_display();

		if ( 'yes' === $settings['masonry'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-masonry-grid' );
			$this->add_render_attribute( 'wrapper', 'data-column', $settings['post_column_grid'] );
			$this->add_render_attribute( 'wrapper', 'data-column-tablet', $settings['post_column_grid_tablet'] );
			$this->add_render_attribute( 'wrapper', 'data-column-mobile', $settings['post_column_grid_mobile'] );
		} else {
			$this->add_render_attribute( 'wrapper', 'class', 'd-flex flex-wrap' );
		}

		if ( 'yes' === $settings['show_pagination'] ) {
			$settings['pagination_hash'] = 'paged' . $id = $this->get_id();
			$current_paged               = isset( $_GET[ $settings['pagination_hash'] ] ) ? sanitize_text_field( wp_unslash( intval( $_GET[ $settings['pagination_hash'] ] ) ) ) : 1;
		}

		?>
		<section <?php echo $this->get_render_attribute_string( 'wrapper' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
			$args  = $this->get_query_args( $settings );
			$query = new \WP_Query( $args );
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) :
					$query->the_post();

					$settings_output = $this->get_post_layout_variables( $this, $settings, false );

					if ( 'block' === $settings['post_layout'] ) {
						include __DIR__ . '/layouts/block.php';
					} elseif ( 'row' === $settings['post_layout'] ) {
						include __DIR__ . '/layouts/row.php';
					} else {
						include __DIR__ . '/layouts/image-card.php';
					}
				endwhile;

			endif;

			if ( 'yes' === $settings['show_pagination'] ) {
				$pagination = array(
					'format'  => '?' . $settings['pagination_hash'] . '=%#%',
					'current' => $current_paged,
					'total'   => $query->max_num_pages,
				);

				if ( paginate_links( $pagination ) ) :
					?>

					<div class="d-flex paginate-links flex-wrap justify-content-center mt-3">
						<?php echo paginate_links( $pagination ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>

					<?php
				endif;
			}

			/** Restore original Post Data */
			wp_reset_postdata();
			?>
		</section>
		<?php
	}
}
