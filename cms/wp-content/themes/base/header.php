<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

$setting_page = get_page_by_path('setting');
$setting_page_id = $setting_page->ID;
$site_logo = CFS()->get('site_logo', $setting_page_id);
$company_name = CFS()->get('company_name', $setting_page_id);
$description = CFS()->get('description', $setting_page_id);
$keywords = CFS()->get('keywords', $setting_page_id);

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta charset="utf-8">
	<meta name="description" content="<?php echo $description; ?>">
    <meta name="keywords" content="<?php echo $keywords; ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Expires" content="0">
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link rel="canonical" href="<?php echo esc_url( home_url( '/' ) ); ?>">
	<link rel="Shortcut Icon" type="image/x-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/common/favicon.png" />
	<?php wp_head(); ?>
</head>

<body id="app_yzwa" <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site-content overflow-visible">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentynineteen' ); ?></a>

		<header id="masthead" class="site-header p-0 position-sticky top-0">
			<div class="site-header container-fluid p-0">
				<div class="sub-nav-menu d-flex align-items-center justify-content-between pl-5">
					<div class="header_sub_nav">
						<div class="site_logo">
							<a href="<?php echo get_home_url(); ?>">
								<div class="logo_img">
									<img src="<?php echo $site_logo ?>" alt="<?php echo $company_name ?>">
								</div>	
							</a>
						</div>
					</div>
					<div class="site-function-menu align-self-stretch p-0">
						<div class="menu-list d-flex align-items-center">
						<?php
							if (!wp_is_mobile()) {
								echo '<div class="d-lg-block d-none">';
								get_template_part( 'template-parts/header/site', 'branding', ['parts' => 'header'] );
								echo '</div>';
							}
						?>
						</div>
					</div>
				</div>
			</div>
		</header><!-- #masthead -->

	<div id="content" class="site-content">
		<?php if (!is_front_page()) : ?>
			<div class="widget_type_breadcrumb screen_widget_key_breadcrumb">
                <div class="widget_content container">
					<?php breadcrumb(); ?>
                </div>
            </div>
		<?php endif; ?>
