<?php

/* Template name: Home Page */

get_header();

?>

<?php

if ( have_posts() ) :

    while ( have_posts() ) : the_post(); ?>

        <?php /* Recupera um Template */ get_template_part('templates/template','home'); ?>

    <?php endwhile; ?>

<?php endif; ?>

<?php get_footer(); ?>