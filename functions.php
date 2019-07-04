<?php

//allow redirection, even if my theme starts to send output to the browser
add_action('init', 'tema_output_buffer');
function tema_output_buffer() {
    ob_start();
}

// Para quem utiliza o Plugin ACF Pro Descomente essa função
// if( function_exists('acf_add_options_page') ) {
//     acf_add_options_page(array(
//         'page_title' 	=> 'Configurações do tema "Tema em Branco"',
//         'menu_title'	=> 'Config Tema',
//         'menu_slug' 	=> 'tema-theme-options',
//         'capability'	=> 'edit_posts',
//         'position'		=> 4,
// //        'icon_url'		=> get_template_directory_uri().'/assets/img/icone_menu.png' /* Ícone do Menu */
//     ));

//     /* Utilize o código abaixo para criar novas opções no menu de configuração */
//     acf_add_options_sub_page(array(
//         'page_title'    => 'Scripts',
//         'menu_title'    => 'Scripts',
//         'parent_slug'   => 'tema-theme-options',
//     ));

//     // Banners site
//     acf_add_options_page(array(
//         'page_title'    => 'Banners',
//         'menu_title'    => 'Banners',
//         'menu_slug'     => 'tema-theme-banners',
//         'capability'    => 'edit_posts',
//         'position'      => 5,
//     ));
    
//     acf_add_options_sub_page(array(
//         'page_title'    => 'Banners',
//         'menu_title'    => 'Banners',
//         'parent_slug'   => 'tema-theme-banners',
//     ));
// }


/* START - ESSENCIAL */

/* Retira meta generator WP */
remove_action('wp_head', 'wp_generator');

/* Esconde atualizações do WP */
add_action('admin_menu','tema_esconde_msg_atualizacao_wp');
function tema_esconde_msg_atualizacao_wp() {
    remove_action('admin_notices', 'update_nag', 3);
}

// Habilita suporte para Thumbnais
add_theme_support('post-thumbnails');

// Muda qualidade das fotos ao regenerar os tamanhos. O Padrão é 82, mas de 82 pra 90 dá uma boa diferença aqui! =)
add_filter('jpeg_quality', function($arg){return 90;});

add_theme_support('html5', array('search-form'));

// Configura o modo de e-mail para HTML
add_filter('wp_mail_content_type', 'set_content_type');
function set_content_type() {
    return 'text/html';
}

// Bloqueia acesso do usuário comum ao wp-admin
add_action( 'init', 'tema_bloqueia_acesso_admin' );
function tema_bloqueia_acesso_admin() {

    //var_dump($GLOBALS['wp_post_types']);

    if (is_user_logged_in() && is_admin() && !current_user_can('administrator'))
    {
        wp_redirect(site_url());
        exit;
    }
}

// Register functions on init
add_action('init', 'registros_init');
function registros_init() {

    /* Adiciona Menus */
    register_nav_menu('principal', 'Menu Principal');

    /* Habilitar Excerpt */
    //add_post_type_support( 'page', 'excerpt' );
}

// Registra rodapé como widgets
if ( function_exists('register_sidebar') ) {

    register_sidebar( array(
        'name' => 'Rodapé 1',
        'id' => 'footer-sidebar-1',
        'description' => 'Adicione as informações para o rodapé',
        'before_widget' => '<div class="col-4">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="title-footer">',
        'after_title' => '</h2>',
    ) );

    register_sidebar( array(
        'name' => 'Rodapé 2',
        'id' => 'footer-sidebar-2',
        'description' => 'Adicione as informações para o rodapé',
        'before_widget' => '<div class="col-4">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="title-footer">',
        'after_title' => '</h2>',
    ) );

    register_sidebar( array(
        'name' => 'Rodapé 3',
        'id' => 'footer-sidebar-3',
        'description' => 'Adicione as informações para o rodapé',
        'before_widget' => '<div class="col-4">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="title-footer">',
        'after_title' => '</h2>',
    ) );

}

// Remove menus do Admin
add_action('admin_menu','remove_menus');
function remove_menus(){
    /*remove_menu_page( 'index.php' );                //Dashboard
    remove_menu_page( 'edit.php?post_type=page' );    //Pages
    remove_menu_page( 'themes.php' );                 //Appearance
    remove_menu_page( 'plugins.php' );                //Plugins
    remove_menu_page( 'users.php' );                  //Users
    remove_menu_page( 'tools.php' );                  //Tools
    remove_menu_page( 'options-general.php' );        //Settings
    remove_menu_page( 'upload.php' );*/               //Media
    remove_menu_page( 'edit.php' );                   //Posts
    remove_menu_page( 'edit-comments.php' );          //Comments
}

