<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Image_Extra {

	public function __construct() {
		add_action( 'elementor/element/image/section_image/after_section_end', array( $this, 'register_controls' ), 10, 2 );

		add_action( 'elementor/frontend/before_render', array( $this, 'before_render' ), 10, 1 );

		add_action( 'elementor/widget/print_template', array( $this, 'print_template' ), 10, 2 );
	}

	public function register_controls( $image, $image_id ) {
		$image->start_controls_section(
			'mp_vid_image_section',
			array(
				'label' => esc_html__( 'استایل ویديو - میهن پرس', 'mihanpress-elementor-addons' ),
			)
		);
		$image->add_control(
			'mp_enable_vid_style',
			array(
				'label'       => esc_html__( 'فعال کردن ', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'label_block' => false,
				'label_on'    => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off'   => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
			)
		);
		$image->end_controls_section();
	}

	public function before_render( $image ) {
		if ( 'image' !== $image->get_name() ) {
			return;
		}
		$settings = $image->get_settings();
		if ( $settings['mp_enable_vid_style'] === 'yes' ) {
			$image->add_render_attribute( 'wrapper', 'class', 'mp-video-style' );
		}
	}

	public function print_template( $template, $widget ) {
		if ( 'image' !== $widget->get_name() ) {
			return $template;
		}
		$old_template = $template;
		ob_start();
		?>
		<# if( 'yes'==settings.mp_enable_vid_style ) { 
			view.addRenderAttribute( 'mp_video_image_data' , 'class' , 'mp-video-style' ); 
		#>
			<div {{{ view.getRenderAttributeString( 'mp_video_image_data' ) }}}><a></a></div>
		<# } #>
		<?php
		$image_content = ob_get_contents();
		ob_end_clean();
		$template = $image_content . $old_template;

		return $template;
	}
}
