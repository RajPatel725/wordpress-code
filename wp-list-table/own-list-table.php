<?php
function create_edit_popup(){
    add_thickbox();
?>
    <div id="wlt_content_id" style="display:none;">

        <div class="post-title wlt-popup">
            <label><?php _e('Post Title :'); ?></label>
            <input type="text" class="wlt_edit_post_title" />
        </div>
        <div class="post-content wlt-popup">
            <label><?php _e('Post content :'); ?></label>
            <textarea class="wlt_edit_post_content"></textarea>
        </div>
        <div class="post-email wlt-popup">
            <label><?php _e('Post Email :'); ?></label>
            <input type="text" class="wlt_edit_post_email" />
        </div>
        <div class="post-img">
          <img src="" class="wlt_edit_post_featured_img" width="150" alt="img" />
        </div>
        <input type="button" class="wlt-update-post button-primary" value="<?php _e( 'Update' ); ?>">

    </div>

<?php }

add_action('in_admin_footer', 'create_edit_popup');

// Update post data  using Ajax

add_action( 'wp_ajax_wlt_edit_update_post', 'edit_update_post' );

function edit_update_post() {

    $post_id = isset( $_POST['post_id'] ) ? (int) $_POST['post_id'] : 0; 
    $post_content = isset( $_POST['post_content'] ) ? sanitize_textarea_field( $_POST['post_content'] ) : ''; 
    $post_name = isset( $_POST['post_name'] ) ? sanitize_text_field( $_POST['post_name'] ) : ''; 
    $post_image = isset( $_POST['post_image'] ) ? sanitize_text_field( $_POST['post_image'] ) : '';
    $post_email = isset( $_POST['post_email'] ) ? sanitize_text_field( $_POST['post_email'] ) : '';

    $data = array(
      'ID'              => $post_id,
      'post_title'      => $post_name,
      'post_content'    => $post_content,
    );

    update_post_meta($post_id , 'email' , $post_email );
     
    wp_update_post( $data );

    wp_die();
}

// Single Delete Post Using AJAX 

add_action( 'wp_ajax_delete_post', 'delete_post_data' );
function delete_post_data() {

    $post_id = isset( $_POST['post_id'] ) ? (int) $_POST['post_id'] : 0;
    if( ! $post_id ) {
        echo __( 'Post ID not found' );

        wp_die();
    }

    wp_delete_post( $post_id );

    wp_die();
}

// Multiple Post Delete Using AJAX 

add_action( 'wp_ajax_multiple_delete_post', 'multiple_delete_post_data' );

function multiple_delete_post_data() {

    $post_ids = isset( $_POST['post_ids'] ) ? $_POST['post_ids'] : [];
    
    if( $post_ids ) {

        foreach( $post_ids as $post_id ) {

            wp_delete_post( $post_id );
        }
    }
    wp_delete_post($post_ids);

    wp_die();
}