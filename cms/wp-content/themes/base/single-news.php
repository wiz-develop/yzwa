
<?php
/**
 * The template for displaying all single posts
 * 新着情報詳細
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */
$category = get_the_category();
$cat_name = $category[0]->name;
$cat_acf = 'category_'.$category[0]->cat_ID;
?>
<div id="splash"></div>
<div class="splashbg"></div>
<div id="app_func" class="app_func app_func_article func_key_article">
	<main>
		<div id="app_func_screen" class="app_func_screen app_func_screen_article screen_key_article py-5">
			<div class="widget_type_article screen_widget_key_article">
				<div class="widget_content container">
					<div class="row">
						<div class="col-12 col-lg-8">
							<div class="widget_main">
								<div class="widget_header">
									<div class="widget_header__detail d-flex align-items-center">
										<div class="news-date">
											<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time>
										</div>
										<div class="news-category" style="background-color: <?php the_field('cat_color', $cat_acf); ?>"><?php echo $cat_name; ?></div>
									</div>
									<h1><?php the_title(); ?></h1>
								</div>
								<div class="widget_body mt-3">
									<section>
									<?php the_content();?>
										<div class="next-link anime_hover-up text-center pt-3">
											<?php
												$referer = $_SERVER['HTTP_REFERER'];
												$url = parse_url($referer);
												$refer_slug = str_replace('/', '', $url['path']);
												if (in_category($refer_slug)) {
													$back_url = $url['path'];
												} else {
													$back_url = '/news';
												}
											?>
											<a href="<?php echo $back_url; ?>">
												<button class="bg-white_btn active rounded">記事一覧へ</button>
											</a>
										</div>
									</section>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-4">
							<div class="widget_side">
								<section>
									<div class="widget_content">
										<div class="widget_body">
											<?php get_sidebar(); ?>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
				</div>
			</div>
	</main><!-- #main -->
</div>