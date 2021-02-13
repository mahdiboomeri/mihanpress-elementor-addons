<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Shape_BG {

	public function __construct() {
		add_action( 'elementor/element/section/section_background/after_section_end', array( $this, 'register_controls' ), 10, 2 );
		add_action( 'elementor/element/column/section_background/after_section_end', array( $this, 'register_controls' ), 10, 2 );

		add_action( 'elementor/frontend/section/before_render', array( $this, 'before_render' ), 99, 1 );
		add_action( 'elementor/frontend/column/before_render', array( $this, 'before_render' ), 99, 1 );

		add_action( 'elementor/section/print_template', array( $this, 'print_template' ), 10, 2 );
		add_action( 'elementor/column/print_template', array( $this, 'print_template' ), 10, 2 );

		add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ), 9 );
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'enqueue_scripts' ), 9 );
	}

	public function register_controls( $section, $section_id ) {
		$section->start_controls_section(
			'shape_bg_section',
			array(
				'label' => esc_html__( 'پس زمینه شکل گونه - میهن پرس', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$section->add_control(
			'shape_bg_switcher',
			array(
				'label'       => esc_html__( 'فعال کردن پس زمینه شکل گونه', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'label_block' => true,
				'label_on'    => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off'   => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
			)
		);
		$section->add_control(
			'shape_bg_type',
			array(
				'label'       => esc_html__( 'نوع', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'skew' => esc_html__( 'Skew', 'mihanpress-elementor-addons' ),
					'wave' => esc_html__( 'Waves', 'mihanpress-elementor-addons' ),
				),
				'render_type' => 'template',
				'default'     => 'skew',
				'condition'   => array(
					'shape_bg_switcher' => 'yes',
				),
			)
		);
		$section->add_responsive_control(
			'shape_bg_height',
			array(
				'label'      => esc_html__( 'ارتفاع', 'mihanpress-elementor-addons' ),
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
					'{{WRAPPER}} .skew-bg'         => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .waves-container' => 'height: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'shape_bg_switcher' => 'yes',
				),
			)
		);
		$section->end_controls_section();
	}

	public function before_render( $section ) {
		$settings = $section->get_settings();
		if ( isset( $settings['shape_bg_switcher'] ) && 'yes' === $settings['shape_bg_switcher'] ) {
			if ( 'skew' === $settings['shape_bg_type'] ) {
				$section->add_render_attribute( '_wrapper', 'data-skew-header', 'true' );
			} elseif ( 'wave' === $settings['shape_bg_type'] ) {
				$section->add_render_attribute( '_wrapper', 'data-waves-header', 'true' );
			}
		}
	}

	public function print_template( $template, $widget ) {
		if ( 'section' !== $widget->get_name() && 'column' !== $widget->get_name() ) {
			return $template;
		}
		$old_template = $template;
		ob_start();
		?>
		<# if( 'yes' == settings.shape_bg_switcher ) {

			if( 'skew' == settings.shape_bg_type ) {
				view.addRenderAttribute( 'shape_bg_data', 'data-skew-header', 'true' );
			} else if ( 'wave' == settings.shape_bg_type ) {
				view.addRenderAttribute( 'shape_bg_data', 'data-waves-header', 'true' );
			}
			#>
			<div {{{ view.getRenderAttributeString( 'shape_bg_data' ) }}}></div>
		<# } #>
		<?php
		$shape_bg_content = ob_get_contents();
		ob_end_clean();
		$template = $shape_bg_content . $old_template;
		return $template;
	}


	public function enqueue_scripts() {
		wp_enqueue_script( 'mihanpress-backend-elementor' );
	}
}
