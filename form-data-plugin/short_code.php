<?php

add_action( "wp_head" , "save_form_data" );

function save_form_data(){

global $reg_errors;
$reg_errors = new WP_Error;


if( $_POST )
{
    global $wpdb;

    $name = sanitize_text_field($_POST['cf_name']);
    $contact = sanitize_text_field($_POST['cf_contact']);
    $massage = sanitize_textarea_field($_POST['cf_massage']);


    if( $name == '' ){
        $reg_errors->add('cf_name','Name is required.');
    }else{
        if (!preg_match ("/^[a-zA-z]*$/", $_fname) ) {  
            $reg_errors->add('cf_name','Only alphabets and whitespace are allowed.');
        }
    }

    if( $contact == ''){
        $reg_errors->add('cf_contact','Phone is required.');
    }else{
        if ( is_numeric( $cf_contact ) )
        {
            $reg_errors->add( 'cf_contact', 'Phone is not valid!' );
        }       
    }

    if( count( $reg_errors->get_error_messages() ) <= 0) {

        $wpdb->insert( 
            'wp_form_data', 
            array( 
                'name' => $name, 
                'contact' => $contact ,
                'massage' => $massage
            )
        );

        wp_redirect( site_url() );
        exit;
    }
}

    if( count( $reg_errors->get_error_messages() ) > 0)
    {
        echo '<div class="alert alert-danger"><ul style="margin-left: 1.5em;">';
        foreach ( $reg_errors->get_error_messages() as $error )
        {
            echo '<li>'.$error.'</li>';
        }
        echo '</ul></div>';
    }
    if( isset($_REQUEST['error']) && $_REQUEST['error'] == '0' )
        {
            echo '<div class="alert alert-success">Registration has been successfully.</div>';
        }

}

add_shortcode( "dislay_form" , "dislay_form_fronend" );

function dislay_form_fronend(){   
 
    ob_start();
    ?>
    <form action="" method="post">
        <label for="name"> Name
            <input type="text" name="cf_name" id="name" value="<?php echo (isset($_POST['cf_name']) ? $_POST['cf_name']:''); ?>">
        </label>
        <label for="contact"> Contact No
            <input type="number" name="cf_contact" id="contact" value="<?php echo (isset($_POST['cf_contact']) ? $_POST['cf_contact']:''); ?>">
        </label>
        <label for="massage"> Massage
            <textarea name="cf_massage" id="cf_massage" cols="1" rows="1" style="width:250px;"></textarea>
        </label>

        <input type="submit" name="cf_submit" value="submit" />
    </form>

    <?php 
    ob_end_flush();
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
