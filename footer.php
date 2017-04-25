<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _bem
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer _footer" role="contentinfo">
		<div class="site-info _footer__info">
			<a class="_footer__info-tagline" href="<?php echo esc_url( __( 'https://wordpress.org/', '_bem' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', '_bem' ), 'WordPress' ); ?></a>
			<span class="sep _footer__separator"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', '_bem' ), '_bem', '<a class="_footer__info-author" href="https://github.com/maliMirkec" rel="designer">maliMirkec</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->
<?php wp_footer(); ?>
<noscript class="deferred-styles">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() . '/dist/css/style.min.css'; ?>" media="all">
</noscript>
<script>
'use strict';

var loadDeferredStyles = function() {
    var addStylesNode = document.getElementsByClassName('deferred-styles');

    while(addStylesNode.length > 0){
        var replacement = document.createElement("div");
        replacement.innerHTML = addStylesNode[0].textContent;
        document.body.appendChild(replacement)
        addStylesNode[0].parentNode.removeChild(addStylesNode[0]);
    }
};
var raf = requestAnimationFrame || mozRequestAnimationFrame ||
webkitRequestAnimationFrame || msRequestAnimationFrame;
if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
else window.addEventListener('load', loadDeferredStyles);
</script>
</body>
</html>
