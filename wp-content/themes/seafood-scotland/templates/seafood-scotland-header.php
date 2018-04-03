<?php

function seafood_scotland_global_header($title, $sub_header) {

  <div class="container">
    <div class="row titles">
        <div class="col-sm-2 logo">
            <?php echo get_the_logo(); ?>
        </div>
        <div class="col-sm-8">
            <h1><?php echo get_the_title(); ?></h1>
            <?php echo get_field('header_text'); ?>
        </div>
    </div>
  </div>

};
?>
