</div><!-- /.container -->

		<div class="blue-bg subfooter">
				<div class="container">
						<div class="row">
								<div class="col-md-4 col-sm-12 col-xs-12 col-lg-4 box">
										<div class="white-background">
												<h3><img src="/wp-content/uploads/2017/12/twitter.png">Twitter</h3>
												<div>
													<?php
													if(is_active_sidebar('widget-area-3')){
													dynamic_sidebar('widget-area-3');
													}
													?>
												</div>
												<div class="clearfix"></div>

										</div>
								</div>
								<?php
									if(is_page(10)):
							
									?>
									<div class="col-md-4 col-sm-12 col-xs-12 col-lg-4 box seablue">
									<div class="col-md-12">
									<div class="offset">
										<h3><img src="http://seafood-scotland.palmerminto.com/wp-content/uploads/2017/12/support-icon.png">Support Available</h3>                                       
									
										<div>
										<div class="simple-content">
											<h4>Make the most of Seafood Scotland’s free services</h4>
									<p>Seafood Scotland is a specialist team providing hands-on, personalised support and advice through a comprehensive range of free services – from trade marketing promotion of Scottish seafood to business development support.</p>
										</div>
																<a href="http://seafood-scotland.palmerminto.com/support-available/" class="btn btn-primary pull-right">Find out more<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
															</div>
										<br style="clear:both">
										</div>
												
									</div>
									</div>
									<?php else: ?>	
								
								<div class="col-md-4 col-sm-12 col-xs-12 col-lg-4 box">
										<div class="infohub-footer" >
												<h3><img src="/wp-content/uploads/2017/12/info-hub.png">Info Hub</h3>
																										<?php
																											if(is_active_sidebar('widget-area-4')){
																											dynamic_sidebar('widget-area-4');
																											}
																											?>
														<div class="clearfix"></div>
												<div class="footer">
													<a href="/info-hub/" style="" class="btn btn-default pull-right">Visit the hub <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
												</div>
										</div>
								</div>
								<?php endif; ?>
								<div class="col-md-4 col-sm-12 col-xs-12 col-lg-4  box">
										<div class="white-background">
												<h3><img src="/wp-content/uploads/2017/12/email-footer.png">Enquiries</h3>
												<?php
													if(is_active_sidebar('widget-area-5')){
													dynamic_sidebar('widget-area-5');
													}
													?>
													<div class="clearfix"></div>
													<br/>
										</div>
								</div>
								
						</div><!-- /.row -->
						<div class="pull-right">
								<p class="white-text" style="margin-top:30px"><?php echo get_bloginfo( 'name' );?>, <span style="font-weight:300">18 Logie Mill, Logie Green Road, Edinburgh, EH7 4HS, UK</span> <img width="20" style="margin-left:20px" src="/wp-content/uploads/2017/12/phone-icon.png" /> +44 (0)131 557 9344</p>
						</div><!-- /.pull-right -->
				</div><!-- /.container -->
		</div><!-- /.blue-bg -->
		<footer>
			
				<div class="container">
						<a href="">Legal Notice</a> | <a href="">Security Policy</a>
						<div class="pull-right">
								Copyright &copy; Seafood Scotland <?php echo date("Y"); ?> | Design by 3fiftysix media
						</div>
				</div>
		</footer>
		<?php wp_footer(); ?>
</body>
</html>
