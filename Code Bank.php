<?php
// Custom Theme Settings
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(
        array(
            'page_title' => 'Theme General Settings',
            'menu_title' => 'Theme Settings',
            'menu_slug' => 'theme-general-settings',
            'capability' => 'manage_options',
            // Changed capability to 'manage_options'
            'redirect' => false
        )
    );
}

// ------------------------------------------------------------------------------------------------------------------------ //

/* =========== SVG Support Start =========== */
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// ------------------------------------------------------------------------------------------------------------------------ //

// Multiple Images upload in user meta (Gallery)

// <input type="file" name="trip_images[]" id="trip_images" accept="image/jpeg, image/jpg, image/png, image/gif" multiple>
// <div id="imagePreviewContainer"></div>
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$post_id = 0;
$uploaded = [];

foreach ($_FILES['vendor_gallery_attachments']['tmp_name'] as $key => $file) {
    $_FILES['_tmp_gallery_image'] = [
        'name' => $_FILES['vendor_gallery_attachments']['name'][$key],
        'type' => $_FILES['vendor_gallery_attachments']['type'][$key],
        'size' => $_FILES['vendor_gallery_attachments']['size'][$key],
        'tmp_name' => $file,
        'error' => $_FILES['vendor_gallery_attachments']['error'][$key],
    ];

    // Upload the file/image.
    $att_id = media_handle_upload('_tmp_gallery_image', $post_id);

    if (!is_wp_error($att_id)) {
        $uploaded[] = $att_id;
    }
}

unset($_FILES['_tmp_gallery_image']);

update_user_meta($vendor_id, 'vendor_gallery', $uploaded);

// ------------------------------------------------------------------------------------------------------------------------ //

// Add new product review
function add_product_review()
{
    if (isset($_POST['new-riview']) && isset($_POST['product_id']) && isset($_POST['user_id']) && isset($_POST['new_ratings']) && isset($_POST['new-comment_content'])) {
        $product_id = $_POST['product_id'];
        $user_id = $_POST['user_id'];
        $rating = $_POST['new_ratings'];
        $comment = $_POST['new-comment_content'];
        $review_data = array(
            'comment_post_ID' => $product_id,
            'user_id' => $user_id,
            'comment_content' => $comment,
            'comment_type' => 'review',
            'comment_meta' => array(
                'rating' => $rating
            )
        );
        wp_insert_comment($review_data);
    }
}
add_action('init', 'add_product_review');

// ------------------------------------------------------------------------------------------------------------------------ //

// Add Cart Quantity In Change Plus Minus Buttons
add_action('woocommerce_after_quantity_input_field', 'bbloomer_display_quantity_plus');
function bbloomer_display_quantity_plus()
{
    echo '<button type="button" class="quantity-plus plus"><i class="fas fa-sort-up"></i></button>';
}

add_action('woocommerce_before_quantity_input_field', 'bbloomer_display_quantity_minus');
function bbloomer_display_quantity_minus()
{
    echo '<button type="button" class="quantity-minus minus"><i class="fas fa-sort-down"></i></button>';
}
?>
<script>
    jQuery(document).on("click", "button.plus, button.minus", function () {
        var qty = jQuery(this).parent(".quantity").find(".qty");
        var val = parseFloat(qty.val());
        var max = parseFloat(qty.attr("max"));
        var min = parseFloat(qty.attr("min"));
        var step = parseFloat(qty.attr("step"));

        if (jQuery(this).is(".plus")) {
            if (max && max <= val) {
                qty.val(max).change();
            } else {
                qty.val(val + step).change();
            }
        } else {
            if (min && min >= val) {
                qty.val(min).change();
            } else if (val > 1) {
                qty.val(val - step).change();
            }
        }

        // Trigger the "Update Cart" button click
        jQuery('button[name="update_cart"]').removeAttr("disabled").trigger("click");
    });
</script>

<?php
// ------------------------------------------------------------------------------------------------------------------------ //

// Send email notification when user registration
function custom_registration_email_notification($user_id)
{

    $user = get_user_by('id', $user_id);
    $to = stripslashes($user->user_email);
    $subject = 'Welcome to Our Site';
    // ' . $user->user_login;
    $img_url = 'https://mindgrow.io/wp-content/uploads/2023/10/Add-a-heading-4.png';
    $message = '<!DOCTYPE html>
	<html lang="en">
	
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Document</title>
	</head>
	<style>
		* {
			padding: 0;
			margin: 0;
			box-sizing: border-box;
		}
	</style>
	<body>
	</body>
	</html>';

    wp_mail($to, $subject, $message);
}

