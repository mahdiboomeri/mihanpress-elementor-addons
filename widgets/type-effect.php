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
class Type_Effect extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'mp-type-effect';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return esc_html__( 'افکت تایپ', 'mihanpress-elementor-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 */
	public function get_icon() {
		return 'eicon-animation-text';
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
		return array( 'mihanpress-type-effect', 'mihanpress-backend-elementor' );
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
				'label' => esc_html__( 'متن', 'mihanpress-elementor-addons' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'افکت تایپ', 'mihanpress-elementor-addons' ),
			)
		);

		$this->add_control(
			'before_text',
			array(
				'label'       => esc_html__( 'متن قبل', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => esc_html__( 'قالب میهن پرس', 'mihanpress-elementor-addons' ),
				'placeholder' => esc_html__( 'متن خود را وارد کنید', 'mihanpress-elementor-addons' ),
				'label_block' => true,
			)
		);
		$this->add_control(
			'messages',
			array(
				'label'       => esc_html__( 'پیغام ها', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title' => esc_html__( 'سریع', 'mihanpress-elementor-addons' ),
					),
					array(
						'title' => esc_html__( 'منعطف', 'mihanpress-elementor-addons' ),
					),
					array(
						'title' => esc_html__( 'زیبا', 'mihanpress-elementor-addons' ),
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->add_control(
			'after_text',
			array(
				'label'       => esc_html__( 'متن بعد', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => esc_html__( 'متن خود را وارد کنید', 'mihanpress-elementor-addons' ),
				'label_block' => true,
			)
		);

		$this->add_responsive_control(
			'alignment',
			array(
				'label'       => esc_html__( 'ترازبندی', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => array(
					'right'  => array(
						'title' => esc_html__( 'راست', 'mihanpress-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					),
					'center' => array(
						'title' => esc_html__( 'وسط', 'mihanpress-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					),
					'left'   => array(
						'title' => esc_html__( 'چپ', 'mihanpress-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					),
				),
				'default'     => 'center',
				'selectors'   => array(
					'{{WRAPPER}} .type-effect' => 'text-align: {{VALUE}}',
				),
				'separator'   => 'before',
			)
		);

		$this->add_control(
			'tag',
			array(
				'label'   => esc_html__( 'تگ HTML', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
				'default' => 'h2',
			)
		);

		$this->add_control(
			'duration',
			array(
				'label'   => esc_html__( 'مدت زمان نمایش هر آیتم', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2000,
				'min'     => 100,
				'step'    => 100,
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			array(
				'label' => esc_html__( 'استایل', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .type-effect-heading' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .type-effect-text',
			)
		);

		$this->add_control(
			'heading_words_style',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'پیام های تایپ شده', 'mihanpress-elementor-addons' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'words_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .wrap' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'words_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .typewrite',
				'exclude'  => array( 'font_size' ),
			)
		);

		$this->add_control(
			'heading_caret',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'نشان گر', 'mihanpress-elementor-addons' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'caret',
			array(
				'label'     => esc_html__( 'رنگ نشان گر', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .caret' => 'background: {{VALUE}} !important',
				),
			)
		);
		$this->add_responsive_control(
			'width',
			array(
				'label'     => esc_html__( 'عرض', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 5,
				),
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 20,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .caret' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'height',
			array(
				'label'     => esc_html__( 'ارتفاع', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .caret' => 'height: {{SIZE}}{{UNIT}};',
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
		$tag      = $settings['tag'];
		$items    = $settings['messages'];

		$items_title = array();
		foreach ( $items as $item ) {
			$items_title[] = '"' . esc_html( $item['title'] ) . '"';
		}
		?>
		<div class="type-effect">
			<<?php echo esc_html( $tag ); ?> class="d-inline-block type-effect-heading type-effect-text"><?php echo esc_html( $settings['before_text'] ); ?></<?php echo esc_html( $tag ); ?>>
			<<?php echo esc_html( $tag ); ?> class="message d-inline-block">
				<a href="#" class="typewrite mr-3 type-effect-text" data-period="<?php echo esc_attr( $settings['duration'] ); ?>" data-type='[<?php echo implode( ',', $items_title ); ?>]'></a>
			</<?php echo esc_html( $tag ); ?>>
			<span class="caret"></span>
			<<?php echo esc_html( $tag ); ?> class="mr-3 d-inline-block type-effect-heading type-effect-text"><?php echo esc_html( $settings['after_text'] ); ?></<?php echo esc_html( $tag ); ?>>
		</div>
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
			var items=settings.messages; 
			var messages=[]; 
			items.forEach(item=> {
				messages.push('"' + item["title"] + '"');
			});
			var string_messages = messages.toString();
		#>
			<div class="type-effect">
				<{{{settings.tag}}} class="d-inline-block type-effect-heading type-effect-text">{{{settings.before_text}}}</{{{settings.tag}}}>
				<{{{settings.tag}}} class="message d-inline-block">
					<a href="#" class="typewrite mr-3 type-effect-text" data-period="{{{settings.duration}}}" data-type='[{{{string_messages}}}]'></a>
				</{{{settings.tag}}}>
				<span class="caret"></span>
				<{{{settings.tag}}} class="mr-3 d-inline-block type-effect-heading type-effect-text">{{{settings.after_text}}}</{{{settings.tag}}}>
			</div>
		<?php
	}
}
