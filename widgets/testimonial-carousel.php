<?php

namespace MihanpressElementorAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main widegt class
 *
 * @since 1.0.0
 */
class Testimonial_Carousel extends Widget_Base {

	use \MihanpressElementorAddons\Traits\Helper;

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'mp_testimonial_carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return esc_html__( 'اسلایدر نظرات مشتریان', 'mihanpress-elementor-addons' );
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
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 */
	public function get_icon() {
		return 'eicon-blockquote';
	}

	/**
	 * Retrieve the list of widget scripts
	 *
	 * @since 1.0.0
	 */
	public function get_script_depends() {
		return array( 'mihanpress-flickity-carousel-js', 'mihanpress-backend-elementor' );
	}

	/**
	 * Retrieve the list of widget styles
	 *
	 * @since 1.0.0
	 */
	public function get_style_depends() {
		return array( 'mihanpress-flickity-carousel' );
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
				'label'       => esc_html__( 'نام مشتری', 'mihanpress-elementor-addons' ),
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
				'label'              => esc_html__( 'نظر مشتری', 'mihanpress-elementor-addons' ),
				'type'               => Controls_Manager::WYSIWYG,
				'rows'               => 5,
				'frontend_available' => true,
			)
		);
		$repeater->add_control(
			'customer_job',
			array(
				'label'       => esc_html__( 'عنوان مشتری', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'label_block' => true,
			)
		);
		$this->start_controls_section(
			'icon_section',
			array(
				'label' => esc_html__( 'آیکون', 'mihanpress-elementor-addons' ),
			)
		);

		$this->add_control(
			'show_icon',
			array(
				'label'     => esc_html__( 'نمایش آيکون', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off' => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
			)
		);
		$this->add_control(
			'icon_type',
			array(
				'label'     => esc_html__( 'وضعیت آیکون', 'mihanpress-elementor-addons' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'default',
				'options'   => array(
					'default' => esc_html__( 'پیشفرض', 'mihanpress-elementor-addons' ),
					'custom'  => esc_html__( 'سفارشی', 'mihanpress-elementor-addons' ),
				),
				'condition' => array(
					'show_icon' => 'yes',
				),
			)
		);
		$this->add_control(
			'icon_or_image',
			array(
				'label'     => esc_html__( 'نوع آیکون', 'mihanpress-elementor-addons' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'toggle'    => false,
				'default'   => 'icon',
				'options'   => array(
					'icon'  => array(
						'title' => esc_html__( 'آیکون', 'mihanpress-elementor-addons' ),
						'icon'  => 'eicon-favorite',
					),
					'image' => array(
						'title' => esc_html__( 'تصویر', 'mihanpress-elementor-addons' ),
						'icon'  => 'eicon-image',
					),
				),
				'condition' => array(
					'icon_type' => 'custom',
				),
			)
		);

		$this->add_control(
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
					'icon_type'     => 'custom',
				),
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
				'condition' => array(
					'icon_or_image' => 'icon',
					'icon_type'     => 'custom',
				),
				'selectors' => array(
					'{{WRAPPER}} .testimonial-carousel > span' => 'color: {{VALUE}}',

				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'icon_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'condition' => array(
					'icon_or_image' => 'icon',
					'icon_type'     => 'custom',
				),
				'selector'  => '{{WRAPPER}} .testimonial-carousel > span',
			)
		);
		$this->add_control(
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
					'icon_type'     => 'custom',
				),
			)
		);
		$this->add_responsive_control(
			'width',
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
					'{{WRAPPER}} .testimonial-carousel > img' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'icon_or_image' => 'image',
					'icon_type'     => 'custom',
				),
			)
		);
		$this->add_responsive_control(
			'height',
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
					'{{WRAPPER}} .testimonial-carousel > img' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'icon_or_image' => 'image',
					'icon_type'     => 'custom',
				),
			)
		);

		$this->add_control(
			'default_icon_color',
			array(
				'label'     => esc_html__( 'رنگ آیکون', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .testimonial-carousel .flaticon-right-quote-sign::before' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'icon_type' => 'default',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'default_icon_typo',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .testimonial-carousel .flaticon-right-quote-sign::before',
				'condition' => array(
					'icon_type' => 'default',
				),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'items',
			array(
				'label' => esc_html__( 'آیتم ها', 'mihanpress-elementor-addons' ),
			)
		);

		$this->add_control(
			'reviews',
			array(
				'label'       => esc_html__( 'آیتم ها', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'title' => esc_html__( 'نام مشتری', 'mihanpress-elementor-addons' ),
						'desc'  => esc_html__( 'نظر مشتری', 'mihanpress-elementor-addons' ),
					),
					array(
						'title' => esc_html__( 'نام مشتری', 'mihanpress-elementor-addons' ),
						'desc'  => esc_html__( 'نظر مشتری', 'mihanpress-elementor-addons' ),
					),
					array(
						'title' => esc_html__( 'نام مشتری', 'mihanpress-elementor-addons' ),
						'desc'  => esc_html__( 'نظر مشتری', 'mihanpress-elementor-addons' ),
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'carousel',
			array(
				'label' => esc_html__( 'اسلایدر', 'mihanpress-elementor-addons' ),
			)
		);

		/**
		 * ------------------------------- Carousel Controls -------------------------------
		 */
		$this->carousel_controls( $this );

		$this->end_controls_section();

		$this->start_controls_section(
			'items_style',
			array(
				'label' => esc_html__( 'آیتم ها', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'رنگ نام مشتری', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .testimonial-carousel .carousel-cell h2' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typo',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .testimonial-carousel .carousel-cell h2',
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label'     => esc_html__( 'رنگ نظر مشتری', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .testimonial-carousel .carousel-cell p' => 'color: {{VALUE}}',

				),
				'separator' => 'before',
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'desc_typo',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .testimonial-carousel .carousel-cell p',
			)
		);

		$this->add_control(
			'customer_job_color',
			array(
				'label'     => esc_html__( 'رنگ شغل مشتری', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .testimonial-carousel .carousel-cell span' => 'color: {{VALUE}}',

				),
				'separator' => 'before',
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'customer_job_typo',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .testimonial-carousel .carousel-cell span',
			)
		);

		$this->end_controls_section();

		/**
		 * ------------------------------- Carousel Nav Style Section -------------------------------
		 */
		$this->carousel_navigation_style_section( $this );
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
		<section class="testimonial-carousel text-center">
			<?php
			if ( 'yes' === $settings['show_icon'] && 'default' === $settings['icon_type'] ) :
				?>
				<span class="flaticon-right-quote-sign"></span>
				<?php
			elseif ( 'yes' === $settings['show_icon'] && 'custom' === $settings['icon_type'] ) :
				if ( 'icon' === $settings['icon_or_image'] ) {
					echo '<span class="' . esc_attr( $settings['icon']['value'] ) . '"></span>';
				} else {
					echo '<img src="' . esc_url( $settings['image']['url'] ) . '" alt="' . esc_attr( $settings['image']['title'] ) . '" title="' . esc_attr( $settings['image']['title'] ) . '">';
				}
			endif;
			?>
			<section <?php echo $this->get_carousel_attributes( $this, $settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php
				foreach ( $settings['reviews'] as $item ) :
					$item_id = ' elementor-repeater-item-' . $item['_id'];
					?>
					<article class="carousel-cell <?php echo esc_attr( $item_id ); ?>">
						<p><?php echo wp_kses_post( $item['desc'] ); ?></p>
						<h2><?php echo esc_html( $item['title'] ); ?></h2>
						<span><?php echo esc_html( $item['customer_job'] ); ?></span>
					</article>
				<?php endforeach; ?>
			</section>
		</section>
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
		<section class="testimonial-carousel text-center">
			<# if (settings.show_icon==='yes' && settings.icon_type==='default' ) { #>
				<span class="flaticon-right-quote-sign"></span>
			<# } else if (settings.show_icon==='yes' && settings.icon_type==='custom' ) {
				if (settings.icon_or_image==='icon' ) { #>
				<span class="{{{settings.icon.value}}}"></span>
			<# } else { #>
				<img src="{{{settings.image.url}}}" alt="{{{settings.image.title}}}" title="{{{settings.image.title}}}">
			<# } 
			} 
			var unstable_nav=settings.unstable_nav==='yes' ? 'unstable-nav' : '' ; 
			var carousel_json={ 
				"dots" : settings.nav_dots==='yes' ? true : false,
				"nav_btn" : settings.nav_buttons==='yes' ? true : false, 
				"loop" : settings.infinite_loop==='yes' ? true : false, 
				"duration" : settings.duration ? settings.duration : 3000 
			};
			var string_json=JSON.stringify(carousel_json); 
			view.addRenderAttribute('carousel_attributes', { "class" : 'carousel mp-dynamic-carousel ' + unstable_nav, "data-carousel" : string_json }); #>
				<section {{{ view.getRenderAttributeString( 'carousel_attributes' ) }}}>
					<# var items=settings.reviews; items.forEach(item=> {
						var item_id = ' elementor-repeater-item-' + item._id;
						#>
						<article class="carousel-cell {{{item_id}}}">
							<p>{{{item.desc}}}</p>
							<h2>{{{item.title}}}</h2>
							<span>{{{item.customer_job}}}</span>
						</article>
						<# }); #>
				</section>
		</section>
		<?php
	}
}
