<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main widegt class
 *
 * @since 1.0.0
 */
class Countdown extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'mp-countdown';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return esc_html__( 'شمارشگر معکوس', 'mihanpress-elementor-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 */
	public function get_icon() {
		return 'eicon-countdown';
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
		return array( 'mihanpress-countdown', 'mihanpress-backend-elementor' );
	}

	/**
	 * Register the widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'شمارشگر معکوس', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'date',
			array(
				'label'       => esc_html__( 'تاریخ', 'mihanpress-elementor-addons' ),
				'type'        => \Elementor\Controls_Manager::DATE_TIME,
				'default'     => date( 'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
				/* translators: %s: Time zone. */
				'description' => sprintf( __( 'تاریخ بر اساس منطقه زمانی شما: %s.', 'mihanpress-elementor-addons' ), Utils::get_timezone_string() ),
			)
		);

		$this->add_control(
			'label_display',
			array(
				'label'   => esc_html__( 'استایل', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'block'  => esc_html__( 'Block', 'mihanpress-elementor-addons' ),
					'inline' => esc_html__( 'Inline', 'mihanpress-elementor-addons' ),
				),
				'default' => 'block',
			)
		);

		$this->add_control(
			'show_days',
			array(
				'label'   => esc_html__( 'روز', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_hours',
			array(
				'label'   => esc_html__( 'ساعت', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_minutes',
			array(
				'label'   => esc_html__( 'دقیقه', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_seconds',
			array(
				'label'   => esc_html__( 'ثانیه', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_labels',
			array(
				'label'     => esc_html__( 'نمایش لیبل ها', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'custom_labels',
			array(
				'label'     => esc_html__( 'لیبل های سفارشی', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'show_labels!' => '',
				),
			)
		);

		$this->add_control(
			'label_days',
			array(
				'label'       => esc_html__( 'روز', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'روز', 'mihanpress-elementor-addons' ),
				'placeholder' => esc_html__( 'روز', 'mihanpress-elementor-addons' ),
				'condition'   => array(
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_days'      => 'yes',
				),
			)
		);

		$this->add_control(
			'label_hours',
			array(
				'label'       => esc_html__( 'ساعت', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'ساعت', 'mihanpress-elementor-addons' ),
				'placeholder' => esc_html__( 'ساعت', 'mihanpress-elementor-addons' ),
				'condition'   => array(
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_days'      => 'yes',
				),
			)
		);

		$this->add_control(
			'label_minutes',
			array(
				'label'       => esc_html__( 'دقیقه', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'دقیقه', 'mihanpress-elementor-addons' ),
				'placeholder' => esc_html__( 'دقیقه', 'mihanpress-elementor-addons' ),
				'condition'   => array(
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_days'      => 'yes',
				),
			)
		);

		$this->add_control(
			'label_seconds',
			array(
				'label'       => esc_html__( 'ثانیه', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'ثانیه', 'mihanpress-elementor-addons' ),
				'placeholder' => esc_html__( 'ثانیه', 'mihanpress-elementor-addons' ),
				'condition'   => array(
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_days'      => 'yes',
				),
			)
		);

		$this->add_control(
			'expire_actions',
			array(
				'label'       => esc_html__( 'بعد از صفر شدن شمارشگر', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => array(
					'redirect' => esc_html__( 'ریدایرکت به صفحه دیگر', 'mihanpress-elementor-addons' ),
					'hide'     => esc_html__( 'پنهان کردن', 'mihanpress-elementor-addons' ),
					'message'  => esc_html__( 'نمایش پیغام', 'mihanpress-elementor-addons' ),
				),
				'label_block' => true,
				'separator'   => 'before',
				'render_type' => 'none',
				'multiple'    => true,
			)
		);
		$this->add_control(
			'message_after_expire',
			array(
				'label'       => esc_html__( 'پیغام', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'separator'   => 'before',
				'dynamic'     => array(
					'active' => true,
				),
				'condition'   => array(
					'expire_actions' => 'message',
				),
			)
		);

		$this->add_control(
			'expire_redirect_url',
			array(
				'label'       => esc_html__( 'آدرس ریدایرکت', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'separator'   => 'before',
				'dynamic'     => array(
					'active' => true,
				),
				'condition'   => array(
					'expire_actions' => 'redirect',
				),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_box_style',
			array(
				'label' => esc_html__( 'باکس', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'container_width',
			array(
				'label'          => esc_html__( 'عرض هر باکس', 'mihanpress-elementor-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => array(
					'unit' => '%',
					'size' => 25,
				),
				'tablet_default' => array(
					'unit' => '%',
				),
				'mobile_default' => array(
					'unit' => '%',
				),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 2000,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'size_units'     => array( '%', 'px' ),
				'selectors'      => array(
					'{{WRAPPER}} .mihanpress-countdown-item' => 'flex-basis: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'box_background_color',
			array(
				'label'     => esc_html__( 'رنگ پس زمینه', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'default'   => '#D5D5D5',
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-countdown-inner' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'box_border',
				'selector'  => '{{WRAPPER}} .mihanpress-countdown-inner',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'box_border_radius',
			array(
				'label'      => esc_html__( 'گوشه های گرد', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-countdown-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'box_spacing',
			array(
				'label'     => esc_html__( 'فاصله بین آیتم ها', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'body:not(.rtl) {{WRAPPER}} .mihanpress-countdown-item:not(:first-of-type)' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body:not(.rtl) {{WRAPPER}} .mihanpress-countdown-item:not(:last-of-type)' => 'padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .mihanpress-countdown-item:not(:first-of-type)' => 'padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .mihanpress-countdown-item:not(:last-of-type)' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 );',
				),
			)
		);

		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-countdown-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'box_box_shadow',
				'selector'  => '{{WRAPPER}} .mihanpress-countdown-inner',
				'separator' => 'before',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			array(
				'label' => esc_html__( 'محتوا', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_digits',
			array(
				'label' => esc_html__( 'عددها', 'mihanpress-elementor-addons' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'digits_color',
			array(
				'label'     => esc_html__( 'رنگ', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-countdown-digits' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'digits_typography',
				'selector' => '{{WRAPPER}} .mihanpress-countdown-digits',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);

		$this->add_control(
			'heading_label',
			array(
				'label'     => esc_html__( 'لیبل', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'label_color',
			array(
				'label'     => esc_html__( 'رنگ', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-countdown-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .mihanpress-countdown-label',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_expire_message_style',
			array(
				'label'     => esc_html__( 'پیغام بعد از اتمام شمارشگر', 'mihanpress-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'expire_actions' => 'message',
				),
			)
		);

		$this->add_responsive_control(
			'align',
			array(
				'label'       => esc_html__( 'ترازبندی', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => array(
					'left'   => array(
						'title' => esc_html__( 'چپ', 'mihanpress-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'وسط', 'mihanpress-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'راست', 'mihanpress-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} .mihanpress-countdown__message' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-countdown__message' => 'color: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
			)
		);
		$this->add_control(
			'message_bg',
			array(
				'label'     => esc_html__( 'رنگ پس زمینه', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-countdown__message' => 'background-color: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .mihanpress-countdown__message',
			)
		);

		$this->add_responsive_control(
			'message_padding',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-countdown__message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'message_margin',
			array(
				'label'      => esc_html__( 'Margin', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-countdown__message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'message_border_radius',
			array(
				'label'      => esc_html__( 'گوشه های گرد', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-countdown__message' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'message_box_shadow',
				'selector'  => '{{WRAPPER}} .mihanpress-countdown__message',
				'separator' => 'before',
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

		$countdown_data = array(
			'date'     => $settings['date'],
			'labels'   => array(
				'days'    => 'yes' === $settings['custom_labels'] ? $settings['label_days'] : esc_html__( 'روز', 'mihanpress-elementor-addons' ),
				'hours'   => 'yes' === $settings['custom_labels'] ? $settings['label_hours'] : esc_html__( 'ساعت', 'mihanpress-elementor-addons' ),
				'minutes' => 'yes' === $settings['custom_labels'] ? $settings['label_minutes'] : esc_html__( 'دقیقه', 'mihanpress-elementor-addons' ),
				'seconds' => 'yes' === $settings['custom_labels'] ? $settings['label_seconds'] : esc_html__( 'ثانیه', 'mihanpress-elementor-addons' ),
			),
			'redirect' => array(
				'enable' => ( ! empty( $settings['expire_actions'] ) && in_array( 'redirect', $settings['expire_actions'], true ) ) ? true : false,
				'url'    => esc_url( $settings['expire_redirect_url'] ),
			),
			'message'  => array(
				'enable'  => ( ! empty( $settings['expire_actions'] ) && in_array( 'message', $settings['expire_actions'], true ) ) ? true : false,
				'content' => $settings['message_after_expire'],
			),
			'hide'     => array(
				'enable' => ( ! empty( $settings['expire_actions'] ) && in_array( 'hide', $settings['expire_actions'], true ) ) ? true : false,
			),
		);

		$show_labels  = 'yes' === $settings['show_labels'] ? '' : 'hide-labels';
		$show_days    = 'yes' === $settings['show_days'] ? '' : 'hide-days';
		$show_hours   = 'yes' === $settings['show_hours'] ? '' : 'hide-hours';
		$show_minutes = 'yes' === $settings['show_minutes'] ? '' : 'hide-min';
		$show_seconds = 'yes' === $settings['show_seconds'] ? '' : 'hide-sec';
		$display_item = 'yes' === $settings['label_display'] ? 'd-flex' : 'd-inline-flex';

		$this->add_render_attribute(
			'countdown',
			array(
				'class'          => 'timer mp-countdown flex-row-reverse flex-wrap ' . $display_item . ' ' . $show_labels . ' ' . $show_days . ' ' . $show_hours . ' ' . $show_minutes . ' ' . $show_seconds,
				'data-countdown' => wp_json_encode( $countdown_data ),
			)
		);
		?>

		<div <?php echo $this->get_render_attribute_string( 'countdown' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></div>

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
		var countdown_data = {
			"date" : settings.date,
			"labels" : {
				"days" : settings.custom_labels === 'yes' ? settings.label_days : "روز",
				"hours" : settings.custom_labels === 'yes' ? settings.label_hours :"ساعت",
				"minutes" : settings.custom_labels === 'yes' ? settings.label_minutes : "دقیقه",
				"seconds" : settings.custom_labels === 'yes' ? settings.label_seconds : "ثانیه"
			},
			"redirect" : {
				"enable" : false
			},
			"message" : {
				"enable" : (settings.expire_actions !== '' && settings.expire_actions.includes('message')) ? true : false,
				"content" : settings.message_after_expire
			},
			"hide" : {
				"enable" : (settings.expire_actions !== '' && settings.expire_actions.includes('hide')) ? true : false,
			},
		};
		var countdown_string = JSON.stringify(countdown_data);

		var show_labels = settings.show_labels === 'yes' ? '' : 'hide-labels';
		var show_days = settings.show_days === 'yes' ? '' : 'hide-days';
		var show_hours = settings.show_hours === 'yes' ? '' : 'hide-hours';
		var show_minutes = settings.show_minutes === 'yes' ? '' : 'hide-min';
		var show_seconds = settings.show_seconds === 'yes' ? '' : 'hide-sec';
		var display_item = settings.label_display === 'block' ? 'd-flex' : 'd-inline-flex';

		view.addRenderAttribute('countdown', 
		{
			"class" : 'timer mihanpress-countdown flex-row-reverse flex-wrap ' + display_item + ' ' + show_labels + ' ' + show_days + ' ' + show_hours + ' ' + show_minutes + ' ' + show_seconds,
			"data-countdown" : countdown_string
		});
	#>
		<div {{{ view.getRenderAttributeString( 'countdown' ) }}}></div>
		<?php
	}
}
