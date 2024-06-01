<?php

/**
 * Check if specific product ID is in the order and perform actions.
 */
add_action( 'woocommerce_thankyou', 'check_order_for_product_id' );

function check_order_for_product_id( $order_id ) {
    // Get the order object
    $order = wc_get_order( $order_id );
    
    $items = $order->get_items();

    foreach ( $items as $item_id => $item ) {
        // Get the product ID
        $product_id = $item->get_variation_id() ? $item->get_variation_id() : $item->get_product_id();

        if ( $product_id === 10 ) {

            $to = 'rajvadariya725@gmail.com';
            $subject = 'Subject of the email';
            $body = 'Body of the email content';
            $headers = array('Content-Type: text/html; charset=UTF-8');

            wp_mail( $to, $subject, $body, $headers );
        }
    }
}
