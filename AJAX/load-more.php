<?php
// Template Name: Load More

get_header();
?>
<div class="contaienr">
    <div class="row" id="load_more">
        <?php
        $args = new WP_Query(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 2,
            'paged' => 1,
        ));
        if ($args->have_posts()) {
            while ($args->have_posts()) {
                $args->the_post(); ?>
                <div class="col-md-4">
                    <?php the_title(); ?>
                </div>
        <?php }
        }
        wp_reset_postdata();
        ?>
    </div>
    <button id="load_more_button">Load More Posts</button>
</div>
<?php
get_footer();
