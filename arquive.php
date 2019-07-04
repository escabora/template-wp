<?php 
/*

    Template Name: Archives
*/
    
get_header(); ?>


  <div class="container-geral">
      <div class="container">
          <h1><?php single_cat_title(); ?></h1>
          <?php
          if(have_posts()): ?>

                  <?php while ( have_posts() ) : the_post(); ?>

                      <div class="colum-6">

                          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                              <a class="wrapper-imagem" href="<?php the_permalink(); ?>">
                                  <?php if(has_post_thumbnail()): ?>
                                      <?php the_post_thumbnail(); ?>
                                  <?php else: ?>
                                      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/post_sem_imagem.gif" class="sem-imagem" alt="<?php _e('Post sem imagem', 'Title Site') ?> - Description"/>
                                  <?php endif; ?>
                              </a>
                              <div class="wrapper-cats-data">
                                  <span class="cats"><?php the_category(', '); ?></span>
                                  <span class="separador">/</span>
                                  <span class="data"><?php echo get_the_date(); ?></span>
                              </div>
                              <a href="<?php the_permalink(); ?>">
                                  <h2><?php the_title(); ?></h2>
                              </a>
                          </article>

                      </div>

                  <?php endwhile; ?>

              <?php

              the_posts_pagination( array(
                  'mid_size' => 2,
                  'prev_text' => '<span class="bolinha"><span>&lt;</span></span>'.__('Posts recentes', 'template-wp'),
                  'next_text' => __('Posts antigos', 'template-wp').'<span class="bolinha"><span>&gt;</span></span>'
              ) );

              ?>

          <?php else: ?>

              <div class="conteudo"><?php _e('Não há posts para essa categoria!', 'template-wp'); ?></div>
              <br/>

          <?php endif; ?>

      </div>

  </div>

<?php get_footer(); ?>
