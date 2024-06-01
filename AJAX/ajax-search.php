
<!-- New -->

<div style="text-align: center;">
    <form class="filter-form">
        <label for="certificate-number">Certificate Number:</label>
        <input type="text" id="certificate-number" name="certificate_number">
        <input type="submit" value="Filter">
    </form>
    <div class="student-list">

        <?php
        while (have_posts()) {
            the_post(); ?>

            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php echo get_field('certificate_number'); ?>

        <?php
        }
        ?>
    </div>
</div>
<?php
// Function.php

function enqueue_ajax_script()
{
	wp_enqueue_script('ajax-script', get_template_directory_uri() . '/assets/js/custome.js', array('jquery'), '1.0', true);
	wp_localize_script('ajax-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_script');


function filter_students()
{
	$certificate_number = $_POST['certificate_number'];
	$args = array(
		'post_type' => 'student',
		'meta_query' => array(
			array(
				'key' => 'certificate_number',
				'value' => $certificate_number,
				'compare' => '='
			)
		)
	);
	$query = new WP_Query($args);
	if ($query->have_posts()) :
		while ($query->have_posts()) : $query->the_post();
	?>

		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php echo get_field('certificate_number');
		
		endwhile;
	else :
		echo 'Lol';
	endif;
	wp_reset_postdata();
	die();
}
add_action('wp_ajax_filter_students', 'filter_students');
add_action('wp_ajax_nopriv_filter_students', 'filter_students');

?>
<script>
jQuery(document).ready(function($) {
    $('.filter-form').on('submit', function(e) {
        e.preventDefault();
        var certificate_number = $('#certificate-number').val();
        var data = {
            'action': 'filter_students',
            'certificate_number': certificate_number
        };
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
                $('.student-list').html(response);
            }
        });
    });
});
</script>

<!-- Old -->

<form id="search-form" action="">
    Number:-<br><input type="text" name="number" />
    <input name="submit" type="submit" value="Submit">
</form>

<script>
	$(function() {
		$('#search-form').bind('submit', function() {
			$.ajax({
				type: 'post',
				url: '<?php echo site_url(); ?>/ajax-search.php',
				data: $('form').serialize(),
				success: function(res) {
					console.log(res.length);
					if (res.length == "3") {
						document.getElementById("demo").innerHTML = 'Not Found';
						console.log('not found')
					} else {
						window.location.href = res;
						// console.log(res);
						// document.getElementById('response').setAttribute('href', res);
					}
					//alert('form was submitted');
				}
			});
			return false;
		});
	});
</script>

<?php
include('wp-load.php');

$query = new WP_Query(array(
    'post_type' => 'post_codes',
    'meta_query' => array(
        array("key" => "post_codes", "value" => $_POST['number'])
    ),
));


// query
$link = '#';
if ($query->have_posts()) : ?>
    
        <?php while ($query->have_posts()) : $query->the_post();
            $class = get_field('featured') ? 'class="featured"' : '';
        ?>
            <?php $link =  get_field('url'); ?>
        <?php
            break;
        endwhile; ?>
    
<?php endif; ?>

<?php wp_reset_query();     // Restore global post data stomped by the_post(). 
echo $link;
?>