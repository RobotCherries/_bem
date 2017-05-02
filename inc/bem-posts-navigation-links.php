<?php
/**
* Custom _bem posts navigation links
*
* @package _bem
*/

add_filter('next_posts_link_attributes', 'bem_next_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'bem_previous_posts_link_attributes');

/**
* Custom posts navigation next link
*/
function _bem_next_posts_link_attributes() {
    return 'class="_post-navigation__link _post-navigation__link--next"';
}

/**
* Custom posts navigation previous link
*/
function _bem_previous_posts_link_attributes() {
    return 'class="_post-navigation__link _post-navigation__link--previous"';
}

add_action( 'navigation_markup_template', '_bem_pagination' );

/**
 * Display posts navigation
 */
function _bem_pagination() {
    $bem_pagination = '';

    if(get_previous_posts_link() || get_next_posts_link()) {
        $bem_pagination .= '<div class="_post-navigation">';

        if(get_previous_posts_link()) {
            $bem_pagination .= '<div class="_post-navigation__item">' . get_previous_posts_link() . '</div>';

        }

        if(get_next_posts_link()) {
            $bem_pagination .= '<div class="_post-navigation__item">' . get_next_posts_link() . '</div>';

        }

        $bem_pagination .= '</div>';
    }

    echo $bem_pagination;
}
