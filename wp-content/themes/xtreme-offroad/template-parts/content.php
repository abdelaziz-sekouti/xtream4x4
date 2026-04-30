<?php
/**
 * Template part for displaying content
 *
 * @package WordPress
 * @subpackage Xtreme_Off_Road
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;

        if ('post' === get_post_type()) :
            ?>
            <div class="entry-meta">
                <?php
                xtreme_posted_on();
                xtreme_posted_by();
                ?>
            </div><!-- .entry-meta -->
        <?php endif;
        ?>
    </header><!-- .entry-header -->

    <?php xtreme_post_thumbnail(); ?>

    <div class="entry-content">
        <?php
        the_content(sprintf(
            wp_kses(
                __('Read more %s', 'xtreme'),
                array(
                    'span' => array(
                        'class' => array(),
                    ),
                )
            ),
            the_title('<span class="screen-reader-text">', '</span>', false)
        ));

        wp_link_pages(array(
            'before' => '<div class="page-links">' . __('Pages:', 'xtreme'),
            'after'  => '</div>',
        ));
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php xtreme_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->