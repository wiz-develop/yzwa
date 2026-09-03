
<?php
/**
 * The template for displaying all single posts
 * Template Name: 事業所紹介
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
			<div class="widget_type_company_about screen_widget_key_office_list pt-4 pb-5">
				<div class="widget_content container anime">
					<div class="widget_body">
						<section>
							<div class="item-list ac-list company anime">
								<?php
									$bases = CFS()->get('bases');
									foreach ($bases as $base) :
										$base_image = $base['base_image'];
										$base_name = $base['base_name'];
										$base_address = $base['base_address'];
										$base_tel = $base['base_tel'];
										$base_fax = $base['base_fax'];
										$base_map = $base['base_map'];
										$base_access = $base['base_access'];
										$base_id = $base['base_id'];
								?>
								<article id="<?php echo $base_id; ?>" class="company__section anime-scroll">
									<h2 class="title-mid"><?php echo $base_name; ?></h2>
									<div class="company__section__content">
										<?php if($base_image) : ?>
											<div class="office-image">
												<img src="<?php echo $base_image; ?>">
											</div>
										<?php endif; ?>
										<dl class="dl-list">
											<?php if($base_address) : ?>
											<div class="d-lg-flex d-md-block">
												<dt class="col-lg-3 col-12">住所</dt>
												<dd class="col-lg-9 col-12"><?php echo $base_address; ?></dd>
											</div>
											<?php
												endif;
												if ($base_tel) :
											?>
											<div class="d-lg-flex d-md-block">
												<dt class="col-lg-3 col-12">TEL</dt>
												<dd class="col-lg-9 col-12"><?php echo $base_tel;?></dd>
											</div>
											<?php
												endif;
												if ($base_fax) :
											?>
											<div class="d-lg-flex d-md-block">
												<dt class="col-lg-3 col-12">FAX</dt>
												<dd class="col-lg-9 col-12"><?php echo $base_fax; ?></dd>
											</div>
											<?php endif; ?>
											
											
											<div class="d-lg-flex d-md-block">
												<dt class="col-lg-3 col-12">アクセス</dt>
												<dd class="col-lg-9 col-12">
													<?php if ($base_access) : ?>
													<div class="access"><p><?php echo $base_access; ?></p></div>
													<?php endif; ?>
													<div>
														<iframe style="border: 0;" src="<?php echo $base_map; ?>" width="100%" height="250" allowfullscreen="allowfullscreen"></iframe>
													</div>
												</dd>
											</div>
										</dl>
									</div>
								</article>
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