add_action('user_register', 'custom_registration_email_notification');

// ------------------------------------------------------------------------------------------------------------------------ //


// Add a custom price to the product when adding to the cart //
function set_custom_product_price($cart)
{
    $current_user = get_current_user_id();
    $billing_postcode = get_user_meta($current_user, 'billing_postcode', true);
    echo $billing_postcode;

    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    // Loop through each cart item
    foreach ($cart->get_cart() as $cart_item) {

        $custom_field_data = $cart_item['custom_price'];
        $product = $cart_item['data'];
        $custom_price = $custom_field_data * 2;
        $product->set_price($custom_price);
    }
}
add_action('woocommerce_before_calculate_totals', 'set_custom_product_price', 10, 1);


// ------------------------------------------------------------------------------------------------------------------------ //

// Wishlist in custom remove button url
// How to get current user wishlist product list  in YITH wooCommerce plugin wordpress
global $wpdb;

$userID = get_current_user_id();
$listOfProduct = $wpdb->get_results($wpdb->prepare("SELECT id, prod_id FROM wp_yith_wcwl WHERE user_id = %d", $userID), ARRAY_N);

$product_ids = [];
// $wishlist_ids = [];

foreach ($listOfProduct as $row) {
    $product_ids[] = $row[1];
    // $wishlist_ids[] = $row[0];
}

$args = array(
    'post_type' => 'product',  // Adjust post type if needed
    'post__in' => $product_ids,
    'posts_per_page' => -1, // Set the number of products you want to retrieve
);

$query = new WP_Query($args);

echo '<div class="row list_product_wishlist">';

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $product_id = get_the_ID();
        ?>
        <div id="yith-wcwl-row-<?php echo get_the_ID(); ?>" class="col-lg-6 col-md-6 col-sm-6 col-xs-12"
            data-row-id="<?php echo get_the_ID(); ?>">
            <div class="card card-product">

                <div class="remove-wishlist">
                    <a href="<?php echo esc_url(wp_nonce_url(add_query_arg('remove_from_wishlist', $product_id), 'remove_from_wishlist')); ?>"
                        class="remove remove_from_wishlist" title="Remove this product">
                        <i class="fa fa-heart"></i>
                    </a>
                </div>
            </div>
        </div>

        <?php
    }
    wp_reset_postdata(); // Reset the post data
} else {
    echo '<div class="no_data_found">No products added to the wishlist</div>';
}

echo '</div>';

// ------------------------------------------------------------------------------------------------------------------------ //

// How to disable WooCommerce password strength meter.
function wphelp_remove_password_strength_checker()
{
    if (wp_script_is('wc-password-strength-meter', 'enqueued')) {
        wp_dequeue_script('wc-password-strength-meter');
    }
}
add_action('wp_print_scripts', 'wphelp_remove_password_strength_checker', 100);


wp_localize_script(
    'wc-password-strength-meter',
    'pwsL10n',
    array(
        'short' => 'Faible',
        'bad' => 'Indice',
        'good' => 'Better but not enough',
        'strong' => 'Better',
    )
);

add_filter('woocommerce_get_script_data', 'register_password_error_message_text', 20, 2);

function register_password_error_message_text($params, $handle)
{

    if ('wc-password-strength-meter' === $handle) {
        $params['i18n_password_error'] = 'Veuillez entrer un mot de passe plus fort.';
        $params['i18n_password_hint'] = 'Indice : Le mot de passe doit comporter au moins douze caractères. Pour le renforcer, utilisez des lettres majuscules et minuscules, des chiffres et des symboles comme ! " ? $ % ^ & ).';
    }

    return $params;

}

// ------------------------------------------------------------------------------------------------------------------------ //

// stripe in get order details
$payment_intent_id = get_post_meta($order_id, '_stripe_intent_id', true);

require_once ABSPATH . '/wp-content/plugins/woocommerce-gateway-stripe/includes/admin/class-wc-stripe-privacy.php';

\Stripe\Stripe::setApiKey('sk_test_BUHnynAbouCdvNtjdgRoqPaG00EDlJe5zR');

