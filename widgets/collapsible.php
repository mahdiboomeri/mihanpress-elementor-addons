<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main widegt class
 *
 * @since 1.0.0
 */
class Collapsible extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'mp-collapsible';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return esc_html__( 'آکوردئون', 'mihanpress-elementor-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 */
	public function get_icon() {
		return 'eicon-accordion';
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
	 * Retrieve the list of widget scripts
	 *
	 * @since 1.0.0
	 */
	public function get_script_depends() {
		return array( 'mihanpress-backend-elementor' );
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
			'title',
			array(
				'label'       => esc_html__( 'متن', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'desc',
			array(
				'label'              => esc_html__( 'توضیحات', 'mihanpress-elementor-addons' ),
				'type'               => Controls_Manager::WYSIWYG,
				'rows'               => 5,
				'frontend_available' => true,
			)
		);

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'آکوردئون', 'mihanpress-elementor-addons' ),
			)
		);

		$this->add_control(
			'collapsible_type',
			array(
				'label'   => esc_html__( 'نوع آکوردئون', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'accordion' => esc_html__( 'جمع شدنی', 'mihanpress-elementor-addons' ),
					'toggle'    => esc_html__( 'تغییر وضعیت', 'mihanpress-elementor-addons' ),
				),
				'default' => 'accordion',
			)
		);
		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'آیتم ها', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title' => esc_html__( 'عنوان شماره ۱', 'mihanpress-elementor-addons' ),
						'desc'  => esc_html__( 'توضیحات عنوان شماره ۱', 'mihanpress-elementor-addons' ),
					),
					array(
						'title' => esc_html__( 'عنوان شماره ۲', 'mihanpress-elementor-addons' ),
						'desc'  => esc_html__( 'توضیحات عنوان شماره ۲', 'mihanpress-elementor-addons' ),
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_collapsible_header',
			array(
				'label' => esc_html__( 'آکوردئون', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'collapsible_header_bg',
			array(
				'label'     => esc_html__( 'رنگ پس زمینه', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .collapsible-header' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'collapsible_header_bg_active',
			array(
				'label'     => esc_html__( 'رنگ پس زمینه فعال', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .active .collapsible-header' => 'background: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'collapsible_header_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .collapsible-header' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'collapsible_header_color_active',
			array(
				'label'     => esc_html__( 'رنگ متن فعال', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .active .collapsible-header' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'collapsible_header_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .collapsible-header',
			)
		);
		$this->add_control(
			'collapsible_header_padding',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .collapsible-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'header_border_width',
			array(
				'label'     => esc_html__( 'اندازه خط بیرونی', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 10,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .collapsible-header' => 'border: {{SIZE}}{{UNIT}} solid;',

				),
			)
		);

		$this->add_control(
			'header_border_color',
			array(
				'label'     => esc_html__( 'رنگ خط بیرونی', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .collapsible-header' => 'border-color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'collapsible_body_border_radius',
			array(
				'label'      => esc_html__( 'گوشه های مدور', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .collapsible-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_style_collapsible_body',
			array(
				'label' => esc_html__( 'محتوا', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'collapsible_body_bg',
			array(
				'label'     => esc_html__( 'رنگ پس زمینه', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .collapsible-body' => 'background: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'collapsible_body_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .collapsible-body' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'collapsible_body_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .collapsible-body',
			)
		);
		$this->add_control(
			'collapsible_body_padding',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .collapsible-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '15',
					'right'    => '15',
					'bottom'   => '15',
					'left'     => '15',
					'isLinked' => true,
				),
			)
		);
		$this->add_control(
			'content_border_width',
			array(
				'label'     => esc_html__( 'اندازه خط بیرونی', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 10,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .collapsible-body' => 'border: {{SIZE}}{{UNIT}} solid;',

				),
			)
		);

		$this->add_control(
			'content_border_color',
			array(
				'label'     => esc_html__( 'رنگ خط بیرونی', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .collapsible-body' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_collapsible_icon',
			array(
				'label' => esc_html__( 'آیکون', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'collapsible_icon_color',
			array(
				'label'     => esc_html__( 'رنگ آیکون', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .collapsible-header::after' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'collapsible_icon_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .collapsible-header::after',
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

		$is_accordion = '';
		if ( 'accordion' === $settings['collapsible_type'] ) {
			$is_accordion = 'is_accordion';
		}
		?>
		<ul class="collapsible mp-elementor-collapsible <?php echo esc_attr( $is_accordion ); ?>">
			<?php
			foreach ( $settings['items'] as $item ) :
				$item_id = ' elementor-repeater-item-' . $item['_id'];
				?>
				<li class="collapsible-wrap <?php echo esc_attr( $item_id ); ?>">
					<a class="collapsible-header"><?php echo esc_html( $item['title'] ); ?></a>
					<ul class="collapsible-body p-0">
						<div class="collapsible-content"><?php echo wp_kses_post( $item['desc'] ); ?></div>
					</ul>
				</li>
				<?php
			endforeach;
			?>
		</ul>
		<?php
	}

	/**
	 * Render the widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 */
	protected function _content_template() {
		?>
	<#
		var is_accordion = '';
		if (settings.collapsible_type === 'accordion') {
			is_accordion = 'is_accordion';
		}
	#>
		<ul class="collapsible mp-elementor-collapsible {{{is_accordion}}}">
			<#
			var items = settings.items;
			items.forEach(item => {
				var item_id = ' elementor-repeater-item-' + item._id;
			#>
				<li class="collapsible-wrap {{{item_id}}}">
					<a class="collapsible-header">{{{item.title}}}</a>
					<ul class="collapsible-body p-0">
						<div class="collapsible-content">{{{item.desc}}}</div>
					</ul>
				</li>
			<#
			});
			#>
		</ul>
		<?php
	}
}
