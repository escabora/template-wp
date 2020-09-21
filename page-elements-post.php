<?php

/* Template name: Elements Posts */

get_header();

?>

<?php

if (have_posts()) :

    while (have_posts()) : the_post(); ?>
        <div class="m-container">
            <div class="m-container__contentPost">
                <article class='m-contentPost m-contentPostId-<?php the_ID(); ?>'>
                    <h1><?php the_title(); ?></h1>
                    <p class="a-contentPost__data"><?php echo get_the_date(); ?></p>
                    <hr /><br />
                    <?php get_template_part('templates/template', 'elements-post'); ?>

                </article>
            </div>
        </div>
    <?php endwhile; ?>

<?php endif; ?>

<?php get_footer(); ?>