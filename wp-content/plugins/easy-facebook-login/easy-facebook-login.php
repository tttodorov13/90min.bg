<?php

/* Plugin Name: Easy Facebook Login
 * Description:  Plugin for facebook authentication and User Registration Process
 * Plugin URI: http://www.phpczar.com/blog/
 * Author: Praveen Singh Shekhawat | Wordpress King 
 * Author URI: http://www.phpczar.com/
 * Version: 1.0.2
 *
 * Copyright 2014  Praveen Singh Shekhawat (email : shlokjodha@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @author Praveen Singh Shekhawat
 * @version 1.0.2
 * */

define('EFLURL', plugins_url('easy-facebook-login/'));

class EFL {

    static function Assets() {

        wp_enqueue_script("jquery");
        $easyFacebookLoginJs = EFLURL . 'assets/js/easy-facebook-login.js';
        wp_enqueue_script('easy-facebook-login', $easyFacebookLoginJs);
        $myAppId = get_option('EFLoginAppID');
        $eflAfterLogin = get_option('EFLoginPageAfterLogin');
        $eflAfterLogOut = get_option('EFLoginPageAfterLogOut');


        wp_localize_script('easy-facebook-login', 'EFL', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'siteurl' => site_url("/"),
            'eflAfterLogin' => $eflAfterLogin,
            'eflAfterLogOut' => $eflAfterLogOut,
            'appId' => $myAppId ,
            'nextNonce' => wp_create_nonce('myajax-next-nonce'))
        );

        $easyFacebookStyleCSS = EFLURL . 'assets/css/easy-facebook-style.css';
        wp_enqueue_style('easy-facebook-tabs', $easyFacebookStyleCSS);
    }

    static function adminAssets() {
        if (!strpos($_REQUEST['page'], "efl.admin.page.php"))
            return;
        $easyFacebookTabsJs = EFLURL . 'assets/js/easy-facebook-tabs.js';
        wp_enqueue_script('easy-facebook-tabs', $easyFacebookTabsJs);

        $easyFacebookTabsCSS = EFLURL . 'assets/css/easy-facebook-tabs.css';
        wp_enqueue_style('easy-facebook-tabs', $easyFacebookTabsCSS);
    }

    static function p($args) {
        echo "<pre>";
        print_r($args);
        echo "</pre>";
    }

    static function Login() {

        $user_profile = $_POST['args'];
        $userFBId = $user_profile['Id'];
        $efl_default_role = (get_option('EFLoginDefaultRole')) ? get_option('EFLoginDefaultRole') : "subscriber";
        $save_avatar = (get_option('EFLoginGetAvatar')) ? get_option('EFLoginGetAvatar') : "no";
        $userdata = array(
            'user_login' => $user_profile['Name'],
            'user_nicename' => $user_profile['Username'],
            'user_email' => $user_profile['Email'],
            'display_name' => $user_profile['Name'],
            'first_name' => $user_profile['Name'],
            'last_name' => $user_profile['Name'],
            'role' => $efl_default_role,
            'user_url' => $user_profile['Link'],
            'user_pass' => "123456"
        );

        $user = reset(get_users(array('meta_key' => "efl_u_facebookID", 'meta_value' => $userFBId, 'number' => 1, 'count_total' => false)));

        if (!$user->ID) {
            $user_id = wp_insert_user($userdata);
            update_user_meta($user_id, "efl_u_facebookID", $userFBId);
            wp_set_auth_cookie($user_id);
        } else {
            wp_set_auth_cookie($user->ID);
            $user_id = $user->ID;
        }

        if ($save_avatar == 'yes') {
            $imgthumb = file_get_contents($user_profile['pic_small']);
            $imgfull = file_get_contents($user_profile['pic_large']);
            $upload = wp_upload_dir();
            $upload_dir = $upload['basedir'];
            $avatar_dir = $upload_dir . '/avatars';

            if (!is_dir($avatar_dir)) {
                mkdir($avatar_dir, 0777);
            }
            $upload_dir = $upload_dir . '/avatars/' . $user_id;

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777);
            }
            $filefull = $upload_dir . '/' . $user_profile['Id'] . '-bpfull.jpg';
            $filethumb = $upload_dir . '/' . $user_profile['Id'] . '-bpthumb.jpg';

            file_put_contents($filefull, $imgfull);
            file_put_contents($filethumb, $imgthumb);
        }


        exit;
    }

    static function Logout($args) {
        wp_logout();
    }

    static function AjaxAction() {

        $output = '';
        $nonce = $_POST['nextNonce'];
        $toDo = $_POST['myAction'];
        if (!wp_verify_nonce($nonce, 'myajax-next-nonce'))
            die('Busted!');

        switch ($toDo) {
            case 'login':
                $args = $_POST['parentId'];
                $output = EFL::Login($args);
                break;
            case 'logout':
                $parentId = $_POST['parentId'];
                $output = EFL::Logout($parentId);
                break;
        }
    }

    static function loginBtn() {

        if (is_user_logged_in()):
            echo '<div class="logout"> <input class="EFL-logout" type="button" value="Logout"/> </div>';
        else:
            echo '<div class="login"> <input class="EFL-login" type="button" value="Login"/> </div>';
        endif;
    }

    static function fbRootDiv() {
        echo '<div id="fb-root"></div>';
    }

    static function adminMenu() {
        add_plugins_page('Easy Facebook Login', 'EFL settings', 'manage_options', 'easy-facebook-login/efl.admin.page.php', '');
    }

    static function plugin_action($links, $file) {
        static $my_plugin;
        if (!$my_plugin) {
            $my_plugin = plugin_basename(__FILE__);
        }
        if ($file == $my_plugin) {
            $settings_link = '<a href="?page=easy-facebook-login/efl.admin.page.php">Settings</a>';
            array_unshift($links, $settings_link);
        }
        return $links;
    }

}

add_filter('plugin_action_links', 'EFL::plugin_action', 10, 2);
add_action('wp_ajax_ajaxAction', 'EFL::AjaxAction');
add_action('wp_ajax_nopriv_ajaxAction', 'EFL::AjaxAction');
add_action("wp_footer", "EFL::Assets");
add_action("init", "EFL::adminAssets");
add_action("wp_head", "EFL::fbRootDiv");
add_action("admin_menu", "EFL::adminMenu");
add_shortcode('efl-login', 'EFL::loginBtn');