try {
    $paymentIntent = \Stripe\PaymentIntent::retrieve($payment_intent_id);


    $paymentMethod = $paymentIntent->payment_method;


    $paymentMethodDetails = \Stripe\PaymentMethod::retrieve($paymentMethod);

    $cardBrand = $paymentMethodDetails->card->brand;

    echo $last4 = $paymentMethodDetails->card->last4;
    $funding = $paymentMethodDetails->card->funding;

} catch (\Stripe\Exception\CardException $e) {
    echo "Stripe Card Error: " . $e->getMessage();
} catch (\Stripe\Exception\InvalidRequestException $e) {
    echo "Stripe Invalid Request Error: " . $e->getMessage();
} catch (\Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}

// ------------------------------------------------------------------------------------------------------------------------ //
// Disabling plugin updates
function disable_plugin_updates($value)
{
    if (isset($value->response['plugin-folder/plugin-file.php'])) {
        unset($value->response['plugin-folder/plugin-file.php']);
    }
    return $value;
}

add_filter('site_transient_update_plugins', 'disable_plugin_updates');

// ------------------------------------------------------------------------------------------------------------------------ //

// Add the filter for Contact Form 7 reCAPTCHA
add_filter('wpcf7_spam', '__return_false');

// ------------------------------------------------------------------------------------------------------------------------ //

// Google Recaptcha
// V3
// <script src="https://www.google.com/recaptcha/enterprise.js?render=6Ld8kZgpAAAAAAbdygBgHXVVBNF5o5Y5bkoucmvP"></script>


// V2 Process form submissions with reCAPTCHA verification
?>
<script>
    jQuery("#carrer_form").validate({
        rules: {
            hiddenRecaptcha: {
                required: function () {
                    if (grecaptcha.getResponse() == '') {
                        return true;
                    } else {
                        return false;
                    }
                }

            },
        }
        messages: {
            hiddenRecaptcha: "Please check captcha box.",
        }
    })
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<input type="hidden" class="hiddenRecaptcha" name="hiddenRecaptcha" id="hiddenRecaptcha">
<?php
echo '<div class="g-recaptcha" style="margin: 0px;" data-sitekey="6LeHwIUpAAAAAAVdjYOtfNA3Z97sq4RvOcS-nQRk"></div>';
?>
<label for="hiddenRecaptcha" id="hiddenRecaptcha-error" generated="true" class="error" style="display: none;"></label>
<!-- ------------------------------------------------------------------------------------------------------------------------ -->

<!-- Socail medai shear -->

https://www.facebook.com/sharer/sharer.php?u=
<?php echo get_post_permalink(); ?>

https://www.instagram.com/?url=
<?php echo get_post_permalink(); ?>

https://twitter.com/intent/tweet?url=
<?php echo get_post_permalink(); ?>

https://www.linkedin.com/shareArticle?mini=true&url=
<?php echo get_post_permalink(); ?>

https://www.reddit.com/submit?url=YOUR_URL_HERE

https://www.tumblr.com/widgets/share/tool?canonicalUrl=YOUR_URL_HERE

https://plus.google.com/share?url=YOUR_URL_HERE

https://pinterest.com/pin/create/button/?url=YOUR_URL_HERE

http://vk.com/share.php?url=YOUR_URL_HERE

mailto:?subject=YOUR_SUBJECT_HERE&body=YOUR_MESSAGE_HERE%0D%0A%0D%0ARead%20more:%20
<?php echo get_post_permalink(); ?>

<!-- ------------------------------------------------------------------------------------------------------------------------ -->

Google Map Key :

1.Go to the Google Cloud Console.
2.Click the project drop-down and select or create the project for which you want to add an API key.
3.Go to APIs and services -> Library - https://prnt.sc/DXDmPAHT1-yy
4. Enable Places API and Maps javascript API
-> https://prnt.sc/ZxIN1_RgsY4E
-> https://prnt.sc/k8zvm_YO36UX
5.Click the menu button and select APIs & Services > Credentials.
6.On the Credentials page, click + Create Credentials > API key. .
7.Click Close.
The new API key is listed on the Credentials page under API Keys.
(Remember to restrict the API key before using it in production.)
API restrictions:
1.Go to the APIs & Services > Credentials page.
2.Select the API key that you want to set a restriction on. The API key property page appears.
3.Click Restrict key.Select Maps Static API from Select APIs drop-down. If the Maps Static API is not listed, you need
to enable it.


