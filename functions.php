<?php

//Regras Padrões
require_once('includes/roles/roles-default.php');

//Regras Plugin ACF
require_once('includes/roles/roles-acf.php');

//Funções de ajuda
require_once('includes/helpers.php');

//allow redirection, even if my theme starts to send output to the browser
add_action('init', 'tema_output_buffer');
function tema_output_buffer()
{
    ob_start();
}


/* START - ESSENCIAL */

/* Retira meta generator WP */
remove_action('wp_head', 'wp_generator');

/* Esconde atualizações do WP */
add_action('admin_menu', 'tema_esconde_msg_atualizacao_wp');
function tema_esconde_msg_atualizacao_wp()
{
    remove_action('admin_notices', 'update_nag', 3);
}

// Habilita suporte para Thumbnais
add_theme_support('post-thumbnails');

// Add automatic image sizes
if (function_exists('add_image_size')) {
    add_image_size('banner-home', 1920, 507, true);
}


// Muda qualidade das fotos ao regenerar os tamanhos. O Padrão é 82, mas de 82 pra 90 dá uma boa diferença aqui! =)
add_filter('jpeg_quality', function ($arg) {
    return 90;
});

add_theme_support('html5', array('search-form'));

// Register functions on init
add_action('init', 'registros_init');
function registros_init()
{

    /* Adiciona Menus */
    register_nav_menu('principal', 'Menu Principal');

    /* Habilitar Excerpt */
    //add_post_type_support( 'page', 'excerpt' );
}

