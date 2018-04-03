<?php /* Template Name: Info Page */ ?>

<?php get_header(); ?>

    <div class="bg-box" style="background-image:url('<?php echo get_field('main_bg')['url']; ?>')">
        <?php echo get_field('main_content'); ?>
    </div>

    <div id="latest-block" class="row boxes">
        <div class="col-sm-4 box">
            <h3 class="news"><img src="/wp-content/themes/seafood-scotland/img/latest-news-icon.png">Latest News</h3>
            <table class="table">
                <?php
                $args = array( 'numberposts' => '5' );
                $recent_posts = wp_get_recent_posts( $args );
                foreach( $recent_posts as $recent ):
                ?>
                    <tr>
                        <td><?php echo date('d.m.Y', strtotime($recent['post_date'])); ?></td>
                        <td><a href="<?php echo $recent['guid']; ?>"><?php echo wp_trim_words( $recent['post_content'], $num_words = 12, $more = null ); ?></a></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>

        <div class="col-sm-4 box">
            <h3 class="events"><img src="/wp-content/themes/seafood-scotland/img/latest-events-icon.png">Latest Events</h3>
            <table class="table">
                <tr>
                    <td>01.01.2017</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit</td>
                </tr>
                <tr>
                    <td>01.01.2017</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit</td>
                </tr>
                <tr>
                    <td>01.01.2017</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit</td>
                </tr>
                <tr>
                    <td>01.01.2017</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit</td>
                </tr>
            </table>
        </div>

        <div class="col-sm-4 box">
            <h3 class="support"><img src="/wp-content/themes/seafood-scotland/img/support-icon.png">Support Available</h3>
            <?php echo get_field('support_available_content'); ?>
        </div>
    </div><!-- /.row -->

<?php get_footer(); ?>
