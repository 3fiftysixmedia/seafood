<div id="latest-block" class="row boxes">
  <div class="col-sm-4 box salmon">
      <h3>Get listed</h3>
      <div class="simple-content">
        <?php echo $block_1['content']; ?>
      </div>
      <a href="<?php echo $block_1['url']; ?>" class="btn btn-primary pull-right"><?php echo $block_1['link_text']; ?><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
  </div>
  <div class="col-sm-4 box oceanblue">
      <h3>Get listed</h3>
      <div class="simple-content">
        <?php echo $block_1['content']; ?>
      </div>
      <a href="<?php echo $block_1['url']; ?>" class="btn btn-primary pull-right"><?php echo $block_1['link_text']; ?><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
  </div>
  <div class="col-sm-4 box silver">
      <h3>Useful Industry Links</h3>
      <?php include( get_template_directory() . '/templates/boxes-useful-links.php'); ?>
  </div>
</div>
