<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Box_Shadow;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main widegt class
 *
 * @since 1.0.0
 */
class Information_Boxes extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'mp_information_boxes';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return esc_html__( 'باکس های اطلاعات', 'mihanpress-elementor-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
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
		$repeater = new Repeater();
		$repeater->add_control(
			'icon_or_image',
			array(
				'label'   => esc_html__( 'نوع آیکون', 'mihanpress-elementor-addons' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'icon',
				'options' => array(
					'icon'  => array(
						'title' => esc_html__( 'آیکون', 'mihanpress-elementor-addons' ),
						'icon'  => 'eicon-favorite',
					),
					'image' => array(
						'title' => esc_html__( 'تصویر', 'mihanpress-elementor-addons' ),
						'icon'  => 'eicon-image',
					),

				),
			)
		);

		$repeater->add_control(
			'icon',
			array(
				'label'       => esc_html__( 'آیکون', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => array(
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'icon_or_image' => 'icon',
				),
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'     => esc_html__( 'گزینش تصویر', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => array(
					'active' => true,
				),
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'icon_or_image' => 'image',
				),
			)
		);

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
				'type'               => Controls_Manager::TEXTAREA,
				'rows'               => 5,
				'frontend_available' => true,
			)
		);
		$repeater->add_control(
			'background',
			array(
				'label'   => esc_html__( 'رنگ', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'btn-info',
				'options' => array(
					'btn-info'    => esc_html__( 'آبی', 'mihanpress-elementor-addons' ),
					'btn-success' => esc_html__( 'سبز', 'mihanpress-elementor-addons' ),
					'btn-danger'  => esc_html__( 'قرمز', 'mihanpress-elementor-addons' ),
					'btn-dark'    => esc_html__( 'دارک', 'mihanpress-elementor-addons' ),
					'custom'      => esc_html__( 'سفارشی', 'mihanpress-elementor-addons' ),
				),
			)
		);

		$repeater->add_control(
			'box_bg',
			array(
				'label'     => esc_html__( 'رنگ پس زمینه', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'background' => 'custom',
				),
			)
		);
		$repeater->add_control(
			'box_custom_text_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'background' => 'custom',
				),
			)
		);
		$repeater->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'box_box_shadow',
				'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'separator' => 'before',
				'condition' => array(
					'background' => 'custom',
				),
			)
		);

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'خدمات', 'mihanpress-elementor-addons' ),
			)
		);

		$this->add_control(
			'info_items',
			array(
				'label'       => esc_html__( 'آیتم ها', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title' => esc_html__( 'عنوان آزمایشی', 'mihanpress-elementor-addons' ),
						'desc'  => esc_html__( 'توضیحات آزمایشی', 'mihanpress-elementor-addons' ),
					),

				),
				'title_field' => '{{{ title }}}',

			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'              => esc_html__( 'تعداد ستون ها', 'mihanpress-elementor-addons' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => '4',
				'tablet_default'     => '3',
				'mobile_default'     => '2',
				'options'            => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
				'frontend_available' => true,
				'selectors'          => array(
					'{{WRAPPER}} .info-box-wrap' => 'width: calc( 100% / {{SIZE}} )',
				),
			)
		);
		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'ظاهر', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'box',
				'options' => array(
					'classic' => 'کلاسیک',
					'box'     => 'جعبه',
				),
			)
		);
		$this->add_responsive_control(
			'padding',
			array(
				'label'     => esc_html__( 'فاصله میان آیتم ها', 'mihanpress-elementor-addons' ),
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
					'{{WRAPPER}} .info-box-wrap' => 'padding: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'icon-align',
			array(
				'label'     => esc_html__( 'موقعیت آیکون', 'mihanpress-elementor-addons' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'toggle'    => false,
				'default'   => 'column',
				'options'   => array(
					'row'         => array(
						'title' => esc_html__( 'راست', 'mihanpress-elementor-addons' ),
						'icon'  => 'fa fa-align-right',
					),
					'column'      => array(
						'title' => esc_html__( 'بالا', 'mihanpress-elementor-addons' ),
						'icon'  => 'fa fa-align-center',
					),
					'row-reverse' => array(
						'title' => esc_html__( 'چپ', 'mihanpress-elementor-addons' ),
						'icon'  => 'fa fa-align-left',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .info-box-box' => 'flex-direction: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'text-align',
			array(
				'label'     => esc_html__( 'تراز بندی متن ها', 'mihanpress-elementor-addons' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'toggle'    => false,
				'default'   => 'center',
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
				'selectors' => array(
					'{{WRAPPER}} .info-box-box'      => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .info-box-box-desc' => 'text-align: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			array(
				'label' => esc_html__( 'محتوا', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_title_style',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'عنوان', 'mihanpress-elementor-addons' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'رنگ عنوان', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .info-box-box-title' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .info-box-box-title',
			)
		);

		$this->add_control(
			'desc_title',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'توضیحات', 'mihanpress-elementor-addons' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label'     => esc_html__( 'رنگ توضیحات', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .info-box-box-desc' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'desc_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .info-box-box-desc',
			)
		);

		$this->add_control(
			'icon_title',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'آیکون', 'mihanpress-elementor-addons' ),
				'separator' => 'before',
			)
		);
		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'رنگ آیکون', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),

				'selectors' => array(
					'{{WRAPPER}} .info-box-box-icon' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'icon_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .info-box-box-icon',
			)
		);

		$this->add_control(
			'image_size_title',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'اندازه تصویر', 'mihanpress-elementor-addons' ),
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'image_width',
			array(
				'label'     => esc_html__( 'طول تصویر', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 65,
				),
				'range'     => array(
					'px' => array(
						'min' => 10,
						'max' => 200,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .info-box-box-img' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'image_height',
			array(
				'label'     => esc_html__( 'عرض تصویر', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 10,
						'max' => 200,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .info-box-box-img' => 'height: {{SIZE}}{{UNIT}};',
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
		?>
		<div class="d-flex flex-wrap">
			<?php
			foreach ( $settings['info_items'] as $item ) :
				$this->add_render_attribute( 'info_box' . $item['_id'], 'class', 'info-box-box d-flex ' . esc_attr( $item['background'] ) . ' elementor-repeater-item-' . $item['_id'] );
				if ( 'box' === $settings['style'] ) {
					$this->add_render_attribute( 'info_box' . $item['_id'], 'class', 'box pt-5 pb-4' );
				}
				?>
				<div class="info-box-wrap">
					<div <?php echo $this->get_render_attribute_string( 'info_box' . $item['_id'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php
						if ( 'icon' === $item['icon_or_image'] ) :
							?>
							<div class="info-box-box-icon">
								<span class="<?php echo esc_attr( $item['icon']['value'] ); ?>"></span>
							</div>
							<?php
						else :
							?>
							<div>
								<img class="info-box-box-img" src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" title="<?php echo esc_attr( $item['title'] ); ?>">
							</div>
							<?php
						endif;
						?>
						<div class="mt-3">
							<h3 class="info-box-box-title"><?php echo esc_html( $item['title'] ); ?></h3>
							<p class="info-box-box-desc"><?php echo wp_kses_post( $item['desc'] ); ?></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
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
		<div class="d-flex flex-wrap">
		<#
		var items = settings.info_items;
		items.forEach(item => {
			view.addRenderAttribute('info_box' + item._id, 'class', 'info-box-box d-flex ' + item.background + ' elementor-repeater-item-' + item._id);
			if (settings.style === 'box') {
				view.addRenderAttribute('info_box' + item._id, 'class', 'box pt-5 pb-4');
			}
		#>
			<div class="info-box-wrap">
				<div {{{ view.getRenderAttributeString( 'info_box' + item._id ) }}}>
					<# if (item.icon_or_image === 'icon') { #>
						<div class="info-box-box-icon">
							<span class="{{{item.icon.value}}}"></span>
						</div>
					<# } else { #>
						<div>
							<img class="info-box-box-img" src="{{{item.image.url}}}" alt="{{{item.title}}}" title="{{{item.title}}}">
						</div>
					<# } #>
					<div class="mt-3">
						<h3 class="info-box-box-title">{{{item.title}}}</h3>
						<p class="info-box-box-desc">{{{item.desc}}}</p>
					</div>
				</div>
			</div>
		<# 
		});
		#>
	</div>

		<?php
	}
}