Google recaptcha Key :

Step 1: Go to https://www.google.com/recaptcha/about/
Step 2: Click on the v3 Admin console
Step 3: Click on + icon top : https://prnt.sc/zqiH6FpJbKU5
Step 4: Add Label and select reCaptcha v2 option
Step 5: Add a domain like https://sitenmae.com/
Step 6: Click on submit button
Please provide us the site key and secret key: https://prnt.sc/vJMsM7YU9mxR, so the team can set it there.


<!-- ------------------------------------------------------------------------------------------------------------------------ -->
<div class="form-group">
    <input type="text" name="addressInput" id="addressInput" placeholder="Enter address" class="form-control">
</div>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBskk6x7PQVCbwQww0RUqMI22B91NkMVmc&callback=initMap&libraries=places&v=weekly"
    defer></script>

<script>
    jQuery(document).ready(function () {
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('addressInput'));
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            console.log(place);
        });
    });
</script>


<!-- ------------------------------------------------------------------------------------------------------------------------ -->
<!-- // user profile picture -->
<!-- // Image upload -->
<script>
    $("#shop-logo-pitcher").on("change", function () {
        loader.show();
        var shopLogo = $("#shop-logo-pitcher")[0].files[0];
        console.log(shopLogo);

        if (shopLogo) {
            var logoShop = new FormData();
            logoShop.append("shop_logo_img", shopLogo);
            logoShop.append("action", "update_shop_avatar");

            $.ajax({
                url: ajax_call.ajaxurl,
                type: "POST",
                data: logoShop,
                processData: false,
                contentType: false,
                success: function (response) {
                    $(".shop_logo_pitcher").html(response);
                    loader.show();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                },
                complete: function () {
                    loader.hide();
                },
            });
        } else {
            alert("No file selected!");
            loader.hide();
        }
    });
</script>

<?php

function update_shop_avatar()
{
    if (isset($_FILES['shop_logo_img'])) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        $user_id = get_current_user_id();

        $attachment_id_logo = media_handle_upload('shop_logo_img', 0);

        // Upload the image
        if (!empty($attachment_id_logo)) {

            $data = get_user_meta($user_id, 'dokan_profile_settings', true);

            $data['gravatar'] = $attachment_id_logo;
            update_user_meta($user_id, 'dokan_profile_settings', $data);

            $logo_url = wp_get_attachment_url($attachment_id_logo);
            echo '<img id="image-preview" src="' . $logo_url . '" alt="Image Preview" />';

        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to retrieve image URL.'
            );
        }
    }

    wp_die(); // Always include wp_die() at the end of an AJAX callback
}
add_action('wp_ajax_update_shop_avatar', 'update_shop_avatar');
add_action('wp_ajax_nopriv_update_shop_avatar', 'update_shop_avatar');

?>
<!-- ------------------------------------------------------------------------------------------------------------------------ -->
<!-- Multiple MAP -->

<!-- https://developers.google.com/chart/interactive/docs/gallery/map -->


<div id="map" style="width: 600px; height: 400px;"></div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBskk6x7PQVCbwQww0RUqMI22B91NkMVmc&callback=initMap" async
    defer></script>

<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 41.508225528253405, lng: -73.98050447295905 },
            zoom: 15
        });

        var marker1 = new google.maps.Marker({
            position: { lat: 41.508225528253405, lng: -73.98050447295905 },
            map: map,
            title: '20 W Main St, Beacon, NY 12508'
        });

        var marker2 = new google.maps.Marker({
            position: { lat: 40.74122360650619, lng: -73.98483176195211 },
            map: map,
            title: '110 E 25th St'
        });

        // Info window content for marker1
        var contentString1 = '<div id="content1">' +
            '<h3>20 W Main St, Beacon, NY 12508</h3>' +
            '<p>Location: 41.508225528253405, -73.98050447295905</p>' +
            '</div>';

        // Info window content for marker2
        var contentString2 = '<div id="content2">' +
            '<h3>110 E 25th St</h3>' +
            '<p>Location: 40.74122360650619, -73.98483176195211</p>' +
            '</div>';

        var infowindow1 = new google.maps.InfoWindow({
            content: contentString1
        });

        var infowindow2 = new google.maps.InfoWindow({
            content: contentString2
        });

        // Event listener for marker1
        marker1.addListener('click', function () {
            infowindow1.open(map, marker1);
        });

        // Event listener for marker2
        marker2.addListener('click', function () {
            infowindow2.open(map, marker2);
        });
    }

