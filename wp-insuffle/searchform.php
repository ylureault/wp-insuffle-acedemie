<?php
/**
 * Template for displaying search forms
 *
 * @package WP_Insuffle
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text"><?php echo esc_html_x( 'Rechercher:', 'label', 'wp-insuffle' ); ?></span>
        <input type="search"
               class="search-field"
               placeholder="<?php echo esc_attr_x( 'Rechercher&hellip;', 'placeholder', 'wp-insuffle' ); ?>"
               value="<?php echo get_search_query(); ?>"
               name="s" />
    </label>
    <button type="submit" class="search-submit">
        <?php echo esc_html_x( 'Rechercher', 'submit button', 'wp-insuffle' ); ?>
    </button>
</form>
