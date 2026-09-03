<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

?>

	</div><!-- #content -->
	<div class="footer-link_content pb-5">
		<div class="widget_content">
			<h3>関連リンク</h3>
			<a href="https://www.nagaokajapan.co.jp/" target="_blank">
				<div class="link-item">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/logo_nagaoka.png" alt="株式会社ナガオカ">
				</div>
			</a>
		</div>
	</div>
	<footer id="colophon" class="site-footer w-100 pt-4 pb-5 bg-black">
		<div class="widget_content container pb-5 pb-lg-0">
			<div class="footer-link_list">
				<?php get_template_part('template-parts/nav/footer-menu'); ?>
			</div>
			<div class="copylight text-end">Copyright © YAZAWA Feromait co.Ltd.</div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	<div class="footer_hamburger d-lg-none position-fixed bottom-0 container-fluid">
		<div class="row align-items-center">
			<button class="sitemap_trigger hamburger-btn col py-1">
				<svg class="hamburger-btn__img d-block mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37 30">
					<g transform="translate(3663 -4780)">
						<rect width="37" height="30" transform="translate(-3663 4780)" fill="none"/>
						<g transform="translate(0 1)">
						<rect width="25" height="3" rx="1.5" transform="translate(-3657 4784)"/>
						<rect width="25" height="3" rx="1.5" transform="translate(-3657 4793)"/>
						<rect width="25" height="3" rx="1.5" transform="translate(-3657 4802)"/>
						</g>
					</g>
				</svg>
				<span class="d-block text-center">メニュー</span>
			</button>
			<a href="<?php echo home_url(); ?>" class="hamburger-btn col">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44">
					<g transform="translate(13088 -1428)">
						<path d="M19327.5,3318.256h-9.029v-9.6l-1.656,1.221-2.051-2.223,15.623-15.946,6.26,6.382v-2.615h4.3v6.96l4.949,5.219-2.2,2.223-1.59-1.221v9.6h-9.285v-7.46h-5.324Z" transform="translate(-32396.332 -1854.984)" fill="#fff"/>
						<rect width="44" height="44" transform="translate(-13088 1428)" fill="none"/>
					</g>
				</svg>
				<span class="d-block text-center">トップ</span>
			</a>
			<a href="<?php echo home_url(); ?>#business" class="hamburger-btn col">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44">
					<g transform="translate(13041 -1428)">
						<g transform="translate(-13104.366 1435.171)">
						<path d="M92.967,10.843,85.44,0,77.913,10.843c-3.053,4.785-4.157,10.9,0,15.054a10.645,10.645,0,0,0,15.054,0C97.124,21.74,96.02,15.629,92.967,10.843ZM78.478,22.285c-1.953-3.979,1.157-9.7,3.112-11.865a14.891,14.891,0,0,0,.651,10.853C83.629,24.087,80.659,26.729,78.478,22.285Z" transform="translate(0)" fill="#fff"/>
						</g>
						<rect width="44" height="44" transform="translate(-13041 1428)" fill="none"/>
					</g>
				</svg>
				<span class="d-block text-center">事業内容</span>
			</a>
			<a href="<?php echo home_url(); ?>/company/" class="hamburger-btn col">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44">
					<g transform="translate(12974 -1428)">
						<g transform="translate(-13015.981 1435.716)">
						<path d="M52.963,0V29.412H63.1v-7.1h3.043v7.1H76.29V0Zm7.1,25.355H57.02V22.312h3.043Zm0-6.085H57.02V16.227h3.043Zm0-6.085H57.02V10.142h3.043Zm0-6.085H57.02V4.057h3.043Zm6.085,12.17H63.1V16.227h3.043Zm0-6.085H63.1V10.142h3.043Zm0-6.085H63.1V4.057h3.043Zm6.085,18.256H69.19V22.312h3.043Zm0-6.085H69.19V16.227h3.043Zm0-6.085H69.19V10.142h3.043Zm0-6.085H69.19V4.057h3.043Z" transform="translate(-1)" fill="#fff"/>
						</g>
						<rect width="44" height="44" transform="translate(-12974 1428)" fill="none"/>
					</g>
				</svg>
				<span class="d-block text-center">企業情報</span>
			</a>
			<a href="<?php echo home_url(); ?>/news/" class="hamburger-btn col">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44">
					<g transform="translate(12900 -1428)">
						<g transform="translate(-12897 1357.75)">
						<path d="M67.382,321.735a2.462,2.462,0,0,1-.982,1.111,2.228,2.228,0,0,1-.531.228l-.6-2.215H61.015l1.484,7.493a.977.977,0,0,0,.959.788h2.777a.978.978,0,0,0,.945-1.233l-1.038-3.835c.08-.022.161-.047.242-.077a3.366,3.366,0,0,0,1.545-1.162,4.126,4.126,0,0,0,.709-1.625c-.327-.062-.668-.119-1.021-.169A3.4,3.4,0,0,1,67.382,321.735Z" transform="translate(-56.499 -223.729)" fill="#fff"/>
						<path d="M108.11,79.25c-.782,0-2.041,1.333-2.585,1.877-.472.472-4.19,4.171-13.619,4.171v11.03c9.429,0,13.147,3.7,13.619,4.172.544.542,1.8,1.876,2.585,1.876a1.415,1.415,0,0,0,1.414-1.414v-20.3A1.415,1.415,0,0,0,108.11,79.25Z" transform="translate(-85.104)" fill="#fff"/>
						<path d="M5.515,160.969a5.515,5.515,0,1,0,0,11.03Z" transform="translate(0 -75.671)" fill="#fff"/>
						<path d="M345.375,207.516v4.14a2.07,2.07,0,1,0,0-4.14Z" transform="translate(-319.814 -118.773)" fill="#fff"/>
						<rect width="5.572" height="1.081" transform="translate(32.321 90.128)" fill="#fff"/>
						<path d="M423.416,116.286l-.58-.911-5.07,3.231.583.912Z" transform="translate(-386.847 -33.451)" fill="#fff"/>
						<path d="M417.766,302.661l5.07,3.232.58-.912-5.067-3.231Z" transform="translate(-386.847 -206.033)" fill="#fff"/>
						</g>
						<rect width="44" height="44" transform="translate(-12900 1428)" fill="none"/>
					</g>
				</svg>
				<span class="d-block text-center">新着情報</span>
			</a>
		</div>
	</div>
	<div id="sitemap_modal" class="modal_box menu_box sitemap_box">
		<div class="sitemap_inner position-absolute w-100 top-0 bottom-0 start-0 end-0 margin-auto bg-white">
			<div class="menu_inner__header">
				<div class="modal_close position-relative container widget_content d-flex align-items-center">
					<button class="m-0 p-0 text-dark position-absolute"><p class="menu_title mb-0 text-center py-3">閉じる</p></button>
				</div>
			</div>
			<div class="menu_block">
				<div class="menu_block__content">
					<?php get_template_part( 'template-parts/header/site', 'branding', ['parts' => 'footer'] ); ?>
				</div>
			</div>
		</div>
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
