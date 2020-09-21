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
            <div class='m-searchFormMenu js--m-searchFormMenu'>
                <div class='m-searchFormMenu__content'>
                    <?php echo get_search_form(); ?>
                    <a href="" class='js--a-searchFormMenuClick' data-change='close'>
                        <svg height="329pt" viewBox="0 0 329.26933 329" width="329pt" xmlns="http://www.w3.org/2000/svg"><path d="m194.800781 164.769531 128.210938-128.214843c8.34375-8.339844 8.34375-21.824219 0-30.164063-8.339844-8.339844-21.824219-8.339844-30.164063 0l-128.214844 128.214844-128.210937-128.214844c-8.34375-8.339844-21.824219-8.339844-30.164063 0-8.34375 8.339844-8.34375 21.824219 0 30.164063l128.210938 128.214843-128.210938 128.214844c-8.34375 8.339844-8.34375 21.824219 0 30.164063 4.15625 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921875-2.089844 15.082031-6.25l128.210937-128.214844 128.214844 128.214844c4.160156 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921874-2.089844 15.082031-6.25 8.34375-8.339844 8.34375-21.824219 0-30.164063zm0 0"/></svg>
                    </a>
                </div>
            </div>
            <div class='m-logo'>
                <a class="a-logo__link" href="<?php echo site_url(); ?>" title="<?php get_bloginfo( 'name' ); ?>">
                    <h3><?php echo get_bloginfo( 'name' ); ?></h3>
                </a>
            </div>
            <nav class="m-header__navMenu">
                <!-- <a class="a-header__navMenu__Link" href="<?php //echo site_url(); ?>" title="">Home</a> -->
                <?php wp_nav_menu( array( 'menu_class' => 'm-header__navMenu__items' ) ); ?>
                <a href="" class='a-searchFormMenu__btn js--a-searchFormMenuClick' data-change='open'>
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 513.28 513.28" style="enable-background:new 0 0 513.28 513.28;" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M495.04,404.48L410.56,320c15.36-30.72,25.6-66.56,25.6-102.4C436.16,97.28,338.88,0,218.56,0S0.96,97.28,0.96,217.6
                                    s97.28,217.6,217.6,217.6c35.84,0,71.68-10.24,102.4-25.6l84.48,84.48c25.6,25.6,64,25.6,89.6,0
                                    C518.08,468.48,518.08,430.08,495.04,404.48z M218.56,384c-92.16,0-166.4-74.24-166.4-166.4S126.4,51.2,218.56,51.2
                                    s166.4,74.24,166.4,166.4S310.72,384,218.56,384z"/>
                            </g>
                        </g>
                    </svg>
                </a>
            </nav>
            <button type="button" class='a-buttonOpenMenu js--a-buttonOpenMenuClick' data-change='open' title='Button open menu moible'>
                <svg id="Layer_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m464.883 64.267h-417.766c-25.98 0-47.117 21.136-47.117 47.149 0 25.98 21.137 47.117 47.117 47.117h417.766c25.98 0 47.117-21.137 47.117-47.117 0-26.013-21.137-47.149-47.117-47.149z"/><path d="m464.883 208.867h-417.766c-25.98 0-47.117 21.136-47.117 47.149 0 25.98 21.137 47.117 47.117 47.117h417.766c25.98 0 47.117-21.137 47.117-47.117 0-26.013-21.137-47.149-47.117-47.149z"/><path d="m464.883 353.467h-417.766c-25.98 0-47.117 21.137-47.117 47.149 0 25.98 21.137 47.117 47.117 47.117h417.766c25.98 0 47.117-21.137 47.117-47.117 0-26.012-21.137-47.149-47.117-47.149z"/></svg>
            </button>
            <a href="" class='a-buttonOpenMenu__close js--a-buttonOpenMenuClick' data-change='close'>
                <svg height="329pt" viewBox="0 0 329.26933 329" width="329pt" xmlns="http://www.w3.org/2000/svg"><path d="m194.800781 164.769531 128.210938-128.214843c8.34375-8.339844 8.34375-21.824219 0-30.164063-8.339844-8.339844-21.824219-8.339844-30.164063 0l-128.214844 128.214844-128.210937-128.214844c-8.34375-8.339844-21.824219-8.339844-30.164063 0-8.34375 8.339844-8.34375 21.824219 0 30.164063l128.210938 128.214843-128.210938 128.214844c-8.34375 8.339844-8.34375 21.824219 0 30.164063 4.15625 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921875-2.089844 15.082031-6.25l128.210937-128.214844 128.214844 128.214844c4.160156 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921874-2.089844 15.082031-6.25 8.34375-8.339844 8.34375-21.824219 0-30.164063zm0 0"/></svg>
            </a>
        </div>
    </header>
    
    <main class='m-main'>