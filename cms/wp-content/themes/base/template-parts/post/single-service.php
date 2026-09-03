
<?php
/**
 * The template for displaying all single posts
 * Template Name: サービス詳細
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();

$page_id = $page_data->ID;
$page_top_catch = CFS()->get('page_top_catch', $page_id);
$page_top_bg_color = CFS()->get('page_top_bg_color', $page_id);
$page_top_bg_img = CFS()->get('page_top_bg_img', $page_id);
$page_top_img = CFS()->get('page_top_img', $page_id);
$page_top_catch_tx_color = CFS()->get('page_top_catch_tx_color', $page_id);
$page_top_fikidasi = CFS()->get('page_top_fikidasi', $page_id);
$page_top_about = CFS()->get('page_top_about', $page_id);
$page_top_about_tx_color = CFS()->get('page_top_about_tx_color', $page_id);
$contact_url = CFS()->get('contact_url', $page_id);
$contact_tx_color = CFS()->get('contact_tx_color', $page_id);
$contact_bg_color = CFS()->get('contact_bg_color', $page_id);
$feature_about = CFS()->get('feature_about', $page_id);
$feature_img = CFS()->get('feature_img', $page_id);
$message_catch = CFS()->get('message_catch', $page_id);
$message_contact_bg = CFS()->get('message_contact_bg', $page_id);
$message_img = CFS()->get('message_img', $page_id);
?>
<div id="splash"></div>
<div class="splashbg"></div>
<div id="app_func" class="app_func app_func_single func_key_service">
	<main>
		<div id="app_func_screen" class="app_func_screen app_func_screen_service screen_key_service">
			<div class="widget_type_page_title screen_widget_key_page_top_main" style="<?php if ($page_top_bg_color) : ?>background-color:<?php echo $page_top_bg_color; ?>;<?php else : ?>background-img:<?php echo $page_top_bg_img; ?>;<?php endif; ?>">
				<div class="widget_content page-tit_content row align-items-center">
                    <div class="col-12 col-md-5">
                        <div class="page-catch mb-0"><?php echo $page_top_fikidasi; ?></div>
                        <h1 class="mb-0" style="color: <?php echo $page_top_catch_tx_color; ?>;"><?php echo $page_top_catch; ?></h1>
                        <div class="service-about">
                            <p class="mb-0" style="color: <?php echo $page_top_catch_tx_color; ?>;"><?php echo $page_top_about; ?></p>
                        </div>
                        <div class="contact-link">
                            <a href="<?php echo $contact_url; ?>">
                                <button class="rounded-pill" style="color: <?php echo $contact_tx_color ; ?>; background-color: <?php echo $contact_bg_color; ?>;">お問い合わせ・<br>資料請求はこちらから</button>
                            </a>
                        </div>
                    </div>
                    <div class="page-catch_img col-12 col-md-7">
                        <img src="<?php echo $page_top_img; ?>">
                    </div>
				</div>
			</div>
            <div class="widget_type_page_about screen_widget_key_age_about_service">
				<div class="widget_content container">
                    <div class="about_content row align-items-center">
                        <div class="about_content__img col-12 col-md-5">
                            <img src="<?php echo $feature_img; ?>">
                        </div>
                        <div class="about_content__detail col-12 col-md-7">
                            <div class="about_content__detail__tx">
                                <p class="mb-0"><?php echo $feature_about; ?></p>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
            <div class="widget_type_merit screen_widget_key_merit_service">
				<div class="widget_content container">
                    <div class="about_content">
                        <div class="about_content__detail">
                            <h2><?php the_title();?>を導入するメリット</h2>
                        </div>
                    </div>
                    <div class="merit_list">
                        <?php
                            $fields = CFS()->get('merit_list');
                            foreach ($fields as $field) :
                        ?>
                        <div class="merit_content row align-items-center">
                            <div class="merit_content__about col-12 col-md-8">
                                <p class="mb-0"><span><?php echo $field['merit_number']; ?></span><?php echo $field['merit_tit']; ?></p>
                                <div class="merit_content__about__detail">
                                    <p class="mb-0"><?php echo $field['merit_detail']; ?></p>
                                </div>
                            </div>
                            <div class="merit_content__img col-12 col-md-4">
                                <img src="<?php echo $field['merit_img']; ?>" alt="<?php echo $field['merit_tit']; ?>">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
				</div>
			</div>
			<div class="widget_type_content_item screen_widget_key_content_item_service">
                <div class="widget_header widget_content anime">
                    <h2 class="top_widget_tit anime-scroll">導入事例 / <span>CASE</span></h2>
                </div>
                <div class="about_content row align-items-center">
                    <div class="case_carousel anime-scroll">
                        <?php
                            $fields = CFS()->get('case_study_list');
                            foreach ($fields as $field) :
                        ?>
                        <div class="slide_content">
                            <div class="slide_item position-relative">
                                <div class="slide_item__header position-relative">
                                    <div class="slide_item__img">
                                        <img src="<?php echo $field['case_study_img']; ?>">
                                    </div>
                                </div>
                                <div class="slide_item__about">
                                    <div class="slide_item__about__name">
                                        <p class="mb-0 fw-bold"><?php echo $field['case_study_tit']; ?></p>
                                    </div>
                                    <div class="slide_item__about__detail">
                                        <p class="mb-0 fw-bold"><?php echo $field['case_study_about']; ?></p>
                                    </div>
                                    <div class="slide_item__about__cat text-end">
                                        <p class="mb-0 fw-bold rounded-pill"><?php echo $field['case_study_cat']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
			</div>
            <div class="widget_type_faq screen_widget_key_<?php echo $class_name; ?>_faq">
				<div class="widget_content">
					<div class="widget_header">
						<h2 class="top_widget_tit">よくあるご質問 / <span>FAQ</span></h2>
					</div>
					<div class="ac-list faq-list">
						<div class="faq_item">
							<div class="ac-parent question">
								<p class="mb-0"><span>Q.</span>質問質問質問質問質問質問質問質問質問質問質問</p>
							</div>
							<div class="ac-child answer">
								<p class="mb-0"><span>A.</span>回答回答回答回答回答回答回答回答回答回答回答</p>
							</div>
						</div>
						<div class="faq_item">
							<div class="ac-parent question">
								<p class="mb-0"><span>Q.</span>質問質問質問質問質問質問質問質問質問質問質問</p>
							</div>
							<div class="ac-child answer">
								<p class="mb-0"><span>A.</span>回答回答回答回答回答回答回答回答回答回答回答</p>
							</div>
						</div>
						<div class="faq_item">
							<div class="ac-parent question">
								<p class="mb-0"><span>Q.</span>質問質問質問質問質問質問質問質問質問質問質問</p>
							</div>
							<div class="ac-child answer">
								<p class="mb-0"><span>A.</span>回答回答回答回答回答回答回答回答回答回答回答</p>
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="widget_type_result screen_widget_key_result_service">
				<div class="widget_content container">
                    <div class="about_content row align-items-center">
                        <div class="about_content__detail col-12 col-md-8">
                            <div class="about_content__detail__tx">
                                <img src="<?php the_field('service_logo'); ?>" alt="<?php the_title();?>">は<br>
                                <?php echo $message_catch; ?>
                            </div>
                        </div>
                        <div class="about_content__img col-12 col-md-4">
                            <img src="<?php echo $message_img; ?>">
                        </div>
                    </div>
				</div>
                <div class="list_link service_list text-center">
                    <a href="<?php echo $contact_url; ?>">
                        <button class="rounded-pill" style="background-color: <?php echo $message_contact_bg; ?>;">お問い合わせ・資料請求はこちらから</button>
                    </a>
                </div>
                <div class="list_link service_list contact-link text-center">
                    <a href="<?php echo site_url(); ?>/service/">
                        <button class="rounded-pill">サービス一覧へ</button>
                    </a>
                </div>
			</div>
	</main><!-- #main -->
</div><!-- #primary -->
<style>
.page-catch:after {
    border-top-color: <?php echo $page_top_bg_color; ?> !important;
}
</style>
<?php
get_footer();