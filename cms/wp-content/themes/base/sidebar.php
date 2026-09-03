<aside>
    <div class="archive-links">
        <p>年別</p>
        <?php
          $cat_ids = [];
          $cat = get_category_by_slug("news_topics");
          $cat_id = $cat->cat_ID;
          $cat_slug = 'news_topics';

          $cat_children = get_term_children( $cat_id, 'category' );
          if ($cat_children) {
            $cat_ids = array_merge(array($cat_id), $cat_children);
          } else {
            $cat_ids = $cat_id;
          }

          $year = NULL;
          $args = array(
            'orderby' => 'date',
            'order'   => 'DESC',
            'posts_per_page' => -1,
            'category__in' => $cat_ids,
          );
          $the_query = new WP_Query($args);
          if($the_query->have_posts()) :
        ?>
        <ul>
          <?php
            while ($the_query->have_posts()): $the_query->the_post();
              if ($year != get_the_date('Y')) :
                $year = get_the_date('Y');
          ?>
            <li>
              <a href="<?php echo home_url(); ?>/<?php echo $cat_slug; ?>/?archive=<?php echo $year; ?>">
                <?php echo $year; ?>年
              </a>
            </li>
          <?php endif; endwhile; ?>
        </ul>
        <?php
            endif;
            wp_reset_postdata();
          ?>
      </div>
</aside>