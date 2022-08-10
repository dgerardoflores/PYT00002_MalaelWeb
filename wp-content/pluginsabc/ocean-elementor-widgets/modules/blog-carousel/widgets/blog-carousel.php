<?php
namespace owpElementor\Modules\BlogCarousel\Widgets;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Blog_Carousel extends Widget_Base {

	public function get_name() {
		return 'oew-blog-carousel';
	}

	public function get_title() {
		return __( 'Blog Carousel', 'ocean-elementor-widgets' );
	}

	public function get_icon() {
		return 'oew-icon eicon-post-slider';
	}

	public function get_categories() {
		return [ 'oceanwp-elements' ];
	}

    public function get_keywords() {
        return [
            'post',
            'post carousel',
            'post slider',
            'blog post',
            'blog',
            'carousel',
            'slider',
            'owp',
        ];
    }

	public function get_script_depends() {
		return [ 'oew-blog-carousel', 'swiper' ];
	}

	public function get_style_depends() {
		return [ 'oew-blog-carousel' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_blog_carousel',
			[
				'label' 		=> __( 'Carousel', 'ocean-elementor-widgets' ),
			]
		);

        $this->add_control(
            'carousel_effect',
            [
                'label'       => __('Effect', 'ocean-elementor-widgets'),
                'description' => __('Sets transition effect', 'ocean-elementor-widgets'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'slide',
                'options'     => [
                    'slide'     => __('Slide', 'ocean-elementor-widgets'),
                    'fade'      => __('Fade', 'ocean-elementor-widgets'),
                    'coverflow' => __('Coverflow', 'ocean-elementor-widgets'),
                ],
            ]
        );

        $this->add_responsive_control(
            'items',
            [
                'label'          => __('Visible Items', 'ocean-elementor-widgets'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => ['size' => 3],
                'tablet_default' => ['size' => 2],
                'mobile_default' => ['size' => 1],
                'range'          => [
                    'px' => [
                        'min'  => 1,
                        'max'  => 10,
                        'step' => 1,
                    ],
                ],
                'size_units'     => '',
                'condition'      => [
                    'carousel_effect' => ['slide', 'coverflow'],
                ],
            ]
        );

        $this->add_responsive_control(
            'slides',
            [
                'label'          => __('Items By Slides', 'ocean-elementor-widgets'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => ['size' => 3],
                'tablet_default' => ['size' => 2],
                'mobile_default' => ['size' => 1],
                'range'          => [
                    'px' => [
                        'min'  => 1,
                        'max'  => 10,
                        'step' => 1,
                    ],
                ],
                'size_units'     => '',
                'condition'      => [
                    'carousel_effect' => ['slide', 'coverflow'],
                ],
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label'      => __('Items Gap', 'ocean-elementor-widgets'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => ['size' => 10],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
                'condition'  => [
                    'carousel_effect' => ['slide', 'coverflow'],
                ],
            ]
        );

        $this->add_control(
            'slider_speed',
            [
                'label'       => __('Slider Speed', 'ocean-elementor-widgets'),
                'description' => __('Duration of transition between slides (in ms)', 'ocean-elementor-widgets'),
                'type'        => Controls_Manager::SLIDER,
                'default'     => ['size' => 400],
                'range'       => [
                    'px' => [
                        'min'  => 100,
                        'max'  => 3000,
                        'step' => 1,
                    ],
                ],
                'size_units'  => '',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'        => __('Autoplay', 'ocean-elementor-widgets'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'label_on'     => __('Yes', 'ocean-elementor-widgets'),
                'label_off'    => __('No', 'ocean-elementor-widgets'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'      => __('Autoplay Speed', 'ocean-elementor-widgets'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => ['size' => 2000],
                'range'      => [
                    'px' => [
                        'min'  => 500,
                        'max'  => 5000,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
                'condition'  => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'        => __('Pause On Hover', 'ocean-elementor-widgets'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'label_on'     => __('Yes', 'ocean-elementor-widgets'),
                'label_off'    => __('No', 'ocean-elementor-widgets'),
                'return_value' => 'yes',
                'condition'    => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label'        => __('Infinite Loop', 'ocean-elementor-widgets'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Yes', 'ocean-elementor-widgets'),
                'label_off'    => __('No', 'ocean-elementor-widgets'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'navigation_heading',
            [
                'label'     => __('Navigation', 'ocean-elementor-widgets'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'arrows',
            [
                'label'        => __('Arrows', 'ocean-elementor-widgets'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Yes', 'ocean-elementor-widgets'),
                'label_off'    => __('No', 'ocean-elementor-widgets'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'dots',
            [
                'label'        => __('Dots', 'ocean-elementor-widgets'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Yes', 'ocean-elementor-widgets'),
                'label_off'    => __('No', 'ocean-elementor-widgets'),
                'return_value' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_query',
            [
                'label' => __( 'Query', 'ocean-elementor-widgets' )
            ]
        );

		$this->add_control(
			'post_type',
			[
				'label' 		=> __( 'Post Type', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'post',
				'options' 		=> oew_get_available_post_types(),
			]
		);

		$this->add_control(
			'count',
			[
				'label' 		=> __( 'Post Per Page', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> '6',
				'separator' 	=> 'before',
			]
		);

		$this->add_control(
			'order',
			[
				'label' 		=> __( 'Order', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'DESC',
				'options' 		=> [
					'' 			=> __( 'Default', 'ocean-elementor-widgets' ),
					'DESC' 		=> __( 'DESC', 'ocean-elementor-widgets' ),
					'ASC' 		=> __( 'ASC', 'ocean-elementor-widgets' ),
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' 		=> __( 'Order By', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'date',
				'options' 		=> [
					'' 				=> __( 'Default', 'ocean-elementor-widgets' ),
					'date' 			=> __( 'Date', 'ocean-elementor-widgets' ),
					'title' 		=> __( 'Title', 'ocean-elementor-widgets' ),
					'name' 			=> __( 'Name', 'ocean-elementor-widgets' ),
					'modified' 		=> __( 'Modified', 'ocean-elementor-widgets' ),
					'author' 		=> __( 'Author', 'ocean-elementor-widgets' ),
					'rand' 			=> __( 'Random', 'ocean-elementor-widgets' ),
					'ID' 			=> __( 'ID', 'ocean-elementor-widgets' ),
					'comment_count' => __( 'Comment Count', 'ocean-elementor-widgets' ),
					'menu_order' 	=> __( 'Menu Order', 'ocean-elementor-widgets' ),
				],
			]
		);

		$this->add_control(
			'include_categories',
			[
				'label' 		=> __( 'Include Categories', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::SELECT2,
				'label_block' 	=> true,
                'options' 		=> wp_list_pluck( get_terms( 'category' ), 'name', 'term_id' ),
                'multiple' 		=> true,
                'default' 		=> [],
                'condition' 	=> [
                    'post_type' => 'post',
                ],
			]
		);

		$this->add_control(
			'post__not_in',
			[
				'label' 		=> __( 'Exclude', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::SELECT2,
				'label_block' 	=> true,
                'options' 		=> oew_get_post_list(),
                'multiple' 		=> true,
                'post_type' 	=> '',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_elements',
            [
                'label' => __( 'Elements', 'ocean-elementor-widgets' )
            ]
        );

		$this->add_control(
			'image_size',
			[
				'label' 		=> __( 'Image Size', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'medium',
				'options' 		=> oew_get_img_sizes(),
			]
		);

        $this->add_control(
            'title',
            [
                'label'        => __('Title', 'ocean-elementor-widgets'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Yes', 'ocean-elementor-widgets'),
                'label_off'    => __('No', 'ocean-elementor-widgets'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'meta',
            [
                'label'        => __('Meta', 'ocean-elementor-widgets'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Yes', 'ocean-elementor-widgets'),
                'label_off'    => __('No', 'ocean-elementor-widgets'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'author',
            [
                'label'        => __('Author Meta', 'ocean-elementor-widgets'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Yes', 'ocean-elementor-widgets'),
                'label_off'    => __('No', 'ocean-elementor-widgets'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'date',
            [
                'label'        => __('Date Meta', 'ocean-elementor-widgets'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Yes', 'ocean-elementor-widgets'),
                'label_off'    => __('No', 'ocean-elementor-widgets'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'cat',
            [
                'label'        => __('Categories Meta', 'ocean-elementor-widgets'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Yes', 'ocean-elementor-widgets'),
                'label_off'    => __('No', 'ocean-elementor-widgets'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'comments',
            [
                'label'        => __('Comments Meta', 'ocean-elementor-widgets'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Yes', 'ocean-elementor-widgets'),
                'label_off'    => __('No', 'ocean-elementor-widgets'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt',
            [
                'label'        => __('Excerpt', 'ocean-elementor-widgets'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Yes', 'ocean-elementor-widgets'),
                'label_off'    => __('No', 'ocean-elementor-widgets'),
                'return_value' => 'yes',
            ]
        );

		$this->add_control(
			'excerpt_length',
			[
				'label' 		=> __( 'Excerpt Length', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> '15',
			]
		);

		$this->add_control(
			'readmore_text',
			[
				'label' 		=> __( 'Learn More Text', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Learn More', 'ocean-elementor-widgets' ),
				'label_block' 	=> true,
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_arrows',
			[
				'label' 		=> __( 'Arrows', 'ocean-elementor-widgets' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
            'arrows_size',
            [
                'label'      => __('Size', 'ocean-elementor-widgets'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => ['size' => 20],
                'range'      => [
                    'px' => [
                        'min'  => 10,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .oew-carousel .oew-swiper-buttons svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label'         => __( 'Color', 'ocean-elementor-widgets' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .oew-carousel .oew-swiper-buttons svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
			'section_content',
			[
				'label' 		=> __( 'Content', 'ocean-elementor-widgets' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_padding',
			[
				'label' 		=> __( 'Padding', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .oew-carousel .oew-carousel-entry-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_bg_',
			[
				'label' 		=> __( 'Background Color', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .oew-carousel .oew-carousel-entry-details' => 'background-color: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_title',
			[
				'label' 		=> __( 'Title', 'ocean-elementor-widgets' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' 		=> __( 'Color', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .oew-carousel .entry-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' 		=> __( 'Color: Hover', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .oew-carousel .entry-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'title_typo',
				'selector' 		=> '{{WRAPPER}} .oew-carousel .entry-title',
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_meta',
			[
				'label' 		=> __( 'Meta', 'ocean-elementor-widgets' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label' 		=> __( 'Color', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} ul.meta, {{WRAPPER}} ul.meta li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_links_hover_color',
			[
				'label' 		=> __( 'Links Color: Hover', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} ul.meta li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_icons_color',
			[
				'label' 		=> __( 'Icons Color', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .oew-carousel .meta li i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .oew-carousel .meta li .owp-icon use' => 'stroke: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'meta_typo',
				'selector' 		=> '{{WRAPPER}} .oew-carousel ul.meta li, {{WRAPPER}} .oew-carousel ul.meta li i',
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_excerpt',
			[
				'label' 		=> __( 'Excerpt', 'ocean-elementor-widgets' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' 		=> __( 'Color', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .oew-carousel .oew-carousel-entry-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'excerpt_typo',
				'selector' 		=> '{{WRAPPER}} .oew-carousel .oew-carousel-entry-excerpt',
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			[
				'label' 		=> __( 'Button', 'ocean-elementor-widgets' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' 		=> __( 'Color', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .oew-carousel .readmore-btn a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' 		=> __( 'Color: Hover', 'ocean-elementor-widgets' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .oew-carousel .readmore-btn a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'button_typo',
				'selector' 		=> '{{WRAPPER}} .oew-carousel .readmore-btn a',
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_pagination',
			[
				'label' 		=> __( 'Pagination', 'ocean-elementor-widgets' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
            'dots_size',
            [
                'label'      => __('Size', 'ocean-elementor-widgets'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => ['size' => 8],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 30,
                        'step' => 1,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .oew-carousel .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'dots_active_color',
            [
                'label'         => __( 'Active Color', 'ocean-elementor-widgets' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .oew-carousel .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label'         => __( 'Color', 'ocean-elementor-widgets' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .oew-carousel .swiper-pagination-bullet' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

	}

    protected function next_icon() {
        $icon = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.002 512.002" xml:space="preserve"><path d="M388.425,241.951L151.609,5.79c-7.759-7.733-20.321-7.72-28.067,0.04c-7.74,7.759-7.72,20.328,0.04,28.067l222.72,222.105L123.574,478.106c-7.759,7.74-7.779,20.301-0.04,28.061c3.883,3.89,8.97,5.835,14.057,5.835c5.074,0,10.141-1.932,14.017-5.795l236.817-236.155c3.737-3.718,5.834-8.778,5.834-14.05S392.156,245.676,388.425,241.951z"/></svg>';

        return $icon;
    }

    protected function prev_icon() {
        $icon = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 443.52 443.52" xml:space="preserve"><path d="M143.492,221.863L336.226,29.129c6.663-6.664,6.663-17.468,0-24.132c-6.665-6.662-17.468-6.662-24.132,0l-204.8,204.8c-6.662,6.664-6.662,17.468,0,24.132l204.8,204.8c6.78,6.548,17.584,6.36,24.132-0.42c6.387-6.614,6.387-17.099,0-23.712L143.492,221.863z"/></svg>';

        return $icon;
    }

	protected function render() {
		$settings = $this->get_settings();

		// Post type
		$post_type = $settings['post_type'];
		$post_type = $post_type ? $post_type : 'post';

		$args = array(
	        'post_type'         => $post_type,
	        'posts_per_page'    => $settings['count'],
	        'order'             => $settings['order'],
	        'orderby'           => $settings['orderby'],
			'no_found_rows' 	=> true,
	    );

	    // Include categories
	    $include = $settings['include_categories'];

	    // Include category
		if ( ! empty( $include ) ) {

			$args['tax_query'] = [];

            $args['tax_query'][] = [
                'taxonomy' 	=> 'category',
                'field' 	=> 'term_id',
                'terms' 	=> $include,
            ];

            if ( ! empty( $args['tax_query'] ) ) {
                $args['tax_query']['relation'] = 'AND';
            }

		}

	    // Exclude
	    if ( ! empty( $settings['post__not_in'] ) ) {
            $args['post__not_in'] = $settings['post__not_in'];
        }

	    // Build the WordPress query
	    $oew_query = new \WP_Query( $args );

		$counter = 0;

		//Output posts
		if ( $oew_query->have_posts() ) :

			// Vars
			$title   	= $settings['title'];
			$meta    	= $settings['meta'];
			$excerpt 	= $settings['excerpt'];
			$readmore 	= $settings['readmore_text'];

			// Image size
			$img_size 		= $settings['image_size'];
			$img_size 		= $img_size ? $img_size : 'medium';

            // Icons RTL
            if ( is_RTL() ) {
                $next = $this->prev_icon();
                $prev = $this->next_icon();
            } else {
                $next = $this->next_icon();
                $prev = $this->prev_icon();
            }

			// Data settings
			$this->add_render_attribute(
	            'oew-carousel-container',
	            [
	                'class'           => [
	                    'swiper-container',
	                    'oew-carousel-container',
	                ],
	            ]
	        );

            if ($settings['dots'] == 'yes') {
                $this->add_render_attribute( 'oew-carousel-container', 'class', 'has-dots' );
            }

            $carousel_settings = [];

	        if (!empty($settings['items']['size'])) {
                $carousel_settings['items'] = $settings['items']['size'];
	        }

	        if (!empty($settings['items_tablet']['size'])) {
                $carousel_settings['items-tablet'] = $settings['items_tablet']['size'];
	        }

	        if (!empty($settings['items_mobile']['size'])) {
                $carousel_settings['items-mobile'] = $settings['items_mobile']['size'];
	        }

	        if (!empty($settings['slides']['size'])) {
                $carousel_settings['slides'] = $settings['slides']['size'];
	        }

	        if (!empty($settings['slides_tablet']['size'])) {
                $carousel_settings['slides-tablet'] = $settings['slides_tablet']['size'];
	        }

	        if (!empty($settings['slides_mobile']['size'])) {
                $carousel_settings['slides-mobile'] = $settings['slides_mobile']['size'];
	        }

	        if (!empty($settings['margin']['size'])) {
                $carousel_settings['margin'] = $settings['margin']['size'];
	        }
	        if (!empty($settings['margin_tablet']['size'])) {
                $carousel_settings['margin-tablet'] = $settings['margin_tablet']['size'];
	        }
	        if (!empty($settings['margin_mobile']['size'])) {
                $carousel_settings['margin-mobile'] = $settings['margin_mobile']['size'];
	        }

	        if ($settings['carousel_effect']) {
                $carousel_settings['effect'] = $settings['carousel_effect'];
	        }

	        if (!empty($settings['slider_speed']['size'])) {
                $carousel_settings['speed'] = $settings['slider_speed']['size'];
	        }

	        if ($settings['autoplay'] == 'yes' && !empty($settings['autoplay_speed']['size'])) {
                $carousel_settings['autoplay'] = $settings['autoplay_speed']['size'];
	        } else {
                $carousel_settings['autoplay'] = '0';
	        }

	        if ($settings['pause_on_hover'] == 'yes') {
                $carousel_settings['pause-on-hover'] = 'true';
	        }

	        if ($settings['infinite_loop'] == 'yes') {
                $carousel_settings['loop'] = '1';
	        }

	        if ($settings['arrows'] == 'yes') {
                $carousel_settings['arrows'] = '1';
	        }

            if ($settings['dots'] == 'yes') {
                $carousel_settings['dots'] = '1';
            }

            $this->add_render_attribute( 'oew-carousel-container', 'data-settings', wp_json_encode( $carousel_settings ) ); ?>

			<div class="oew-carousel oew-carousel-blog swiper-container-wrap clr">

				<div <?php echo $this->get_render_attribute_string( 'oew-carousel-container' ); ?>>
					<div class="swiper-wrapper">

						<?php
						// Start loop
						while ( $oew_query->have_posts() ) : $oew_query->the_post();

							// Create new post object.
							$post = new \stdClass();

							// Get post data
							$get_post = get_post();

							// Post Data
							$post->ID           = $get_post->ID;
							$post->permalink    = get_the_permalink( $post->ID );
							$post->title        = $get_post->post_title;

							// Only display carousel item if there is content to show
							if ( has_post_thumbnail()
								|| 'yes' == $title
								|| 'yes' == $meta
								|| 'yes' == $excerpt
							) { ?>

								<div class="oew-carousel-slide swiper-slide">

									<?php

										$video = oceanwp_get_post_video_html();

										if ( $video && ! post_password_required() ) {
											?>

											<div class="blog-entry-media thumbnail clr">

												<div class="blog-entry-video">

													<?php echo $video; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

												</div><!-- .blog-entry-video -->

											</div><!-- .blog-entry-media -->

											<?php

										// Else display post thumbnail.
										} elseif ( has_post_thumbnail() ) { ?>

										<div class="oew-carousel-entry-media clr">

											<a href="<?php echo $post->permalink; ?>" title="<?php the_title(); ?>" class="oew-carousel-entry-img">

												<?php
												// Display post thumbnail
												the_post_thumbnail( $img_size, array(
													'alt'		=> get_the_title(),
													'itemprop' 	=> 'image',
												) ); ?>

											</a>

										</div><!-- .oew-carousel-entry-media -->

									<?php } ?>

									<?php

									// Open details element if the title or excerpt are true
									if ( 'yes' == $title
										|| 'yes' == $meta
										|| 'yes' == $excerpt
									) { ?>

										<div class="oew-carousel-entry-details clr">

											<?php
											// Display title if $title is true and there is a post title
											if ( 'yes' == $title ) { ?>

												<h2 class="oew-carousel-entry-title entry-title">
													<a href="<?php echo $post->permalink; ?>" title="<?php the_title(); ?>"><?php echo $post->title; ?></a>
												</h2>

											<?php } ?>

											<?php
											// Display meta
											if ( 'yes' == $meta ) { ?>

												<ul class="meta">

													<?php if ( 'yes' == $settings['author'] ) { ?>
														<li class="meta-author" itemprop="name"><?php oew_svg_icon( 'user' ); ?><?php echo the_author_posts_link(); ?></li>
													<?php } ?>

													<?php if ( 'yes' == $settings['date'] ) { ?>
														<li class="meta-date" itemprop="datePublished" pubdate><?php oew_svg_icon( 'date' ); ?><?php echo get_the_date(); ?></li>
													<?php } ?>

													<?php if ( 'yes' == $settings['cat'] ) { ?>
														<li class="meta-cat"><?php oew_svg_icon( 'category' ); ?><?php the_category( ' / ', get_the_ID() ); ?></li>
													<?php } ?>

													<?php if ( 'yes' == $settings['comments'] && comments_open() && ! post_password_required() ) { ?>
														<li class="meta-comments"><?php oew_svg_icon( 'comment' ); ?><?php comments_popup_link( esc_html__( '0 Comments', 'ocean-elementor-widgets' ), esc_html__( '1 Comment',  'ocean-elementor-widgets' ), esc_html__( '% Comments', 'ocean-elementor-widgets' ), 'comments-link' ); ?></li>
													<?php } ?>

												</ul>

											<?php } ?>

											<?php
											// Display excerpt if $excerpt is true
											if ( 'yes' == $excerpt ) { ?>

												<div class="oew-carousel-entry-excerpt clr">
													<?php oew_excerpt( $settings['excerpt_length'] ); ?>
												</div><!-- .oew-carousel-entry-excerpt -->
												
											<?php } ?>

											<?php
											// Display read more
											if ( '' != $readmore ) { ?>

												<div class="oew-carousel-entry-readmore readmore-btn clr">
													<a href="<?php echo $post->permalink; ?>"><?php echo $readmore; ?></a>
												</div><!-- .oew-carousel-entry-excerpt -->
												
											<?php } ?>

										</div><!-- .oew-carousel-entry-details -->

									<?php } ?>

								</div>

							<?php } ?>

							<?php $counter++; ?>

						<?php
						// End entry loop
						endwhile; ?>

						<?php
						// Reset the post data to prevent conflicts with WP globals
						wp_reset_postdata(); ?>

					</div>
				</div>

				<?php
		        if ($settings['arrows'] == 'yes') { ?>
		            <div class="swiper-button-next oew-swiper-buttons swiper-button-next-<?php echo esc_attr( $this->get_id() ); ?>">
                        <?php echo $next; ?>
		            </div>
		            <div class="swiper-button-prev oew-swiper-buttons swiper-button-prev-<?php echo esc_attr( $this->get_id() ); ?>">
                        <?php echo $prev; ?>
		            </div>
		        <?php
		    	}

		        if ($settings['dots'] == 'yes') { ?>
		            <div class="swiper-pagination swiper-pagination-<?php echo esc_attr( $this->get_id() ); ?>"></div>
		        <?php
		    	} ?>

			</div><!-- .oew-carousel -->

		<?php
		// If no posts are found display message
		else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'ocean-elementor-widgets' ); ?></p>

		<?php
		// End post check
		endif; ?>

	<?php
	}

}