<?php
/**
 * Custom _bem script loader
 *
 * @package _bem
 */

/**
 * _bem script loader
 *
 * @param string  $tag    Accepts script tag.
 * @param array   $handle Accepts script name.
 * @param integer $src    Accepts source type.
 */
function _bem_script_loader_tag( $tag, $handle, $src ) {
	// The handles of the enqueued scripts we want to defer
	// $defer_scripts = array(
    //     'wp-embed',
	// 	'dsq_count_script'
	// );
    //
    // if ( in_array( $handle, $defer_scripts ) ) {
    //     return '<script src="' . $src . '" type="text/javascript" defer></script>' . "\n";
    // }

    return $tag;
}

add_filter( 'script_loader_tag', '_bem_script_loader_tag', 10, 3 );

/**
 * _bem style loader
 *
 * @param string  $tag    Accepts style tag.
 * @param array   $handle Accepts style name.
 * @param integer $src    Accepts source type.
 * @param integer $src    Accepts media.
 */
function _bem_style_loader_tag( $tag, $handle, $src, $media ) {
	// The handles of the enqueued styles we want to defer
	// $defer_styles = array(
    //     'metaslider-responsive-slider',
	// 	'metaslider-public',
    //     'pibfi_pinterest_style'
	// );
    //
    // if ( in_array( $handle, $defer_styles ) ) {
    //     if(!$media) {
    //         $media = 'all';
    //     }
    //     return '<noscript class="deferred-styles"><link rel="stylesheet" type="text/css" href="' . $src . '"' . $style_media.' media="' . $media . '"></noscript>' . "\n";
    // }

    return $tag;
}

add_filter( 'style_loader_tag', '_bem_style_loader_tag', 10, 3 );
