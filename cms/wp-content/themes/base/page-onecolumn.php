
<?php
/**
 * The template for displaying all single posts
 * Template Name: ワンカラムテンプレート
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();

$page_tit_en = CFS()->get('page_tit_en', $get_page_id);
$func_screen = CFS()->get('func_screen', $get_page_id);
$widget_name = CFS()->get('widget_name', $get_page_id);
?>
<div id="splash"></div>
<div class="splashbg"></div>
<div id="app_func" class="app_func app_func_page func_key_page pb-5">
	<main>
		<div id="app_func_screen" class="app_func_screen app_func_screen_<?php echo $func_screen; ?> screen_key_<?php echo $func_screen; ?> pb-5">
			<div class="widget_type_page_title screen_widget_key_page_title position-relative">
				<div class="widget_content page-tit_content position-relative">
					<h1 class="mb-0"><?php the_title();?><span class="d-block"><?php echo $page_tit_en; ?></span></h1>
					<p class="page-name_en mb-0 position-absolute"><?php echo $page_tit_en; ?></p>
				</div>
			</div>
			<div class="widget_type_<?php echo $widget_name; ?> screen_widget_key_<?php echo $widget_name; ?>">
				<div class="widget_content">
					<div class="widget_body">
						<?php the_content();?>
					</div>
				</div>
			</div>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();