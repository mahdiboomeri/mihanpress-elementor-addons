<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main widegt class
 *
 * @since 1.0.0
 */
class Static_Posts extends Widget_Base {

	use \MihanpressElementorAddons\Traits\Helper;

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'mp_static_posts';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return esc_html__( 'پست های استاتیک', 'mihanpress-elementor-addons' );
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
		} elseif ( $this->get_settings_for_display( 'masonry' ) === 'yes' ) {
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
		$repeater = new Repeater();

		$repeater->add_control(
			'thumbnail',
			array(
				'label'   => esc_html__( 'تصویر پست', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => array(
					'active' => true,
				),
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);
		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'عنوان', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'excerpt',
			array(
				'label'              => esc_html__( 'توضیحات', 'mihanpress-elementor-addons' ),
				'type'               => Controls_Manager::WYSIWYG,
				'rows'               => 5,
				'frontend_available' => true,
			)
		);
		$repeater->add_control(
			'after_title',
			array(
				'label'       => esc_html__( 'متن بعد از عنوان', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'post_link',
			array(
				'label'         => __( 'لینک پست', 'mihanpress-elementor-addons' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => 'https://your-link.com',
				'show_external' => true,
				'default'       => array(
					'url'         => '',
					'is_external' => true,
					'nofollow'    => false,
				),
			)
		);
		$repeater->add_control(
			'class',
			array(
				'label'       => esc_html__( 'کلاس های CSS', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'label_block' => true,
			)
		);

		/**
		 * ------------------------------- Template Tab -------------------------------
		 */

		$this->post_layout_section( $this );

		/**
		 * ------------------------------- Items Tab -------------------------------
		 */

		$this->start_controls_section(
			'section_post_items',
			array(
				'label' => esc_html__( 'پست ها', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'post_items',
			array(
				'label'       => esc_html__( 'آیتم ها', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'title'       => esc_html__( 'نام پست', 'mihanpress-elementor-addons' ),
						'after_title' => esc_html__( 'متن بعد از عنوان', 'mihanpress-elementor-addons' ),
					),
					array(
						'title'       => esc_html__( 'نام پست', 'mihanpress-elementor-addons' ),
						'after_title' => esc_html__( 'متن بعد از عنوان', 'mihanpress-elementor-addons' ),
					),
					array(
						'title'       => esc_html__( 'نام پست', 'mihanpress-elementor-addons' ),
						'after_title' => esc_html__( 'متن بعد از عنوان', 'mihanpress-elementor-addons' ),
					),
				),

			)
		);

		$this->end_controls_section();

		/**
		 * -------------------------------Thumbnail Tab -------------------------------
		 */
		$this->post_thumbnail_section( $this );

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

		?>
		<section <?php echo $this->get_render_attribute_string( 'wrapper' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
			foreach ( $settings['post_items'] as $post_item ) {
				$settings_output = $this->get_post_layout_variables( $this, $settings, $post_item );

				if ( 'block' === $settings['post_layout'] ) {
					include __DIR__ . '/layouts/block.php';
				} elseif ( 'row' === $settings['post_layout'] ) {
					include __DIR__ . '/layouts/row.php';
				} else {
					include __DIR__ . '/layouts/image-card.php';
				}
			}
			?>
		</section>
		<?php
	}
}
