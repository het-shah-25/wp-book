<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://hetshah.me
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 * @author     het shah <shah2002het@gmail.com>
 */

/**
 * includes
 */
// for rendering shortcode's front-end and custom option page
require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/wp-book-admin-display.php';

class Wp_Book_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Book_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Book_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-book-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Book_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Book_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-book-admin.js', array('jquery'), $this->version, false);

    }
    /**
     * Custom funation development
     */
    /**
     * Custom post registration
     */
    public function custom_post_type() {
        register_post_type('book', ['public' => true, 'label' => 'Book', 'menu_icon' => 'dashicons-book']);
    }
    /**
     * Custom Catagory Taxonomy
     */
    public function create_category_tax() {
        $labels = array(
            'name' => _x('Categorys', 'taxonomy general name', 'category'),
            'singular_name' => _x('Category', 'taxonomy singular name', 'category'),
            'search_items' => __('Search Categorys', 'category'),
            'all_items' => __('All Categorys', 'category'),
            'parent_item' => __('Parent Category', 'category'),
            'parent_item_colon' => __('Parent Category:', 'category'),
            'edit_item' => __('Edit Category', 'category'),
            'update_item' => __('Update Category', 'category'),
            'add_new_item' => __('Add New Category', 'category'),
            'new_item_name' => __('New Category Name', 'category'),
            'menu_name' => __('Categorys', 'category'),
        );
        $args = array(
            'labels' => $labels,
            'description' => __('category Taxonomy ', 'category'),
            'hierarchical' => true,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'show_in_quick_edit' => true,
            'show_admin_column' => false,
            'show_in_rest' => true,
        );
        register_taxonomy('category', array('book'), $args);
    }
    /**
     *Custom Tag taxonomy
     */
    public function create_tag_tax() {
        $labels = array(
            'name' => _x('Tags', 'taxonomy general name', 'tag'),
            'singular_name' => _x('Tag', 'taxonomy singular name', 'tag'),
            'search_items' => __('Search Tags', 'tag'),
            'all_items' => __('All Tags', 'tag'),
            'parent_item' => __('Parent Tag', 'tag'),
            'parent_item_colon' => __('Parent Tag:', 'tag'),
            'edit_item' => __('Edit Tag', 'tag'),
            'update_item' => __('Update Tag', 'tag'),
            'add_new_item' => __('Add New Tag', 'tag'),
            'new_item_name' => __('New Tag Name', 'tag'),
            'menu_name' => __('Tags', 'tag'),
        );
        $args = array(
            'labels' => $labels,
            'description' => __('Tag taxonomy ', 'tag'),
            'hierarchical' => false,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'show_in_quick_edit' => true,
            'show_admin_column' => false,
            'show_in_rest' => true,
        );
        register_taxonomy('tag', array('book'), $args);
    }
    /**
     *Mata Data
     */
    public function wp_book_add_meta_box() {
        // add_meta_box(
        //     'wp_book_meta_box',
        //     'Book Meta Information',
        //     'wp_book_render_meta_box',
        //     'book',
        //     'normal',
        //     'high'
        // );
        add_meta_box('details', __('Additional Information', 'wp-book'), array($this, 'wp_book_render_meta_box'), 'book');
    }
    /**
     * Render Meta data
     *
     */
    public function wp_book_render_meta_box($post) {
        wp_nonce_field('wp_book_save_book_meta', 'wp_book_meta_nonce');
        //render html file
        render_custom_metadata($post);
    }
    // Save book meta information
    public function wp_book_save_book_meta($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!isset($_POST['wp_book_meta_nonce']) || !wp_verify_nonce($_POST['wp_book_meta_nonce'], 'wp_book_save_book_meta')) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['book_meta'])) {
            $meta_data = $_POST['book_meta'];

            foreach ($meta_data as $meta_key => $meta_value) {
                if (!empty($meta_value)) {
                    update_post_meta($post_id, $meta_key, $meta_value);
                } else {
                    delete_post_meta($post_id, $meta_key);
                }
            }
        }
    }
    /**
     * Create Custom table
     */
    public function book_create_custom_table() {
        global $wpdb;
        $table_name = 'book_data';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE book_data (
		author_name VARCHAR(255) NOT NULL,
		price VARCHAR(255) NOT NULL,
		publisher VARCHAR(255) NOT NULL,
		year VARCHAR(255) NOT NULL,
		edition VARCHAR(255) NOT NULL,
		url VARCHAR(255) NOT NULL
		) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }
    /**
     * Register custom table
     */
    public function book_register_custom_table() {

        global $wpdb;

        $wpdb->bookinfometa = 'book_data';
        $wpdb->tables[] = 'book_data';

        return;
    }

    //save matadata information

    public function save_book_name_to_table($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!isset($_POST['wp_book_meta_nonce']) || !check_admin_referer('wp_book_save_book_meta', 'wp_book_meta_nonce')) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        global $wpdb;
        $table_name = 'book_data';
        if (array_key_exists('book_meta', $_POST) && is_array($_POST['book_meta'])) {
            $book_meta = $_POST['book_meta'];
            $author_name = sanitize_text_field($book_meta['author_name']);
            $price = sanitize_text_field($book_meta['price']);
            $publisher = sanitize_text_field($book_meta['publisher']);
            $year = sanitize_text_field($book_meta['year']);
            $edition = sanitize_text_field($book_meta['edition']);
            $url = sanitize_text_field($book_meta['url']);
            try {
                $wpdb->insert(
                    $table_name,
                    array(
                        'author_name' => $author_name,
                        'price' => $price,
                        'publisher' => $publisher,
                        'year' => $year,
                        'edition' => $edition,
                        'url' => $url,
                    ));
            } catch (Exception $e) {
                error_log('Database insertion error: ' . $e->getMessage());
            }
        }
    }
    //dashbord widget
    public function wp_book_register_dashboard_widget() {
        wp_add_dashboard_widget(
            'wp_book_top_categories_widget',
            'Top 5 Book Categories',
            'wp_book_render_dashboard_widget'
        );
    }

    // Register and initialize settings

    public function wp_book_add_settings_page() {
        add_submenu_page(
            'edit.php?post_type=book',
            'Book Settings',
            'Settings',
            'manage_options',
            'wp-book-settings',
            'wp_book_render_settings_page'
        );
    }

    public function wp_book_register_settings() {
        // Register settings section
        add_settings_section(
            'wp_book_general_section',
            'General Settings',
            'wp_book_general_section_callback',
            'wp_book_settings'
        );

        // Add settings fields
        add_settings_field(
            'wp_book_currency',
            'Currency',
            'wp_book_currency_callback',
            'wp_book_settings',
            'wp_book_general_section'
        );
        add_settings_field(
            'wp_book_books_per_page',
            'Number of Books Displayed Per Page',
            'wp_book_books_per_page_callback',
            'wp_book_settings',
            'wp_book_general_section'
        );

        // Register settings
        register_setting('wp_book_settings', 'wp_book_currency');
        register_setting('wp_book_settings', 'wp_book_books_per_page');
    }

}
