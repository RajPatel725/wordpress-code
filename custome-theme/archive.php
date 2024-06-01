<?php get_header(); ?>

<main id="site-main">
    <div class="container">
        <header class="archive-header">
            <h1 class="archive-title">
                <?php
                if ( is_category() ) :
                    single_cat_title();
                elseif ( is_tag() ) :
                    single_tag_title();
                elseif ( is_author() ) :
                    the_post();
                    echo 'Author Archives: ' . get_the_author();
                    rewind_posts();
                elseif ( is_day() ) :
                    echo 'Daily Archives: ' . get_the_date();
                elseif ( is_month() ) :
                    echo 'Monthly Archives: ' . get_the_date( 'F Y' );
                elseif ( is_year() ) :
                    echo 'Yearly Archives: ' . get_the_date( 'Y' );
                else :
                    echo 'Archives';
                endif;
                ?>
            </h1>
        </header>

        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                
                the_title();
                echo 'this is simple contetnt';
            endwhile;

            the_posts_pagination();

        else :
            get_template_part( 'template-parts/content', 'none' );
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
