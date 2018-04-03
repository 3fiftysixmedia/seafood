<?php /* Template Name: schemes template */ ?>
<?php get_header(); ?>
<?php get_seafood_scotland_global_header(get_the_title(), get_field('header_text')); ?>
<div class="container brd-1-db">
		<!-- section -->
		<div class="row">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
			<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
			<script>
			$(document).ready(function () {
    //Toggle fullscreen
    $("#panel-fullscreen").click(function (e) {
        e.preventDefault();
        
        var $this = $(this);
    
        if ($this.children('i').hasClass('glyphicon-resize-full'))
        {
            $this.children('i').removeClass('glyphicon-resize-full');
            $this.children('i').addClass('glyphicon-resize-small');
        }
        else if ($this.children('i').hasClass('glyphicon-resize-small'))
        {
            $this.children('i').removeClass('glyphicon-resize-small');
            $this.children('i').addClass('glyphicon-resize-full');
        }
        $(this).closest('.panel').toggleClass('panel-fullscreen', 500, );
    });
});
</script>

			</div>
	    </div>

		<div class="container" style="">
			<div class="row">
			<div class="col-md-8" style="">
				<div class="" style="padding:15px;">
					<div class="content">
						<?php the_content(); ?>
					</div>

					
		

			</div>
			<div class="panel panel-default">
						<div class="panel-heading">
						<div class="row">
						<div class="col-sm-11">
						<h3 class="panel-title"> Click each individual logo for further information.</h3>

						</div>
						<div class="col-sm-1">
						<ul class="list-inline panel-actions">
								<li><a href="#" id="panel-fullscreen" role="button" title="Toggle fullscreen"><i class="glyphicon glyphicon-resize-full"></i></a></li>
							</ul>
						</div>

						</div>

						</div>
						<div class="panel-body">
						<table class="table">
						<col>
						<colgroup span="2"></colgroup>
						<colgroup span="2"></colgroup>
						<tr>
						  <td rowspan="2"></td>
						  <th  colspan="3" scope="colgroup">  <img style="width:300px;height:550x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.19.13.png" alt=""></th>
						  <th class="" colspan="3" scope="colgroup">  <img style="width:290px;height:550x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.19.41.png" alt=""></th>
						</tr>
						<tr>
						  <th style="background-color:#5794b0;color:white;" scope="col">Product Defined</th>
						  <th style="background-color:#5794b0;color:white;"  scope="col">Sustainability/<br>welfare</th>
						  <th style="background-color:#5794b0;color:white;"  scope="col">Quality Safety/ Manufacturing Practise</th>
						  <th style="background-color:#9f9860;color:white;"  class="" scope="col">Product Defined</th>
						  <th style="background-color:#9f9860;color:white;" scope="col">Sustainability/<br>welfare</th>
						  <th style="background-color:#9f9860;color:white;" scope="col">Quality Safety/ Manufacturing Practise</th>
						</tr>
						<tr>
						  <th style="background-color:#e3e3e3" scope="row"> <img style="width:91px;height:70x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/2.png"></th>
						  <td class="table_bottom table_right">
						  <a href="https://ec.europa.eu/agriculture/quality/schemes_en"> <img style="width:50px;height:50x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.21.35.png"><br> 
						  <a href=""> <img style="width:50px;height:50x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.21.51.png"><br>
						  <a href="http://www.saumonecossais.com/en/label-rouge-scottish-salmon/what-is-label-rouge"> <img style="width:80px;height:50x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.22.14.png">
						   </td>
						  <td class="table_bottom table_right">
						  <a href="https://www.asc-aqua.org"> <img style="width:80px;height:40px;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.22.27.png"><br>
						  <a href="https://www.berspcaassured.org.uk"> <img style="width:50px;height:50x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.22.34.png"><br>
						  <a href="https://www.msc.org"> <img style="width:80px;height:40px;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.22.45.png">
						  </td>
						  <td class="table_bottom table_right">
						   <a href="https://www.iso.org/certification.html"> <img style="width:60px;height:60x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.23.16.png"><br>
						   <a href="http://thecodeofgoodpractice.co.uk"> <img style="width:80px;height:40px;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.23.09.png">
						   </td>
						  <td class="table_bottom table_right">
						  <a href="https://ec.europa.eu/agriculture/quality/schemes_en"> <img style="width:50px;height:50x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.21.35.png"><br>
						  <a href=""> <img style="width:50px;height:50x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.21.51.png"><br>
						  <a href="http://www.saumonecossais.com/en/label-rouge-scottish-salmon/what-is-label-rouge"> <img style="width:80px;height:50x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.22.14.png">
						  </td>
						  <td class="table_bottom table_right"> 
						   <a href="https://www.asc-aqua.org"> <img style="width:80px;height:40px;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.22.27.png"><br>
						   <a href="https://www.berspcaassured.org.uk"> <img style="width:50px;height:50x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.22.34.png"><br>
						   <a href="https://www.msc.org"> <img style="width:80px;height:40px;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.22.45.png">
						   </td>
						  <td class="table_bottom">
						   <a href="https://www.brcglobalstandards.com"> <img style="width:50px;height:60px;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.23.46.png"><br>
						   <a href="https://www.iso.org/certification.html"> <img style="width:60px;height:60x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.23.16.png">
						   </td>
						</tr>
						<tr>
						<th style="background-color:#f4e9d8"  scope="row"> <img style="width:90px;height:70x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/1.png" alt=""></th>
						  <td class="table_right">
						   <a href="https://ec.europa.eu/agriculture/quality/schemes_en"> <img style="width:50px;height:50x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.21.35.png">
						  </td>
						  <td class="table_right">
						   <a href="http://www.friendofthesea.org"> <img style="width:60px;height:60x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.22.52.png"><br>
						   <a href="https://www.msc.org"> <img style="width:80px;height:40px;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.22.45.png">
						   </td>
						  <td class="table_right">
						  <a href="http://www.seafish.org/rfs/"> <img style="width:50px;height:50x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.23.26.png">
						  </td>
						  <td class="table_right">
						  <a href="https://ec.europa.eu/agriculture/quality/schemes_en"> <img style="width:50px;height:50x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.21.35.png">
						  </td>
						  <td class="table_right">
						  <a href="http://www.friendofthesea.org"> <img style="width:60px;height:60x;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.22.52.png"><br>
						  <a href="https://www.msc.org"> <img style="width:80px;height:40px;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.22.45.png">
						   </td>
						  <td>
						   <a href="https://www.salsafood.co.uk/index.php"> <img style="width:80px;height:40px;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.24.02.png"><br>
						   <a href="https://www.ifs-certification.com/index.php/en/"> <img style="width:80px;height:40px;" src="http://seafood-scotland.palmerminto.com/wp-content/themes/seafood-scotland/img/schemes/Screen%20Shot%202018-01-30%20at%2010.24.12.png">
						   </td>
						</tr>
					  </table>
						</div>
					</div>

			</div>
			
			<div class="col-sm-4 box silver1">
      <h3> <img src="/wp-content/uploads/2017/12/grey-link-icon.png">Useful Industry Links</h3>
      <?php include( get_template_directory() . '/templates/boxes-useful-links.php'); ?>
  </div>
			<?php
			$git_block_2 = get_field('git_block_2');
			if( $git_block_2 ): ?>
			<div class="col-md-4 box seablue" style="margin-top:-5px">
				<div class="offset">
					<h3>  <img src="<?php echo $git_block_2['icon']; ?>"/><?php echo $git_block_2['title']; ?></h3>
					<div>
						<div class="simple-content">
							<?php echo $git_block_2['content']; ?>
						</div>
						<?php  if ($git_block_2['link_title'] != null) { ?>
						<a href="<?php echo $git_block_2['link']; ?>" class="btn btn-primary pull-right"><?php echo $git_block_2['link_title']; ?><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
					<?php }; ?>
					</div>
					<br style="clear:both" />
				</div>
			</div>

			<?php endif; ?>
		</div>
		<br>

<style>
 table { table-layout: fixed; }
  table th, table td { overflow: hidden; }
</style>
		
	
				
</div>

			<!-- /article -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>
	</div>


<?php get_footer(); ?>
