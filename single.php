<?php

get_header();

?>

<?php

if ( have_posts() ) :

    while ( have_posts() ) : the_post();

        ?>
        
        <div class="container">    
            <div class="content-post">
                <h1><?php the_title(); ?></h1>
                <div class="data"><?php echo get_the_date(); ?></div>
                <?php the_content(); ?>
            </div>
        </div>

    <?php endwhile; ?>

<?php endif; ?>

<?php get_footer(); ?>