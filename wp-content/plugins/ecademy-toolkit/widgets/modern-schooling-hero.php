<?php
/**
 * Modern Schooling Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Modern_Schooling_Hero extends Widget_Base {

	public function get_name() {
        return 'Modern_Schooling_Hero';
    }

	public function get_title() {
        return esc_html__( 'Modern Schooling Hero', 'ecademy-toolkit' );
    }

	public function get_icon() {
        return 'eicon-banner';
    }

	public function get_categories() {
        return [ 'ecademy-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
			'Modern_Schooling_Hero_Area',
			[
				'label' => esc_html__( 'Banner Controls', 'ecademy-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'bg_color',
				[
					'label' => esc_html__( 'Section Background Color', 'ecademy-toolkit' ),
					'type'	 => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hero-banner-area' => 'background-color: {{VALUE}}',
					],
				]
            );

			$this->add_control(
				'title',
				[
					'label' 	=> esc_html__( 'Title', 'ecademy-toolkit' ),
					'type' 		=> Controls_Manager::TEXTAREA,
					'default' 	=> __('Build Development Skills With eCademy Any Time, Anywhere', 'ecademy-toolkit'),
				]
            );
            
            $this->add_control(
                'title_note', [
                    'label' => '',
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => __( 'Input the Typed words within curly braces. <br>Eg Title, True Multi-Purpose Theme for {Education, School, Business} and more.', 'ecademy-toolkit' ),
                    'content_classes' => 'elementor-warning',
                ]
            );

			$this->add_control(
                'title_tag',
                [
                    'label' 	=> esc_html__( 'Title Tag', 'ecademy-toolkit' ),
                    'type' 		=> Controls_Manager::SELECT,
                    'options' 	=> [
                        'h1'         => esc_html__( 'h1', 'ecademy-toolkit' ),
                        'h2'         => esc_html__( 'h2', 'ecademy-toolkit' ),
                        'h3'         => esc_html__( 'h3', 'ecademy-toolkit' ),
                        'h4'         => esc_html__( 'h4', 'ecademy-toolkit' ),
                        'h5'         => esc_html__( 'h5', 'ecademy-toolkit' ),
                        'h6'         => esc_html__( 'h6', 'ecademy-toolkit' ),
                    ],
                    'default' => 'h1',
                ]
            );

			$this->add_control(
				'content',
				[
					'label' 	=> esc_html__( 'Content', 'ecademy-toolkit' ),
					'type' 		=> Controls_Manager::TEXTAREA,
					'default' 	=> __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'ecademy-toolkit'),
				]
            );
            
            $this->add_control(
                'is_divider',
                [
                    'label' 	=> esc_html__( 'Enable Divider', 'ecademy-toolkit' ),
                    'type' 		=> Controls_Manager::SELECT,
                    'options' 	=> [
                        'yes'         => esc_html__( 'Yes', 'ecademy-toolkit' ),
                        'no'         => esc_html__( 'No', 'ecademy-toolkit' ),
                    ],
                    'default' => 'yes',
                ]
            );

			$this->add_control(
				'divider_bg_color',
				[
					'label' => esc_html__( 'Divider Background Color', 'ecademy-toolkit' ),
					'type'	 => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hero-banner-area .divider' => 'background-color: {{VALUE}}',
					],
                    'condition' => [
                        'is_divider' => 'yes',
                    ]
				]
            );

            $this->add_control(
                'fimage',
                [
                    'label'		=> esc_html__('Feature Image', 'ecademy-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

			$this->add_control(
                'shape1',
                [
                    'label'		=> esc_html__('Shape Image One', 'ecademy-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
			);

			$this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ecademy-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> __('Join For Free', 'ecademy-toolkit'),
				]
            ); 
            
            $this->add_control(
				'user_button_text',
				[
					'label' 	=> esc_html__( 'User Logged in Button Text', 'ecademy-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> __('Profile', 'ecademy-toolkit'),
				]
			);

            $this->add_control(
				'button_icon',
				[
					'label' => esc_html__( 'Button Icon', 'ecademy-toolkit' ),
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'options' => ecademy_flaticons(),
				]
            );

            $this->add_control(
                'link_type',
                [
                    'label' 		=> esc_html__( 'Button Link Type', 'ecademy-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' => [
                        '1'  	=> esc_html__( 'Link To Page', 'ecademy-toolkit' ),
                        '2' 	=> esc_html__( 'External Link', 'ecademy-toolkit' ),
                    ], 
                ]
            );
    
            $this->add_control(
                'link_to_page',
                [
                    'label' 		=> esc_html__( 'Button Link Page', 'ecademy-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' 		=> ecademy_toolkit_get_page_as_list(),
                    'condition' => [
                        'link_type' => '1',
                    ]
                ]
            );
    
            $this->add_control(
                'ex_link',
                [
                    'label'		=> esc_html__('Button External Link', 'ecademy-toolkit'),
                    'type'		=> Controls_Manager:: TEXT,
                    'condition' => [
                        'link_type' => '2',
                    ]
                ]
            );

            $this->start_controls_tabs(
                'style_tabs'
            );
    
            /// Normal Button Style
            $this->start_controls_tab(
                'style_normal_btn',
                [
                    'label' => __( 'Normal', 'ecademy-toolkit' ),
                ]
            );
    
            $this->add_control(
                'font_color', [
                    'label' => __( 'Font Color', 'ecademy-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .hero-banner-content .default-btn' => 'color: {{VALUE}}',
                    )
                ]
            );
    
            $this->add_control(
                'btn_bg_color', [
                    'label' => __( 'Background Color', 'ecademy-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .hero-banner-content .default-btn' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                    )
                ]
            );
    
            $this->end_controls_tab();

            $this->start_controls_tab(
                'style_hover_btn',
                [
                    'label' => __( 'Hover', 'ecademy-toolkit' ),
                ]
            );
    
            $this->add_control(
                'hover_font_color', [
                    'label' => __( 'Font Color', 'ecademy-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .hero-banner-content .default-btn:hover' => 'color: {{VALUE}}',
                    )
                ]
            );
    
            $this->add_control(
                'hover_bg_color', [
                    'label' => __( 'Background Color', 'ecademy-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array (
                        '{{WRAPPER}} .default-btn span' => 'background: {{VALUE}}',
                    )
                ]
            );
            
            $this->end_controls_tab();
        
        $this->end_controls_section();

        $this->start_controls_section(
			'banner_style',
			[
				'label' => esc_html__( 'Style', 'ecademy-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );	
            $this->add_control(
                'sec_padding', [
                    'label' => __( 'Section padding', 'ecademy-toolkit' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .hero-banner-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'default' => [
                        'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',

                    ],
                ]
            );

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ecademy-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hero-banner-content h1, .hero-banner-content h2, .hero-banner-content h3, .hero-banner-content h4, .hero-banner-content h5, .hero-banner-content h6' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Title Typography', 'ecademy-toolkit' ),
                    'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .hero-banner-content h1, .hero-banner-content h2, .hero-banner-content h3, .hero-banner-content h4, .hero-banner-content h5, .hero-banner-content h6',
                ]
            );
			
			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ecademy-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hero-banner-content p' => 'color: {{VALUE}}',
					],
				]
			);
			
			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Content Typography', 'ecademy-toolkit' ),
                    'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .hero-banner-content p',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

		$settings = $this->get_settings_for_display();
        
        global $ecademy_opt;
		if( isset( $ecademy_opt['enable_lazyloader'] ) ):
			$is_lazyloader = $ecademy_opt['enable_lazyloader'];
		else:
			$is_lazyloader = true;
		endif;
		
        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');

		// Button Icon
        if( $settings['button_icon'] != '' ):
            $icon = $settings['button_icon'];
        else:
            $icon = 'flaticon-user';
        endif;

        // Get Button Link
        if($settings['link_type'] == 1){
            $link = get_page_link( $settings['link_to_page'] ); 
        } else {
            $link = $settings['ex_link'];
        }

        if ( is_user_logged_in() ):
            $button_text = $settings['user_button_text'];
        else:
            $button_text = $settings['button_text'];
        endif;
		?>

        <div class="hero-banner-area">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="hero-banner-content">
							<<?php echo esc_attr( $settings['title_tag'] ); ?> <?php echo $this-> get_render_attribute_string('title'); ?>>
								<?php echo esc_html( $settings['title'] ); ?>
							</<?php echo esc_attr( $settings['title_tag'] ); ?>>
                            <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo esc_html( $settings['content'] ); ?></p>
                            <?php if( $button_text != '' ): ?>
								<a href="<?php echo esc_url( $link ); ?>" class="default-btn"><i class="<?php echo esc_attr( $icon ); ?>"></i><?php echo esc_html( $button_text ); ?><span></span></a>
							<?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <?php if( $settings['fimage']['url'] != '' ): ?>
                            <div class="hero-banner-image">
                                <?php if( $is_lazyloader == true ): ?>
                                    <img sm-src="<?php echo esc_url( $settings['fimage']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                                <?php else: ?>
                                    <img src="<?php echo esc_url( $settings['fimage']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if( $settings['shape1']['url'] != '' ): ?>
                <div class="banner-shape19">
                    <?php if( $is_lazyloader == true ): ?>
                        <img sm-src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr__( 'shape image', 'ecademy-toolkit' ); ?>">
                    <?php else: ?>
                        <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr__( 'shape image', 'ecademy-toolkit' ); ?>">
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if( $settings['is_divider'] == 'yes' ): ?>
                <div class="divider"></div>
            <?php endif; ?>
        </div>	
        <?php
	}

	protected function _content_template() {}

}

Plugin::instance()->widgets_manager->register_widget_type( new Modern_Schooling_Hero );