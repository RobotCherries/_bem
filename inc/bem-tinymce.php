<?php
/**
* Customized _bem tinymce
*
* @package _bem
*/

/**
 * Customize tinymce
 *
 * @param array $format Accepts tinymce settings array.
 */
function _bem_tinymce($init) {
    // uncomment lines below if custom font families needed
    // $init['content_css'] = $init['content_css'] . ',/wp-content/custom-fonts/signarita-zhai/stylesheet.css,https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&amp;subset=latin-ext';
    // $init['font_formats'] = 'Signarita=signarita_zhairegular;Lora=Lora,sans-serif;Georgia=georgia;Times New Roman=times new roman,times';
    
    // uncomment line below if custom sizes needed
    // $init['fontsize_formats'] = '10px 12px 14px 16px 20px 24px 32px 48px';
    
    // uncomment lines below if small format needed
    // $init['style_formats'] = json_encode(array('title' => 'Small', 'inline' => 'small'));
    // $init['style_formats_merge'] = true;
    
    return $init;
}

add_filter('tiny_mce_before_init', '_bem_tinymce');

/**
 * Load custom fonts
 */
// function load_custom_fonts_frontend() {
//     echo '<link type="text/css" rel="stylesheet" href="/wp-content/custom-fonts/signarita-zhai/stylesheet.css">';
//     echo '<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">';
// }
// 
// add_action('wp_head', 'load_custom_fonts_frontend');
// add_action('admin_head', 'load_custom_fonts_frontend');