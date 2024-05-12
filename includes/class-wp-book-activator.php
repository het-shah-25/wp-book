<?php

/**
 * Fired during plugin activation
 *
 * @link       https://hetshah.me
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 * @author     het shah <shah2002het@gmail.com>
 */

class Wp_Book_Activator {
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        flush_rewrite_rules();
        $version = '1.0.0';

        if (defined('wp-book-VERSION')) {
            $version = wp - book - VERSION;
        }
        $wp_book_admin = new wp_book_Admin('rahi_wpbook', $version);
        $wp_book_admin->book_create_custom_table();
    }
}