add_shortcode('tema-email', 'tema_shortcode_email');
function tema_shortcode_email($atts) {
    $email = antispambot($atts['email']);
    return "<a href='mailto:{$email}'>{$email}</a>";
}

function tema_monta_breadcrumb($pageId = '')
{
    $homeUrl = home_url();

    $breadcrumb = "<div class='pl-breadcrumb'>";

    if($pageId)
    {
        $pagAtual = get_the_title($pageId);

        $strPagAtual = "<i class='fa fa-angle-right'></i><span class='pag-atual'><strong>{$pagAtual}</strong></span>";

        $breadcrumb .= "<i class='fa fa-angle-right' aria-hidden='true'></i><span class='pag-home'><a href='{$homeUrl}'>HOME</a></span>{$strPagAtual}";

    }
    else //404
    {
        $breadcrumb .= "<i class='fa fa-angle-right' aria-hidden='true'></i><span class='pag-home'><a href='{$homeUrl}'>HOME</a></span><i class='fa fa-angle-right' aria-hidden='true'></i><span><strong>ERRO 404. PÁGINA NÃO ENCONTRADA</strong></span>";
    }

    $breadcrumb .= "</div>";

    return $breadcrumb;
}

function tema_limite_caracteres($str, $qtd, $complemento = '...')
{
    return strlen($str) <= $qtd ? $str : substr($str, 0, $qtd).$complemento;
}

if (!is_admin())
{
    add_action('wp_enqueue_scripts', 'tema_js_css_init');
}
else
{
    add_action('admin_enqueue_scripts', 'tema_js_css_admin_init');
}

// Remove Estilos WP Admin Bar
add_action('get_header', 'remove_admin_login_header');
function remove_admin_login_header() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}

function tema_js_css_admin_init()
{
    //JS
    wp_register_script('tema-admin-js', get_template_directory_uri() . '/assets/js/tema-admin.js', array( 'jquery' ), '1.0', true);
    //wp_register_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '3.3.6', true);

    //CSS
    //wp_register_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_register_style('font-awesome-css', get_template_directory_uri() . '/assets/css/font-awesome.min.css');
    wp_register_style('tema-admin-css', get_template_directory_uri() . '/assets/css/tema-admin.css');

    wp_enqueue_script('tema-admin-js');
    wp_enqueue_style('font-awesome-css');
    wp_enqueue_style('tema-admin-css');

    wp_localize_script( 'tema-admin-js', 'ajax_object', array(
        'template_url' => get_template_directory_uri()
    ));
}

