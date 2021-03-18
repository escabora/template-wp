<?php 

// Para quem utiliza o Plugin ACF Pro Descomente essa função
if( function_exists('acf_add_options_page') && is_user_logged_in() && is_admin() && current_user_can('administrator')) {
    acf_add_options_page(array(
        'page_title' 	=> 'Configurações do tema "Tema em Branco"',
        'menu_title'	=> 'Config Tema',
        'menu_slug' 	=> 'tema-theme-options',
        'capability'	=> 'edit_posts',
        'position'		=> 4,
//        'icon_url'		=> get_template_directory_uri().'/assets/img/icone_menu.png' /* Ícone do Menu */
    ));

    /* Utilize o código abaixo para criar novas opções no menu de configuração */
    acf_add_options_sub_page(array(
        'page_title'    => 'Scripts',
        'menu_title'    => 'Scripts',
        'parent_slug'   => 'tema-theme-options',
    ));

    // Banners site
    // acf_add_options_page(array(
    //     'page_title'    => 'Banners',
    //     'menu_title'    => 'Banners',
    //     'menu_slug'     => 'tema-theme-banners',
    //     'capability'    => 'edit_posts',
    //     'position'      => 5,
    // ));
    
    // acf_add_options_sub_page(array(
    //     'page_title'    => 'Banners',
    //     'menu_title'    => 'Banners',
    //     'parent_slug'   => 'tema-theme-banners',
    // ));
}

?>