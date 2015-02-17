<?php
    /*
    Plugin Name: reEmbed script adder
    Description: A plugin to add a script in order for the reEmbed player to work.
    Author: reEmbed
    Version: 1.0.1
    */
    class ScriptAdder {
        public static $code;

        public static function includeScript() {
            $code = self::$code;
            echo  '<script data-cfasync="false">  (function(a,b,c,d,e){var f=a+"Q";b[a]=b[a]||{};b[a][d]=b[a][d]||function(){
  (b[f]=b[f]||[]).push(arguments)};a=c.getElementsByTagName(e)[0];c=c.createElement(e);c.async=1;
  c.src="' . $code . '";
  a.parentNode.insertBefore(c,a)})("reEmbed",window,document,"setupPlaylist","script");
</script>';
        }
    }
    class AdminMenu {
        public static function adminOptions() {
            add_options_page( 'reEmbed Script', 'reEmbed Script', 'edit_posts', 'reEmbedScript', array( 'AdminMenu', 'addOptions' ) );
        }
        public static function addOptions() {
            include( 'optionsPage.php' );
        }
    }
    if ( !( ScriptAdder::$code = get_option( 'reembed_script_code' ) ) ) {
        ScriptAdder::$code = '//static.reembed.com/data/scripts/g_4542_8d615e63791799074e5cb8ec54b73a9a.js';
        add_option( 'reembed_script_code', ScriptAdder::$code );
    }
    add_action( 'wp_head', array( 'ScriptAdder', 'includeScript' ) );
    add_action( 'admin_menu', array( 'AdminMenu', 'adminOptions' ) );
