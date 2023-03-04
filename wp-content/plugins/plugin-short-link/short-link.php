<?php

/*
 * Plugin Name: Short-link plugin
 * Description: This plugin is designed to shorten links
 * Plugin URI:  https://github.com/Abdujamil/
 * Author URI:  https://github.com/Abdujamil/
 * Author:      Jamil
 * Version:     1.0
 */

define('HOME_URL', home_url());
define('SHORT_LINK_NONCE', 'shortlink-nonce');
define('SHORT_LINK_VERSION', '1');
define('SHORT_LINK_TABLE_NAME', 'short_link');

register_activation_hook(__FILE__, 'short_link_plugin_activation');
function short_link_plugin_activation()
{
    short_link_create_table();
}

register_deactivation_hook(__FILE__, 'short_link_plugin_deactivation');
function short_link_plugin_deactivation()
{
}

function short_link_create_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . SHORT_LINK_TABLE_NAME;

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    //Check if table already exists
    if (!get_option('short_link_table_created')) {
        $query = "
        CREATE TABLE `{$table_name}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `url` TEXT NOT NULL,
            `token` varchar(10) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    	";

        dbDelta($query);

        update_option('short_link_table_created', true);
    }
}

add_shortcode('short_link_form', 'short_link_form');
function short_link_form($atts)
{
    $nonce = wp_create_nonce(SHORT_LINK_NONCE . '-form');
    $out = '
    <div class="login-box">
        <div class="moon"></div>
        <div id="preloader" style="display: none">
        </div>
        <h2>SHORT LINK</h2>
        <form action="" id="short_link_form">
            <input class="form-field" type="url" id="short_link_value" name="link" placeholder="Insert link"><br>
            <input type="hidden" id="short_link_nonce" value="' . $nonce . '"/>
            <input type="submit" value="Submit" id="btn_submit">
            <span id="error"></span>
        </form>
    </div >
    </div>
	';

    return $out;
}

add_action('wp_ajax_short_link_generate', 'ajax_short_link_generate');
add_action('wp_ajax_nopriv_short_link_generate', 'ajax_short_link_generate');
function ajax_short_link_generate()
{
    try {
        if (!check_ajax_referer(SHORT_LINK_NONCE . '-form', '_ajax_nonce', false)) {
            throw new Exception('Nonce invalid');
        }

        $url = trim($_POST['url']); //Remove whitespaces

        //Check empty url
        if (empty($url)) {
            throw new Exception('Please add url...');
        }

        //Check if valid url
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception('Please add valid url');
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'short_link';
        $token = generate_token();
        $data = [
            'url' => $url,
            'token' => $token,
        ];

        $insert = $wpdb->insert($table_name, $data);
        if ($insert === false) {
            throw new Exception('Something wrong. Please try again');
        }

        wp_send_json_success($token);
    } catch (Exception $exception) {
        wp_send_json_error($exception->getMessage(), 400);
    }
}

add_action('wp_enqueue_scripts', 'shortlink_scripts');
function shortlink_scripts()
{
    wp_enqueue_style('shortlink-style', plugin_dir_url(__FILE__) . 'css/main.css', array(), SHORT_LINK_VERSION);
    wp_enqueue_script('shortlink-scripts', plugin_dir_url(__FILE__) . 'js/main.js', array(), SHORT_LINK_VERSION, true);
    wp_localize_script(
        'shortlink-scripts',
        'shortlink_scripts_data',
        [
            'admin_ajax_url' => admin_url('admin-ajax.php'),
        ]
    );
}

//Action for redirect url
add_action('template_redirect', 'short_link_redirect_template');
function short_link_redirect_template()
{
    //Check if open shor url page
    if (str_contains($_SERVER['REQUEST_URI'], '/l/')) {
        //Get token from url
        $params = explode('/', $_SERVER['REQUEST_URI']);
        if (is_array($params) && !empty($params[2])) {
            $token = $params[2];
            global $wpdb;
            $table_name = $wpdb->prefix . SHORT_LINK_TABLE_NAME;

            $data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE token = '{$token}'");
            if ($data) {
                wp_redirect($data->url);
            }
        }
    }
}

function generate_token()
{
    global $wpdb;

    //Variant1
    //return substr(md5(uniqid(rand(), true)),0, 6);

    //Variant 2 - with check in db
    $table_name = $wpdb->prefix . 'short_link';
    $token_exists = true;
    $token = substr(md5(uniqid(rand(), true)),0, 6);
    while ($token_exists) {
        $exists = $wpdb->get_var("SELECT token FROM {$table_name} WHERE token = '{$token}'");
        if (!$exists) {
            $token_exists = false;
        }
    }

    return $token;
}
