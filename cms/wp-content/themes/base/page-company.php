
<?php
/**
 * The template for displaying all single posts
 * Template Name: 企業情報
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();

$page_tit_en = CFS()->get('page_tit_en', get_queried_object_id());

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
			<div class="widget_type_product_list screen_widget_key_product_list py-5 bg-white">
				<div class="widget_content container">
					<div class="widget_body">
						<section>
							<ul class="product-list anime list-unstyled d-flex flex-wrap">
								<?php
									$fields = CFS()->get('content_list');
									foreach ($fields as $field) :
								?>
								<li class="product zommIn">
									<a href="<?php echo $field['content_url']; ?>">
										<div class="product-content">
											<div class="product-img mask p-0 mb-2">
												<img src="<?php echo $field['content_img']; ?>" class="w-100" alt="<?php echo $field['content_tit']; ?>">
											</div>
											<div class="product-detail text-start">
												<p class="product-detail__title mb-2"><?php echo $field['content_tit']; ?></p>
												<?php if ($field['content_about']) : ?>
												<p class="product-detail__about mb-2"><?php echo $field['content_about']; ?></p>
												<?php endif; ?>
											</div>
										</div>
									</a>
								</li>
								<?php endforeach; ?>
							</ul>
						</section>
					</div>
				</div>
			</div>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();
