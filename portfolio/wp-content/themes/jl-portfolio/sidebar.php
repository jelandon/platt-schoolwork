<aside id="sidebar">
  <section id="categories" class="widget">
    <h3 class="widget-title"> Categories </h3>
    <ul>
      <?php 
      //show the 15 most commonly used categories
      wp_list_categories( array(
        'title_li'    => '',
        'show_count'  => 1,
        'orderby'     => 'count',
        'order'       => 'DESC',
        'number'      => 15,
      ) ); ?>
    </ul>
  </section>
  <section id="archives" class="widget">
    <h3 class="widget-title"> Archives </h3>
    <ul>
      <?php 
      //get yearly archives
      wp_get_archives( array(
        'type' => 'yearly',
      ) ); ?>
    </ul>
  </section>
  <section id="tags" class="widget">
    <h3 class="widget-title"> Tags </h3>
    <?php wp_tag_cloud( array(
      'largest' => 1,
      'smallest' => 1,
      'unit' => 'em',
      // 'format' => 'list',
    ) ); ?>

  </section>
  <section id="meta" class="widget">
    <h3 class="widget-title"> Meta </h3>
    <ul>
      <?php if( is_user_logged_in() ){  ?>
      <li><a href="<?php echo admin_url(); ?>">Site Admin</a></li>
      <?php } ?>
      <li><?php wp_loginout(); ?></li>
    </ul>
  </section>
</aside>
<!-- end #sidebar -->