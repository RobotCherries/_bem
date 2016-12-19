<?php
/**
 * Custom _bem nav menu
 *
 * @package _bem
 */

/**
 * Adding custom class to navigation links
 */
class Bem_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * Start level
	 *
	 * @param string  $output Accepts output string.
	 * @param integer $depth  Accepts depth integer.
	 */
	function start_lvl( &$output, $depth ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"_header__submenu-list\">\n";
	}

	/**
	 * Start element
	 *
	 * @param string  $output Accepts output string.
	 * @param object  $item   Accepts item object.
	 * @param integer $depth  Accepts depth integer.
	 * @param array   $args  Accepts arguments array.
	 */
	function start_el( &$output, $item, $depth, $args ) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$item_class = $depth > 0 ? '_header__submenu-item' : '_header__menu-item';
		$class_names = ' class="' . $item_class . ' ' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';

		$attributes	= ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target )		 ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn )				? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url )				? ' href="' . esc_attr( $item->url ) . '"' : '';

		$link_class = $depth > 0 ? '_header__submenu-link' : '_header__menu-link';
		$attributes .= ' class="' . $link_class . '"';

		$description	= ! empty( $item->description ) ? '<span class="_header__menu-item-description">' . esc_attr( $item->description ) . '</span>' : '';

		if ( 0 !== $depth ) {
			$description = $append = $prepend = '';
		}

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= $description . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
