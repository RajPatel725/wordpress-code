<?php get_header(); ?>

<main id="site-main">
    <div class="container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
               
                the_title();
                
            endwhile;
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
