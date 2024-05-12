<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://hetshah.me
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 * @author     het shah <shah2002het@gmail.com>
 */
class Wp_Book_Deactivator {
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate() {
        flush_rewrite_rules();
        global $wpdb;
        $wpdb->query('DROP TABLE IF EXISTS book_data');
    }
}
