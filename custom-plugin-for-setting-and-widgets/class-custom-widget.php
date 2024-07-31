<?php
if (!defined('ABSPATH')) {
    exit;
}

class Custom_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'custom_widget',
            __('Custom Widget', 'custom-plugin'),
            array('description' => __('A Custom Widget', 'custom-plugin'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        echo '<div>';
        echo '<p>Hello, My Name is ' . esc_attr($instance['first_name']) . ' ' . esc_attr($instance['last_name']) . '</p>';
        if (!empty($instance['sex']) && !empty($instance['display_sex'])) {
            echo '<p>Sex: ' . esc_attr($instance['sex']) . '</p>';
        }
        echo '</div>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('New title', 'custom-plugin');
        $first_name = !empty($instance['first_name']) ? $instance['first_name'] : '';
        $last_name = !empty($instance['last_name']) ? $instance['last_name'] : '';
        $sex = !empty($instance['sex']) ? $instance['sex'] : '';
        $display_sex = !empty($instance['display_sex']) ? (bool)$instance['display_sex'] : false;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('first_name'); ?>"><?php _e('First Name:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('first_name'); ?>" name="<?php echo $this->get_field_name('first_name'); ?>" type="text" value="<?php echo esc_attr($first_name); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('last_name'); ?>"><?php _e('Last Name:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('last_name'); ?>" name="<?php echo $this->get_field_name('last_name'); ?>" type="text" value="<?php echo esc_attr($last_name); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sex'); ?>"><?php _e('Sex:'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('sex'); ?>" name="<?php echo $this->get_field_name('sex'); ?>">
                <option value="Male" <?php echo ($sex == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($sex == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo ($sex == 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($display_sex); ?> id="<?php echo $this->get_field_id('display_sex'); ?>" name="<?php echo $this->get_field_name('display_sex'); ?>" />
            <label for="<?php echo $this->get_field_id('display_sex'); ?>"><?php _e('Display sex publicly?'); ?></label>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['first_name'] = (!empty($new_instance['first_name'])) ? sanitize_text_field($new_instance['first_name']) : '';
        $instance['last_name'] = (!empty($new_instance['last_name'])) ? sanitize_text_field($new_instance['last_name']) : '';
        $instance['sex'] = (!empty($new_instance['sex'])) ? sanitize_text_field($new_instance['sex']) : '';
        $instance['display_sex'] = (!empty($new_instance['display_sex'])) ? (bool)$new_instance['display_sex'] : false;

        return $instance;
    }
}
