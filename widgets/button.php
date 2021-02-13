<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Button_Extra {

	public function __construct() {
		add_action( 'elementor/element/button/section_button/before_section_end', array( $this, 'buuton_options' ), 10, 2 );
	}

	public function buuton_options( $control_stack, $args ) {
		$control                                  = \Elementor\Plugin::instance()->controls_manager->get_control_from_stack( $control_stack->get_unique_name(), 'button_type' );
		$control['options']['mp-primary']         = esc_html__( 'پیشفرض (گرادینت)', 'mihanpress-addons' );
		$control['options']['mp-secondary']       = esc_html__( 'خاکستری (گرادینت)', 'mihanpress-addons' );
		$control['options']['mp-info']            = esc_html__( 'اطلاعات (گرادینت)', 'mihanpress-addons' );
		$control['options']['mp-success']         = esc_html__( 'موفق (گرادینت)', 'mihanpress-addons' );
		$control['options']['mp-warning']         = esc_html__( 'هشدار (گرادینت)', 'mihanpress-addons' );
		$control['options']['mp-danger']          = esc_html__( 'خطر (گرادینت)', 'mihanpress-addons' );
		$control['options']['mp-light']           = esc_html__( 'لایت', 'mihanpress-addons' );
		$control['options']['mp-dark']            = esc_html__( 'دارک', 'mihanpress-addons' );
		$control['options']['mp-outline-primary'] = esc_html__( 'Outline Primary', 'mihanpress-addons' );
		$control['options']['mp-outline-success'] = esc_html__( 'Outline Success', 'mihanpress-addons' );
		$control['options']['mp-outline-info']    = esc_html__( 'Outline Info', 'mihanpress-addons' );
		$control['options']['mp-outline-danger']  = esc_html__( 'Outline Danger', 'mihanpress-addons' );
		$control_stack->update_control( 'button_type', $control );
	}
}
