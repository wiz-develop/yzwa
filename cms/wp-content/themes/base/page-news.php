
<?php
/**
 * The template for displaying all single posts
 * Template Name: 新着情報
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
		<div id="app_func_screen" class="app_func_screen app_func_screen_archive-list screen_key_archive-list pb-5">
			<div class="widget_type_page_title screen_widget_key_page_title position-relative">
				<div class="widget_content page-tit_content position-relative">
					<h1 class="mb-0"><?php the_title();?><span class="d-block"><?php echo $page_tit_en; ?></span></h1>
					<p class="page-name_en mb-0 position-absolute"><?php echo $page_tit_en; ?></p>
				</div>
			</div>
			<div class="widget_type_news screen_widget_key_news_archive">
				<div class="widget_content container">
					<div class="row">
						<div class="col-12 col-lg-8">
							<div class="widget_main">
								<div class="widget_body anime">
								<?php
									$args = array(
										'posts_per_page' => 30,
										'post_type' => 'post',
										'orderby' => 'date',
										'category_name' => 'news_topics'
									);
									
									$query = new WP_Query( $args );
									if ( $query->have_posts() ) :
										
										while ( $query->have_posts() ) :
											$query->the_post();
											$postid = get_the_ID();
											$slug = get_post($postid)->post_name;
												$category = get_the_category();
												$primary_category = reset( $category );
												$cat_name = $primary_category ? $primary_category->name : '';
												$cat_acf = $primary_category ? 'category_' . $primary_category->cat_ID : '';
								?>
									<article class="anime-scroll mb-2">
										<a href="<?php the_permalink(); ?>">
											<div class="news-content d-md-flex d-block align-items-baseline">
												<div class="news-header d-lg-flex d-block align-items-center">
													<?php
														$days = 7;
														$now = date_i18n('U');
														$entry = get_the_time('U');
														$term = date('U',($now - $entry)) / 86400;
														if( $days > $term ) {
															echo '<div class="new rounded-pill">NEW</div>';
														}
													?>
													<div class="d-flex">
														<div class="news-date">
															<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time>
														</div>
														<div class="news-category" style="background-color: <?php the_field('cat_color', $cat_acf); ?>"><?php echo $cat_name; ?></div>
													</div>
												</div>
												<div class="news-body">
													<p class="mb-0"><?php the_title(); ?></p>
												</div>
											</div>
										</a>
									</article>
								<?php
										endwhile;
										else :
											echo '<p class="mb-0">最新の記事はありません</p>';
									endif; wp_reset_postdata();
								?>
									<div class="pnavi">
										<?php //ページリスト表示処理
												// global $wp_rewrite;
												// $paginate_base = get_pagenum_link(1);
												// if (strpos($paginate_base, '?') || !$wp_rewrite->using_permalinks()) {
												// 	$paginate_format = '';
												// 	$paginate_base = add_query_arg('paged', '%#%');
												// } else {
												// 	$paginate_format = (substr($paginate_base, -1, 1) == '/' ? '' : '/') .
												// 		user_trailingslashit('page/%#%/', 'paged');
												// 	$paginate_base .= '%_%';
												// }
												// echo paginate_links(array(
												// 	'base' => $paginate_base,
												// 	'format' => $paginate_format,
												// 	'total' => $the_query->max_num_pages,
												// 	'mid_size' => 1,
												// 	'current' => ($paged ? $paged : 1),
												// 	'prev_text' => '< 前へ',
												// 	'next_text' => '次へ >',
												// )); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="anime col-12 col-lg-4">
							<div class="widget_side anime-scroll">
								<section>
									<div class="widget_body">
										<?php get_sidebar(); ?>
									</div>
								</section>
							</div>
						</div>
					</div>
				</div>
			</div>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();
