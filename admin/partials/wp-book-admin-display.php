<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://hetshah.me
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin/partials
 */

/**
 * Helper Function for rendering book info
 * for shortcode
 *
 * @since    1.0.6
 */
//Dashboard Widget code
function wp_book_render_dashboard_widget() {
    $categories = get_terms(array(
        'taxonomy' => 'book_category',
        'orderby' => 'count',
        'order' => 'DESC',
        'number' => 5,
    ));
    if (!empty($categories) && !is_wp_error($categories)) {
        echo '<ul>';
        foreach ($categories as $category) {
            echo '<li>' . esc_html ($category->name) . ' (' . $category->count . ')</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No book categories found.</p>';
    }
}

//Custom metadata
function render_custom_metadata($post) {
    $author_name = get_post_meta($post->ID, 'author_name', true);
    $price = get_post_meta($post->ID, 'price', true);
    $publisher = get_post_meta($post->ID, 'publisher', true);
    $year = get_post_meta($post->ID, 'year', true);
    $edition = get_post_meta($post->ID, 'edition', true);
    $url = get_post_meta($post->ID, 'url', true);
    ?>

    <table class="form-table">
        <tr>
            <th><label for="author_name">Author Name</label></th>
            <td>
                <input type="text" name="book_meta[author_name]" id="author_name" value="<?php echo esc_attr($author_name); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="price">Price</label></th>
            <td>
                <input type="text" name="book_meta[price]" id="price" value="<?php echo esc_attr($price); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="publisher">Publisher</label></th>
            <td>
                <input type="text" name="book_meta[publisher]" id="publisher" value="<?php echo esc_attr($publisher); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="year">Year</label></th>
            <td>
                <input type="text" name="book_meta[year]" id="year" value="<?php echo esc_attr($year); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="edition">Edition</label></th>
            <td>
                <input type="text" name="book_meta[edition]" id="edition" value="<?php echo esc_attr($edition); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="url">URL</label></th>
            <td>
                <input type="text" name="book_meta[url]" id="url" value="<?php echo esc_attr($url); ?>" class="regular-text">
            </td>
        </tr>
		</table>
		<?php
}
//Book Setting page
function wp_book_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Book Settings</h1>
        <form method="post" action="options.php">
            <?php
settings_fields('wp_book_settings');
    do_settings_sections('wp_book_settings');
    submit_button();
    ?>
        </form>
    </div>
    <?php
}

function wp_book_general_section_callback() {
    echo 'Configure general settings for Books.';
}

// Callback function for the currency field
function wp_book_currency_callback() {
    $currency = get_option('wp_book_currency', '$');
    echo '<input type="text" name="wp_book_currency" value="' . esc_attr($currency) . '" class="regular-text">';
}

// Callback function for the books per page field
function wp_book_books_per_page_callback() {
    $books_per_page = get_option('wp_book_books_per_page', 10);
    echo '<input type="number" name="wp_book_books_per_page" value="' . esc_attr($books_per_page) . '" min="1" step="1">';
}
?>
