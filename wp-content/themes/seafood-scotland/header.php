<!DOCTYPE html>
<html>
    <head>
        <?php wp_head(); ?>

          <?php
                  if(is_page(8)):              
                  ?>

                   <style type="text/css">

                   .bg-box .content.darkblue h2 {
  margin: 0 0 -6px;
  padding-top: 9px;
}

                    
                  </style>

                  <?php endif; ?>

                 
    </head>
    <body>

      <nav class="navbar navbar-default">
          <div class="container">

                  <?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'menu_class'=> 'nav navbar-nav',  ) ); ?>

          </div>
      </nav>
        <div class="container">
            <div class="row contact-header">
                <div class="  pull-right">
                    <img src="/wp-content/themes/seafood-scotland/img/phone-icon.png"> <h3 class="number">+44 (0)131 557 9344</h3>
                    <img src="/wp-content/themes/seafood-scotland/img/mail-icon.png"><a href="mailto:enquiries@seafoodscotland.org" target="_top"> enquiries@seafoodscotland.org</a>
                </div>
            </div>
        </div>
<!-- end header -->
