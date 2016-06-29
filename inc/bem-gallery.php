<?php
// source: http://wpsnipp.com/index.php/functions-php/add-a-custom-class-to-wp_get_attachment_link/
function _bem_gallery_link($link, $id) {
  return str_replace('<a ', '<a class="_gallery__link" ', $link);
}

add_filter( 'wp_get_attachment_link', '_bem_gallery_link', 10, 2 );

// source: http://robido.com/wordpress/wordpress-gallery-filter-to-modify-the-html-output-of-the-default-gallery-shortcode-and-style/

// Custom filter function to modify default gallery shortcode output
function _bem_gallery( $output, $attr ) {
	// Initialize
	global $post, $wp_locale;

	// Validate the author's orderby attribute
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( ! $attr['orderby'] ) unset( $attr['orderby'] );
	}

	// Get attributes from shortcode
	extract( shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => (isset($attr["columns"]) && $attr["columns"] > 1) ? " _gallery__item--" . $attr["columns"] : "",
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr ) );

	// Initialize
	$id = intval( $id );
	$attachments = array();
	if ( $order == 'RAND' ) $orderby = 'none';

	if ( ! empty( $include ) ) {

		// Include attribute is present
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

		// Setup attachments array
		foreach ( $_attachments as $key => $val ) {
			$attachments[ $val->ID ] = $_attachments[ $key ];
		}

	} else if ( ! empty( $exclude ) ) {

		// Exclude attribute is present
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );

		// Setup attachments array
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	} else {
		// Setup attachments array
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	}

	if ( empty( $attachments ) ) return '';

	// Filter gallery differently for feeds
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
		return $output;
	}

	// Filter tags and attributes
	$itemtag = tag_escape( $itemtag );
	$captiontag = tag_escape( $captiontag );
	$columns = intval( $columns );
	$itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
	$float = is_rtl() ? 'right' : 'left';
	$selector = (isset($attr["columns"]) && $attr["columns"] > 1) ? " _gallery__item--" . $attr["columns"] : "";

	// Iterate through the attachments in this gallery instance
	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		// Attachment link
    
    $image_attr = array(
      'src'   => $src,
      'class' => "_gallery__image attachment-$size size-$size",
      'alt'   => trim(strip_tags( get_post_meta($id, '_wp_attachment_image_alt', true) )), // Use Alt field first
    );
    $image = wp_get_attachment_image( $id, $size, false, $image_attr );
      
		if( isset( $attr['link'] ) && 'file' == $attr['link'] ) {
      $image = wp_get_attachment_link( $id, $size, true, false, $image );
		} elseif( !isset($attr['link']) ) {
      $image = wp_get_attachment_link( $id, $size, false, false, $image );
    }

		// Start itemtag
		$output .= "<{$itemtag} class='_gallery__item" . $selector . " gallery-item'>";

		// icontag
		$output .= "
		<{$icontag} class='_gallery__media gallery-icon'>
			$image
		</{$icontag}>";

		if ( $captiontag && trim( $attachment->post_excerpt ) ) {

			// captiontag
			$output .= "
			<{$captiontag} class='_gallery__caption gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
			</{$captiontag}>";

		}

		// End itemtag
		$output .= "</{$itemtag}>";

		// Line breaks by columns set
		if($columns > 0 && ++$i % $columns == 0) $output .= '<br style="clear: both">';

	}

	// End gallery output
	$output .= "
		<br style='clear: both;'>
	</div>\n";
  
  $output = '<div class="_gallery">' . $output . '</div>';
  
	return $output;

}

// Apply filter to default gallery shortcode
  add_filter( 'post_gallery', '_bem_gallery', 10, 2 );