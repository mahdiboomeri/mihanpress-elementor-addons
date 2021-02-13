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
class Portfolio_Filter extends Widget_Base {

	use \MihanpressElementorAddons\Traits\Helper;

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'mp_portfolio_filter';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return esc_html__( 'فیلتر نمونه کارها', 'mihanpress-elementor-addons' );
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
		return 'eicon-gallery-grid';
	}

	/**
	 * Retrieve the list of widget scripts
	 *
	 * @since 1.0.0
	 */
	public function get_script_depends() {
		return array( 'mihanpress-mixitup-js', 'mihanpress-backend-elementor' );
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
				'label' => esc_html__( 'آیتم ها', 'mihanpress-elementor-addons' ),
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'      => esc_html__( 'اندازه هر آیتم', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .item-portfolio' => 'flex-basis: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'items_border_radius',
			array(
				'label'      => esc_html__( 'گردی آیتم ها', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'unit'      => 'px',
					'top'       => '15',
					'right'     => '15',
					'bottom'    => '15',
					'left'      => '15',
					'is_linked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .item-portfolio figure' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .item-portfolio figcaption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'items_padding',
			array(
				'label'      => esc_html__( 'فاصله بین آیتم ها', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .item-portfolio' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'overlay_effect',
			array(
				'label'       => esc_html__( 'افکت Overlay', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'options'     => $this->overlay_classes(),
				'default'     => 'fadeshow',
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'button_filter',
			array(
				'label' => esc_html__( 'فیلتر', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'tax_id',
			array(
				'label'   => esc_html__( 'نام Taxonomy', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_taxonomy_lists(),
				'default' => 'category',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'overlay_style',
			array(
				'label' => esc_html__( 'Overlay', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'overlay_bg_title',
			array(
				'type'  => Controls_Manager::HEADING,
				'label' => esc_html__( 'پس زمینه', 'mihanpress-elementor-addons' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'overlay_color',
				'label'          => esc_html__( 'پس زمینه Overlay', 'mihanpress-elementor-addons' ),
				'types'          => array( 'classic', 'gradient' ),
				'exclude'        => array( 'image' ),
				'selector'       => '{{WRAPPER}} .item-portfolio figcaption',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color'      => array(
						'default' => '#4a00e0',
					),
				),
			)
		);
		$this->add_control(
			'overlay_text_title',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'متن', 'mihanpress-elementor-addons' ),
				'separator' => 'before',
			)
		);
		$this->add_control(
			'overlay_text_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .item-portfolio figcaption' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'overlay_text_color_hover',
			array(
				'label'     => esc_html__( 'رنگ متن در صورت هاور', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .item-portfolio figcaption a:hover' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_overlay',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .item-portfolio figcaption h2',
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'buttons_style',
			array(
				'label' => esc_html__( 'دکمه ها', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'button_style_title',
			array(
				'type'  => Controls_Manager::HEADING,
				'label' => esc_html__( 'دکمه ها', 'mihanpress-elementor-addons' ),
			)
		);

		$this->start_controls_tabs(
			'filter_buttons_tabs'
		);

		$this->start_controls_tab(
			'normal_filter_tab',
			array(
				'label' => esc_html__( 'دکمه های معمولی', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'رنگ دکمه ها', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .filter' => 'background: {{VALUE}}',

				),
			)
		);
		$this->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'رنگ متن دکمه ها', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .filter' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'button_box_shadow',
				'label'     => esc_html__( 'سایه دکمه', 'mihanpress-elementor-addons' ),
				'selector'  => '{{WRAPPER}} .mixit-buttons .filter',
				'separator' => 'after',
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'active_filter_tab',
			array(
				'label' => esc_html__( 'دکمه فعال', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'button_active_color',
				'label'    => esc_html__( 'رنگ دکمه فعال', 'mihanpress-elementor-addons' ),
				'types'    => array( 'classic', 'gradient' ),
				'exclude'  => array( 'image' ),
				'selector' => '{{WRAPPER}} .filter.mixitup-control-active',
			)
		);
		$this->add_control(
			'button_active_text_color',
			array(
				'label'     => esc_html__( 'رنگ متن دکمه فعال', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .filter.mixitup-control-active' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_active_box_shadow',
				'label'    => esc_html__( 'سایه دکمه', 'mihanpress-elementor-addons' ),
				'selector' => '{{WRAPPER}} .mixit-buttons .mixitup-control-active',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'button_general_title',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'عمومی', 'mihanpress-elementor-addons' ),
				'separator' => 'before',
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'buttons_typo',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .filter',
				'separator' => 'before',
			)
		);
		$this->add_control(
			'margin_buttons',
			array(
				'label'     => esc_html__( 'فاصله بین دکمه ها', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 15,
				),
				'selectors' => array(
					'{{WRAPPER}} .filter' => 'margin: 0 {{SIZE}}{{UNIT}} 0 {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'margin_top_buttons',
			array(
				'label'     => esc_html__( 'فاصله دکمه ها با آیتم ها', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 15,
				),
				'selectors' => array(
					'{{WRAPPER}} .mixit-buttons' => 'margin: {{SIZE}}{{UNIT}} auto {{SIZE}}{{UNIT}} auto;',
				),
			)
		);
		$this->add_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'گردی دکمه ها', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		global $post;
		?>
		<section class="d-flex flex-column">
			<section class="mixit-buttons d-block">
				<button type="button" class="filter waves-light" data-filter="all"><?php esc_html_e( 'همه', 'mihanpress-elmentor-addons' ); ?></button>
				<?php
				$terms = get_terms( $settings['tax_id'] );
				$count = count( $terms );
				if ( $count > 0 ) {
					foreach ( $terms as $term ) {
						echo '<button type="button" class="filter" data-filter=".' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</button>';
					}
				}
				?>
			</section>
			<section class="d-flex flex-wrap portfolio mixportfolio">
				<?php
				$args  = $this->get_query_args( $settings );
				$query = new \WP_Query( $args );
				while ( $query->have_posts() ) {
					$query->the_post();
					$tax_list = '';
					$terms    = wp_get_post_terms( $post->ID, $settings['tax_id'] );
					$count    = count( $terms );
					if ( $count > 0 ) {
						foreach ( $terms as $term ) {
							$tax_list .= $term->slug . ' ';
						}
					}

					?>
					<article class="item-portfolio <?php echo esc_attr( $settings['overlay_effect'] ); ?> mix  <?php echo esc_attr( $tax_list ); ?>">
						<figure>
							<?php the_post_thumbnail(); ?>
							<figcaption>
								<a href="<?php the_permalink(); ?>">
									<h2> <?php the_title(); ?></h2>
								</a>
							</figcaption>
						</figure>
					</article>
					<?php
				}
				// Restore original Post Data
				wp_reset_postdata();
				?>
			</section>
		</section>
		<?php
	}
}
