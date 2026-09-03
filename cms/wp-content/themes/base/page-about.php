
<?php
/**
 * The template for displaying all single posts
 * Template Name: 会社概要・沿革
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();

$page_tit_en = CFS()->get('page_tit_en', $get_page_id);

?>
<div id="splash"></div>
<div class="splashbg"></div>
<div id="app_func" class="app_func app_func_page func_key_page pb-5">
	<main>
		<div id="app_func_screen" class="app_func_screen app_func_screen_company screen_key_company pb-5">
			<div class="widget_type_page_title screen_widget_key_page_title position-relative">
				<div class="widget_content page-tit_content position-relative">
					<h1 class="mb-0"><?php the_title();?><span class="d-block"><?php echo $page_tit_en; ?></span></h1>
					<p class="page-name_en mb-0 position-absolute"><?php echo $page_tit_en; ?></p>
				</div>
			</div>
			<div class="widget_type_company_about screen_widget_key_company_about pb-5 bg-white">
				<div class="widget_content container">
					<div class="widget_body">
						<section class="anime">
							<div class="item-list anime">
								<?php
									$fields = CFS()->get('item_list');
									foreach ($fields as $field) :
								?>
								<div class="item-list__content anime-scroll d-lg-flex d-sm-block flex-wrap">
									<div class="item_tit"><p class="mb-0"><?php echo $field['item_tit']; ?></p></div>
									<div class="item_about"><p class="mb-0"><?php echo $field['item_about']; ?></p></div>
								</div>
								<?php endforeach; ?>
							</div>
						</section>
					</div>
				</div>
			</div>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();