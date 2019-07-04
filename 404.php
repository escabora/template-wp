<?php
get_header();
?>

<section class="section section--breadcrumb">
  <div class="container">
    <h2 class="title-section"><?php the_title(); ?></h2>
    <?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?> 
  </div>
</section>

<div class="container">
    <div class="container__404">
        <?php _e('Oops, essa página não existe!', 'juliafaria'); ?>
    </div>
</div>

<?php get_footer(); ?>