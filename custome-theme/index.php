<?php get_header(); ?>

<main id="site-main">
    <div class="container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                get_template_part( 'template-parts/content', get_post_type() );
            endwhile;
        else :
            get_template_part( 'template-parts/content', 'none' );
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
