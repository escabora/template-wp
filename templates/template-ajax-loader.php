<?php

/* Template name: Ajax Loader */

get_header();

$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'order' => 'DESC',
    'posts_per_page' => '6',
);
$queryall = new WP_Query($args); ?>

<div class="m-container">
    <h1><?php the_title(); ?></h1>

    <div class="m-container__contentPost --gridContent">
        <?php if ($queryall->have_posts()) :
            while ($queryall->have_posts()) : $queryall->the_post();
        ?>


                <article class='m-cardPost m-cardPostId-<?php the_ID(); ?>'>
                    <figure class='m-cardPost__figure'>
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail(); ?>
                        <?php endif; ?>
                    </figure>
                    <div class='m-cardPost__infos'>
                        <h1><?php the_title(); ?></h1>
                        <p class="a-container__contentPost__data"><?php echo get_the_date(); ?></p>
                        <p class="a-container__contentPost__categories"><?php the_category(', '); ?></p>

                        <p class="a-container__contentPost__description"><?php echo tema_limite_caracteres(get_the_content(), 100); ?></p>
                        <a class='a-cardPost__btn' href="<?php the_permalink(); ?>">Ver Mais</a>
                    </div>
                </article>

            <?php endwhile; ?>
    </div>
    <div class="m-container__contentPost --gridContent js--contentMorePosts">
    </div>

    <div class="m-container">
        <button class="a-contentPost__btn js--a-contentPost__btnMorePosts" data-list-page="2" data-page="single">Carregar mais posts</button>
    </div>

    <div class="m-contentPost__loader-ajax js--m-contentPost__loader-ajax is--hide">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
            <circle cx="84" cy="50" r="2.64408" fill="#ccc">
                <animate attributeName="r" repeatCount="indefinite" dur="0.33333333333333326s" calcMode="spline" keyTimes="0;1" values="7;0" keySplines="0 0.5 0.5 1" begin="0s"></animate>
                <animate attributeName="fill" repeatCount="indefinite" dur="1.333333333333333s" calcMode="discrete" keyTimes="0;0.25;0.5;0.75;1" values="#ccc;#ccc;#ccc;#ccc;#ccc" begin="0s"></animate>
            </circle>
            <circle cx="16" cy="50" r="4.35572" fill="#ccc">
                <animate attributeName="r" repeatCount="indefinite" dur="1.333333333333333s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;7;7;7" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="0s"></animate>
                <animate attributeName="cx" repeatCount="indefinite" dur="1.333333333333333s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="0s"></animate>
            </circle>
            <circle cx="37.1563" cy="50" r="7" fill="#ccc">
                <animate attributeName="r" repeatCount="indefinite" dur="1.333333333333333s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;7;7;7" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.33333333333333326s"></animate>
                <animate attributeName="cx" repeatCount="indefinite" dur="1.333333333333333s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.33333333333333326s"></animate>
            </circle>
            <circle cx="71.1563" cy="50" r="7" fill="#ccc">
                <animate attributeName="r" repeatCount="indefinite" dur="1.333333333333333s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;7;7;7" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.6666666666666665s"></animate>
                <animate attributeName="cx" repeatCount="indefinite" dur="1.333333333333333s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.6666666666666665s"></animate>
            </circle>
            <circle cx="16" cy="50" r="0" fill="#ccc">
                <animate attributeName="r" repeatCount="indefinite" dur="1.333333333333333s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;7;7;7" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.9999999999999999s"></animate>
                <animate attributeName="cx" repeatCount="indefinite" dur="1.333333333333333s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.9999999999999999s"></animate>
            </circle>
        </svg>
    </div>
</div>

<div class="m-container js--m-contentPost__notPost is--hide">
    <span class='a-contentPost__notPost'>As postagens acabaram...</span>
</div>

<?php else : ?>

    </div>
    </div>

    <h2>Nenhum conteúdo encontradob :(</h2>
    <span>Que tal você digitar abaixo o que precisa e pesquisamos para você? (:</span>

<?php endif; ?>

<?php get_footer(); ?>