//limitar o destaque do post
function excerpt($limit)
{
    $limit = 20;
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt) >= $limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt) . '...';
    } else {
        $excerpt = implode(" ", $excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
    return $excerpt;
}

// Registra rodapé como widgets
if (function_exists('register_sidebar')) {

    register_sidebar(array(
        'name' => 'Rodapé 1',
        'id' => 'footer-sidebar-1',
        'description' => 'Adicione as informações para o rodapé',
        'before_widget' => '<div class="">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="title-footer">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Rodapé 2',
        'id' => 'footer-sidebar-2',
        'description' => 'Adicione as informações para o rodapé',
        'before_widget' => '<div class="">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="title-footer">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Rodapé 3',
        'id' => 'footer-sidebar-3',
        'description' => 'Adicione as informações para o rodapé',
        'before_widget' => '<div class="">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="title-footer">',
        'after_title' => '</h2>',
    ));
}

// Remove menus do Admin
add_action('admin_menu', 'remove_menus');
function remove_menus()
{
    /*remove_menu_page( 'index.php' );                //Dashboard
    remove_menu_page( 'edit.php?post_type=page' );    //Pages
    remove_menu_page( 'themes.php' );                 //Appearance
    remove_menu_page( 'plugins.php' );                //Plugins
    remove_menu_page( 'users.php' );                  //Users
    remove_menu_page( 'tools.php' );                  //Tools
    remove_menu_page( 'options-general.php' );        //Settings
    remove_menu_page( 'upload.php' );*/               //Media
    // remove_menu_page( 'edit.php' );                   //Posts
    // remove_menu_page( 'edit-comments.php' );          //Comments
}

add_shortcode('tema-email', 'tema_shortcode_email');
function tema_shortcode_email($atts)
{
    $email = antispambot($atts['email']);
    return "<a href='mailto:{$email}'>{$email}</a>";
}

function tema_monta_breadcrumb($pageId = '')
{
    $homeUrl = home_url();

    $breadcrumb = "<div class='pl-breadcrumb'>";

    if ($pageId) {
        $pagAtual = get_the_title($pageId);

        $strPagAtual = "<i class='fa fa-angle-right'></i><span class='pag-atual'><strong>{$pagAtual}</strong></span>";

        $breadcrumb .= "<i class='fa fa-angle-right' aria-hidden='true'></i><span class='pag-home'><a href='{$homeUrl}'>HOME</a></span>{$strPagAtual}";
    } else //404
    {
        $breadcrumb .= "<i class='fa fa-angle-right' aria-hidden='true'></i><span class='pag-home'><a href='{$homeUrl}'>HOME</a></span><i class='fa fa-angle-right' aria-hidden='true'></i><span><strong>ERRO 404. PÁGINA NÃO ENCONTRADA</strong></span>";
    }

    $breadcrumb .= "</div>";

    return $breadcrumb;
}

function tema_limite_caracteres($str, $qtd, $complemento = '...')
{
    return strlen($str) <= $qtd ? $str : substr($str, 0, $qtd) . $complemento;
}

if (!is_admin()) {
    add_action('wp_enqueue_scripts', 'tema_js_css_init');
} else {
    add_action('admin_enqueue_scripts', 'tema_js_css_admin_init');
}

// Remove Estilos WP Admin Bar
add_action('get_header', 'remove_admin_login_header');
function remove_admin_login_header()
{
    remove_action('wp_head', '_admin_bar_bump_cb');
}

function tema_js_css_admin_init()
{
    //JS
    wp_register_script('tema-admin-js', get_template_directory_uri() . '/assets/js/tema-admin.js', array('jquery'), '1.0', true);
    //wp_register_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '3.3.6', true);

    //CSS
    //wp_register_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_register_style('font-awesome-css', get_template_directory_uri() . '/assets/css/font-awesome.min.css');
    wp_register_style('tema-admin-css', get_template_directory_uri() . '/assets/css/tema-admin.css');

    // wp_enqueue_script('tema-admin-js');
    // wp_enqueue_style('font-awesome-css');
    // wp_enqueue_style('tema-admin-css');

    wp_localize_script('tema-admin-js', 'ajax_object', array(
        'template_url' => get_template_directory_uri()
    ));
}

function tema_js_css_init()
{

    // Scripts Javascript
    wp_register_script('commonJs', get_template_directory_uri() . '/assets/dist/js/template-wp-globals.js', array('jquery'), '27.0', true);
    wp_register_script('homeJs', get_template_directory_uri() . '/assets/dist/js/template-wp-home.js');
    wp_register_script('categoryJs', get_template_directory_uri() . '/assets/dist/js/template-wp-category.js');
    wp_register_script('searchJs', get_template_directory_uri() . '/assets/dist/js/template-wp-search.js');

    //Vendors
    wp_register_script('jquery-js', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'); // jQuery UI
    wp_register_script('jquery-validate', 'https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js');
    wp_register_script('jquery-migrate', 'http://code.jquery.com/jquery-migrate-1.2.1.min.js');
    wp_register_script('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js');
    wp_register_script('mask', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js');


    wp_enqueue_script('jquery-migrate');
    wp_enqueue_script('slick-carousel');
    wp_enqueue_script('jquery-validate');
    wp_enqueue_script('mask');
    wp_enqueue_script('commonJs');

    if (is_home()) {
        wp_enqueue_script('homeJs');
    }
    if (is_category() || is_archive()) {
        wp_enqueue_script('categoryJs');
    }
    if (is_search()) {
        wp_enqueue_script('searchJs');
    }


    $adminAjaxUrl = admin_url('admin-ajax.php');

    wp_localize_script('tema-js', 'ajax_object', array(
        'ajax_url' => $adminAjaxUrl,
        'home_url' => home_url(),
        'template_url' => get_template_directory_uri(),
        'is_mobile' => wp_is_mobile()
    ));

    // Scripts CSS
    wp_register_style('commonCss', get_template_directory_uri() . '/assets/dist/css/template-wp-globals.css'); 
    wp_register_style('homeCss', get_template_directory_uri() . '/assets/dist/css/template-wp-home.css');
    wp_register_style('categoryCss', get_template_directory_uri() . '/assets/dist/css/template-wp-category.css');
    wp_register_style('searchCss', get_template_directory_uri() . '/assets/dist/css/template-wp-search.css');


    wp_enqueue_style('commonCss');

    if (is_home()) {
        wp_enqueue_style('homeCss');
    }
    if (is_category() || is_archive()) {
        wp_enqueue_style('categoryCss');
    }
    if (is_search()) {
        wp_enqueue_style('searchCss');
    }
}

function load_posts_by_ajax_callback()
{
    global $post;

    check_ajax_referer('load_more_posts', 'security');
    $paged = $_POST['page'];
    $cat_name = $_POST['category_name'];
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => '6',
        'order' => 'DESC',
        'paged' => $paged,
        'category_name' => $cat_name,
    );
    $my_posts = new WP_Query($args);
    if ($my_posts->have_posts()) :
?>
        <?php while ($my_posts->have_posts()) : $my_posts->the_post(); ?>

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
    <?php endif;

    wp_die();
}

add_action('wp_ajax_load_posts_by_ajax', 'load_posts_by_ajax_callback');
add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_posts_by_ajax_callback');



function wpa56343_search()
{
    $authorID = $_POST['author__in'];
    $author = get_user_by('ID', $authorID);
    if (!is_null($author))
        $author_name = $author->user_nicename;
    if (!isset($_POST['search']))
        exit;

    query_posts(
        array(
            'posts_per_page' => 50,
            'no_found_rows' => true,
            'post_type' => 'empreendimentos',
            's' => wp_unslash((string) $_POST['search']),
        )
    );

    // The Loop
    while (have_posts()) : the_post();
    ?>
        <article class='m-cardPost m-cardPostId-<?php the_ID(); ?>'>
            <figure class='m-cardPost__figure'>
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail(); ?>
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/post_sem_imagem.gif" class="sem-imagem" alt="<?php _e('Post sem imagem', 'Title Site') ?> - Description" />
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
<?php
    endwhile;

    // Reset Query
    wp_reset_query();
    wp_die();
}

add_action('wp_ajax_nopriv_wpa56343_search', 'wpa56343_search');
add_action('wp_ajax_wpa56343_search',        'wpa56343_search');




?>