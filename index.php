<?php

get_header();

?>

<?php

if (have_posts()) :

    while (have_posts()) : the_post();

?>

        <div class="m-container">
            <div class="m-container__contentPost">
            <article class='m-contentPost m-contentPostId-<?php the_ID(); ?>'>
                    <?php if (has_post_thumbnail()) : ?>
                        <figure class='m-contentPost__figure'>
                            <?php the_post_thumbnail(); ?>
                        </figure>
                    <?php endif; ?>
                <h1><?php the_title(); ?></h1>
                <p class="a-contentPost__data"><?php echo get_the_date(); ?></p>
                <?php the_content(); ?>
            </article>
            </div>
        </div>

    <?php endwhile; ?>
<?php else : ?>

    <h2>Nenhum conteúdo encontradob :(</h2>
    <span>Que tal você digitar abaixo o que precisa e pesquisamos para você? (:</span>

<?php endif; ?>

<?php get_footer(); ?>