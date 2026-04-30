<?php get_header(); ?>

<section class="section">
    <h2><?php the_title(); ?></h2>
    <div style="max-width: 800px; margin: 2rem auto;">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; endif; ?>
    </div>
</section>

<?php get_footer(); ?>
