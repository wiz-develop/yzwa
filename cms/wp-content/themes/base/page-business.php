
<?php
/**
 * The template for displaying all single posts
 * Template Name: 事業紹介
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
<div id="app_func" class="app_func app_func_business func_key_business pb-5">
	<main>
		<div id="app_func_screen" class="app_func_screen app_func_screen_business screen_key_business pb-5">
			<div class="widget_type_page_title screen_widget_key_page_title position-relative">
				<div class="widget_content page-tit_content position-relative">
					<h1 class="mb-0"><?php the_title();?><span class="d-block"><?php echo $page_tit_en; ?></span></h1>
					<p class="page-name_en mb-0 position-absolute"><?php echo $page_tit_en; ?></p>
				</div>
				<div class="page-img_content position-absolute">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/business/wiz_town.png">
				</div>
			</div>
			<div class="widget_type_business screen_widget_key_page_business pt-4 pb-5 position-relative">
				<div class="business_main position-relative">
					<div class="widget_content container">
						<div class="widget_body anime row">
							<div class="business_list anime-scroll">
								<div class="business_content anime_hover-up">
									<a href="<?php echo home_url(); ?>/business/system/">
										<div class="business_content__img business_system">
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/business/system_catch.png">
										</div>
										<div class="business_content__about">
											<div class="business_content__about__name">
												<p class="mb-0">請負・受託開発<span class="d-block">CONTRACT DEVELOPMENT</span></p>
											</div>
											<div class="business_content__about__detail">
												<p class="mb-0">価値あるシステム開発をご提案。（仮）</p>
											</div>
											<div class="more-link">
												<button class="rounded-pill">
													<p class="mb-0">もっと詳しく<i class="fas fa-arrow-right pl-4"></i></p>
												</button>
											</div>
										</div>
									</a>
								</div>
								<div class="business_content anime_hover-up">
									<a href="<?php echo home_url(); ?>/business/package/">
										<div class="business_content__img business_original">
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/business/original_catch.png">
										</div>
										<div class="business_content__about">
											<div class="business_content__about__name">
												<p class="mb-0">自社パッケージ開発<span class="d-block">ORIGINAL PACKAGE</span></p>
											</div>
											<div class="business_content__about__detail">
												<p class="mb-0">価値あるシステム開発をご提案。（仮）</p>
											</div>
											<div class="more-link">
												<button class="rounded-pill">
													<p class="mb-0">もっと詳しく<i class="fas fa-arrow-right pl-4"></i></p>
												</button>
											</div>
										</div>
									</a>
								</div>
								<div class="business_content anime_hover-up">
									<a href="<?php echo home_url(); ?>/business/web/">
										<div class="business_content__img business_web">
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/business/web_catch.png">
										</div>
										<div class="business_content__about">
											<div class="business_content__about__name">
												<p class="mb-0">WEBサイト制作<span class="d-block">WEB PRODUCTION</span></p>
											</div>
											<div class="business_content__about__detail">
												<p class="mb-0">課題の発見から戦略の組み立て、解決に導きます。（仮）</p>
											</div>
											<div class="more-link">
												<button class="rounded-pill">
													<p class="mb-0">もっと詳しく<i class="fas fa-arrow-right pl-4"></i></p>
												</button>
											</div>
										</div>
									</a>
								</div>
								<div class="business_content anime_hover-up">
									<a href="<?php echo home_url(); ?>/business/consulting/">
										<div class="business_content__img business_consulting">
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/business/consulting_catch.png">
										</div>
										<div class="business_content__about">
											<div class="business_content__about__name">
												<p class="mb-0">コンサルタント<span class="d-block">CONSULTANT</span></p>
											</div>
											<div class="business_content__about__detail">
												<p class="mb-0">社内外の多様な能力を武器にプロジェクトの遂行をサポートします。（仮）</p>
											</div>
											<div class="more-link">
												<button class="rounded-pill">
													<p class="mb-0">もっと詳しく<i class="fas fa-arrow-right pl-4"></i></p>
												</button>
											</div>
										</div>
									</a>
								</div>
								<div class="business_content anime_hover-up">
									<a href="<?php echo home_url(); ?>/business/dispatch/">
										<div class="business_content__img business_dispatch">
											<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/business/dispatch_catch.png">
										</div>
										<div class="business_content__about">
											<div class="business_content__about__name">
												<p class="mb-0">技術者派遣事業<span class="d-block">TECHNICIAN DISPATCH</span></p>
											</div>
											<div class="business_content__about__detail">
												<p class="mb-0">価社内外の多様な能力を武器にプロジェクトの遂行をサポートします。（仮）</p>
											</div>
											<div class="more-link">
												<button class="rounded-pill">
													<p class="mb-0">もっと詳しく<i class="fas fa-arrow-right pl-4"></i></p>
												</button>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();