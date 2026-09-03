
<?php
/**
 * The template for displaying all single posts
 * Template Name: 2カラムテンプレート
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
?>
<div id="app_mikiprune">
	<div id="app_func" class="app_func app_func_screen_機能名 screen_key_機能名">
		<main>
			<div id="app_func_screen" class="app_func_screen app_func_screen_画面名 screen_key_画面名">
				<div class="container">
					<div class="row">
						<div class="col-12 col-xl-8">
							<div class="widget_type_コンテンツタイプ screen_widget_key_コンテンツ名 py-5">
								<div class="widget_content">
									<div class="widget_header">
										<h1></h1>
									</div>
									<div class="widget_body">
										<!-- メインコンテンツ -->
										<section>
											<!-- sectionの中にはh2、h3…の見出しを1つ置く -->
											<!-- コンテンツ１つで自己完結できる場合はarticleで囲む 例：ブログの記事を並べる場合など -->
											<h2></h2>
											<p></p>
										</section>
										<section>
											<h2></h2>
											<p></p>
										</section>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-xl-4">
							<div class="widget_type_コンテンツタイプ screen_widget_key_コンテンツ名 py-5">
								<section>
									<div class="widget_content">
										<div class="widget_header">
											<h2></h2>
										</div>
										<div class="widget_body">
											<!-- サイドコンテンツ -->
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
				</div>
		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php
get_footer();