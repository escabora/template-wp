<?php

if (have_posts()) :

    while (have_posts()) : the_post();

?>

        <div class="m-container">
            <h1><?php single_cat_title(); ?></h1>

            <div class="m-container__contentPost">
                <article class='m-cardPost m-cardPostId-<?php the_ID(); ?>'>
                    <figure class='m-cardPost__figure'>
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail(); ?>
                        <?php endif; ?>
                    </figure>
                    <div class='m-cardPost__description'>
                        <h1><?php the_title(); ?></h1>
                        <p class="a-container__contentPost__data"><?php echo get_the_date(); ?></p>
                        <p class="a-container__contentPost__categories"><?php the_category(', '); ?></p>

                        <?php the_content(); ?>
                        <a class='a-cardPost__btn' href="<?php the_permalink(); ?>">Ver Mais</a>
                    </div>
                </article>
            </div>
        </div>

    <?php endwhile; ?>

    <section class="m-pagination">
        <div class="m-paginationButtons">
            <?php
            /* example code for using the wp_pagenavi plugin */
            if (function_exists('wp_pagenavi')) {
                wp_pagenavi();
            }
            ?>
        </div>
    </section>

<?php else : ?>

    <h2>Nenhum conteúdo encontradob :(</h2>
    <span>Que tal você digitar abaixo o que precisa e pesquisamos para você? (:</span>

<?php endif; ?>