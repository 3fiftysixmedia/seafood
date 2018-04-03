<table class="table ">
  <tbody>
    <?php
    $posts = get_posts(array('post_type'=> 'useful_link','posts_per_page'	=> 10,'order'=> 'DESC'));
    if( $posts ):
      foreach( $posts as $post ):
      setup_postdata( $post ) ?>
          <tr>
              <td class="item"><a href="<?php echo the_field('industry_url'); ?>" alt="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></td>
          </tr>
      <?php endforeach; ?>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>
  </tbody>
</table>
