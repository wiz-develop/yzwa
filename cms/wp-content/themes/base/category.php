<?php
/**
 * The template for displaying all single posts
 * カテゴリー
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */
get_header();
$cat_id = get_query_var('cat'); //カテゴリーのid
$cat_slug = get_query_var('category_name'); //カテゴリーのスラッグ
$get_data = false;

?>
    
<?php

    $news_id = get_category_by_slug('news_topics')->cat_ID;
    $news_children = get_term_children( $news_id, 'category' );
    if (($cat_slug === 'news_topics') || in_array($cat_id, $news_children, true)) :

    $year = $_GET['archive'];
?>
    <div id="app_func" class="app_func app_func_page func_key_page">
        <main>
            <div id="app_func_screen" class="app_func_screen app_func_screen_archive-list screen_key_archive-list py-5">
                <div class="widget_type_page_title screen_widget_key_page_title">
                    <div class="widget_content container">
                        <h1 class="mb-0">
                            <?php echo $year.'年の'; single_cat_title(); echo '記事一覧'; ?>
                        </h1>
                    </div>
                </div>
                <div class="widget_type_news screen_widget_key_news_archive">
                    <div class="widget_content container">
                        <div class="row">
                            <div class="col-12 col-lg-8">
                                <div class="widget_main">
                                    <div class="widget_body anime">
                                        <?php
                                            $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
                                            $args = array(
                                                'posts_per_page' => 10,
                                                'paged' => $paged,
                                                'post_type' => 'post',
                                                'orderby' => 'date',
                                                'category_name' => $cat_slug,
                                                'post_status' => 'publish',
                                            );
                                            if ($year) {
                                                $date_query = array (
                                                    'date_query' => array(
                                                        'year'  => $year,
                                                    ),
                                                );
                                                $args = array_merge($args, $date_query);
                                            }
                                            
                                            $query = new WP_Query( $args );
                                            if ( $query->have_posts() ) :
                                                while ( $query->have_posts() ) :
                                                    $query->the_post();

                                                    $category = get_the_category();
                                                    $cat_name = $category[0]->name;
                                                    $cat_acf = 'category_'.$category[0]->cat_ID;
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
                                        <?php endwhile; ?>
                                        <div class="pnavi mt-3 mx-auto">
                                            <?php
                                                if ($query->max_num_pages > 1) {
                                                    echo paginate_links(array(
                                                        'base'      => '%_%',
                                                        'format'    => '?page=%#%',
                                                        'current'   => max(1, $paged),
                                                        'mid_size'  => 2,
                                                        'total'     => $query->max_num_pages,
                                                        'prev_text' => '<',
                                                        'next_text' => '>',
                                                        'type'      => 'list'
                                                    ));
                                                }
                                            ?>
                                        </div>
                                        <?php
                                            else :
                                                echo '<p class="mb-0">最新の記事はありません</p>';
                                            endif; wp_reset_postdata();
                                            if ($back_btn) :
                                        ?>
                                        <div class="next-link anime_hover-up text-center pt-5">
                                            <a href="/<?php echo $back_btn; ?>">
                                                <button class="bg-white_btn active rounded">記事一覧へ</button>
                                            </a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="anime col-12 col-lg-4">
                                <div class="widget_side anime-scroll">
                                    <section>
                                        <div class="widget_content">
                                            <div class="widget_body">
                                                <?php get_sidebar(); ?>
                                            </div>
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
    endif;

get_footer();