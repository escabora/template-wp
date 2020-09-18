<?php
//global $ft_option;
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>

    <?php
    $customAfterOpenHead = get_field('geral_apos_abrir_head_html', 'option');
    if ($customAfterOpenHead) {
        echo $customAfterOpenHead;
    };
    ?>

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--<meta name="theme-color" content="#00427a">-->
    <title><?php bloginfo(); ?><?php wp_title('|', true, 'left'); ?></title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,900" rel="stylesheet">

    <!-- <link rel="shortcut icon" href="<-?php echo get_template_directory_uri().'/assets/img/icone_liga_color_64.png' ?>" type="image/x-icon" /> -->

    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js"></script>
    <![endif]-->

    <?php wp_head(); ?>

    <?php $cssCustomizado = get_field('geral_css_customizado', 'option'); ?>
    <?php if ($cssCustomizado) : ?>
        <?php echo  '<style type="text/css">' . $cssCustomizado . '</style>'; ?>
    <?php endif; ?>

    <?php
    $customBeforeCloseHead = get_field('geral_antes_fechar_head_html', 'option');
    if ($customBeforeCloseHead) {
        echo $customBeforeCloseHead;
    }
    ?>
</head>

<body <?php echo body_class('has--loader'); ?>>

    <?php
    $customAfterOpenBody = get_field('geral_apos_abrir_body_html', 'option');
    if ($customAfterOpenBody) {
        echo $customAfterOpenBody;
    };
    ?>

    <header class="m-header">
        <div class='m-container'>
            <div class='m-logo'>
                <a class="a-logo__link" href="<?php echo site_url(); ?>" title="<?php get_bloginfo( 'name' ); ?>">
                    <h3><?php echo get_bloginfo( 'name' ); ?></h3>
                </a>
            </div>
            <nav class="m-header__navMenu">
                <!-- <a class="a-header__navMenu__Link" href="<?php //echo site_url(); ?>" title="">Home</a> -->
                <?php wp_nav_menu( array( 'menu_class' => 'm-header__navMenu__items' ) ); ?>
            </nav>
        </div>
    </header>
    
    <main class='m-main'>