</script>

<!-- ------------------------------------------------------------------------------------------------------------------------ -->

1. Go to the Stripe website: https://dashboard.stripe.com/register
2. Click on the "Get Started" button.
3. Enter your email address and create a strong password.
4. Enter your business details, such as your business name and type.
5. Provide your contact information, including your full name and phone number.
6. Agree to Stripe's terms of service and privacy policy.
7. Click on the "Create Account" button.
8. You will then be redirected to your Stripe dashboard where you can start setting up your account.
9. To start accepting payments, you will need to connect your bank account to Stripe.
10. You may also need to provide additional information depending on your business and industry.


<!-- ------------------------------------------------------------------------------------------------------------------------ -->
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



// <!-- ------------------------------------------------------------------------------------------------------------------------ -->

// multi please map
?>
<script>
    var location1 = '23.012369,72.561745';
    var location2 = '23.001520,72.502419';

    function initMap() {
        var location1Coords = location1.split(',');
        var location2Coords = location2.split(',');

        var center = { lat: parseFloat(location1Coords[0]), lng: parseFloat(location1Coords[1]) };

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: center
        });

        var infowindow = new google.maps.InfoWindow();
        var locations = [
            ['323, Devpath Complex, B/H Lal Bungalow<br>\
            Off C.G.Road, Navrangpura, Ahmedabad <br>\
            <a target="_blank" href="https://www.google.com/maps/place/Devpath+Complex/@23.0304826,72.5546559,17z/data=!4m14!1m7!3m6!1s0x395e84f1c15dd00b:0x29be72c325abb13a!2sDevpath+Complex!8m2!3d23.0304826!4d72.5572308!16s%2Fg%2F11dym3x_yc!3m5!1s0x395e84f1c15dd00b:0x29be72c325abb13a!8m2!3d23.0304826!4d72.5572308!16s%2Fg%2F11dym3x_yc?entry=ttu">Get Directions</a>', 23.012369, 72.561745],
            ['Shaligram Corporates<br>\
            B/H Dishman Corporate House,C.J Road,<br>\ Ambli, Ahmedabad, Gujarat 380058<br>\
            <a target="_blank" href="https://www.google.com/maps?q=Shaligram+Corporates+-+B/H+Dishman+Corporate+House,C.J+Road,+Ambli,+Ahmedabad,+Gujarat+380058&gs_lcrp=EgZjaHJvbWUyBggAEEUYOdIBBzg1MmowajSoAgCwAgA&um=1&ie=UTF-8">Get Directions</a>', 23.001520, 72.502419],
        ];

        var marker, count;

        for (count = 0; count < locations.length; count++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[count][1], locations[count][2]),
                map: map
            });

            marker.infowindow = new google.maps.InfoWindow();
            marker.infowindow.setContent(locations[count][0], locations[count][6]);
            marker.infowindow.open(map, marker);

            google.maps.event.addListener(marker, 'click', (function (marker, count) {
                return function () {
                    marker.infowindow.open(map, marker);
                }
            })(marker, count));

        }
    }
</script>
<!-- ------------------------------------------------------------------------------------------------------------------------ -->


<!-- Contact Form 7 Form Submit loader -->

<script>
    jQuery(document).ready(function ($) {

        $('body').on('click', '.wpcf7-submit', function () {
            $('.page-loader').show();
        });

        document.addEventListener('wpcf7mailsent', function (event) {
            $('.page-loader').hide();
        }, false);
    });
</script>

<?php
// <!-- ------------------------------------------------------------------------------------------------------------------------ -->
// Remove the form id form url after Contact Form 7 submission
add_action('wpcf7_mail_sent', 'custom_cf7_redirect');
function custom_cf7_redirect($contact_form)
{
    ?>
    <script>
        if (window.location.href.indexOf('#') > -1) {
            window.history.replaceState({}, document.title, window.location.href.split('#')[0]);
        }
    </script>
    <?php
}

?>
