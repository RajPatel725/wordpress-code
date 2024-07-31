<?php
if (!defined('ABSPATH')) {
    exit;
}

class Custom_Widget_Plugin
{
    public function run()
    {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('widgets_init', array($this, 'register_custom_widget'));
    }

    public function add_admin_menu()
    {
        add_menu_page(
            'WP Settings & Widget Page Test',
            'WP Settings',
            'manage_options',
            'custom_plugin',
            array($this, 'settings_page'),
            'dashicons-admin-generic'
        );
    }

    public function register_settings()
    {
        register_setting('custom_plugin_settings_group', 'custom_plugin_settings', array($this, 'sanitize_settings'));

        add_settings_section('custom_plugin_main_section', '', null, 'custom_plugin');

        add_settings_field('title', 'Title', array($this, 'title_callback'), 'custom_plugin', 'custom_plugin_main_section');
        add_settings_field('description', 'Description', array($this, 'description_callback'), 'custom_plugin', 'custom_plugin_main_section');
        add_settings_field('editor_content', 'Editor content', array($this, 'editor_content_callback'), 'custom_plugin', 'custom_plugin_main_section');
        add_settings_field('date', 'Date', array($this, 'date_callback'), 'custom_plugin', 'custom_plugin_main_section');
        add_settings_field('image', 'Image', array($this, 'image_callback'), 'custom_plugin', 'custom_plugin_main_section');
        add_settings_field('color_picker', 'Color Picker', array($this, 'color_picker_callback'), 'custom_plugin', 'custom_plugin_main_section');
    }

    public function sanitize_settings($input)
    {
        $sanitized = array();
        $errors = array();

        // Validate title
        if (isset($input['title'])) {
            if (empty(trim($input['title']))) {
                $errors[] = 'Title cannot be empty.';
            } else {
                $sanitized['title'] = sanitize_text_field($input['title']);
            }
        }

        // Validate description
        if (isset($input['description'])) {
            if (empty(trim($input['description']))) {
                $errors[] = 'Description cannot be empty.';
            } else {
                $sanitized['description'] = sanitize_textarea_field($input['description']);
            }
        }

        // Sanitize other fields
        if (isset($input['editor_content'])) {
            $sanitized['editor_content'] = wp_kses_post($input['editor_content']);
        }

        if (isset($input['date'])) {
            $sanitized['date'] = sanitize_text_field($input['date']);
        }

        if (isset($input['image'])) {
            $sanitized['image'] = esc_url_raw($input['image']);
        }

        if (isset($input['color_picker'])) {
            $sanitized['color_picker'] = sanitize_hex_color($input['color_picker']);
        }

        // If there are errors, do not save data and return original input
        if (!empty($errors)) {
            foreach ($errors as $error) {
                add_settings_error(
                    'custom_plugin_settings',
                    'custom_plugin_settings_error',
                    $error,
                    'error'
                );
            }
            // Return original input to retain form data
            return get_option('custom_plugin_settings');
        }

        return $sanitized;
    }
    public function title_callback()
    {
        $options = get_option('custom_plugin_settings');
        echo '<input type="text" id="title" name="custom_plugin_settings[title]" value="' . esc_attr($options['title'] ?? '') . '" />';
    }

    public function description_callback()
    {
        $options = get_option('custom_plugin_settings');
        echo '<textarea id="description" name="custom_plugin_settings[description]" rows="5" cols="50">' . esc_textarea($options['description'] ?? '') . '</textarea>';
    }

    public function editor_content_callback()
    {
        $options = get_option('custom_plugin_settings');
        wp_editor($options['editor_content'] ?? '', 'editor_content', array('textarea_name' => 'custom_plugin_settings[editor_content]'));
    }

    public function date_callback()
    {
        $options = get_option('custom_plugin_settings');
        echo '<input type="date" id="date" name="custom_plugin_settings[date]" value="' . esc_attr($options['date'] ?? '') . '" />';
    }

    public function image_callback()
    {
        $options = get_option('custom_plugin_settings');
        echo '<input type="text" id="image" name="custom_plugin_settings[image]" value="' . esc_url($options['image'] ?? '') . '" />';
        echo '<input type="button" id="upload_image_button" class="button" value="Choose image" />';
    }

    public function color_picker_callback()
    {
        $options = get_option('custom_plugin_settings');
        echo '<input type="text" id="color_picker" name="custom_plugin_settings[color_picker]" value="' . esc_attr($options['color_picker'] ?? '') . '" class="color-field" />';
    }

    public function settings_page()
    {
        ?>
        <div class="wrap">
            <h1>WP Settings & Widget Page</h1>
            <?php settings_errors(); ?>
            <form method="post" action="options.php">
                <?php
                settings_fields('custom_plugin_settings_group');
                do_settings_sections('custom_plugin');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }


    public function register_custom_widget()
    {
        register_widget('Custom_Widget');
    }
}
