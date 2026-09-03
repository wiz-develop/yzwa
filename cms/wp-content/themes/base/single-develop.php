
<?php
/**
 * The template for displaying all single posts
 * Template Name: 開発実績詳細
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();

$page_id = $page_data->ID;
$page_catch = CFS()->get('page_catch', $page_id);
$task = CFS()->get('task', $page_id);
$task_img = CFS()->get('task_img', $page_id);
$main_content = CFS()->get('main_content', $page_id);
$main_content_about = CFS()->get('main_content_about', $page_id);
$main_content_img = CFS()->get('main_content_img', $page_id);
$merit_main_tit = CFS()->get('merit_main_tit', $page_id);
$result_about = CFS()->get('result_about', $page_id);
$result_img = CFS()->get('result_img', $page_id);

?>
<div id="splash"></div>
<div class="splashbg"></div>
<div id="app_func" class="app_func app_func_single func_key_develop">
	<main>
		<div id="app_func_screen" class="app_func_screen app_func_screen_develop screen_key_develop">
			<div class="widget_type_page_title screen_widget_key_page_title position-relative">
				<div class="widget_content page-tit_content position-relative">
                    <p class="page-catch mb-0"><?php echo $page_catch; ?></p>
					<h1 class="mb-0"><?php the_title();?></h1>
				</div>
				<div class="page-img_content position-absolute">
					<img src="<?php the_post_thumbnail_url('full'); ?>">
				</div>
			</div>
            <div class="widget_type_page_about screen_widget_key_age_about_develop">
				<div class="widget_content container">
                    <div class="about_content row align-items-center">
                        <div class="about_content__img col-12 col-md-5">
                            <img src="<?php echo $task_img; ?>">
                        </div>
                        <div class="about_content__detail col-12 col-md-7">
                            <h2>課題</h2>
                            <div class="about_content__detail__tx">
                                <p class="mb-0"><?php echo $task; ?></p>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<div class="widget_type_content_item screen_widget_key_content_item_develop">
				<div class="widget_content container">
                    <div class="about_content row align-items-center">
                        <div class="about_content__detail col-12 col-md-7">
                            <h2><?php echo $main_content; ?></h2>
                            <div class="about_content__detail__tx">
                                <?php echo $main_content_about; ?>
                            </div>
                        </div>
                        <div class="about_content__img col-12 col-md-5">
                            <img src="<?php echo $main_content_img; ?>">
                        </div>
                    </div>
				</div>
			</div>
            <div class="widget_type_merit screen_widget_key_merit_develop">
				<div class="widget_content container">
                    <div class="about_content">
                        <div class="about_content__detail">
                            <h2><?php echo $merit_main_tit; ?>のメリット</h2>
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
            <div class="widget_type_result screen_widget_key_result_develop">
				<div class="widget_content container">
                    <div class="about_content row align-items-center">
                        <div class="about_content__img col-12 col-md-4">
                            <img src="<?php echo $result_img; ?>">
                        </div>
                        <div class="about_content__detail col-12 col-md-8">
                            <h2>結果と今後の展開</h2>
                            <div class="about_content__detail__tx">
                                <?php echo $result_about; ?>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="list_link develop_list text-center">
                    <a href="/development/">
                        <button class="rounded-pill">開発実績一覧へ</button>
                    </a>
                </div>
			</div>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();