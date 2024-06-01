</div><!-- #content -->

<footer id="site-footer">
    <div class="container">
        <div class="site-info">
            <?php if ( get_theme_mod( 'footer_text' ) ) : ?>
                <p><?php echo get_theme_mod( 'footer_text' ); ?></p>
            <?php else : ?>
                <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
            <?php endif; ?>
        </div>
        <div class="footer-menu">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'menu_id'        => 'footer-menu',
            ) );
            ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
