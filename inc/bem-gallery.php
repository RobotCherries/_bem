<?php
/**
 * Custom _bem gallery
 *
 * @package _bem
 */

/**
 * Adds gallery link, source: http://wpsnipp.com/index.php/functions-php/add-a-custom-class-to-wp_get_attachment_link/
 *
 * @param  string $link Accepts link string.
 */
function _bem_gallery_link( $link ) {
	return str_replace( '<a ', '<a class="_gallery__link" ', $link );
}

add_filter( 'wp_get_attachment_link', '_bem_gallery_link', 10, 2 );

/**
 * Checks media view settings, source: http://wordpress.stackexchange.com/questions/203317/set-default-number-of-columns-in-gallery
 *
 * @param  array $settings Accepts settings array.
 */
function _bem_media_view_settings( $settings ) {
	$settings['galleryDefaults']['columns'] = 1;
	return $settings;
}
add_filter( 'media_view_settings', '_bem_media_view_settings' );

/**
 * Custom filter function to modify default gallery shortcode output, source: http://robido.com/wordpress/wordpress-gallery-filter-to-modify-the-html-output-of-the-default-gallery-shortcode-and-style/
 *
 * @param  string $output Accepts output string.
 * @param  array  $attr   Accepts attributs array.
 */
function _bem_gallery( $output, $attr ) {
	// Initialize.
	global $post, $wp_locale;

	// Validate the author's orderby attribute.
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( ! $attr['orderby'] ) { unset( $attr['orderby'] );
		}
	}

	// Get attributes from shortcode.
	$shortcode_atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => (isset( $attr['columns'] ) && $attr['columns'] > 1) ? ' _gallery__item--' . $attr['columns'] : '',
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
	), $attr );

	// Initialize.
	$shortcode_atts['id'] = intval( $shortcode_atts['id'] );
	$attachments = array();
	if ( 'RAND' === $shortcode_atts['order'] ) {
		$shortcode_atts['orderby'] = 'none';
	}

	if ( ! empty( $shortcode_atts['include'] ) ) {

		// Include attribute is present.
		$shortcode_atts['include'] = preg_replace( '/[^0-9,]+/', '', $shortcode_atts['include'] );
		$_attachments = new WP_Query( array( 'include' => $shortcode_atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $shortcode_atts['order'], 'orderby' => $shortcode_atts['orderby'] ) );

		// Setup attachments array.
		foreach ( $_attachments->posts as $key => $val ) {
			$attachments[ $val->ID ] = $_attachments->posts[ $key ];
		}
	} elseif ( ! empty( $shortcode_atts['exclude'] ) ) {

		// Exclude attribute is present.
		$shortcode_atts['exclude'] = preg_replace( '/[^0-9,]+/', '', $shortcode_atts['exclude'] );

		// Setup attachments array.
		$__attachments = new WP_Query( array( 'post_parent' => $shortcode_atts['id'], 'exclude' => $shortcode_atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $shortcode_atts['order'], 'orderby' => $shortcode_atts['orderby'] ) );

		$attachments = $__attachments->posts;
	} else {
		// Setup attachments array.
		$__attachments = new WP_Query( array( 'post_parent' => $shortcode_atts['id'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $shortcode_atts['order'], 'orderby' => $shortcode_atts['orderby'] ) );

		$attachments = $__attachments->posts;
	}

	if ( empty( $attachments ) ) { return '';
	}

	// Filter gallery differently for feeds.
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) { $output .= wp_get_attachment_link( $att_id, $shortcode_atts['size'], true ) . "\n";
		}
		return $output;
	}

	// Filter tags and attributes.
	$shortcode_atts['itemtag'] = tag_escape( $shortcode_atts['itemtag'] );
	$shortcode_atts['captiontag'] = tag_escape( $shortcode_atts['captiontag'] );
	$shortcode_atts['columns'] = intval( $shortcode_atts['columns'] );
	$itemwidth = $shortcode_atts['columns'] > 0 ? floor( 100 / $shortcode_atts['columns'] ) : 100;
	$float = is_rtl() ? 'right' : 'left';
	$selector = (isset( $attr['columns'] ) && $attr['columns'] > 1) ? ' _gallery__item--' . $attr['columns'] : '';

	// Iterate through the attachments in this gallery instance.
	$i = 0;
	foreach ( $attachments as $shortcode_atts['id'] => $attachment ) {
		$itemtag = $shortcode_atts['itemtag'];
		$icontag = $shortcode_atts['icontag'];
		$captiontag = $shortcode_atts['captiontag'];
		$size = $shortcode_atts['size'];

		// Attachment link.
		$image_attr = array(
		'src'   => $src,
		'class' => "_gallery__image attachment-$size size-$size",
		'alt'   => trim( strip_tags( get_post_meta( $shortcode_atts['id'], '_wp_attachment_image_alt', true ) ) ), // Use Alt field first.
		);
		$image = wp_get_attachment_image( $shortcode_atts['id'], $shortcode_atts['size'], false, $image_attr );

		if ( isset( $attr['link'] ) && 'file' === $attr['link'] ) {
			$image = wp_get_attachment_link( $shortcode_atts['id'], $shortcode_atts['size'], true, false, $image );
		} elseif ( ! isset( $attr['link'] ) ) {
			$image = wp_get_attachment_link( $shortcode_atts['id'], $shortcode_atts['size'], false, false, $image );
		}

		// Start itemtag.
		$output .= "<{$itemtag} class='_gallery__item" . $selector . " gallery-item'>";

		// Icontag.
		$output .= "
		<{$icontag} class='_gallery__media gallery-icon'>
			$image
		</{$icontag}>";

		if ( $shortcode_atts['captiontag'] && trim( $attachment->post_excerpt ) ) {

			// Captiontag.
			$output .= "
			<{$captiontag} class='_gallery__caption gallery-caption'>
				" . wptexturize( $attachment->post_excerpt ) . "
			</{$captiontag}>";

		}

		// End itemtag.
		$output .= "</{$itemtag}>";

		// Line breaks by columns set.
		if ( $shortcode_atts['columns'] > 0 && ++$i % 0 === $shortcode_atts['columns'] ) { $output .= '<br style="clear: both">';
		}
	}

	// End gallery output.
	$output = '<div class="_gallery">' . $output . '</div>';

	return $output;

}

// Apply filter to default gallery shortcode.
add_filter( 'post_gallery', '_bem_gallery', 10, 2 );
