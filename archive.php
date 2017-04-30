<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _bem
 */

get_header(); ?>

	<div id="primary" class="content-area _content__wrapper _content__wrapper--category">
		<main id="main" class="site-main _content__main _content__main--category" role="main">

		<?php
		if ( have_posts() ) : ?>
			<?php
			/* If exists, display highlight image
			 * If not, display thumbnail
			 */
			// if ( class_exists( 'MultiPostThumbnails' ) ) {
			//   MultiPostThumbnails::the_post_thumbnail( get_post_type(), 'highlight-image' );
			// } else if( has_post_thumbnail() ) {
			//   the_post_thumbnail('medium');
			// }
			?>

			<header class="page-header _content__header _content__header--category">
				<?php
					the_archive_title( '<h1 class="page-title _content__title _content__title--category">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description _content__description _content__description--category">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;
            ?>

            <div class="_post-navigation">
                <div class="_post-navigation__item"><?php previous_posts_link() ?></div>
                <div class="_post-navigation__item"><?php next_posts_link() ?></div>
            </div>

            <?php
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
if ( has_post_format( 'aside' ) ) {
	get_sidebar();
}
get_footer();