function tema_js_css_init()
{

    // Scripts Javascript
    wp_register_script('jquery-js', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'); // jQuery UI
    wp_register_script('tema-js', get_template_directory_uri() . '/assets/dist/js/template-wp-globals.js', array('jquery'), '1.0', true);
   
    // wp_enqueue_script('bootstrap-js');

    wp_enqueue_script('jquery-js');
    wp_enqueue_script('tema-js');

    $adminAjaxUrl = admin_url( 'admin-ajax.php' );

    wp_localize_script( 'tema-js', 'ajax_object', array(
        'ajax_url' => $adminAjaxUrl,
        'home_url' => home_url(),
        'template_url' => get_template_directory_uri(),
        'is_mobile' => wp_is_mobile()
    ));

    // Scripts CSS
    wp_register_style('commons-css', get_template_directory_uri() . '/assets/dist/css/template-wp-globals.css'); /* CSS principal */
    
    wp_enqueue_style('commons-css');
}

/* Sobrescreve o CSS do Login */
add_action('login_enqueue_scripts', 'tema_login_logo');
function tema_login_logo()
{
    echo '<style type="text/css"></style>';
}

/* Muda a URL do logo do painel para a nossa Home */
add_filter( 'login_headerurl', 'my_login_logo_url' );
function my_login_logo_url() {
    return get_bloginfo('url');
}

/* Muda o title do logo do painel para o nome do nosso site */
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
function my_login_logo_url_title() {
    return get_option('blogname').' - '.get_option('blogdescription');
}

/* Este filtro é para desativar a função padrão do WP que envia um e-mail ao trocar a senha */
add_filter('send_password_change_email', '__return_false');

/* Mensagem de redefinição de senha */
add_filter ('retrieve_password_message', 'tema_redefinir_senha', 10, 4);
function tema_redefinir_senha($message, $key, $user_login, $user_data)
{
    $conteudo = array();
    $conteudo[] = array('tipo' => 'texto', 'valor' => '<b>REDEFINI&Ccedil;&Atilde;O DE SENHA</b>', 'cor'=>'#00adef') ;
    $conteudo[] = array('tipo' => 'texto', 'valor' => '<font color="#6f2282"><b>'.$user_login."</b></font>, alguém solicitou a alteração de senha para sua conta.") ;
    $conteudo[] = array('tipo' => 'texto', 'valor' => __('If this was a mistake, just ignore this email and nothing will happen.'));
    $conteudo[] = array('tipo' => 'texto', 'valor' => __('To reset your password, visit the following address:'));
    $conteudo[] = array('tipo' => 'texto', 'valor' => network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login'));

    $message = templateEmail($conteudo);

    return $message;
}

//add_action( 'widgets_init', 'tema_widgets_init' );
function tema_widgets_init() {
    /*
    register_sidebar( array(
        'name'          => 'Twitter Sidebar',
        'id'            => 'sidebar-twitter',
        'description'   => 'Main sidebar that appears on the left.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
    */
}

// Sobrescreve a regra de pesquisa
//add_filter('pre_get_posts','tema_search_filter');
function tema_search_filter($query) {

    if ($query->is_search) {
        //$query->query_vars['post__not_in'] = array(69,73,79,82);
        //$query->query_vars['posts_per_page'] = -1;
    }
    return $query;
}

// Troca o que tiver entre "[]" pela tag <strong>
function tema_trata_string_com_colchetes($frase){
    return str_replace('[', '<strong>', str_replace(']', '</strong>', $frase));
}

// Template de E-mail Padrão do site
function templateEmail($conteudo){
    $header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Tema</title>
    <style type="text/css">
        table { mso-table-lspace: 0pt; mso-table-rspace: 0pt;}

        body{
            background: #ffffff;
        }

        a{color: #06b7e3; text-decoration: none;}

        .tabela-600{width: 600px;}
        .tabela-560{width: 560px;}

        @media screen and (max-width:600px) {
            .tabela-600{width: 100% !important;}
            .tabela-560{width: 100% !important; text-align: center !important;}
            .tabela-resp{width: 100% !important;}
            .img-100{width: 100% !important; height: auto !important}
        }
    </style>
</head>
<body>
<table width="600" class="tabela-600" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff">
    <tr>
        <td>
            <table width="560" class="tabela-560" cellspacing="0" cellpadding="0" align="center">';

    $body = '';

    if ($conteudo && is_array($conteudo)){
        foreach ($conteudo as $linha){
            $cor = isset($linha['cor']) ? $linha['cor'] : '#000000';

            if ($linha['tipo'] == 'texto'){
                $body .= '<tr><td style="padding-bottom: 30px;"><font face="Verdana" color="'.$cor.'" style="font-size: 18px; font-weight: 300;">'.$linha['valor'].'</font></td></tr>';
            }
            else if ($linha['tipo'] == 'dados-usuario'){
                $body .= '<tr><td style="padding-bottom: 15px;"><font face="Verdana" color="#000000" style="font-size: 18px; font-weight: 300;">Seus dados de acesso:</font></td></tr>';
                $body .= '<tr><td><table width="100" cellpadding="0" cellspacing="0" border="0" align="left" class="tabela-resp"><tr><td style="padding: 0 2px;">';
                $body .= '<font face="Verdana" color="#000000" style="font-size: 18px; font-weight: 300;">Usu&aacute;rio:</font>';
                $body .= '</td></tr></table><table cellpadding="0" cellspacing="0" border="0" align="left" class="tabela-resp"><tr><td style="padding: 0 2px;">';
                $body .= '<font face="Verdana" color="'.$cor.'" style="font-size: 14px; font-weight: bold;">'.$linha['valor'][0].'</font>';
                $body .= '</td></tr></table></td></tr><tr><td style="padding-top: 10px;"><table width="100" cellpadding="0" cellspacing="0" border="0" align="left" class="tabela-resp"><tr><td style="padding: 0 2px;">';
                $body .= '<font face="Verdana" color="#000000" style="font-size: 18px; font-weight: 300;">Senha:</font>';
                $body .= '</td></tr></table><table cellpadding="0" cellspacing="0" border="0" align="left" class="tabela-resp"><tr><td style="padding: 0 2px;">';
                $body .= '<font face="Verdana" color="'.$cor.'" style="font-size: 14px; font-weight: bold;">'.$linha['valor'][1].'</font>';
                $body .= '</td></tr></table></td></tr>';
            }
        }
    }

    $footer = '</table>
        </td>
    </tr>
</table>
</body>
</html>';

    return $header.$body.$footer;
}

// Login em AJAX
add_action('wp_ajax_nopriv_tema_login_ajax','tema_login_ajax');
add_action('wp_ajax_tema_login_ajax','tema_login_ajax');
function tema_login_ajax()
{
    $nonce = isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : false;

    if($nonce && wp_verify_nonce($nonce, 'tema_form_login')) {
        $email = isset($_POST['email']) ? $_POST['email'] : false;
        $senha = isset($_POST['senha']) ? $_POST['senha'] : false;

        if ($email && $senha) {
            $return = array('status' => 'alert-danger', 'message' => 'Preencha todos os campos corretamente.');
        }
        else {
            $creds = array();
            $creds['user_login'] = $email;
            $creds['user_password'] = $senha;
            $creds['remember'] = true;
            $usuario = wp_signon($creds, true);

            if(is_wp_error($usuario)) {
                $return = array('status' => 'alert-danger', 'message' => 'Usuário ou senha inválidos');
            } else {
                $return = array('status' => 'alert-success', 'message' => 'Login efetuado com sucesso');
            }
        }
    } else {
        $return = array('status' => 'alert-danger', 'message' => 'Ops, ta querendo nos enganar?');
    }

    echo json_encode($return);
    die();
}

add_action('wp_ajax_tema_confirma_cadastro_ajax','tema_confirma_cadastro_ajax');
function tema_confirma_cadastro_ajax(){

    if(is_user_logged_in()) {
        global $current_user;

        $novaSenha = isset($_POST['nova_senha']) ? $_POST['nova_senha'] : false;
        $confSenha = isset($_POST['conf_senha']) ? $_POST['conf_senha'] : false;

        if ($novaSenha && $confSenha) {
            wp_set_password($novaSenha, $current_user->ID);
            wp_set_auth_cookie($current_user->ID, true);

            $nomeBlog = get_option('blogname');
            $adminEmail = get_bloginfo('admin_email');
            $siteUrl = site_url();

            $conteudo = array();
            $conteudo[] = array('tipo' => 'texto', 'valor' => '<b>CONFIRMA&Ccedil;&Atilde;O DE CADASTRO</b>', 'cor'=>'#00adef') ;
            $conteudo[] = array('tipo' => 'texto', 'valor' => '<font color="#6f2282"><b>'.$current_user->display_name."</b></font>, seu cadastro foi realizado com sucesso!") ;
            $conteudo[] = array('tipo' => 'texto', 'valor' => "Confira abaixo seus novos dados de acesso e n&atilde;o deixe de acompanhar suas atualiza&ccedil;&otilde;es no site <br><a href='{$siteUrl}' style='color: #00adef; text-decoration: none;'><b>{$nomeBlog}</b></a>");
            $conteudo[] = array('tipo' => 'dados-usuario', 'valor' => array($current_user->user_email, $novaSenha));

            $message = templateEmail($conteudo);

            $headers[] = "From: {$nomeBlog} <{$adminEmail}>";
            $headers[] = "Content-Type: text/html; charset=UTF-8";

            $status_email = (wp_mail($current_user->user_email, 'Confirmação de Cadastro', $message, $headers));

            $return = array('status' => 'alert-success', 'message' => 'Senha alterada com sucesso.', 'redirect' => site_url('meu-historico'), 'status_email' => $status_email);
        } else {
            $return = array('status' => 'alert-danger', 'message' => 'Preencha todos os campos corretamente.');
        }
    }
    else {
        $return = array('status' => 'alert-danger', 'message' => 'Ops, tá querendo nos enganar?');
    }

    echo json_encode($return);
    die();
}

add_action('wp_ajax_nopriv_tema_recuperar_senha_ajax','tema_recuperar_senha_ajax');
function tema_recuperar_senha_ajax()
{
    $nonce = isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : false;

    if($nonce && wp_verify_nonce($nonce, 'tema_form_recuperar_senha')) {
        $email = isset($_POST['email']) ? trim($_POST['email']) : false;

        if ($email && is_email($email)){
            global $current_user;

            $randomPassword = wp_generate_password(12, false);
            $updateUser = wp_update_user( array('ID' => $current_user->ID, 'user_pass' => $randomPassword) );

            if ($updateUser){
                $nomeBlog = get_option('blogname');
                $adminEmail = get_bloginfo('admin_email');
                $siteUrl = site_url();

                $conteudo = array();
                $conteudo[] = array('tipo' => 'texto', 'valor' => '<b>RECUPERA&Ccedil;&Atilde;O DE SENHA</b>', 'cor'=>'#00adef') ;
                $conteudo[] = array('tipo' => 'texto', 'valor' => '<font color="#6f2282"><b>'.$current_user->display_name."</b></font>, sua senha foi alterada com sucesso!") ;
                $conteudo[] = array('tipo' => 'texto', 'valor' => "Acesse <a href='{$siteUrl}' style='color: #00adef; text-decoration: none;'><b>{$nomeBlog}</b></a> e fique por dentro de todas novidades e atualiza&ccedil;&otilde;es.");
                $conteudo[] = array('tipo' => 'dados-usuario', 'valor' => array($current_user->user_email, $randomPassword));

                $message = templateEmail($conteudo);

                $headers[] = "From: {$nomeBlog} <{$adminEmail}>";
                $headers[] = "Content-Type: text/html; charset=UTF-8";

                if(wp_mail($email, 'Recuperação de senha', $message, $headers)){
                    $return = array('status' => 'alert-success', 'message' => 'Uma nova senha foi enviada para seu e-mail de cadastro.');
                }
                else{
                    $return = array('status' => 'alert-danger', 'message' => 'Não foi possível enviar o e-mail.');
                }
            }
            else{
                $return = array('status' => 'alert-danger', 'message' => 'Não foi possível recuperar sua senha.');
            }
        }
        else{
            $return = array('status' => 'alert-danger', 'message' => 'Digite um e-mail válido.');
        }
    }
    else{
        $return = array('status' => 'alert-danger', 'message' => 'Ops, ta querendo nos enganar?');
    }

    echo json_encode($return);
    die();
}

add_action('wp_ajax_tema_troca_senha_ajax','tema_troca_senha_ajax');
function tema_troca_senha_ajax()
{
    if(is_user_logged_in()) {
        global $current_user;

        $nonce     = isset($_POST['_wpnonce'])    ? $_POST['_wpnonce']    : false;
        $senha     = isset($_POST['atual_senha']) ? $_POST['atual_senha'] : false;
        $novaSenha = isset($_POST['nova_senha'])  ? $_POST['nova_senha']  : false;
        $confSenha = isset($_POST['conf_senha'])  ? $_POST['conf_senha']  : false;

        if ($nonce && wp_verify_nonce($nonce, 'tema_form_troca_senha')){
            if ($novaSenha && $confSenha && $novaSenha !== "" && $confSenha !== '' && wp_check_password($senha, $current_user->user_pass)) {
                wp_set_password($novaSenha, $current_user->ID);
                wp_set_auth_cookie($current_user->ID, true);

                $nomeBlog = get_option('blogname');
                $adminEmail = get_bloginfo('admin_email');
                $siteUrl = site_url();

                $conteudo = array();
                $conteudo[] = array('tipo' => 'texto', 'valor' => '<b>RECUPERA&Ccedil;&Atilde;O DE SENHA</b>', 'cor'=>'#00adef') ;
                $conteudo[] = array('tipo' => 'texto', 'valor' => '<font color="#6f2282"><b>'.$current_user->display_name."</b></font>, sua senha foi alterada com sucesso!") ;
                $conteudo[] = array('tipo' => 'texto', 'valor' => "Acesse <a href='{$siteUrl}' style='color: #00adef; text-decoration: none;'><b>{$nomeBlog}</b></a> e fique por dentro de todas novidades e atualiza&ccedil;&otilde;es!.");
                $conteudo[] = array('tipo' => 'dados-usuario', 'valor' => array($current_user->user_email, $novaSenha));

                $message = templateEmail($conteudo);

                $headers[] = "From: {$nomeBlog} <{$adminEmail}>";
                $headers[] = "Content-Type: text/html; charset=UTF-8";

                $status_email = (wp_mail($current_user->user_email, 'Nova senha', $message, $headers));

                $return = array('status' => 'alert-success', 'message' => 'Senha alterada com sucesso.', 'redirect' => home_url(), 'status_email' => $status_email);
            }
            else{
                $return = array('status' => 'alert-danger', 'message' => 'Senhas inválidas. Revise suas informações e tente novamente.');
            }
        }
        else {
            $return = array('status' => 'alert-danger', 'message' => 'Ops, tá querendo nos enganar?');
        }
    }
    else{
        $return = array('status' => 'alert-danger', 'message' => 'Ops, tá querendo nos enganar?');
    }

    echo json_encode($return);
    die();

}