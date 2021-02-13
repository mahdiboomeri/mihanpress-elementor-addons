<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main widegt class
 *
 * @since 1.4.0
 */
class Call_To_Action extends Widget_Base {

	use \MihanpressElementorAddons\Traits\Helper;

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.4.0
	 */
	public function get_name() {
		return 'mp-call-to-action';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.4.0
	 */
	public function get_title() {
		return esc_html__( 'المان Call to Action', 'mihanpress-elementor-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.4.0
	 */
	public function get_icon() {
		return 'eicon-call-to-action';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.4.0
	 */
	public function get_categories() {
		return array( 'mihanpress-category' );
	}

	/**
	 * Register the widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.4.0
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Call to Action', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'description',
			array(
				'label'              => esc_html__( 'توضیحات', 'mihanpress-elementor-addons' ),
				'type'               => Controls_Manager::WYSIWYG,
				'rows'               => 5,
				'frontend_available' => true,
				'default'            => esc_html__( 'تخفیف فوق العاده روی محصولات پرفروش', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'button_text',
			array(
				'label'     => esc_html__( 'متن دکمه', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => array(
					'active' => true,
				),
				'default'   => esc_html__( 'مشاهده محصولات', 'mihanpress-elementor-addons' ),
				'separator' => 'before',
			)
		);
		$this->add_control(
			'button_url',
			array(
				'label'       => esc_html__( 'لینک دکمه', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'mihanpress-elementor-addons' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);
		$this->add_control(
			'button_style',
			array(
				'label'     => esc_html__( 'استایل دکمه', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'custom',
				'options'   => $this->btn_classes(),
				'separator' => 'after',
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_style_box',
			array(
				'label' => esc_html__( 'باکس', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs(
			'box_tabs'
		);

		$this->start_controls_tab(
			'box_normal_tab',
			array(
				'label' => esc_html__( 'معمولی', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} .mp-call-to-action' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typo',
				'selector' => '{{WRAPPER}} .mp-call-to-action',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'box_bg',
				'label'          => esc_html__( 'پس زمینه باکس', 'mihanpress-elementor-addons' ),
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '{{WRAPPER}} .mp-call-to-action',
				'separator'      => 'before',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color'      => array(
						'default' => '#FD0043',
					),
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'box_shadow',
				'selector'  => '{{WRAPPER}} .mp-call-to-action',
				'separator' => 'before',
			)
		);
		$this->add_control(
			'box_radius',
			array(
				'label'      => esc_html__( 'گوشه های مدور', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mp-call-to-action' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'box_padding',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mp-call-to-action' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'box_hover_tab',
			array(
				'label' => esc_html__( 'هاور', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'text_color_hover',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} .mp-call-to-action:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typo_hover',
				'selector' => '{{WRAPPER}} .mp-call-to-action:hover',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'box_bg_hover',
				'label'          => esc_html__( 'پس زمینه باکس', 'mihanpress-elementor-addons' ),
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '{{WRAPPER}} .mp-call-to-action:hover',
				'separator'      => 'before',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'box_shadow_hover',
				'selector'  => '{{WRAPPER}} .mp-call-to-action:hover',
				'separator' => 'before',
			)
		);
		$this->add_control(
			'box_radius_hover',
			array(
				'label'      => esc_html__( 'گوشه های مدور', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mp-call-to-action:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'box_padding_hover',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mp-call-to-action:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/** ------------------------------------------------------------------ */

		$this->start_controls_section(
			'section_style_button',
			array(
				'label'     => esc_html__( 'دکمه', 'mihanpress-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'button_style' => 'custom',
				),
			)
		);

		$this->start_controls_tabs(
			'button_tabs'
		);

		$this->start_controls_tab(
			'button_normal_tab',
			array(
				'label' => esc_html__( 'معمولی', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} .mp-call-to-action .btn' => 'color: {{VALUE}};',
				),
				'default'   => '#FD0043',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_text_typo',
				'selector' => '{{WRAPPER}} .mp-call-to-action .btn',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'button_bg',
				'label'          => esc_html__( 'پس زمینه دکمه', 'mihanpress-elementor-addons' ),
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '{{WRAPPER}} .mp-call-to-action .btn',
				'separator'      => 'before',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color'      => array(
						'default' => '#FFFFFF',
					),
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'button_shadow',
				'selector'  => '{{WRAPPER}} .mp-call-to-action .btn',
				'separator' => 'before',
			)
		);
		$this->add_control(
			'button_radius',
			array(
				'label'      => esc_html__( 'گوشه های مدور', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mp-call-to-action .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'btn_padding',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mp-call-to-action .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover_tab',
			array(
				'label' => esc_html__( 'هاور', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'button_text_color_hover',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} .mp-call-to-action .btn:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_text_typo_hover',
				'selector' => '{{WRAPPER}} .mp-call-to-action .btn:hover',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'button_bg_hover',
				'label'          => esc_html__( 'پس زمینه دکمه', 'mihanpress-elementor-addons' ),
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '{{WRAPPER}} .mp-call-to-action .btn:hover',
				'separator'      => 'before',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'button_shadow_hover',
				'selector'  => '{{WRAPPER}} .mp-call-to-action .btn:hover',
				'separator' => 'before',
			)
		);
		$this->add_control(
			'button_radius_hover',
			array(
				'label'      => esc_html__( 'گوشه های مدور', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mp-call-to-action .btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'button_padding_hover',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mp-call-to-action .btn:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.4.0
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['button_url']['url'] ) ) {
			$this->add_render_attribute(
				'button',
				array(
					'href'   => esc_url( $settings['button_url']['url'] ),
					'target' => $settings['button_url']['is_external'] ? '_blank' : '_self',
					'rel'    => $settings['button_url']['nofollow'] ? 'nofollow' : 'follow',
				)
			);
		}
		$this->add_render_attribute( 'button', 'class', 'btn ' . $settings['button_style'] );

		get_template_part(
			'elements/call-to-action',
			null,
			array(
				'description'       => $settings['description'],
				'button_text'       => $settings['button_text'],
				'button_attributes' => $this->get_render_attribute_string( 'button' ),
			)
		);

	}

	/**
	 * Render the widget output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.4.0
	 */
	protected function _content_template() {
		?>
		<#
		if ( settings.button_url.url !== '' ) {
			view.addRenderAttribute(
				'button',
				{
					'href'   : settings.button_url.url,
					'target' : settings.button_url.is_external ? '_blank' : '_self',
					'rel'    : settings.button_url.nofollow ? 'nofollow' : 'follow',
				}
			);
		}
		view.addRenderAttribute( 'button', 'class', 'btn ' + settings.button_style );
		#>

		<div class="mp-call-to-action d-flex justify-content-between align-items-center flex-wrap">
			<div>
				{{{settings.description}}}
			</div>
			<div>
				<a {{{ view.getRenderAttributeString( 'button' ) }}}>
					{{{settings.button_text}}}
				</a>
			</div>
		</div>

		<?php
	}


}
