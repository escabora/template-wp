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

    <?php echo get_field('geral_apos_abrir_head_html', 'option'); ?>

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--<meta name="theme-color" content="#00427a">-->
    <title><?php bloginfo(); ?><?php wp_title('|', true, 'left' );?></title>
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,900" rel="stylesheet">
    
    <!-- <link rel="shortcut icon" href="<-?php echo get_template_directory_uri().'/assets/img/icone_liga_color_64.png' ?>" type="image/x-icon" /> -->

    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js"></script>
    <![endif]-->

    <?php wp_head(); ?>
    
    <?php $cssCustomizado = get_field('geral_css_customizado', 'option'); ?>
    <?php if($cssCustomizado): ?>
        <?php echo  '<style type="text/css">'.$cssCustomizado.'</style>'; ?>
    <?php endif; ?>
    <?php echo get_field('geral_antes_fechar_head_html', 'option'); ?>
</head>

<body>

<?php echo get_field('geral_apos_abrir_body_html', 'option'); ?>

<header class="header">
    <nav class="nav-menu">
        <a class="nav-menu__link" href="<?php echo site_url(); ?>" title="">Home</a>
    </nav>    
</header>








