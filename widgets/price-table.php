<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main widegt class
 *
 * @since 1.0.0
 */
class Price_Table extends Widget_Base {

	use \MihanpressElementorAddons\Traits\Helper;

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'mp-price-table';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return esc_html__( 'جدول قیمت بندی', 'mihanpress-elementor-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 */
	public function get_icon() {
		return 'eicon-price-table';
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
			'title',
			array(
				'label'       => esc_html__( 'متن', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'background',
			array(
				'label'   => esc_html__( 'آيکون', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'tick',
				'options' => array(
					'tick'   => esc_html__( 'تیک', 'mihanpress-elementor-addons' ),
					'close'  => esc_html__( 'ضربدر', 'mihanpress-elementor-addons' ),
					'custom' => esc_html__( 'سفارشی', 'mihanpress-elementor-addons' ),
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
					'background' => 'custom',
				),
			)
		);
		$repeater->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'رنگ آیکون', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .mp-price-table-custom-icon' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'background' => 'custom',
				),
			)
		);

		$this->start_controls_section(
			'header_content',
			array(
				'label' => esc_html__( 'سربرگ', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'عنوان', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'پلن تجاری', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'title_style',
			array(
				'label'     => esc_html__( 'استایل عنوان', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'btn-info',
				'options'   => $this->btn_classes(),
				'separator' => 'after',
			)
		);
		$this->add_control(
			'price',
			array(
				'label'       => esc_html__( 'قیمت', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( '۲۴۰,۰۰۰', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'price_unit',
			array(
				'label'       => esc_html__( 'واحد قیمت', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'تومان', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'after_price',
			array(
				'label'       => esc_html__( 'متن بعد قیمت', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'ماهانه', 'mihanpress-elementor-addons' ),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_items',
			array(
				'label' => esc_html__( 'آیتم ها', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'features',
			array(
				'label'       => esc_html__( 'آیتم ها', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'title'      => esc_html__( 'ویژگی شماره ۱', 'mihanpress-elementor-addons' ),
						'background' => 'tick',
					),
					array(
						'title'      => esc_html__( 'ویژگی شماره ۲', 'mihanpress-elementor-addons' ),
						'background' => 'close',
					),
				),

			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_footer',
			array(
				'label' => esc_html__( 'فوتر', 'mihanpress-elementor-addons' ),
			)
		);

		$this->add_control(
			'show_button',
			array(
				'label'   => esc_html__( 'نمایش دکمه', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);
		$this->add_control(
			'button_style',
			array(
				'label'     => esc_html__( 'استایل دکمه', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'btn-info',
				'options'   => $this->btn_classes(),
				'condition' => array(
					'show_button' => 'yes',
				),

			)
		);
		$this->add_control(
			'button_text',
			array(
				'label'       => esc_html__( 'متن دکمه', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'متن دکمه', 'mihanpress-elementor-addons' ),
				'condition'   => array(
					'show_button' => 'yes',
				),
			)
		);
		$this->add_control(
			'button_url',
			array(
				'label'       => esc_html__( 'لینک دکمه', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'condition'   => array(
					'show_button' => 'yes',
				),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_style_header',
			array(
				'label' => esc_html__( 'سربرگ', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'heading_title',
			array(
				'label' => esc_html__( 'عنوان', 'mihanpress-elementor-addons' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-price-table__title' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'title_style' => 'custom',
				),
			)
		);
		$this->add_control(
			'title_bg',
			array(
				'label'     => esc_html__( 'رنگ پس زمینه', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-price-table__title' => 'background: {{VALUE}};',
				),
				'condition' => array(
					'title_style' => 'custom',
				),
			)
		);
		$this->add_control(
			'title_border_radius',
			array(
				'label'      => esc_html__( 'گوشه های گرد', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-price-table__title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'title_padding',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-price-table__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .mihanpress-price-table__title',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);

		$this->add_control(
			'heading_price',
			array(
				'label'     => esc_html__( 'عدد قیمت', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-price-table__price-number' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} .mihanpress-price-table__price-number',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);

		$this->add_control(
			'heading_price_unit',
			array(
				'label'     => esc_html__( 'واحد قیمت', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'price_unit_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-price-table__price-unit' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_unit_typography',
				'selector' => '{{WRAPPER}} .mihanpress-price-table__price-unit',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);

		$this->add_control(
			'heading_after_price',
			array(
				'label'     => esc_html__( 'متن بعد از قیمت', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'after_price_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-price-table__after-price' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'after_price_typography',
				'selector' => '{{WRAPPER}} .mihanpress-price-table__after-price',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_style_items',
			array(
				'label' => esc_html__( 'آیتم ها', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'items_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-price-table__features ul li' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'items_typography',
				'selector' => '{{WRAPPER}} .mihanpress-price-table__features ul li',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_style_footer',
			array(
				'label' => esc_html__( 'فوتر', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'heading_footer_button',
			array(
				'label' => esc_html__( 'دکمه', 'mihanpress-elementor-addons' ),
				'type'  => Controls_Manager::HEADING,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .mihanpress-price-table__btn',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);
		$this->add_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'گوشه های گرد', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-price-table__btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-price-table__btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'button_background_color',
			array(
				'label'     => esc_html__( 'رنگ پس زمینه', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'default'   => '#D5D5D5',
				'selectors' => array(
					'{{WRAPPER}} .mihanpress-price-table__btn' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'button_style' => 'custom',
				),
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
					'{{WRAPPER}} .mihanpress-price-table__btn' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'button_style' => 'custom',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'button_border',
				'selector'  => '{{WRAPPER}} .mihanpress-price-table__btn',
				'condition' => array(
					'button_style' => 'custom',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .mihanpress-price-table__btn',
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
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'box_bg',
				'label'          => esc_html__( 'پس زمینه', 'mihanpress-elementor-addons' ),
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '{{WRAPPER}} .mihanpress-price-table',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color'      => array(
						'default' => '#ffffff',
					),
				),

			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'box_box_shadow',
				'selector'  => '{{WRAPPER}} .mihanpress-price-table',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-price-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'box_margin',
			array(
				'label'      => esc_html__( 'فاصله از اطراف', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-price-table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'box_border_radius',
			array(
				'label'      => esc_html__( 'گوشه های گرد', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .mihanpress-price-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'box_border',
				'selector'  => '{{WRAPPER}} .mihanpress-price-table',
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

		if ( ! empty( $settings['button_url']['url'] ) ) {
			$this->add_render_attribute(
				'button_text',
				array(
					'href'   => esc_url( $settings['button_url']['url'] ),
					'target' => $settings['button_url']['is_external'] ? '_blank' : '_self',
					'rel'    => $settings['button_url']['nofollow'] ? 'nofollow' : 'follow',
				)
			);
		}
		$this->add_render_attribute( 'button_text', 'class', 'mihanpress-price-table__btn btn d-inline-block ' . $settings['button_style'] );
		?>
		<div class="mihanpress-price-table box box-shadow-sm d-flex flex-column align-items-center mt-4">
			<div class="mihanpress-price-table__title btn <?php echo esc_attr( $settings['title_style'] ); ?>">
				<?php echo esc_html( $settings['title'] ); ?>
			</div>
			<div class="mihanpress-price-table__price">
				<span class="mihanpress-price-table__price-number"><?php echo esc_html( $settings['price'] ); ?></span>
				<span class="mihanpress-price-table__price-unit"><?php echo esc_html( $settings['price_unit'] ); ?></span>
			</div>
			<div class="mihanpress-price-table__after-price"><?php echo esc_html( $settings['after_price'] ); ?></div>
			<div class="mihanpress-price-table__features tick-list">
				<ul>
					<?php
					foreach ( $settings['features'] as $item ) :
						$item_id   = $item['_id'];
						$icon_type = 'close' === $item['background'] ? "class='close-sign elementor-repeater-item-$item_id'" : ( 'custom' === $item['background'] ? "class='custom-icon elementor-repeater-item-$item_id'" : '' );
						?>
						<li <?php echo $icon_type; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php
							if ( ! empty( $item['icon'] ) ) {
								echo '<i class="mp-price-table-custom-icon ' . esc_html( $item['icon']['value'] ) . '" aria-hidden="true"></i>';
							}
							?>
							<?php echo esc_html( $item['title'] ); ?>
						</li>
						<?php
					endforeach;
					?>
				</ul>
			</div>
			<?php if ( 'yes' === $settings['show_button'] ) : ?>
				<a <?php echo $this->get_render_attribute_string( 'button_text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $settings['button_text'] ); ?></a>
			<?php endif; ?>
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
		if (settings.button_url.url !== '') {
			view.addRenderAttribute(
				'button_text',
				{
					'href' : settings.button_url.url,
					'target' : settings.button_url.is_external ? '_blank' : '_self',
					'rel' : settings.button_url.nofollow ? 'nofollow' : 'follow',
				}
			);
		}
		view.addRenderAttribute('button_text', 'class', 'mihanpress-price-table__btn btn d-inline-block ' + settings.button_style);
		#>

		<div class="mihanpress-price-table box box-shadow-sm d-flex flex-column align-items-center mt-4">
			<div class="mihanpress-price-table__title btn {{{settings.title_style}}}">{{{settings.title}}}</div>
			<div class="mihanpress-price-table__price">
				<span class="mihanpress-price-table__price-number">{{{settings.price}}}</span>
				<span class="mihanpress-price-table__price-unit">{{{settings.price_unit}}}</span>
			</div>
			<div class="mihanpress-price-table__after-price">{{{settings.after_price}}}</div>
			<div class="mihanpress-price-table__features tick-list">
				<ul>
					<#
					var features = settings.features;
					features.forEach(item => {
						var item_id = item._id;
						var icon_type = item.background === 'close' ? "class='close-sign elementor-repeater-item-"+ item_id +"'" : (item.background === 'custom' ? "class='custom-icon elementor-repeater-item-" + item_id + "'" : '');
					#>
						<li {{{icon_type}}}>
							<#
							if (item.icon !== '' && item.background === 'custom') {
							#>
								<i class="mp-price-table-custom-icon {{{item.icon.value}}}" aria-hidden="true"></i>
							<#
							}
							print(item.title);
							#>
						</li>
					<#
					});
					#>
				</ul>
			</div>
			<# if (settings.show_button === 'yes') { #>
				<a {{{ view.getRenderAttributeString( 'button_text' ) }}}>{{{settings.button_text}}}</a>
			<# } #>
		</div>
		<?php
	}
}
