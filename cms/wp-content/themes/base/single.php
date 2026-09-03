<?php get_header();

$news_cat = get_category_by_slug('news_topics');
$news_cat_children = get_term_children($news_cat->term_id, 'category');

if (in_category('develop')) {
    get_template_part('template-parts/post/single', 'develop');
} else if (in_category('service')) {
    get_template_part('template-parts/post/single', 'service');
} else if (in_category($news_cat_children)) {
    get_template_part('template-parts/post/single', 'news');
}

get_footer();