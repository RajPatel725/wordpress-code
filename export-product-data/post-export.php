<?php
// Add this to your theme's functions.php or a custom plugin file
function custom_post_export_menu() {
    add_menu_page(
        'Post Export',         // Page title
        'Post Export',         // Menu title
        'manage_options',      // Capability
        'post-export',         // Menu slug
        'custom_post_export_page', // Callback function
        'dashicons-upload',    // Icon URL (dashicon)
        6                      // Position
    );
}
add_action('admin_menu', 'custom_post_export_menu');

function custom_post_export_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Post Export', 'textdomain'); ?></h1>
        <p><?php _e('Click the button below to export posts data.', 'textdomain'); ?></p>
        <form method="post" action="">
            <?php wp_nonce_field('export_post_data', 'export_post_data_nonce'); ?>
            <input type="hidden" name="custom_post_export_action" value="export">
            <input type="submit" class="button button-primary" value="<?php _e('Export Posts', 'textdomain'); ?>">
        </form>
    </div>
    <?php
}

function handle_post_export_action() {
    if (
        isset($_POST['custom_post_export_action']) && 
        $_POST['custom_post_export_action'] === 'export' && 
        check_admin_referer('export_post_data', 'export_post_data_nonce')
    ) {
        // Query the posts
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );
        $posts = get_posts($args);

        if (!empty($posts)) {
            $csv_output = "ID,Title,Content,Date\n";
            foreach ($posts as $post) {
                $csv_output .= $post->ID . ',"' . $post->post_title . '","' . $post->post_content . '","' . $post->post_date . "\"\n";
            }

            // Set the headers for the CSV download
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=post-export.csv');
            echo $csv_output;
            exit;
        } else {
            wp_die(__('No posts found to export.', 'textdomain'));
        }
    }
}
add_action('admin_init', 'handle_post_export_action');
 