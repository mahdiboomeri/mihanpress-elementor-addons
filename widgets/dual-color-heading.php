<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main widegt class
 *
 * @since 1.0.0
 */
class Dual_Heading extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'mp-dual-heading';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return esc_html__( 'هدینگ دو رنگ', 'mihanpress-elementor-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 */
	public function get_icon() {
		return 'eicon-animated-headline';
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
	 * Register the widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_headings',
			array(
				'label' => esc_html__( 'هدینگ', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'before_heading_text',
			array(

				'label'   => esc_html__( 'متن قبل', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array(
					'active' => true,
				),
				'default' => esc_html__( 'متن قبل', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'second_heading_text',
			array(
				'label'   => esc_html__( 'متن هایلایت شده', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array(
					'active' => true,
				),
				'default' => esc_html__( 'هایلایت', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'after_heading_text',
			array(
				'label'   => esc_html__( 'متن بعد', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array(
					'active' => true,
				),
			)
		);
		$this->add_control(
			'heading_link',
			array(
				'label'       => esc_html__( 'لینک', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'mihanpress-elementor-addons' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);
		$this->add_control(
			'html_tag',
			array(
				'label'   => esc_html__( 'تگ', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1'   => esc_html__( 'H1', 'mihanpress-elementor-addons' ),
					'h2'   => esc_html__( 'H2', 'mihanpress-elementor-addons' ),
					'h3'   => esc_html__( 'H3', 'mihanpress-elementor-addons' ),
					'h4'   => esc_html__( 'H4', 'mihanpress-elementor-addons' ),
					'h5'   => esc_html__( 'H5', 'mihanpress-elementor-addons' ),
					'h6'   => esc_html__( 'H6', 'mihanpress-elementor-addons' ),
					'div'  => esc_html__( 'div', 'mihanpress-elementor-addons' ),
					'span' => esc_html__( 'span', 'mihanpress-elementor-addons' ),
					'p'    => esc_html__( 'p', 'mihanpress-elementor-addons' ),
				),
				'default' => 'h3',
			)
		);

		$this->add_responsive_control(
			'alignment',
			array(
				'label'     => esc_html__( 'ترازبندی', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'right'  => array(
						'title' => esc_html__( 'راست', 'mihanpress-elementor-addons' ),
						'icon'  => 'fa fa-align-right',
					),
					'center' => array(
						'title' => esc_html__( 'وسط', 'mihanpress-elementor-addons' ),
						'icon'  => 'fa fa-align-center',
					),
					'left'   => array(
						'title' => esc_html__( 'چپ', 'mihanpress-elementor-addons' ),
						'icon'  => 'fa fa-align-left',
					),
				),
				'default'   => 'right',
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-dual-color-heading' => 'text-align: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'box_spacing',
			array(
				'label'     => esc_html__( 'فاصله بین آیتم ها', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 10,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-dual-color-heading__second' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
				),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'heading_style',
			array(
				'label' => esc_html__( 'استایل', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'tabs_heading' );

		$this->start_controls_tab(
			'tab_heading',
			array(
				'label' => esc_html__( 'متن قبل و بعد', 'mihanpress-elementor-addons' ),
			)
		);

		$this->add_control(
			'first_heading_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-dual-color-heading__after-before' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'before_heading_text_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .mihanpress-dual-color-heading__after-before',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'heading_bg_color',
				'label'    => esc_html__( 'Background Color', 'mihanpress-elementor-addons' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .mihanpress-dual-color-heading__after-before',
			)
		);
		$this->add_responsive_control(
			'heading_padding',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-dual-color-heading__after-before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => 0,
					'bottom' => 0,
					'left'   => 0,
					'right'  => 0,
					'unit'   => 'px',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'heading_text_border',
				'label'       => esc_html__( 'Border', 'mihanpress-elementor-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .mihanpress-dual-color-heading__after-before',
			)
		);
		$this->add_control(
			'heading_border_radius',
			array(
				'label'      => esc_html__( 'گوشه های گرد', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-dual-color-heading__after-before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'dual_text_shadow',
				'selector' => '{{WRAPPER}} .mihanpress-dual-color-heading__after-before',
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_highlight',
			array(
				'label' => esc_html__( 'متن هایلایت', 'mihanpress-elementor-addons' ),
			)
		);

		$this->add_control(
			'second_heading_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-dual-color-heading__second' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'second_heading_text_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .mihanpress-dual-color-heading__second',
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'highlight_bg_color',
				'label'    => esc_html__( 'Background Color', 'mihanpress-elementor-addons' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .mihanpress-dual-color-heading__second',
			)
		);
		$this->add_responsive_control(
			'heading_highlight_padding',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => array(
					'top'    => 0,
					'bottom' => 0,
					'left'   => 0,
					'right'  => 0,
					'unit'   => 'px',
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-dual-color-heading__second' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'highlight_text_border',
				'label'       => esc_html__( 'Border', 'mihanpress-elementor-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .mihanpress-dual-color-heading__second',
			)
		);
		$this->add_control(
			'heading_highlight_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-dual-color-heading__second' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'dual_highlight_shadow',
				'selector' => '{{WRAPPER}} .mihanpress-dual-color-heading__second',
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
	 * @since 1.0.0
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$html_tag = $settings['html_tag'];
		if ( ! empty( $settings['heading_link']['url'] ) ) {
			$this->add_render_attribute(
				'heading_link',
				array(
					'href'   => esc_url( $settings['heading_link']['url'] ),
					'target' => $settings['heading_link']['is_external'] ? '_blank' : '_self',
					'rel'    => $settings['heading_link']['nofollow'] ? 'nofollow' : 'follow',
				)
			);

		}
		?>

		<a <?php echo $this->get_render_attribute_string( 'heading_link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<<?php echo $html_tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="mihanpress-dual-color-heading">
				<span class="mihanpress-dual-color-heading__after-before"><?php echo esc_html( $settings['before_heading_text'] ); ?></span>
				<span class="mihanpress-dual-color-heading__second"><?php echo esc_html( $settings['second_heading_text'] ); ?></span>
				<span class="mihanpress-dual-color-heading__after-before"><?php echo esc_html( $settings['after_heading_text'] ); ?></span>
			</<?php echo $html_tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		</a>

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
			if (settings.heading_link.url !=='' ) { 
				view.addRenderAttribute( 'duel-heading-link', {
					'href': settings.heading_link.url,
					'target': settings.heading_link.is_external !== '' ? '_blank' : '_self',
					'rel': settings.heading_link.nofollow !== '' ? 'nofollow' : 'follow',
				});
			}
			#>
			<a {{{ view.getRenderAttributeString( 'duel-heading-edit' ) }}}>
				<{{{settings.html_tag}}} class='mihanpress-dual-color-heading'>
					<span class="mihanpress-dual-color-heading__after-before">{{{settings.before_heading_text}}}</span>
					<span class="mihanpress-dual-color-heading__second">{{{settings.second_heading_text}}}</span>
					<span class="mihanpress-dual-color-heading__after-before">{{{settings.after_heading_text}}}</span>
				</{{{settings.html_tag}}}>
			</a>
		<?php
	}
}
