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
function bem_next_posts_link_attributes() {
    return 'class="_post-navigation__link _post-navigation__link--next"';
}

/**
* Custom posts navigation previous link
*/
function bem_previous_posts_link_attributes() {
    return 'class="_post-navigation__link _post-navigation__link--previous"';
}
