<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Particles {

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
			'mp_particles_section',
			array(
				'label' => esc_html__( 'افکت ذره ها - میهن پرس', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$section->add_control(
			'mp_enable_particles',
			array(
				'label'       => esc_html__( 'فعال کردن افکت ', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'label_block' => true,
				'label_on'    => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off'   => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
			)
		);
		$section->add_responsive_control(
			'mp_particles_particles',
			array(
				'label'      => esc_html__( 'ارتفاع', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => '%',
					'size' => '100',
				),
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
					'{{WRAPPER}} .mp-particle-container' => 'height: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'mp_enable_particles' => 'yes',
				),
			)
		);
		$section->add_control(
			'mp_particles_color',
			array(
				'label'       => esc_html__( 'رنگ ذره ها', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#000000',
				'condition'   => array(
					'mp_enable_particles' => 'yes',
				),
				'alpha'       => false,
				'render_type' => 'template',
			)
		);
		$section->add_control(
			'mp_particles_number',
			array(
				'label'       => esc_html__( 'تعداد ذره ها', 'mihanpress-elementor-addons' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 5,
				'max'         => 500,
				'step'        => 1,
				'condition'   => array(
					'mp_enable_particles' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$section->add_control(
			'mp_particles_size',
			array(
				'label'       => esc_html__( 'اندازه ذره ها', 'mihanpress-elementor-addons' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 10,
				'step'        => 1,
				'condition'   => array(
					'mp_enable_particles' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$section->add_control(
			'mp_particles_speed',
			array(
				'label'       => esc_html__( 'سرعت ذره ها', 'mihanpress-elementor-addons' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 20,
				'step'        => 1,
				'condition'   => array(
					'mp_enable_particles' => 'yes',
				),
				'render_type' => 'template',
			)
		);
		$section->add_control(
			'mp_enable_links',
			array(
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'تعامل ذره ها با هم', 'mihanpress-elementor-addons' ),
				'default'      => 'no',
				'label_on'     => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off'    => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
				'return_value' => 'yes',
				'condition'    => array(
					'mp_enable_particles' => 'yes',
				),
				'render_type'  => 'template',
				'separator'    => 'before',
			)
		);
		$section->add_control(
			'mp_color_links',
			array(
				'label'       => esc_html__( 'رنگ اتصال ها', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#000000',
				'condition'   => array(
					'mp_enable_links'     => 'yes',
					'mp_enable_particles' => 'yes',
				),
				'alpha'       => false,
				'render_type' => 'template',
			)
		);
		$section->add_control(
			'mp_enable_opacity_anim',
			array(
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'چشمک زدن', 'mihanpress-elementor-addons' ),
				'default'      => 'no',
				'label_on'     => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off'    => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
				'return_value' => 'yes',
				'condition'    => array(
					'mp_enable_particles' => 'yes',
				),
				'render_type'  => 'template',
				'separator'    => 'before',
			)
		);

		$section->end_controls_section();
	}

	public function before_render( $section ) {
		$settings = $section->get_settings();
		if ( isset( $settings['mp_enable_particles'] ) && 'yes' === $settings['mp_enable_particles'] ) {
			wp_enqueue_script( 'mihanpress-particles' );
			$json = array(
				'particles'     => array(
					'number'      => array(
						'value' => $settings['mp_particles_number'] ? intval( $settings['mp_particles_number'] ) : 100,
					),
					'color'       => array(
						'value' => empty( $settings['mp_particles_color'] ) ? '#000000' : $settings['mp_particles_color'],
					),
					'shape'       => array(
						'type' => 'circle',
					),
					'opacity'     => array(
						'value'  => .5,
						'random' => false,
						'anim'   => array(
							'enable'      => 'yes' === $settings['mp_enable_opacity_anim'] ? true : false,
							'speed'       => 1,
							'opacity_min' => 0,
							'sync'        => false,
						),
					),
					'size'        => array(
						'value'  => $settings['mp_particles_size'] ? intval( $settings['mp_particles_size'] ) : 4,
						'random' => true,
					),
					'line_linked' => array(
						'enable'   => $settings['mp_enable_links'] === 'yes' ? true : false,
						'distance' => 150,
						'color'    => empty( $settings['mp_color_links'] ) ? '#000000' : $settings['mp_color_links'],
						'opacity'  => 0.4,
						'width'    => 1,
					),
					'move'        => array(
						'enable' => true,
						'speed'  => $settings['mp_particles_speed'] ? intval( $settings['mp_particles_speed'] ) : 3,
					),
				),
				'interactivity' => array(
					'detect_on' => 'canvas',
					'events'    => array(
						'onhover' => array(
							'enable' => true,
							'mode'   => 'grab',
						),
						'onclick' => array(
							'enable' => false,
						),
						'resize'  => true,
					),
				),
				'retina_detect' => true,
			);
			$section->add_render_attribute( '_wrapper', 'class', 'mp-particles-js' );
			$section->add_render_attribute( '_wrapper', 'data-particles', json_encode( $json ) );
		}
	}

	public function print_template( $template, $widget ) {
		if ( $widget->get_name() !== 'section' && $widget->get_name() !== 'column' ) {
			return $template;
		}
		$old_template = $template;
		ob_start();
		?>
		<# if( 'yes'==settings.mp_enable_particles ) { var the_numbers=settings.mp_particles_number !="" ? parseInt(settings.mp_particles_number) : 100; var color=settings.mp_particles_color==="" ? "#000000" : settings.mp_particles_color; var opacity_anim=settings.mp_enable_opacity_anim==="yes" ? true : false; var particles_size=settings.mp_particles_size !="" ? parseInt(settings.mp_particles_size) : 4; var is_linked=settings.mp_enable_links==="yes" ? true : false; var link_color=settings.mp_color_links==="" ? "#000000" : settings.mp_color_links; var speed=settings.mp_particles_speed !="" ? parseInt(settings.mp_particles_speed) : 3; var json='{"particles":{"number":{"value":' +the_numbers+'},"color":{"value":"'+color+'"},"shape":{"type":"circle"},"opacity":{"value":0.5,"random":false,"anim":{"enable":'+opacity_anim+',"speed":1,"opacity_min":0,"sync":false}},"size":{"value":'+particles_size+',"random":true},"line_linked":{"enable":'+is_linked+',"distance":150,"color":"'+link_color+'","opacity":0.4,"width":1},"move":{"enable":true,"speed":'+speed+'}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"grab"},"onclick":{"enable":false},"resize":true}},"retina_detect":true}'; view.addRenderAttribute( 'mp_paricles_data' , 'class' , 'mp-particles-js' ); view.addRenderAttribute( 'mp_paricles_data' , 'data-particles' , json ); #>
			<div {{{ view.getRenderAttributeString( 'mp_paricles_data' ) }}}></div>
			<# } #>
		<?php
		$particles_content = ob_get_contents();
		ob_end_clean();
		$template = $particles_content . $old_template;
		return $template;
	}


	public function enqueue_scripts( $section ) {
		wp_enqueue_script( 'mihanpress-backend-elementor' );

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_enqueue_script( 'mihanpress-particles' );
		}
	}
}
