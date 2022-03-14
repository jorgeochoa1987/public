<?php
/**
 * Feedback Slider Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class eCademy_Feedback_Slider2 extends Widget_Base {

	public function get_name() {
        return 'FeedbackSliderTwo';
    }

	public function get_title() {
        return esc_html__( 'Feedback Slider Two', 'ecademy-toolkit' );
    }

	public function get_icon() {
        return 'eicon-testimonial';
    }

	public function get_categories() {
        return [ 'ecademy-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'ecademy-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

		$repeater = new Repeater();

        $repeater->add_control(
            'image', [
                'label' => __( 'Image', 'ecademy-toolkit' ),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'name', [
                'label' => __( 'Name', 'ecademy-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Olivar Lucy' , 'ecademy-toolkit' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'designation', [
                'label' => __( 'Designation', 'ecademy-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Designer' , 'ecademy-toolkit' ),
            ]
        );

        $repeater->add_control(
            'feedback', [
                'label' => __( 'Feedback Content', 'ecademy-toolkit' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.' , 'ecademy-toolkit' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'ecademy_feedback_items',
            [
                'label' => __( 'Slider Item', 'ecademy-toolkit' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'name' => __( 'Olivar Lucy', 'ecademy-toolkit' ),
                        'designation' => __( 'Designer', 'ecademy-toolkit' ),
                    ],
                ],
                'title_field' => '{{{ name }}}',
            ]
        );

    $this->end_controls_section();

    $this->start_controls_section(
        'style',
        [
            'label' => __( 'Style', 'ecademy-toolkit' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

        $this->add_control(
            'bd_color',
            [
                'label' => esc_html__( 'Section Background Color', 'ecademy-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonials-item' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .testimonials-item' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'feedback_color',
            [
                'label' => esc_html__( 'Feedback Color', 'ecademy-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.testimonials-item p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'feedback_size',
            [
                'label' => esc_html__( 'Feedback Font Size', 'ecademy-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-item p' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__( 'Name Color', 'ecademy-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonials-item h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'name_size',
            [
                'label' => esc_html__( 'Name Font Size', 'ecademy-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-item h3' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'designation_color',
            [
                'label' => esc_html__( 'Designation Color', 'ecademy-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonials-item span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'designation_size',
            [
                'label' => esc_html__( 'Designation Font Size', 'ecademy-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-item span' => 'font-size: {{SIZE}}px;',
                ],
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
        $slider = $settings['ecademy_feedback_items'];

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');

        $count = 0;
        foreach ($slider as $items => $counts):
            $count++;
        endforeach;
        ?>

        <div class="container">
            <?php if( $count == 1 ): ?>
                <div class="col-lg-12">
            <?php else: ?>
                <div class="testimonials-slides-two owl-carousel owl-theme">
            <?php endif; ?>
                <?php foreach ($slider as $key => $value): ?>
                    <div class="testimonials-item">
                        <div class="row align-items-center">
                            <div class="col-lg-8 col-md-12">
                                <p><?php echo esc_html( $value['feedback'] ); ?></p>
                                <h3><?php echo esc_html( $value['name'] ); ?></h3>
                                <span><?php echo esc_html( $value['designation'] ); ?></span>
                            </div>
                            <div class="col-lg-4 col-md-12 text-center">
                            <?php if( $value['image']['url'] != '' ): ?>
                                <img src="<?php echo esc_url( $value['image']['url'] ); ?>" alt="<?php echo esc_attr( $value['name'] ); ?>">
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php
	}

	protected function _content_template() {}

}

Plugin::instance()->widgets_manager->register_widget_type( new eCademy_Feedback_Slider2 );