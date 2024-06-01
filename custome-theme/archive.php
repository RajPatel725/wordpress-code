<?php get_header(); ?>

<main id="site-main">
    <div class="container">
        <header class="archive-header">
            <h1 class="archive-title">
                <?php
                echo get_the_archive_title();
                ?>
            </h1>
        </header>

        <?php
        if (have_posts()):
            while (have_posts()):
                the_post();

                the_title();
                echo 'this is simple contetnt';
            endwhile;

            the_posts_pagination();

        else:
            get_template_part('template-parts/content', 'none');
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>