<?php

namespace MihanpressElementorAddons\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

trait Helper {

	/**
	 * Query controls section
	 *
	 * @since 1.0.0
	 */
	public function query_section( $widget ) {
		$widget->start_controls_section(
			'query',
			array(
				'label' => esc_html__( 'کوئری', 'mihanpress-elementor-addons' ),
			)
		);

		$widget->add_control(
			'post_type',
			array(
				'label'   => esc_html__( 'پست تایپ', 'mihanpress-elementor-addons' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_post_types(),
				'default' => 'post',
			)
		);
		$widget->start_controls_tabs(
			'query_filter_tabs'
		);

		$widget->start_controls_tab(
			'include_tab',
			array(
				'label' => esc_html__( 'Include', 'mihanpress-elementor-addons' ),
			)
		);

		$widget->add_control(
			'post_taxonomies',
			array(
				'label'       => esc_html__( 'فیلتر بر اساس دسته بندی و تگ', 'mihanpress-elementor-addons' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'description' => esc_html__( 'برای نمایش همه پست ها خالی بگدارید.', 'mihanpress-elementor-addons' ),
				'options'     => $this->get_all_terms(),
				'multiple'    => true,
				'label_block' => true,
			)
		);
		$widget->add_control(
			'post_authors',
			array(
				'label'       => esc_html__( 'فیلتر بر اساس نویسنده', 'mihanpress-elementor-addons' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'description' => esc_html__( 'برای نمایش همه نویسنده ها خالی بگدارید.', 'mihanpress-elementor-addons' ),
				'options'     => $this->get_authors(),
				'multiple'    => true,
				'label_block' => true,
				'separator'   => 'after',
			)
		);

		$widget->end_controls_tab();

		$widget->start_controls_tab(
			'exclude__tab',
			array(
				'label' => esc_html__( 'Exclude', 'mihanpress-elementor-addons' ),
			)
		);

		$widget->add_control(
			'post_not_taxonomies',
			array(
				'label'       => esc_html__( 'کدوم دسته بندی و تگ نباشه ؟', 'mihanpress-elementor-addons' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $this->get_all_terms(),
				'multiple'    => true,
				'label_block' => true,
			)
		);
		$widget->add_control(
			'post_not_authors',
			array(
				'label'       => esc_html__( 'کدوم نویسنده نباشه؟', 'mihanpress-elementor-addons' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $this->get_authors(),
				'multiple'    => true,
				'label_block' => true,
				'separator'   => 'after',

			)
		);
		$widget->end_controls_tab();

		$widget->end_controls_tabs();

		$widget->add_control(
			'post_per_page',
			array(
				'label'   => esc_html__( 'تعداد پست ها', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => -1,
				'step'    => 1,
			)
		);
		$widget->add_control(
			'order',
			array(
				'label'   => esc_html__( 'ترتیب', 'mihanpress-elementor-addons' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'DESC' => esc_html__( 'نزولی', 'mihanpress-elementor-addons' ),
					'ACS'  => esc_html__( 'صعودی', 'mihanpress-elementor-addons' ),
				),
				'default' => 'DESC',
			)
		);
		$widget->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'مرتب سازی بر اساس', 'mihanpress-elementor-addons' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'date'     => esc_html__( 'تاریخ', 'mihanpress-elementor-addons' ),
					'modified' => esc_html__( 'تاریخ بروزرسانی', 'mihanpress-elementor-addons' ),
					'title'    => esc_html__( 'عنوان', 'mihanpress-elementor-addons' ),
					'author'   => esc_html__( 'نویسنده', 'mihanpress-elementor-addons' ),
					'comments' => esc_html__( 'تعداد نظرات', 'mihanpress-elementor-addons' ),
					'rand'     => esc_html__( 'رندم', 'mihanpress-elementor-addons' ),
				),
				'default' => 'date',
			)
		);
		$widget->add_control(
			'offset',
			array(
				'label'   => esc_html__( 'offset', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => 0,
				'step'    => 1,
			)
		);
		$widget->end_controls_section();
	}

	/**
	 * Get query controls value
	 *
	 * @since 1.0.0
	 */
	public function get_query_args( $settings ) {
		/** WP_Query arguments */
		$args = array(
			'post_type'   => $settings['post_type'],
			'order'       => $settings['order'],
			'orderby'     => $settings['orderby'],
			'post_status' => 'publish',
		);

		if ( ! empty( $settings['post_per_page'] ) ) {
			$args['posts_per_page'] = $settings['post_per_page'];
		}
		if ( ! empty( $settings['offset'] ) ) {
			$args['offset'] = $settings['offset'];
		}
		if ( ! empty( $settings['post_taxonomies'] ) ) {
			$args['tax_query']['relation'] = 'OR';
			$taxonomies_in                 = $settings['post_taxonomies'];
			foreach ( $taxonomies_in as $taxonomy ) {
				$term                = get_term( $taxonomy );
				$term_taxonomy       = $term->taxonomy;
				$args['tax_query'][] = array(
					'taxonomy' => $term_taxonomy,
					'field'    => 'slug',
					'terms'    => $term->slug,
				);
			}
		}

		if ( isset( $settings['show_pagination'] ) && 'yes' === $settings['show_pagination'] ) {
			$args['paged'] = isset( $_GET[ $settings['pagination_hash'] ] ) ? sanitize_text_field( wp_unslash( intval( $_GET[ $settings['pagination_hash'] ] ) ) ) : 1;
		}

		if ( ! empty( $settings['post_not_taxonomies'] ) ) {
			$args['tax_query']['relation'] = 'OR';
			$taxonomies_not_in             = $settings['post_not_taxonomies'];
			foreach ( $taxonomies_not_in as $taxonomy_not ) {
				$term_not            = get_term( $taxonomy_not );
				$term_not_taxonomy   = $term_not->taxonomy;
				$args['tax_query'][] = array(
					'taxonomy' => $term_not_taxonomy,
					'field'    => 'slug',
					'terms'    => $term_not->slug,
					'operator' => 'NOT IN',
				);
			}
		}
		if ( ! empty( $settings['post_authors'] ) ) {
			$args['author'] = $settings['post_authors'];
		}
		if ( ! empty( $settings['post_not_authors'] ) ) {
			$args['author__not_in'] = $settings['post_not_authors'];
		}

		return $args;
	}

	/**
	 * Layout controls for post widget
	 *
	 * @since 1.0.0
	 */
	public function post_layout_section( $widget ) {
		$widget->start_controls_section(
			'posts_layout',
			array(
				'label' => esc_html__( 'ساختار', 'mihanpress-elementor-addons' ),
			)
		);

		$widget->add_control(
			'post_layout',
			array(
				'label'   => esc_html__( 'ساختار', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'block',
				'options' => array(
					'block'      => 'Block',
					'row'        => 'Row',
					'image-card' => 'Image Card',
				),
			)
		);

		if ( 'mp_dynamic_carousel' !== $widget->get_name() ) {
			$widget->add_control(
				'masonry',
				array(
					'label'     => esc_html__( 'چیدمان آجری (Masonry)', 'mihanpress-elementor-addons' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => '',
					'label_on'  => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
					'label_off' => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
				)
			);
			$widget->add_responsive_control(
				'post_column',
				array(
					'label'              => esc_html__( 'تعداد ستون ها', 'mihanpress-elementor-addons' ),
					'type'               => Controls_Manager::SELECT,
					'frontend_available' => true,
					'default'            => 3,
					'tablet_default'     => 2,
					'mobile_default'     => 1,
					'options'            => array(
						1 => 'یک',
						2 => 'دو',
						3 => 'سه',
						4 => 'چهار',
						5 => 'پنج',
						6 => 'شش',
					),
					'selectors'          => array(
						'{{WRAPPER}} article'   => 'flex-basis: calc( 100% / {{VALUE}} )',
						'{{WRAPPER}} .card-row' => 'max-width: calc( 100% / {{VALUE}} );min-width: calc( 100% / {{VALUE}} )',
					),
					'condition'          => array(
						'masonry' => '',
					),
				)
			);

			$widget->add_control(
				'post_column_grid',
				array(
					'label'              => esc_html__( 'تعداد ستون ها (دسکتاپ)', 'mihanpress-elementor-addons' ),
					'type'               => Controls_Manager::SELECT,
					'frontend_available' => true,
					'default'            => 3,
					'options'            => array(
						'2' => 'دو',
						'3' => 'سه',
						'4' => 'چهار',
						'5' => 'پنج',
						'6' => 'شش',
					),
					'condition'          => array(
						'masonry' => 'yes',
					),
				)
			);
			$widget->add_control(
				'post_column_grid_tablet',
				array(
					'label'              => esc_html__( 'تعداد ستون ها (تبلت)', 'mihanpress-elementor-addons' ),
					'type'               => Controls_Manager::SELECT,
					'frontend_available' => true,
					'default'            => 2,
					'options'            => array(
						'1' => 'یک',
						'2' => 'دو',
						'3' => 'سه',
						'4' => 'چهار',
						'5' => 'پنج',
						'6' => 'شش',
					),
					'condition'          => array(
						'masonry' => 'yes',
					),
				)
			);
			$widget->add_control(
				'post_column_grid_mobile',
				array(
					'label'              => esc_html__( 'تعداد ستون ها (موبایل)', 'mihanpress-elementor-addons' ),
					'type'               => Controls_Manager::SELECT,
					'frontend_available' => true,
					'default'            => 1,
					'options'            => array(
						'1' => 'یک',
						'2' => 'دو',
						'3' => 'سه',
						'4' => 'چهار',
						'5' => 'پنج',
						'6' => 'شش',
					),
					'condition'          => array(
						'masonry' => 'yes',
					),
				)
			);
		}

		$widget->add_control(
			'stretch-items',
			array(
				'label'     => esc_html__( 'تراز بندی آیتم ها', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off' => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
				'condition' => array(
					'masonry' => '',
				),
			)
		);

		$widget->add_control(
			'show_title',
			array(
				'label'     => esc_html__( 'نمایش عنوان', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off' => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
				'separator' => 'before',
			)
		);
		$widget->add_control(
			'html_tag',
			array(
				'label'     => esc_html__( 'تگ عنوان', 'mihanpress-elementor-addons' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
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
				'default'   => 'h2',
				'condition' => array(
					'show_title' => 'yes',
				),
			)
		);
		$widget->add_control(
			'show_excerpt',
			array(
				'label'     => esc_html__( 'نمایش توضیحات', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off' => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
				'separator' => 'before',
				'condition' => array(
					'post_layout!' => 'image-card',
				),
			)
		);

		$widget->add_control(
			'show_read_more',
			array(
				'label'     => esc_html__( 'نمایش دکمه ادامه مطلب', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off' => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
				'separator' => 'before',
				'condition' => array(
					'post_layout!' => 'image-card',
				),
			)
		);
		$widget->add_control(
			'read_more_text',
			array(
				'label'     => esc_html__( 'متن دکمه', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'ادامه مطلب', 'mihanpress-elementor-addons' ),
				'condition' => array(
					'show_read_more' => 'yes',
					'post_layout!'   => 'image-card',
				),
			)
		);
		$widget->add_control(
			'button_style',
			array(
				'label'     => esc_html__( 'استایل دکمه', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'btn-success',
				'options'   => $this->btn_classes(),
				'condition' => array(
					'show_read_more' => 'yes',
					'post_layout!'   => 'image-card',
				),
			)
		);

		if ( 'mp_static_posts' !== $widget->get_name() ) {
			$widget->add_control(
				'show_price',
				array(
					'label'     => esc_html__( 'نمایش قیمت محصول', 'mihanpress-elementor-addons' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_on'  => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
					'label_off' => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
					'separator' => 'before',
					'condition' => array(
						'post_type'    => 'product',
						'post_layout!' => 'image-card',
					),
				)
			);
		}

		if ( 'mp_static_posts' !== $widget->get_name() ) {
			$widget->add_control(
				'show_modified',
				array(
					'label'     => esc_html__( 'نمایش تاریخ بروزرسانی', 'mihanpress-elementor-addons' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_on'  => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
					'label_off' => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
					'separator' => 'before',
					'condition' => array(
						'orderby'      => 'modified',
						'post_layout!' => 'image-card',
					),
				)
			);

			$widget->add_control(
				'show_pagination',
				array(
					'label'     => esc_html__( 'نمایش صفحه‌بندی', 'mihanpress-elementor-addons' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_on'  => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
					'label_off' => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
					'separator' => 'before',
				)
			);
		}

		$widget->end_controls_section();
	}

	/**
	 * Thumbnail controls for post widget
	 *
	 * @since 1.0.0
	 */
	public function post_thumbnail_section( $widget ) {
		$widget->start_controls_section(
			'thumbnail_settings',
			array(
				'label' => esc_html__( 'تصویر پست', 'mihanpress-elementor-addons' ),
			)
		);

		$widget->add_control(
			'show_thumbnail',
			array(
				'label'     => esc_html__( 'نمایش تصویر', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off' => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
				'separator' => 'before',
				'condition' => array(
					'post_layout!' => 'image-card',
				),
			)
		);
		$widget->add_control(
			'thumbnail_size',
			array(
				'label'      => esc_html__( 'اندازه تصویر', 'mihanpress-elementor-addons' ),
				'type'       => \Elementor\Controls_Manager::SELECT,
				'options'    => $this->get_intermediate_image_sizes(),
				'default'    => 'large',
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => 'show_thumbnail',
							'value' => 'yes',
						),
						array(
							'name'  => 'post_layout',
							'value' => 'image-card',
						),
					),
				),
			)
		);
		$widget->add_control(
			'align_thumbnail',
			array(
				'label'     => esc_html__( 'ترازبندی تصاویر', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'label_on'  => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off' => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
				'condition' => array(
					'show_thumbnail' => 'yes',
					'post_layout'    => 'row',
				),
			)
		);
		$widget->add_control(
			'thumbnail_style',
			array(
				'label'     => esc_html__( 'استایل تصویر', 'mihanpress-elementor-addons' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'classic'  => esc_html__( 'کلاسیک', 'mihanpress-elementor-addons' ),
					'modern'   => esc_html__( 'مدرن', 'mihanpress-elementor-addons' ),
					'modern-2' => esc_html__( 'مدرن (۲)', 'mihanpress-elementor-addons' ),
				),
				'default'   => 'modern',
				'condition' => array(
					'show_thumbnail' => 'yes',
					'post_layout!'   => 'image-card',
				),
			)
		);
		$widget->add_responsive_control(
			'thumbnail-height',
			array(
				'label'      => esc_html__( 'ارتفاع تصویر', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .card figure img' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} figure > img'     => 'height: {{SIZE}}{{UNIT}}',
				),
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => 'show_thumbnail',
							'value' => 'yes',
						),
						array(
							'name'  => 'post_layout',
							'value' => 'image-card',
						),
					),
				),
			)
		);
		$widget->add_responsive_control(
			'thumbnail_margin_around',
			array(
				'label'      => esc_html__( 'فاصله تصویر از اطراف', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 150,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 35,
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .card .card__thumbnail' => 'margin-right: {{SIZE}}{{UNIT}} !important;margin-left: {{SIZE}}{{UNIT}} !important',
				),
				'condition'  => array(
					'show_thumbnail' => 'yes',
					'post_layout!'   => 'image-card',
				),
			)
		);

		$widget->add_control(
			'show_thumbnail_overlay',
			array(
				'label'     => esc_html__( 'نمایش Overlay', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off' => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
				'condition' => array(
					'show_thumbnail' => 'yes',
					'post_layout!'   => 'image-card',
				),
			)
		);

		$widget->end_controls_section();
	}

	/**
	 * Meta data controls for post widget
	 *
	 * @since 1.0.0
	 */
	public function post_metadata_section( $widget ) {
		$widget->start_controls_section(
			'posts_metadata',
			array(
				'label' => esc_html__( 'متا دیتا', 'mihanpress-elementor-addons' ),
			)
		);

		$widget->add_control(
			'show_metadata',
			array(
				'label'     => esc_html__( 'نمایش متا دیتا', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'بله', 'mihanpress-elementor-addons' ),
				'label_off' => esc_html__( 'خیر', 'mihanpress-elementor-addons' ),
			)
		);

		$widget->add_control(
			'metadata_content',
			array(
				'label'       => esc_html__( 'محتوای متا دیتا', 'mihanpress-elementor-addons' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => array(
					'author'   => 'نویسنده',
					'date'     => 'تاریخ',
					'comments' => 'نظرات',
					'category' => 'دسته بندی',
				),
				'default'     => array( 'author', 'date', 'comments', 'category' ),
				'multiple'    => true,
				'label_block' => true,
				'condition'   => array(
					'show_metadata' => 'yes',
				),
			)
		);

		$widget->add_control(
			'metadata_tax_id',
			array(
				'label'     => esc_html__( 'نام Taxonomy', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_taxonomy_lists(),
				'default'   => 'category',
				'condition' => array(
					'show_metadata'    => 'yes',
					'metadata_content' => 'category',
				),
			)
		);
		$widget->end_controls_section();
	}

	/**
	 * Style section controls for post widget
	 *
	 * @since 1.0.0
	 */
	public function post_style_section( $widget ) {
		$widget->start_controls_section(
			'overlay_style',
			array(
				'label'     => esc_html__( 'Overlay', 'mihanpress-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_thumbnail'         => 'yes',
					'show_thumbnail_overlay' => 'yes',
					'post_layout!'           => 'image-card',
				),
			)
		);
		$widget->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'overlay_bg',
				'label'          => esc_html__( 'پس زمینه Overlay', 'mihanpress-elementor-addons' ),
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '{{WRAPPER}} .card-thumbnail_overlay',
				'fields_options' => array(
					'background'     => array(
						'default' => 'gradient',
					),
					'color'          => array(
						'default' => '#2D74E2',
					),
					'color_b'        => array(
						'default' => '#00E0A1',
					),
					'color_stop'     => array(
						'default' => array(
							'unit' => '%',
							'size' => 30,
						),
					),
					'color_b_stop'   => array(
						'default' => array(
							'unit' => '%',
							'size' => 70,
						),
					),
					'gradient_angle' => array(
						'default' => array(
							'unit' => 'deg',
							'size' => 50,
						),
					),
				),

			)
		);

		$widget->end_controls_section();
		$widget->start_controls_section(
			'content_style',
			array(
				'label' => esc_html__( 'محتوا', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$widget->add_responsive_control(
			'content-align',
			array(
				'label'     => esc_html__( 'موقعیت متون', 'mihanpress-elementor-addons' ),
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
					'{{WRAPPER}} .card__content' => 'text-align: {{VALUE}};',
				),
			)
		);
		$widget->add_responsive_control(
			'content_padding',
			array(
				'label'      => esc_html__( 'فاصله درونی', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .card__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'unit'      => 'px',
					'top'       => '15',
					'right'     => '15',
					'bottom'    => '15',
					'left'      => '15',
					'is_linked' => true,
				),
				'separator'  => 'after',
			)
		);
		$widget->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'رنگ عنوان', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .card__title' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'show_title' => 'yes',
				),
			)
		);
		$widget->add_control(
			'title_color_hover',
			array(
				'label'     => esc_html__( 'رنگ عنوان در صورت هاور', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .card__title:hover' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'show_title' => 'yes',
				),
			)
		);
		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'title_typo',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .card__title',
				'condition' => array(
					'show_title' => 'yes',
				),
			)
		);

		$widget->add_control(
			'excerpt_color',
			array(
				'label'     => esc_html__( 'رنگ توضیحات', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .card-excerpt' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'show_excerpt' => 'yes',
					'post_layout!' => 'image-card',
				),
				'separator' => 'before',
			)
		);
		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'excerpt_typo',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .card-excerpt p',
				'condition' => array(
					'show_excerpt' => 'yes',
					'post_layout!' => 'image-card',
				),
			)
		);

		$widget->add_control(
			'metadata_color',
			array(
				'label'     => esc_html__( 'رنگ متادیتا', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .card__data div'      => 'color: {{VALUE}}',
					'{{WRAPPER}} .card__author-meta a' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'show_metadata' => 'yes',
				),
				'separator' => 'before',
			)
		);
		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'metadata_typo',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .card__data div',
				'condition' => array(
					'show_metadata' => 'yes',
				),
			)
		);
		$widget->add_responsive_control(
			'metadata-align',
			array(
				'label'     => esc_html__( 'موقعیت متن های متادیتا', 'mihanpress-elementor-addons' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'toggle'    => false,
				'default'   => 'center',
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'راست', 'mihanpress-elementor-addons' ),
						'icon'  => 'fa fa-align-right',
					),
					'center'     => array(
						'title' => esc_html__( 'وسط', 'mihanpress-elementor-addons' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'چپ', 'mihanpress-elementor-addons' ),
						'icon'  => 'fa fa-align-left',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .card__data' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$widget->end_controls_section();
		$widget->start_controls_section(
			'button_style_section',
			array(
				'label'     => esc_html__( 'دکمه ادامه مطلب', 'mihanpress-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_read_more' => 'yes',
					'post_layout!'   => 'image-card',
				),
			)
		);
		$widget->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'read_more_bg',
				'label'          => esc_html__( 'پس زمینه', 'mihanpress-elementor-addons' ),
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '{{WRAPPER}} .btn',
				'fields_options' => array(
					'background'     => array(
						'default' => 'gradient',
					),
					'color'          => array(
						'default' => '#8e2de2',
					),
					'color_b'        => array(
						'default' => '#4a00e0',
					),
					'color_stop'     => array(
						'default' => array(
							'unit' => '%',
							'size' => 0,
						),
					),
					'color_b_stop'   => array(
						'default' => array(
							'unit' => '%',
							'size' => 50,
						),
					),
					'gradient_angle' => array(
						'default' => array(
							'unit' => 'deg',
							'size' => 260,
						),
					),
				),
				'condition'      => array(
					'button_style' => 'custom',
				),
			)
		);
		$widget->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'رنگ متن', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .btn' => 'color: {{VALUE}}',

				),
				'separator' => 'before',
				'default'   => '#ffffff',
				'condition' => array(
					'button_style' => 'custom',
				),
			)
		);
		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typo',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .btn',
			)
		);
		$widget->add_responsive_control(
			'button_width',
			array(
				'label'      => esc_html__( 'اندازه دکمه', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => '%',
					'size' => '100',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 400,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'width: {{SIZE}}{{UNIT}}',
				),
				'separator'  => 'before',
			)
		);
		$widget->add_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'گوشه های مدور', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);
		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'button_box_shadow',
				'selector'  => '{{WRAPPER}} .btn',
				'condition' => array(
					'button_style' => 'custom',
				),
				'separator' => 'before',
			)
		);
		$widget->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border',
				'label'       => esc_html__( 'خط دور', 'mihanpress-elementor-addons' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .btn',
				'condition'   => array(
					'button_style' => 'custom',
				),
				'separator'   => 'before',
			)
		);

		$widget->end_controls_section();
		$widget->start_controls_section(
			'box_style',
			array(
				'label' => esc_html__( 'باکس', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$widget->start_controls_tabs(
			'post_box_tabs'
		);

		$widget->start_controls_tab(
			'normal_post_box_tab',
			array(
				'label' => esc_html__( 'معمولی', 'mihanpress-elementor-addons' ),
			)
		);
		$widget->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'box_bg',
				'label'          => esc_html__( 'پس زمینه', 'mihanpress-elementor-addons' ),
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '{{WRAPPER}} .card',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color'      => array(
						'default' => '#fff',
					),
				),
				'condition'      => array(
					'post_layout!' => 'image-card',
				),
			)
		);
		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'box_box_shadow',
				'selector'  => '{{WRAPPER}} .card',
				'separator' => 'before',
			)
		);
		$widget->end_controls_tab();
		$widget->start_controls_tab(
			'hover_post_box_tab',
			array(
				'label' => esc_html__( 'هاور', 'mihanpress-elementor-addons' ),
			)
		);
		$widget->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'box_bg_hover',
				'label'          => esc_html__( 'پس زمینه', 'mihanpress-elementor-addons' ),
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '{{WRAPPER}} .card:hover',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color'      => array(
						'default' => '#fff',
					),
				),
				'condition'      => array(
					'post_layout!' => 'image-card',
				),
			)
		);
		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'box_box_shadow_hover',
				'selector'  => '{{WRAPPER}} .card:hover',
				'separator' => 'before',
			)
		);
		$widget->end_controls_tab();
		$widget->end_controls_tabs();

		$widget->add_responsive_control(
			'items_margin',
			array(
				'label'      => esc_html__( 'فاصله بین آیتم ها', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} article' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
				'default'    => array(
					'unit'      => 'px',
					'top'       => '10',
					'right'     => '10',
					'bottom'    => '10',
					'left'      => '10',
					'is_linked' => true,
				),
				'separator'  => 'before',
			)
		);
		$widget->end_controls_section();
	}

	/**
	 * Get post widget output values
	 *
	 * @since 1.0.0
	 */
	public function get_post_layout_variables( $widget, $settings, $post_item ) {
		/** Only for dynamic posts */
		$terms_id      = ! empty( $settings['metadata_tax_id'] ) ? $settings['metadata_tax_id'] : 'category';
		$stretch_items = 'yes' === $settings['stretch-items'] ? ' d-flex' : '';

		/** Set main variables */
		if ( 'mp_static_posts' !== $widget->get_name() ) {
			$widget->add_render_attribute( 'article_' . get_the_ID(), 'id', 'post-' . get_the_ID() );
			$widget->add_render_attribute( 'article_' . get_the_ID(), 'class', $stretch_items );

			if ( 'mp_dynamic_carousel' === $widget->get_name() && 'yes' === $settings['stretch-items'] ) {
				$widget->add_render_attribute( 'article_' . get_the_ID(), 'class', 'align-carousel' );
			}

			if ( 'block' === $settings['post_layout'] ) {
				$widget->add_render_attribute( 'article_' . get_the_ID(), 'class', 'yes' === get_post_class( $settings['stretch-items'] ? ' d-flex' : '' ) );
			} else {
				$widget->add_render_attribute( 'article_' . get_the_ID(), 'class', get_post_class( "card-row $stretch_items" ) );
			}
		} else {
			$widget->add_render_attribute( 'article_' . $post_item['_id'], 'class', ( $post_item && ! is_null( $post_item['class'] ) ) ? $post_item['class'] : '' );
		}

		$var_array = array(
			'article_attr'               => 'mp_static_posts' !== $widget->get_name() ? $widget->get_render_attribute_string( 'article_' . get_the_ID() ) : $widget->get_render_attribute_string( 'article_' . $post_item['_id'] ),
			'html_tag'                   => $settings['html_tag'],
			'modern_thumbnail'           => 'modern' === $settings['thumbnail_style'] ? ' out-thumbnail' : ( 'modern-2' === $settings['thumbnail_style'] ? ' out-thumbnail shaped-thumbnail' : '' ),
			'stretch_thumbnail_row_card' => 'yes' === $settings['align_thumbnail'] ? ' d-lg-flex' : '',
			'button_class'               => $settings['button_style'],
			'terms_id'                   => 'mp_static_posts' !== $widget->get_name() ? $terms_id : false,
			'permalink'                  => 'mp_static_posts' !== $widget->get_name() ? esc_url( get_the_permalink() ) : esc_url( $post_item['post_link']['url'] ),
			'permalink_target'           => ( 'mp_static_posts' === $widget->get_name() && $post_item['post_link']['is_external'] ) ? ' target="_blank" ' : '',
			'permalink_nofollow'         => ( 'mp_static_posts' === $widget->get_name() && $post_item['post_link']['nofollow'] ) ? ' rel="nofollow" ' : '',
			'thumbnail'                  => 'mp_static_posts' !== $widget->get_name() ? get_the_post_thumbnail( '', $settings['thumbnail_size'] ) : wp_get_attachment_image( $post_item['thumbnail']['id'], $settings['thumbnail_size'] ),
			'title'                      => 'mp_static_posts' !== $widget->get_name() ? get_the_title() : $post_item['title'],
			'excerpt'                    => 'mp_static_posts' !== $widget->get_name() ? '<p>' . get_the_excerpt() . '</p>' : $post_item['excerpt'],
		);

		return $var_array;
	}

	/**
	 * Get all registered post types
	 *
	 * @since 1.0.0
	 */
	public function get_post_types() {
		$args       = array( 'public' => true );
		$post_types = get_post_types( $args, 'objects' );
		$posts      = array();
		foreach ( $post_types as $post_type ) {
			$posts[ $post_type->name ] = $post_type->labels->singular_name;
		}
		$posts['related'] = esc_html__( 'مطالب مرتبط', 'mihanpress-elementor-addons' );
		return $posts;
	}

	/**
	 * Get all terms from all taxonomies
	 *
	 * @since 1.0.0
	 */
	public function get_all_terms() {
		$post_types = get_post_types( array( 'public' => false ) );

		foreach ( $post_types as $post_type ) {
			$taxonomy_names = get_object_taxonomies( $post_type );

			$terms = get_terms( $taxonomy_names, array( 'hide_empty' => true ) );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$all_terms[ $term->term_id ] = $term->name;
				}
			}
		}
		return $all_terms;
	}

	/**
	 * Get all users who published at least one post
	 *
	 * @since 1.0.0
	 */
	public function get_authors() {
		$authors = get_users();
		foreach ( $authors as $author ) {
			if ( count_user_posts( $author->ID ) > 0 ) {
				$all_authors[ $author->ID ] = $author->display_name;
			}
		}
		return $all_authors;
	}

	/**
	 * Get list of all taxonomies
	 *
	 * @since 1.0.0
	 */
	public function get_taxonomy_lists() {
		$post_types = get_post_types( array( 'public' => true ) );
		foreach ( $post_types as $post_type ) {
			$taxonomy_names = get_object_taxonomies( $post_type );
			if ( ! is_wp_error( $taxonomy_names ) ) {
				foreach ( $taxonomy_names as $taxonomy_name ) {
					$taxonomies_list[ $taxonomy_name ] = $taxonomy_name;
				}
			}
		}
		return $taxonomies_list;
	}

	/**
	 * Get all image sizes
	 *
	 * @since 1.0.0
	 */
	public function get_intermediate_image_sizes() {
		$sizes     = get_intermediate_image_sizes();
		$sizes_obj = array();
		foreach ( $sizes as $size ) {
			$sizes_obj[ $size ] = $size;
		}
		return $sizes_obj;
	}

	/**
	 * Get carousel widget controls
	 *
	 * @since 1.0.0
	 */
	public function carousel_controls( $widget ) {
		$widget->add_responsive_control(
			'columns',
			array(
				'label'      => esc_html__( 'اندازه هر آیتم', 'mihanpress-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => '%',
					'size' => '50',
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
					'{{WRAPPER}} .carousel-cell' => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} article'        => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$widget->add_control(
			'carousel-align',
			array(
				'label'     => esc_html__( 'موقعیت آیتم ها', 'mihanpress-elementor-addons' ),
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
				'separator' => 'before',
			)
		);
		$widget->add_control(
			'nav_buttons',
			array(
				'label'     => esc_html__( 'دکمه های ناوبری', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			)
		);

		$widget->add_control(
			'unstable_nav',
			array(
				'label'       => esc_html__( 'نمایش فقط در صورت هاور', 'mihanpress-elementor-addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_block' => true,
				'default'     => 'yes',
				'condition'   => array(
					'nav_buttons' => 'yes',
				),
			)
		);

		$widget->add_control(
			'nav_dots',
			array(
				'label'     => esc_html__( 'نقطه های ناوبری', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			)
		);
		$widget->add_control(
			'infinite_loop',
			array(
				'label'   => esc_html__( 'نمایش به صورت چرخه', 'mihanpress-elementor-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			)
		);
		$widget->add_control(
			'duration',
			array(
				'label'     => esc_html__( 'مدت زمان نمایش هر آیتم', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 2000,
				'min'       => 100,
				'step'      => 100,
				'separator' => 'after',
			)
		);
	}

	/**
	 * Get carousel controls values
	 *
	 * @since 1.0.0
	 */
	public function get_carousel_attributes( $widget, $settings ) {
		$unstable_nav  = 'yes' === $settings['unstable_nav'] ? 'unstable-nav' : '';
		$carousel_json = array(
			'dots'     => 'yes' === $settings['nav_dots'] ? true : false,
			'nav_btn'  => 'yes' === $settings['nav_buttons'] ? true : false,
			'loop'     => 'yes' === $settings['infinite_loop'] ? true : false,
			'duration' => $settings['duration'] ? $settings['duration'] : 3000,
			'align'    => $settings['carousel-align'],
		);

		$widget->add_render_attribute( 'carousel_attributes', 'class', 'carousel mp-dynamic-carousel ' . $unstable_nav );
		$widget->add_render_attribute( 'carousel_attributes', 'data-carousel', wp_json_encode( $carousel_json ) );

		return $widget->get_render_attribute_string( 'carousel_attributes' );
	}

	/**
	 * Style section for carousel widget
	 *
	 * @since 1.0.0
	 */
	public function carousel_navigation_style_section( $widget ) {

		$widget->start_controls_section(
			'nav_style',
			array(
				'label' => esc_html__( 'ناوبری', 'mihanpress-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$widget->start_controls_tabs(
			'nav_buttons_tabs'
		);
		$widget->start_controls_tab(
			'btn_nav_tab',
			array(
				'label' => esc_html__( 'دکمه های ناوبری', 'mihanpress-elementor-addons' ),
			)
		);
		$widget->add_control(
			'nav_buttons_color',
			array(
				'label'     => esc_html__( 'رنگ دکمه های ناوبری', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .mp-dynamic-carousel .flickity-button.next' => 'background: {{VALUE}}',
					'{{WRAPPER}} .mp-dynamic-carousel .flickity-button.previous' => 'background: {{VALUE}}',

				),
				'default'   => '#673ab7',
				'condition' => array(
					'nav_buttons' => 'yes',
				),
			)
		);

		$widget->add_control(
			'nav_buttons_color_text',
			array(
				'label'     => esc_html__( 'رنگ آیکون دکمه های ناوبری', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .mp-dynamic-carousel .flickity-button.previous::before' => 'color: {{VALUE}}',
					'{{WRAPPER}} .mp-dynamic-carousel .flickity-button.next::before' => 'color: {{VALUE}}',
				),
				'default'   => '#ffffff',
				'condition' => array(
					'nav_buttons' => 'yes',
				),
			)
		);
		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'button_box_shadow',
				'selector'  => '{{WRAPPER}} .mp-dynamic-carousel>button',
				'separator' => 'after',
				'condition' => array(
					'nav_buttons' => 'yes',
				),
				'separator' => 'after',
			)
		);
		$widget->end_controls_tab();
		$widget->start_controls_tab(
			'dot_nav_tab',
			array(
				'label' => esc_html__( 'نقطه های ناوبری', 'mihanpress-elementor-addons' ),
			)
		);
		$widget->add_control(
			'nav_dots_color',
			array(
				'label'     => esc_html__( 'رنگ نقطه های ناوبری', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#acacac',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .dot' => 'background: {{VALUE}}',

				),
				'condition' => array(
					'nav_dots' => 'yes',
				),

			)
		);
		$widget->add_control(
			'nav_dots_active_color',
			array(
				'label'     => esc_html__( 'رنگ نقطه ناوبری فعال', 'mihanpress-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#4a00e0',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .dot.is-selected' => 'background: {{VALUE}}',

				),
				'condition' => array(
					'nav_dots' => 'yes',
				),
			)
		);

		$widget->end_controls_tab();
		$widget->end_controls_tabs();

		$widget->end_controls_section();
	}

	/**
	 * Get all button classes
	 *
	 * @since 1.0.0
	 */
	public function btn_classes() {
		$options = array(
			'btn-primary'         => esc_html__( 'Primary', 'mihanpress-elementor-addons' ),
			'btn-secondary'       => esc_html__( 'Secondary', 'mihanpress-elementor-addons' ),
			'btn-success'         => esc_html__( 'Success', 'mihanpress-elementor-addons' ),
			'btn-info'            => esc_html__( 'Info', 'mihanpress-elementor-addons' ),
			'btn-warning'         => esc_html__( 'Warning', 'mihanpress-elementor-addons' ),
			'btn-danger'          => esc_html__( 'Danger', 'mihanpress-elementor-addons' ),
			'btn-dark'            => esc_html__( 'Dark', 'mihanpress-elementor-addons' ),
			'btn-light'           => esc_html__( 'Light', 'mihanpress-elementor-addons' ),
			'btn-outline-primary' => esc_html__( 'Outline Primary', 'mihanpress-elementor-addons' ),
			'btn-outline-success' => esc_html__( 'Outline Success', 'mihanpress-elementor-addons' ),
			'btn-outline-info'    => esc_html__( 'Outline Info', 'mihanpress-elementor-addons' ),
			'btn-outline-danger'  => esc_html__( 'Outline Danger', 'mihanpress-elementor-addons' ),
			'custom'              => esc_html__( 'سفارشی', 'mihanpress-elementor-addons' ),
		);
		apply_filters( 'mihanpress_elementor_btn_classes', $options );
		return $options;
	}

	/**
	 * Get all overlay classes
	 *
	 * @since 1.0.0
	 */
	public function overlay_classes() {
		$options = array(
			'fadeshow'    => esc_html__( 'fade', 'mihanpress-elementor-addons' ),
			'slide-right' => esc_html__( 'slide-right', 'mihanpress-elementor-addons' ),
			'slide-left'  => esc_html__( 'slide-left', 'mihanpress-elementor-addons' ),
			'grow'        => esc_html__( 'grow', 'mihanpress-elementor-addons' ),
		);
		apply_filters( 'mihanpress_elementor_overlay_classes', $options );
		return $options;
	}
}
