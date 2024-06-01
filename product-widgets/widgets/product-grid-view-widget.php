if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Product_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'product-widget';
    }

    public function get_title() {
        return __('Product Widget', 'product-widget');
    }

    public function get_icon() {
        return 'eicon-product-images';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'product_section',
            [
                'label' => __('Product Information', 'product-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'post_type',
            [
                'label' => esc_html__('Select Post Type', 'product-widget'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'post' => esc_html__('Post', 'product-widget'),
                    'product'  => esc_html__('Product', 'product-widget'),
                ],
            ]
        );

        $this->add_control(
            'post_per_page',
            [
                'label' => esc_html__('Number Of Post', 'product-widget'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => -1,
                'step' => 1,
                'default' => 5,
            ]
        );

        $this->add_control(
            'product_grid_page',
            [
                'label' => esc_html__('Product Per Row', 'product-widget'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '3' => esc_html__('3', 'product-widget'),
                    '4' => esc_html__('4', 'product-widget'),
                ],
            ]
        );

        $this->end_controls_section();

        // Style controls
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'product-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'more_options',
            [
                'label' => esc_html__('Product Title', 'product-widget'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__('Color', 'product-widget'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .card_title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .card_title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'title_background',
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .card_title',
            ]
        );

        $this->add_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'product-widget'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .card_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_box_width',
            [
                'label' => esc_html__('Box Width', 'product-widget'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '75',
                'options' => [
                    '25' => esc_html__('25%', 'product-widget'),
                    '50'  => esc_html__('50%', 'product-widget'),
                    '75'  => esc_html__('75%', 'product-widget'),
                    '100'  => esc_html__('100%', 'product-widget'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .card_title' => 'width: {{VALUE}}%;',
                ],
            ]
        );

        $this->add_control(
            'text_align',
            [
                'label' => esc_html__('Alignment', 'product-widget'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'product-widget'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'product-widget'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'product-widget'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .card_title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'price_more_options',
            [
                'label' => esc_html__('Product Price', 'product-widget'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'price_text_color',
            [
                'label' => esc_html__('Color', 'product-widget'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .card_price' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .card_price',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'price_background',
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .card_price',
            ]
        );

        $this->add_control(
            'price_padding',
            [
                'label' => esc_html__('Padding', 'product-widget'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .card_price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'price_box_width',
            [
                'label' => esc_html__('Box Width', 'product-widget'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '75',
                'options' => [
                    '25' => esc_html__('25%', 'product-widget'),
                    '50'  => esc_html__('50%', 'product-widget'),
                    '75'  => esc_html__('75%', 'product-widget'),
                    '100'  => esc_html__('100%', 'product-widget'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .card_price' => 'width: {{VALUE}}%;',
                ],
            ]
        );

        $this->add_control(
            'price_align',
            [
                'label' => esc_html__('Alignment', 'product-widget'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'product-widget'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'product-widget'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'product-widget'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .card_price' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_options',
            [
                'label' => esc_html__('Read More', 'product-widget'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'read_more_text_color',
            [
                'label' => esc_html__('Color', 'product-widget'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .read_more' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'read_more_typography',
                'selector' => '{{WRAPPER}} .read_more',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'read_more_background',
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .read_more',
            ]
        );

        $this->add_control(
            'read_more_padding',
            [
                'label' => esc_html__('Padding', 'product-widget'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .read_more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_box_width',
            [
                'label' => esc_html__('Box Width', 'product-widget'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '75',
                'options' => [
                    '25' => esc_html__('25%', 'product-widget'),
                    '50'  => esc_html__('50%', 'product-widget'),
                    '75'  => esc_html__('75%', 'product-widget'),
                    '100'  => esc_html__('100%', 'product-widget'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .read_more' => 'width: {{VALUE}}%;',
                ],
            ]
        );

        $this->add_control(
            'read_more_align',
            [
                'label' => esc_html__('Alignment', 'product-widget'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'product-widget'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'product-widget'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'product-widget'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .read_more' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $query_args = [
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['post_per_page'],
        ];

        $query = new \WP_Query($query_args);

        if ($query->have_posts()) {
            echo '<div class="products-grid">';
            while ($query->have_posts()) {
                $query->the_post();

                // Custom rendering logic for products
                echo '<div class="product-card">';
                echo '<div class="card_title" style="color: ' . esc_attr($settings['title_text_color']) . ';">' . get_the_title() . '</div>';
                echo '<div class="card_price">' . get_post_meta(get_the_ID(), '_price', true) . '</div>';
                echo '<a class="read_more" href="' . get_permalink() . '">' . __('Read More', 'product-widget') . '</a>';
                echo '</div>';
            }
            echo '</div>';

            wp_reset_postdata();
        } else {
            echo '<p>' . __('No products found', 'product-widget') . '</p>';
        }
    }

    protected function _content_template() {
        ?>
        <#
        var postType = settings.post_type;
        var postsPerPage = settings.post_per_page;

        var posts = [];

        // This is just a placeholder since _content_template does not support PHP.
        // Replace with actual JS rendering logic if needed.
        for (var i = 0; i < postsPerPage; i++) {
            posts.push({
                title: 'Product ' + (i + 1),
                price: '$' + ((i + 1) * 10)
            });
        }
        #>

        <div class="products-grid">
            <# _.each(posts, function(post) { #>
                <div class="product-card">
                    <div class="card_title">{{{ post.title }}}</div>
                    <div class="card_price">{{{ post.price }}}</div>
                    <a class="read_more" href="#">{{{ settings.read_more_text }}}</a>
                </div>
            <# }); #>
        </div>
        <?php
    }
}

// Register widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Product_Widget());

