<?php

// Configura o modo de e-mail para HTML
add_filter('wp_mail_content_type', 'set_content_type');
function set_content_type() {
    return 'text/html';
}

// // Bloqueia acesso do usuário comum ao wp-admin
// add_action( 'init', 'tema_bloqueia_acesso_admin' );
// function tema_bloqueia_acesso_admin() {

//     //var_dump($GLOBALS['wp_post_types']);

//     if (is_user_logged_in() && is_admin() && !current_user_can('administrator'))
//     {
//         wp_redirect(site_url());
//         exit;
//     }
// }

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

?>