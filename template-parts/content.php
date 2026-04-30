<?php
/**
 * Default template part for displaying content
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
        ?>
    </header>

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
    </div>

    <footer class="entry-footer">
        <?php xtreme_entry_footer(); ?>
    </footer>
</article>