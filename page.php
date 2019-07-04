<?php get_header(); ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

<section class="section section--content-page">
  <div class="container">
        <p><?php the_content(); ?></p>
    
    <?php endwhile; ?>

    <?php else : ?>

    <h2>Nenhum conteúdo encontradob :(</h2>
    <span>Que tal você digitar abaixo o que precisa e pesquisamos para você? (:</span>

    <?php endif; ?>
  </div>
</section>


<?php get_footer(); ?>