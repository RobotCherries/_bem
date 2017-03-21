<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _bem
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php require_once 'favicon.php';  ?>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
$critical_css = get_template_directory() . '/dist/css/style.min.css';
if(file_exists($critical_css)) { ?>
<style media="screen">
<?php echo file_get_contents($critical_css); ?>
</style>
<?php } ?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site _site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', '_bem' ); ?></a>

	<header id="masthead" class="_header" role="banner">
		<div class="_header__branding">
			<?php
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="_header__title"><a class="_header__title-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<h2 class="_header__title"><a class="_header__title-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
if ( $description || is_customize_preview() ) : ?>
				<p class="_header__description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- ._header__branding -->

		<?php get_template_part( 'template-parts/menu-static', true ); ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content _content">
