<?php
/**
 * Template part for displaying menu with mobile toggler.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _bem
 */
?>

<nav id="_header__navigation" class="_header__navigation" role="navigation">
    <input type="checkbox" class="_header__navigation-checkbox" name="navigation-checkbox" id="navigation-toggler" value="true" aria-controls="primary-menu" aria-expanded="false">
    <label class="_header__navigation-toggler" for="navigation-toggler"><?php esc_html_e( 'Primary Menu', '_bem' ); ?></label>
    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'depth' => 2, 'menu_class' => '_header__menu-list', 'container_class' => '_header__menu', 'walker' => new Bem_Walker_Nav_Menu() ) ); ?>
</nav><!-- #_header__navigation -->