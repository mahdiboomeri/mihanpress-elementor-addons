<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main widegt class
 *
 * @since 1.3.0
 */
class Pie_Chart extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.3.0
	 */
	public function get_name() {
		return 'mp-pie-chart';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.3.0
	 */
	public function get_title() {
		return esc_html__( 'نوار پیشرفت دایره‌ای', 'mihanpress-elementor-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.3.0
	 */
	public function get_icon() {
		return 'eicon-counter-circle';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.3.0
	 */
	public function get_categories() {
		return array( 'mihanpress-category' );
	}

	/**
	 * Retrieve the list of widget scripts
	 *
	 * @since 1.3.0
	 */
	public function get_script_depends() {
		return array( 'mihanpress-pie-chart', 'mihanpress-backend-elementor' );
	}

	/**
	 * Register the widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.3.0
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'نوار پیشرفت دایره‌ای', 'mihanpress-elementor-addons' ),
			)
		);

		$this->add_control(
			'text',
			array(
				'label' => esc_html__( 'متن', 'mihanpress-elementor-addons' ),
				'type'  => Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'percentage',
			array(
				'label'   => esc_html__( 'میزان درصد', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 75,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
			)
		);
		$this->add_control(
			'linewidth',
			array(
				'label'   => esc_html__( 'اندازه خط', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 20,
				'step'    => 1,
			)
		);
		$this->add_control(
			'size',
			array(
				'label'   => esc_html__( 'اندازه دایره', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 150,
				'min'     => 150,
				'max'     => 500,
				'step'    => 1,
			)
		);
		$this->add_control(
			'linecap',
			array(
				'label'   => esc_html__( 'استایل خط', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'square' => esc_html__( 'Square', 'mihanpress-elementor-addons' ),
					'butt'   => esc_html__( 'Butt', 'mihanpress-elementor-addons' ),
					'round'  => esc_html__( 'Round', 'mihanpress-elementor-addons' ),
				),
				'default' => 'square',
			)
		);
		$this->add_control(
			'show_scale',
			array(
				'label'   => esc_html__( 'نمایش مقیاس', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_chart_style',
			array(
				'label' => esc_html__( 'استایل', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'color_a',
			array(
				'label'       => esc_html__( 'رنگ گرادینت ۱', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#27AB4A',
				'alpha'       => false,
				'render_type' => 'template',
			)
		);

		$this->add_control(
			'color_b',
			array(
				'label'       => esc_html__( 'رنگ گرادینت ۲', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#B5DBAB',
				'alpha'       => false,
				'render_type' => 'template',
			)
		);

		$this->add_control(
			'trackcolor',
			array(
				'label'       => esc_html__( 'رنگ دایره', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2f2f2',
				'alpha'       => false,
				'render_type' => 'template',
			)
		);

		$this->add_control(
			'scale_color',
			array(
				'label'       => esc_html__( 'رنگ مقیاس', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#dddddd',
				'condition'   => array(
					'show_scale' => 'yes',
				),
				'alpha'       => false,
				'render_type' => 'template',
				'seperator'   => 'after',
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-pie-chart__text' => 'color: {{VALUE}}',
				),
				'separator' => 'before',
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typo',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .mihanpress-pie-chart__text',
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.3.0
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$chart_data = array(
			'color_a'    => $settings['color_a'],
			'color_b'    => $settings['color_b'],
			'linewidth'  => $settings['linewidth'],
			'trackColor' => $settings['trackcolor'],
			'scalecolor' => 'yes' === $settings['show_scale'] ? $settings['scale_color'] : false,
			'size'       => $settings['size'],
			'lineCap'    => $settings['linecap'],
		);

		$this->add_render_attribute(
			'pie-chart',
			array(
				'data-percent' => $settings['percentage'],
				'data-chart'   => wp_json_encode( $chart_data ),
			)
		);

		get_template_part(
			'elements/pie-chart',
			null,
			array(
				'attributes' => $this->get_render_attribute_string( 'pie-chart' ),
				'text'       => $settings['text'],
			)
		);

	}

	/**
	 * Render the widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.3.0
	 */
	protected function _content_template() {
		?>
	<#
		var chart_data = {
			"color_a"    : settings.color_a,
			"color_b"    : settings.color_b,
			"linewidth"  : settings.linewidth,
			"trackColor" : settings.trackcolor,
			"scalecolor" : 'yes' === settings.show_scale ? settings.scale_color : false,
			"size"       : settings.size,
			"lineCap"    : settings.linecap,

		};
		var chart_data_string = JSON.stringify(chart_data);

		view.addRenderAttribute('pie-chart', 
		{
			"data-percent" : settings.percentage,
			"data-chart" : chart_data_string
		});
	#>
		<div class="mihanpress-pie-chart chart-hidden d-block text-center" {{{ view.getRenderAttributeString( 'pie-chart' ) }}}>
			<span class="mihanpress-pie-chart__text">
				{{{ settings.text }}}
			</span>
		</div>
		<?php
	}


}
