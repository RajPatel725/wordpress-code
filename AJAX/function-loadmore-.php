<?php
function enqueue_ajax_scripts()
{
	wp_enqueue_script('my_ajax', get_template_directory_uri() . '/template-page/ajax-form.js', array("jquery"), 1.1, true);
	wp_localize_script("my_ajax", "ajax_form", array('ajaxurl' => admin_url('admin-ajax.php')));

	wp_enqueue_script( 'load-ajax', get_template_directory_uri().'/template-page/load-more.js', array('jquery'), 1.2, true);
	wp_localize_script( 'load-ajax', 'load_ajax_url', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action("wp_enqueue_scripts", 'enqueue_ajax_scripts');

function create_new_post()
{
	$title = $_POST['title'];
	$details = $_POST['post_content'];

	$data = array(
		'post_title' => $title,
		'post_content' => $details,
		'post_status' => "publish",
		"post_type" => 'post',
	);

	wp_insert_post($data);

	wp_die();
}

add_action('wp_ajax_send_post_data', "create_new_post");
add_action('wp_ajax_nopriv_send_post_data', "create_new_post");

function add_new_post_ajax(){
	
	$args = array(
        'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => 2,
		'paged' => $_POST['paged'],
    );

    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : $the_query->the_post();
            ?>
				<div class="col-md-4">
                    <?php the_title(); ?>
                </div>

        <?php endwhile;
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_action', 'add_new_post_ajax');
add_action('wp_ajax_nopriv_load_more_action', 'add_new_post_ajax');