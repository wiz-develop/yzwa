<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage wiz
 * @since wiz 2022.7
 */

$parts = $args['parts'];

?>
<nav id="site-navigation" class="text-center <?php if ($parts === 'header') echo 'main-navigation';?><?php if ($parts === 'footer') echo 'search-navigation';?>" aria-label="Top Menu">
	<div class="menu-headernavigation-container">
		<ul id="menu-headernavigation" class="main-menu list-unstyled mb-0">

			<?php if ($parts === 'header') : // PC用（ヘッダーメニュー） ?>
			<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
				<?php //if ($parts === 'header') : ?>
					<a href="/">
						<div class="parent-name">
							<p class="mb-0">トップ</p>
						</div>
					</a>
				<?php //endif; ?>
			</li>
			<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
				<?php if ($parts === 'header') : ?>
					<a href="/#business">
						<div class="parent-name">
							<p class="mb-0">事業内容</p>
						</div>
					</a>
				<?php endif; ?>
			</li>
			<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
				<?php if ($parts === 'header') : ?>
					<a href="/company/">
						<div class="parent-name">
							<p class="mb-0">企業情報</p>
						</div>
					</a>
				<?php endif; ?>
				<div class="<?php if ($parts === 'header') echo 'sub-menu '; ?>">
					<section class="food-product_content <?php if ($parts === 'footer') { echo 'ac-list'; } ?>">
						<div class="sp-nav <?php if ($parts === 'header') echo 'd-none'; ?><?php if ($parts === 'footer') { echo 'ac-parent'; } ?>">
							<div class="parent-name">
								<h2 class="d-flex align-items-center mb-0">企業情報</h2>
							</div>
							<svg class="open-cat" xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21">
								<defs>
									<style>.a{fill:#0F5398;}.b{fill:none;stroke:#fff;stroke-width:3px;}</style>
								</defs>
								<g transform="translate(-0.443 -0.04)">
									<circle class="a" cx="10.5" cy="10.5" r="10.5" transform="translate(0.443 0.039)"/>
									<line class="b" x2="12.12" transform="translate(4.557 10.764)"/>
									<line class="b" x2="12.12" transform="translate(10.617 4.704) rotate(90)"/>
								</g>
							</svg>
							<svg class="close-cat" xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21">
								<defs>
									<style>.a{fill:#0F5398;}.b{fill:none;stroke:#fff;stroke-width:3px;}</style>
								</defs>
								<g transform="translate(-0.443 -0.04)">
									<circle class="a" cx="10.5" cy="10.5" r="10.5" transform="translate(0.443 0.039)"/>
									<line class="b" x2="12.12" transform="translate(4.557 10.764)"/>
								</g>
							</svg>
						</div>
						<div class="<?php if ($parts === 'footer') echo 'ac-child'; ?>">
							<div class="container <?php if ($parts === 'footer') echo ' widget_content mt-3 mb-5'; ?>">
								<div class="row">
									<?php if (!wp_is_mobile()) : ?>
									<div class="nav-about col-4">
										<div class="nav-about__tit">
											<p class="mb-0">企業情報</p>
										</div>
										<div class="nav-about__th">
											<img src="/cms/wp-content/uploads/2022/12/company_th.png" alt="企業情報">
										</div>
										<div class="nav-about__detail">
											<p class="pb-0">時代の変遷の中で自社の事業を大きく変え、上水道等の水処理に関わる設備設計と工事を主力事業としております。</p>
										</div>
										<div class="nav-about__link more-link">
											<a href="/company/">
												<button class="rounded-pill">
													<p class="mb-0">企業情報トップへ<i class="fas fa-arrow-right pl-4"></i></p>
												</button>
											</a>
										</div>
									</div>
									<?php endif; ?>
									<div class="col-12 col-md-8">
										<div class="nav-link_list d-flex align-items-center flex-wrap">
											<div class="link-content zoomIn">
												<a href="/company/greeting/">
													<div class="link-content__item">
														<div class="link-content__item__img mask">
															<img src="/cms/wp-content/uploads/2022/12/greeting_th.jpg" alt="ご挨拶">
														</div>
														<div class="link-content__item__about">
															<div class="link-content__item__about__tit">
																<p class="mb-0">ご挨拶</p>
															</div>
														</div>
													</div>
												</a>
											</div>
											<div class="link-content zoomIn">
												<a href="/company/about/">
													<div class="link-content__item">
														<div class="link-content__item__img mask">
															<img src="/cms/wp-content/uploads/2022/12/company_th.png" alt="会社概要">
														</div>
														<div class="link-content__item__about">
															<div class="link-content__item__about__tit">
																<p class="mb-0">会社概要</p>
															</div>
														</div>
													</div>
												</a>
											</div>
											<div class="link-content zoomIn">
												<a href="/company/history/">
													<div class="link-content__item">
														<div class="link-content__item__img mask">
															<img src="/cms/wp-content/uploads/2022/12/history_th.jpg" alt="会社沿革">
														</div>
														<div class="link-content__item__about">
															<div class="link-content__item__about__tit">
																<p class="mb-0">会社沿革</p>
															</div>
														</div>
													</div>
												</a>
											</div>
											<div class="link-content zoomIn">
												<a href="/company/office/">
													<div class="link-content__item">
														<div class="link-content__item__img mask">
															<img src="/cms/wp-content/uploads/2022/12/office_th.jpg" alt="事業所紹介">
														</div>
														<div class="link-content__item__about">
															<div class="link-content__item__about__tit">
																<p class="mb-0">事業所紹介</p>
															</div>
														</div>
													</div>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</li>
			<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
				<?php // if ($parts === 'header') : ?>
					<a href="/news/">
						<div class="parent-name">
							<p class="mb-0">新着情報</p>
						</div>
					</a>
				<?php // endif; ?>
			</li>
			<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
				<?php // if ($parts === 'header') : ?>
					<a href="/contact/">
						<div class="parent-name">
							<p class="mb-0">お問い合わせ</p>
						</div>
					</a>
				<?php // endif; ?>
			</li>
			<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-recruit d-flex align-items-center">
				<?php // if ($parts === 'header') : ?>
					<a href="/recruit/">
						<div class="parent-name">
							<p class="mb-0">採用情報</p>
						</div>
					</a>
				<?php // endif; ?>
			</li>
			<?php endif; ?>

			<?php if ($parts === 'footer') : // スマホ用 ?>
			<li class="menu-item menu-item-type-custom menu-item-object-custom">
				<div>
					<section class="food-product_content ac-list">
						<div class="sp-nav">
							<a href="/">
								<h2 class="d-flex align-items-center mb-0">トップ</h2>
							</a>
						</div>
					</section>
				</div>
			</li>
			<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
				<div>
					<section class="food-product_content ac-list">
						<div class="sp-nav ac-parent">
							<h2 class="d-flex align-items-center mb-0">企業情報</h2>
							<svg class="open-cat" xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21">
								<defs>
									<style>.a{fill:#0F5398;}.b{fill:none;stroke:#fff;stroke-width:3px;}</style>
								</defs>
								<g transform="translate(-0.443 -0.04)">
									<circle class="a" cx="10.5" cy="10.5" r="10.5" transform="translate(0.443 0.039)"/>
									<line class="b" x2="12.12" transform="translate(4.557 10.764)"/>
									<line class="b" x2="12.12" transform="translate(10.617 4.704) rotate(90)"/>
								</g>
							</svg>
							<svg class="close-cat" xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21">
								<defs>
									<style>.a{fill:#0F5398;}.b{fill:none;stroke:#fff;stroke-width:3px;}</style>
								</defs>
								<g transform="translate(-0.443 -0.04)">
									<circle class="a" cx="10.5" cy="10.5" r="10.5" transform="translate(0.443 0.039)"/>
									<line class="b" x2="12.12" transform="translate(4.557 10.764)"/>
								</g>
							</svg>
						</div>
						<div class="ac-child">
							<div class="widget_content mt-5 mb-5'">
								<div class="container">
									<div class="row">
										<div class="nav-about col-12">
											<div class="container">
												<div class="row align-items-center mt-3">
													<div class="nav-about__th col-5">
														<img src="/cms/wp-content/uploads/2022/12/company_th.png" alt="企業情報">
													</div>
													<div class="nav-about__detail col-7">
														<p class="pb-0 ps-0 text-start">
															時代の変遷の中で自社の事業を大きく変え、上水道等の水処理に関わる設備設計と工事を主力事業としております。
														</p>
													</div>
													<div class="nav-about__link more-link col-12 text-center pl-0">
														<a href="/company/">
															<button class="rounded-pill">
																<p class="mb-0">企業情報トップへ<i class="fas fa-arrow-right ps-4"></i></p>
															</button>
														</a>
													</div>
												</div>
											</div>
										</div>
										<div class="menu-link_list col-12 col-md-9 mt-5">
											<div class="container">
												<div class="row">
													<div class="link-content zoomIn col-6 mb-3">
														<a href="/company/greeting/">
															<div class="link-content__item">
																<div class="link-content__item__img mask">
																	<img src="/cms/wp-content/uploads/2022/12/greeting_th.jpg" alt="ご挨拶">
																</div>
																<div class="link-content__item__about">
																	<div class="link-content__item__about__tit">
																		<p class="mb-0">ご挨拶</p>
																	</div>
																</div>
															</div>
														</a>
													</div>
													<div class="link-content zoomIn col-6 mb-3">
														<a href="/company/about/">
															<div class="link-content__item">
																<div class="link-content__item__img mask">
																	<img src="/cms/wp-content/uploads/2022/12/company_th.png" alt="会社概要">
																</div>
																<div class="link-content__item__about">
																	<div class="link-content__item__about__tit">
																		<p class="mb-0">会社概要</p>
																	</div>
																</div>
															</div>
														</a>
													</div>
													<div class="link-content zoomIn col-6 mb-3">
														<a href="/company/history/">
															<div class="link-content__item">
																<div class="link-content__item__img mask">
																	<img src="/cms/wp-content/uploads/2022/12/history_th.jpg" alt="会社沿革">
																</div>
																<div class="link-content__item__about">
																	<div class="link-content__item__about__tit">
																		<p class="mb-0">会社沿革</p>
																	</div>
																</div>
															</div>
														</a>
													</div>
													<div class="link-content zoomIn col-6 mb-3">
														<a href="/company/office/">
															<div class="link-content__item">
																<div class="link-content__item__img mask">
																	<img src="/cms/wp-content/uploads/2022/12/office_th.jpg" alt="事業所紹介">
																</div>
																<div class="link-content__item__about">
																	<div class="link-content__item__about__tit">
																		<p class="mb-0">事業所紹介</p>
																	</div>
																</div>
															</div>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</li>
			<li class="menu-item menu-item-type-custom menu-item-object-custom">
				<div>
					<section class="food-product_content ac-list">
						<div class="sp-nav">
							<a href="/news・">
								<h2 class="d-flex align-items-center mb-0">新着情報</h2>
							</a>
						</div>
					</section>
				</div>
			</li>
			<li class="menu-item menu-item-type-custom menu-item-object-custom">
				<div>
					<section class="food-product_content ac-list">
						<div class="sp-nav">
							<a href="/contact/">
								<h2 class="d-flex align-items-center mb-0">お問い合わせ</h2>
							</a>
						</div>
					</section>
				</div>
			</li>
			<li class="menu-item menu-item-type-custom menu-item-object-custom">
				<div>
					<section class="food-product_content ac-list">
						<div class="sp-nav">
							<a href="/recruit/">
								<h2 class="d-flex align-items-center mb-0">採用情報</h2>
							</a>
						</div>
					</section>
				</div>
			</li>
			<?php endif; ?>
		</ul>
		<?php if (wp_is_mobile()) : ?>
			<?php get_template_part('template-parts/nav/footer-menu'); ?>
		<?php endif; ?>
	</div>
</nav>
