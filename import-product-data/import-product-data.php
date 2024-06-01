<?php

function theme_options_page()
{
    ?>
    <div class="wrap">
        <h2>Import Product Data</h2>
        <form method="post" action="admin.php?page=theme_options" enctype="multipart/form-data">
            <?php settings_fields('theme_options_group'); ?>
            <?php do_settings_sections('theme_options'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
function theme_options_init()
{
    register_setting('theme_options_group', 'theme_options', 'theme_options_sanitize');
    add_settings_section('csv_upload_section', 'CSV Upload', 'csv_upload_section_callback', 'theme_options');
    add_settings_field(
        'csv_file',
        'CSV File',
        'csv_file_callback',
        'theme_options',
        'csv_upload_section'
    );
}
add_action('admin_init', 'theme_options_init');
function theme_options_sanitize($input)
{
    return $input;
}
function csv_file_callback()
{
    $options = get_option('theme_options');
    ?>
    <input type="file" name="theme_options[csv_file]" accept=".csv" />
    <?php
}
function csv_upload_section_callback()
{
    echo '<p>Upload your CSV file here.</p>';
}

function handle_csv_upload()
{
    if (isset($_FILES['theme_options']['tmp_name']['csv_file']) && !empty($_FILES['theme_options']['tmp_name']['csv_file'])) {
        $allowed_extensions = array('csv', 'xlsx');
        $file_info = pathinfo($_FILES['theme_options']['name']['csv_file']);
        $file_extension = strtolower($file_info['extension']);
        if (in_array($file_extension, $allowed_extensions)) {
            $csv_file = $_FILES['theme_options']['tmp_name']['csv_file'];
            $csv_data = array_map('str_getcsv', file($csv_file));

            if (!empty($csv_data)) {
                $i = 0;
                foreach ($csv_data as $row) {
                    if ($i != 0) {

                        $variety = $csv_data[0][2];
                        $packaging = $csv_data[0][3];
                        $brand = $csv_data[0][4];
                        $country = $csv_data[0][5];
                        $size = $csv_data[0][7];
                        $unit = $csv_data[0][8];
                        $unitPackage = $csv_data[0][9];
                        $standardUnitPackage = $csv_data[0][11];

                        $_product_attributes = [[$variety, $row[2]], [$packaging, $row[3]], [$brand, $row[4]], [$country, $row[5]], [$size, $row[7]], [$unit, $row[8]], [$unitPackage, $row[9]], [$standardUnitPackage, $row[11]]];

                        $category_name = $row[21];

                        $category_id = term_exists($category_name, 'product_cat');

                        // If category doesn't exist, create it
                        if (!$category_id) {
                            $category_id = wp_insert_term(
                                $category_name, // Category name
                                'product_cat' // Taxonomy
                            );

                            if (is_wp_error($category_id)) {
                                // Handle error if category creation fails
                                echo "Error creating category: " . $category_id->get_error_message();
                            } else {
                                // Category created successfully
                                $category_id = $category_id['term_id'];
                            }
                        }

                        $post_data = array(
                            'post_type' => 'product',
                            'post_title' => sanitize_text_field($row[1]),
                            'post_status' => 'publish',
                            'post_content' => sanitize_text_field($row[6]),
                        );

                        $post_id = wp_insert_post($post_data);

                        wp_set_post_terms($post_id, $category_id, 'product_cat');

                        $images = $row[22];
                        $image_urls = explode(', ', $images);
                        $attachment_ids = array();

                        // Get attachment IDs for each image URL
                        foreach ($image_urls as $image_url) {
                            // Get the attachment ID for the image URL
                            $attachment_id = attachment_url_to_postid($image_url);

                            if ($attachment_id) {
                                $attachment_ids[] = $attachment_id;
                            }
                        }

                        // Set the first image as the featured image
                        if (!empty($attachment_ids)) {
                            set_post_thumbnail($post_id, $attachment_ids[0]);

                            // Add additional images to the product gallery
                            if (count($attachment_ids) > 1) {
                                $gallery_ids = array_slice($attachment_ids, 1); // Exclude the first image (featured image)
                                update_post_meta($post_id, '_product_image_gallery', implode(',', $gallery_ids));
                            }
                        }

                        update_post_meta($post_id, '_sku', $row[0]);
                        update_post_meta($post_id, '_weight', $row[10]);
                        update_post_meta($post_id, '_regular_price', $row[12]);
                        update_post_meta($post_id, '_sale_price', $row[13]);
                        update_post_meta($post_id, '_price', $row[13]);

                        // Initialize an empty array to store formatted attributes
                        $formatted_attributes = [];

                        // Loop through each attribute and format it
                        foreach ($_product_attributes as $attribute) {
                            $formatted_attributes['attribute_' . $attribute[0]] = [
                                'name' => ucfirst($attribute[0]), // Capitalize the attribute name
                                'value' => $attribute[1], // Assign attribute value
                                'position' => 0,
                                'is_visible' => 1,
                                'is_variation' => 0, // Set to 0 for non-variation attributes
                                'is_taxonomy' => 0
                            ];
                        }

                        // Update the post meta with the formatted attributes
                        update_post_meta($post_id, '_product_attributes', $formatted_attributes);

                        update_post_meta($post_id, 'net_selling_price_EVAT', $row[14]);
                        update_post_meta($post_id, 'VAT%', $row[15]);
                        update_post_meta($post_id, 'selling_price_VAT_Inc', $row[16]);
                        update_post_meta($post_id, 'cost_price', $row[17]);
                        update_post_meta($post_id, 'total_cost', $row[18]);
                        update_post_meta($post_id, 'profit', $row[19]);
                        update_post_meta($post_id, 'margin%', $row[20]);

                    }
                    $i++;
                }
            }
        } else {
            add_action('admin_notices', 'display_csv_upload_error');
        }
    }
}
add_action('admin_init', 'handle_csv_upload');

function display_csv_upload_error()
{
    ?>
    <div class="error">
        <p>
            <?php _e('Invalid file type. Only CSV and XLSX files are allowed.', 'textdomain'); ?>
        </p>
    </div>
    <?php
}

add_action('admin_init', 'handle_csv_upload');

function my_theme_menu()
{
    add_submenu_page(
        'edit.php?post_type=product', // The parent menu_slug
        'Upload Product Data',
        'Upload Product Data',
        'manage_options',
        'theme_options',
        'theme_options_page'
    );
}
add_action('admin_menu', 'my_theme_menu');
