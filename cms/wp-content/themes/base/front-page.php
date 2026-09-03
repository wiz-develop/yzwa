
<?php
/**
 * The template for displaying all single posts
 * Template Name: トップページ
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();

$catch_copy = CFS()->get('catch_copy');
$catch_about = CFS()->get('catch_about');
$business_about = CFS()->get('business_about');
$recruit_about = CFS()->get('recruit_about');

$syusui_product1_name = CFS()->get('syusui_product1_name');
$syusui_product1_about = CFS()->get('syusui_product1_about');
$syusui_product1_img = CFS()->get('syusui_product1_img');
$tinsati_product1_name = CFS()->get('tinsati_product1_name');
$tinsati_product1_about = CFS()->get('tinsati_product1_about');
$tinsati_product1_img = CFS()->get('tinsati_product1_img');
$yakuhin_product1_name = CFS()->get('yakuhin_product1_name');
$yakuhin_product1_about = CFS()->get('yakuhin_product1_about');
$yakuhin_product1_img = CFS()->get('yakuhin_product1_img');
$yakuhin_k_product1_name = CFS()->get('yakuhin_k_product1_name');
$yakuhin_k_product1_about = CFS()->get('yakuhin_k_product1_about');
$yakuhin_k_product1_img = CFS()->get('yakuhin_k_product1_img');
$frock_product1_name = CFS()->get('frock_product1_name');
$frock_product1_about = CFS()->get('frock_product1_about');
$frock_product1_img = CFS()->get('frock_product1_img');
$tinden_product1_name = CFS()->get('tinden_product1_name');
$tinden_product1_about = CFS()->get('tinden_product1_about');
$tinden_product1_img = CFS()->get('tinden_product1_img');
$tinden_product2_name = CFS()->get('tinden_product2_name');
$tinden_product2_about = CFS()->get('tinden_product2_about');
$tinden_product2_img = CFS()->get('tinden_product2_img');
$tinden_product3_name = CFS()->get('tinden_product3_name');
$tinden_product3_about = CFS()->get('tinden_product3_about');
$tinden_product3_img = CFS()->get('tinden_product3_img');
$tinden_product4_name = CFS()->get('tinden_product4_name');
$tinden_product4_about = CFS()->get('tinden_product4_about');
$tinden_product4_img = CFS()->get('tinden_product4_img');
$roka_product1_name = CFS()->get('roka_product1_name');
$roka_product1_about = CFS()->get('roka_product1_about');
$roka_product1_img = CFS()->get('roka_product1_img');
$roka_product2_name = CFS()->get('roka_product2_name');
$roka_product2_about = CFS()->get('roka_product2_about');
$roka_product2_img = CFS()->get('roka_product2_img');
$roka_product3_name = CFS()->get('roka_product3_name');
$roka_product3_about = CFS()->get('roka_product3_about');
$roka_product3_img = CFS()->get('roka_product3_img');
$roka_product4_name = CFS()->get('roka_product4_name');
$roka_product4_about = CFS()->get('roka_product4_about');
$roka_product4_img = CFS()->get('roka_product4_img');
$sensui_product1_name = CFS()->get('sensui_product1_name');
$sensui_product1_about = CFS()->get('sensui_product1_about');
$sensui_product1_img = CFS()->get('sensui_product1_img');
$haisui_product1_name = CFS()->get('haisui_product1_name');
$haisui_product1_about = CFS()->get('haisui_product1_about');
$haisui_product1_img = CFS()->get('haisui_product1_img');
$haisui_product2_name = CFS()->get('haisui_product2_name');
$haisui_product2_about = CFS()->get('haisui_product2_about');
$haisui_product2_img = CFS()->get('haisui_product2_img');

?>


<div id="app_func" class="app_func app_func_main func_key_main">
	<main>
		<div id="app_func_screen" class="app_func_screen app_func_screen_top screen_key_top pb-5">
			<div class="widget_type_first-view screen_widget_key_top_first-view">
				<div class="catch_content row">
					<div class="catch-copy col-lg-8 col-12 position-relative">
						<div class="catch_bg position-absolute">
							<?php if(wp_is_mobile()) : ?>
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/sp/catch_tit_sp.jpg">
							<?php else : ?>
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/catch_tit_pc.png">
							<?php endif; ?>
						</div>
						<?php echo $catch_copy; ?>
						<div class="catch_about"><?php echo $catch_about; ?></div>
					</div>
					<div class="top_img col-lg-5 col-12">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/top_img.jpg">
					</div>
				</div>
			</div>

			<div id="business" class="widget_type_business screen_widget_key_top_business home-appear">
				<div class="widget_content">
					<div class="widget_header anime">
						<h2 class="top_widget_tit anime-scroll">BUSINESS<span class="d-block">事業紹介</span></h2>
					</div>
					<div class="widget_body">
						<div class="business_about">
							<?php echo $business_about; ?>
						</div>
						<div class="business_content position-relative">
							<div class="flow-header">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/business_flow.png?20240319">
							</div>
							<div class="flow-body">
								<div class="product">
									<div class="syusui_img modal_trigger syusui position-absolute">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/syusui.png" onmouseover="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/syusui_on.png'" onmouseout="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/syusui.png'" />
									</div>
									<div class="modal_box">
										<div class="modal_bg"></div>
										<div class="modal_inner">
											<div class="modal_block">
												<div class="business_item">
													<div class="business_item__header">
														<h3>取水塔</h3>
													</div>
													<div class="business_item__about row">
														<div class="business_item__about__img col-lg-5 col-12">
															<?php if($syusui_product1_img) : ?>
																<img src="<?php echo $syusui_product1_img; ?>">
															<?php else : ?>
																<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/no-img.png">
															<?php endif; ?>
														</div>
														<div class="business_item__about__detail col-lg-7 col-12">
															<div class="product_name"><?php echo $syusui_product1_name; ?></div>
															<p class="mb-0"><?php echo $syusui_product1_about; ?></p>
														</div>
													</div>
												</div>
											</div>
											<div class="modal_close">
												<div class="rounded-pill">
													閉じる<span class="pl-3">×</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="product">
									<div class="tinsati_img modal_trigger tinsati position-absolute">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/tinsati.png" onmouseover="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/tinsati_on.png'" onmouseout="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/tinsati.png'" />
									</div>
									<div class="modal_box">
										<div class="modal_bg"></div>
										<div class="modal_inner">
											<div class="modal_block">
												<div class="business_item">
													<div class="business_item__header">
														<h3>沈砂池</h3>
													</div>
													<div class="business_item__about row">
														<div class="business_item__about__img col-lg-5 col-12">
															<?php if($tinsati_product1_img) : ?>
																<img src="<?php echo $tinsati_product1_img; ?>">
															<?php else : ?>
																<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/no-img.png">
															<?php endif; ?>
														</div>
														<div class="business_item__about__detail col-lg-7 col-12">
															<div class="product_name"><?php echo $tinsati_product1_name; ?></div>
															<p class="mb-0"><?php echo $tinsati_product1_about; ?></p>
														</div>
													</div>
												</div>
											</div>
											<div class="modal_close">
												<div class="rounded-pill">
													閉じる<span class="pl-3">×</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="product">
									<div class="frock_img modal_trigger frock position-absolute">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/frock.png" onmouseover="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/frock_on.png'" onmouseout="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/frock.png'" />
									</div>
									<div class="modal_box">
										<div class="modal_bg"></div>
										<div class="modal_inner">
											<div class="modal_block">
												<div class="anime-scroll">
													<div class="business_content business_carousel">
														<div class="business_item">
															<div class="business_item__header">
																<h3>薬品混和池</h3>
															</div>
															<div class="business_item__about row">
																<div class="business_item__about__img col-lg-5 col-12">
																	<?php if($yakuhin_k_product1_img) : ?>
																		<img src="<?php echo $yakuhin_k_product1_img; ?>">
																	<?php else : ?>
																		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/no-img.png">
																	<?php endif; ?>
																</div>
																<div class="business_item__about__detail col-lg-7 col-12">
																	<div class="product_name"><?php echo $yakuhin_k_product1_name; ?></div>
																	<p class="mb-0"><?php echo $yakuhin_k_product1_about; ?></p>
																</div>
															</div>
														</div>
														<div class="business_item">
															<div class="business_item__header">
																<h3>フロック形成池</h3>
															</div>
															<div class="business_item__about row">
																<div class="business_item__about__img col-lg-5 col-12">
																	<?php if($frock_product1_img) : ?>
																		<img src="<?php echo $frock_product1_img; ?>">
																	<?php else : ?>
																		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/no-img.png">
																	<?php endif; ?>
																</div>
																<div class="business_item__about__detail col-lg-7 col-12">
																	<div class="product_name"><?php echo $frock_product1_name; ?></div>
																	<p class="mb-0"><?php echo $frock_product1_about; ?></p>
																</div>
															</div>
														</div>
														<div class="business_item">
															<div class="business_item__header">
																<h3>沈殿池</h3>
															</div>
															<div class="business_item__about row">
																<div class="business_item__about__img col-lg-5 col-12">
																	<?php if($tinden_product1_img) : ?>
																		<img src="<?php echo $tinden_product1_img; ?>">
																	<?php else : ?>
																		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/no-img.png">
																	<?php endif; ?>
																</div>
																<div class="business_item__about__detail col-lg-7 col-12">
																	<div class="product_name"><?php echo $tinden_product1_name; ?></div>
																	<p class="mb-0"><?php echo $tinden_product1_about; ?></p>
																</div>
															</div>
															<!-- <div class="business_item__about row mt-md-4 mt-5">
																<div class="business_item__about__img col-lg-5 col-12">
																	<img src="<?php echo $tinden_product1_img; ?>">
																</div>
																<div class="business_item__about__detail col-lg-7 col-12">
																	<div class="product_name"><?php echo $tinden_product1_name; ?></div>
																	<p class="mb-0"><?php echo $tinden_product1_about; ?></p>
																</div>
															</div> -->
														</div>
													</div>
												</div>
											</div>
											<div class="modal_close">
												<div class="rounded-pill">
													閉じる<span class="pl-3">×</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="product">
									<div class="yakuhin_img modal_trigger yakuhin position-absolute">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/yakuhin.png" onmouseover="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/yakuhin_on.png'" onmouseout="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/yakuhin.png'" />
									</div>
									<div class="modal_box">
										<div class="modal_bg"></div>
										<div class="modal_inner">
											<div class="modal_block">
												<div class="business_item">
													<div class="business_item__header">
														<h3>ろ過装置</h3>
													</div>
													<div class="business_item__about row">
														<div class="business_item__about__img col-lg-5 col-12">
															<?php if($yakuhin_product1_img) : ?>
																<img src="<?php echo $yakuhin_product1_img; ?>">
															<?php else : ?>
																<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/no-img.png">
															<?php endif; ?>
														</div>
														<div class="business_item__about__detail col-lg-7 col-12">
															<div class="product_name"><?php echo $yakuhin_product1_name; ?></div>
															<p class="mb-0"><?php echo $yakuhin_product1_about; ?></p>
														</div>
													</div>
												</div>
											</div>
											<div class="modal_close">
												<div class="rounded-pill">
													閉じる<span class="pl-3">×</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="product">
									<div class="roka1_img modal_trigger roka1 position-absolute">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/roka1.png" onmouseover="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/roka1_on.png'" onmouseout="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/roka1.png'" />
									</div>
									<div class="modal_box">
										<div class="modal_bg"></div>
										<div class="modal_inner">
											<div class="modal_block">
												<div class="anime-scroll">
													<div class="business_content">
														<div class="business_item">
															<div class="business_item__header">
																<h3>ろ過池</h3>
															</div>
															<div class="business_item__about row">
																<div class="business_item__about__img col-lg-5 col-12">
																	<?php if($roka_product1_img) : ?>
																		<img src="<?php echo $roka_product1_img; ?>">
																	<?php else : ?>
																		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/no-img.png">
																	<?php endif; ?>
																</div>
																<div class="business_item__about__detail col-lg-7 col-12">
																	<div class="product_name"><?php echo $roka_product1_name; ?></div>
																	<p class="mb-0"><?php echo $roka_product1_about; ?></p>
																</div>
															</div>
															<div class="business_item__about row">
																<div class="business_item__about__img col-lg-5 col-12">
																	<?php if($roka_product2_img) : ?>
																		<img src="<?php echo $roka_product2_img; ?>">
																	<?php else : ?>
																		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/no-img.png">
																	<?php endif; ?>
																</div>
																<div class="business_item__about__detail col-lg-7 col-12">
																	<div class="product_name"><?php echo $roka_product2_name; ?></div>
																	<p class="mb-0"><?php echo $roka_product2_about; ?></p>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="modal_close">
												<div class="rounded-pill">
													閉じる<span class="pl-3">×</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="product">
									<div class="roka2_img modal_trigger roka2 position-absolute">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/roka2.png" onmouseover="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/roka2_on.png'" onmouseout="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/roka2.png'" />
									</div>
									<div class="modal_box">
										<div class="modal_bg"></div>
										<div class="modal_inner">
											<div class="modal_block">
												<div class="business_item">
													<div class="business_item__header">
														<h3>ろ過池</h3>
													</div>
													<div class="business_item__about row">
														<div class="business_item__about__img col-lg-5 col-12">
															<?php if($roka_product3_img) : ?>
																<img src="<?php echo $roka_product3_img; ?>">
															<?php else : ?>
																<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/no-img.png">
															<?php endif; ?>
														</div>
														<div class="business_item__about__detail col-lg-7 col-12">
															<div class="product_name"><?php echo $roka_product3_name; ?></div>
															<p class="mb-0"><?php echo $roka_product3_about; ?></p>
														</div>
													</div>
												</div>
											</div>
											<div class="modal_close">
												<div class="rounded-pill">
													閉じる<span class="pl-3">×</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="product">
									<div class="roka3_img modal_trigger roka3 position-absolute">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/roka3.png" onmouseover="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/roka3_on.png'" onmouseout="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/roka3.png'" />
									</div>
									<div class="modal_box">
										<div class="modal_bg"></div>
										<div class="modal_inner">
											<div class="modal_block">
												<div class="business_item">
													<div class="business_item__header">
														<h3>ろ過池</h3>
													</div>
													<div class="business_item__about row">
														<div class="business_item__about__img col-lg-5 col-12">
															<?php if($roka_product4_img) : ?>
																<img src="<?php echo $roka_product4_img; ?>">
															<?php else : ?>
																<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/no-img.png">
															<?php endif; ?>
														</div>
														<div class="business_item__about__detail col-lg-7 col-12">
															<div class="product_name"><?php echo $roka_product4_name; ?></div>
															<p class="mb-0"><?php echo $roka_product4_about; ?></p>
														</div>
													</div>
												</div>
											</div>
											<div class="modal_close">
												<div class="rounded-pill">
													閉じる<span class="pl-3">×</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="product">
									<div class="sensui1_img modal_trigger sensui1 position-absolute">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/sensui1.png" onmouseover="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/sensui1_on.png'" onmouseout="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/sensui1.png'" />
									</div>
									<div class="modal_box">
										<div class="modal_bg"></div>
										<div class="modal_inner">
											<div class="modal_block">
												<div class="business_item">
													<div class="business_item__header">
														<h3>浄水池・配水池</h3>
													</div>
													<div class="business_item__about row">
														<div class="business_item__about__img col-lg-5 col-12">
															<?php if($sensui_product1_img) : ?>
																<img src="<?php echo $sensui_product1_img; ?>">
															<?php else : ?>
																<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/no-img.png">
															<?php endif; ?>
														</div>
														<div class="business_item__about__detail col-lg-7 col-12">
															<div class="product_name"><?php echo $sensui_product1_name; ?></div>
															<p class="mb-0"><?php echo $sensui_product1_about; ?></p>
														</div>
													</div>
												</div>
											</div>
											<div class="modal_close">
												<div class="rounded-pill">
													閉じる<span class="pl-3">×</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="product">
									<div class="sensui2_img modal_trigger sensui2 position-absolute">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/sensui2.png" onmouseover="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/sensui2_on.png'" onmouseout="this.src='<?php echo get_stylesheet_directory_uri(); ?>/assets/image/top/business/sensui2.png'" />
									</div>
									<div class="modal_box">
										<div class="modal_bg"></div>
										<div class="modal_inner">
											<div class="modal_block">
												<div class="business_item">
													<div class="business_item__header">
														<h3>配水池・各戸地域</h3>
													</div>
													<div class="business_item__about row">
														<div class="business_item__about__img col-lg-5 col-12">
															<?php if($haisui_product1_img) : ?>
																<img src="<?php echo $haisui_product1_img; ?>">
															<?php else : ?>
																<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/no-img.png">
															<?php endif; ?>
														</div>
														<div class="business_item__about__detail col-lg-7 col-12">
															<div class="product_name"><?php echo $haisui_product1_name; ?></div>
															<p class="mb-0"><?php echo $haisui_product1_about; ?></p>
														</div>
													</div>
												</div>
											</div>
											<div class="modal_close">
												<div class="rounded-pill">
													閉じる<span class="pl-3">×</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="more-link">
							<p>民間用排水、総合水処理、リサイクル水に関するお問合せはこちら</p>
							<a href="https://www.nagaokajapan.co.jp/contact/" target="_blank">
								<button class="rounded-pill">
									<p class="mb-0">お問い合わせへ<i class="fas fa-arrow-right pl-4"></i></p>
								</button>
							</a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="widget_type_recruit screen_widget_key_top_recruit home-appear">
				<div class="widget_content">
					<div class="widget_header anime">
						<h2 class="top_widget_tit anime-scroll">RECRUIT<span class="d-block">採用情報</span></h2>
					</div>
					<div class="widget_body">
						<div class="recruit_about">
							<?php echo $recruit_about; ?>
						</div>
						<div class="more-link">
							<a href="/recruit/" target="_blank">
								<button class="rounded-pill">
									<p class="mb-0">採用応募へ<i class="fas fa-arrow-right pl-4"></i></p>
								</button>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="widget_type_news screen_widget_key_top_news home-appear">
				<div class="widget_content">
					<div class="widget_header anime">
						<h2 class="top_widget_tit anime-scroll">NEWS<span class="d-block">新着情報</span></h2>
					</div>
					<div class="widget_body anime row">
						<div class="news-list">
							<?php
								$topics_args = array(
									'posts_per_page' => 3,
									'post_type' => 'post',
									'orderby' => 'date',
									'order' => 'DESC',
									'category_name' => 'news_topics'
								);
								
								$topics_posts = get_posts( $topics_args );
								if ( $topics_posts ) :
									foreach ($topics_posts as $post) : setup_postdata( $post );
										$days = 7;
										$now = wp_date('U');
										$entry = get_the_time('U');
										$term = date('U', ($now - $entry)) / 86400;

										$cat_data = get_the_category();
										$cat_id_text = 'category_'.$cat_data[0]->term_id; 
										$cat_color = get_field('cat_color', $cat_id_text);
							?>
							<article class="anime-scroll">
								<a href="<?php the_permalink(); ?>">
									<div class="news-content d-lg-flex d-block align-items-center anime_hover-up">
										<div class="news-header d-lg-flex d-block align-items-center">
											<?php
												if( $days > $term ) {
													echo '<div class="new rounded-pill">NEW</div>';
												}
											?>
											<div class="d-flex align-items-center">
												<div class="news-date">
													<time datetime="<?php the_time('Y.m.d') ?>"><?php the_time('Y.m.d') ?></time>
												</div>
												<div class="news-category" <?php if($cat_color) echo 'style="background-color: '.$cat_color.'"'; ?>>
													<p class="mb-0"><?php echo $cat_data[0]->cat_name; ?></p>
												</div>
											</div>
										</div>
										<div class="news-body">
											<p class="mb-0 fw-normal"><?php the_title(); ?></p>
										</div>
									</div>
								</a>
							</article>
							<?php endforeach; else : ?>
								<p class="mb-0 text-center">新着情報はございません。</p>
							<?php endif; wp_reset_postdata(); ?>
						</div>
						<div class="more-link">
							<a href="<?php echo home_url(); ?>/news/">
								<button class="rounded-pill">
									<p class="mb-0">一覧へ<i class="fas fa-arrow-right pl-4"></i></p>
								</button>
							</a>
						</div>
					</div>
				</div>
			</div>
				
	</main><!-- #main -->
</div><!-- #primary -->
<script>
	class ParallaxEffectBackground {
	constructor() {
		this.devided = 5;
		this.target = '.screen_widget_key_top_recruit';
		this.setBackgroundPosition();
	}

	getScrollTop() {
		return Math.max(
		window.pageYOffset,
		document.documentElement.scrollTop,
		document.body.scrollTop,
		window.scrollY
		);
	}

	setBackgroundPosition() {
		document.addEventListener('scroll', e => {
		const scrollTop = this.getScrollTop();
		const position = scrollTop / this.devided;
		if (position) {
			document.querySelectorAll(this.target).forEach(element => {
			element.style.backgroundPosition = 'center top -' + position + 'px';
			});
		}
		});
	}
	}

	document.addEventListener('DOMContentLoaded', event => {
	new ParallaxEffectBackground();
	});
</script>

<?php
get_footer();