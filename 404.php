<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _bem
 */

get_header(); ?>

	<div id="primary" class="content-area _content__wrapper _content__wrapper-404">
		<main id="main" class="site-main _content__main _content__main--404" role="main">

			<section class="error-404 not-found _content__section _content__section--404">
				<header class="page-header _content__header _content__header--404">
					<h1 class="page-title _content__title _content__title--404"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', '_bem' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content _content__article-content _content__article-content--404">
					<p class="_content__404-text"><?php esc_html_e( 'It looks like nothing was found at this location. Are you "trying" to find something funny?', '_bem' ); ?></p>
                    <div class="_content__404-video">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/kkuhGHFnvSU" frameborder="0" allowfullscreen></iframe>
                    </div>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
if ( has_post_format( 'aside' ) ) {
	get_sidebar();
}
get_footer();
