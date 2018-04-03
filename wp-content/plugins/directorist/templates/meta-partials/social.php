<?php
/*
 * Template for showing Social Meta Info on Add listing page
 */
$social_info = (array_key_exists('social_info', $args)) ? $args['social_info'] : array();
$ATBDP = ATBDP();
?>


        <div id="social_info_sortable_container">
            <?php
            if ( !empty($social_info) ) {
                foreach ($social_info as $index => $socialInfo) { // eg. here, $socialInfo = ['id'=> 'facebook', 'url'=> 'http://fb.com']
                    ?>
                    <div class="row  atbdp_social_field_wrapper" id="socialID-<?= $index; ?>">
                        <!--Social ID-->
                        <div class="col-md-3 col-sm-12">
                            <select name="listing[social][<?= $index; ?>][id]">
                                <?php foreach ($ATBDP->helper->social_links() as $nameID => $socialName) { ?>
                                    <option value='<?= esc_attr($nameID); ?>' <?php selected($nameID, $socialInfo['id']); ?> > <?= esc_html($socialName); ?></option>;
                                <?php } ?>
                            </select>
                        </div>
                        <!--Social URL-->
                        <div class="col-md-6 col-sm-12">
                            <input type="url" name="listing[social][<?= $index; ?>][url]"
                                   class="directory_field atbdp_social_input"
                                   value="<?= esc_url($socialInfo['url']); ?>" placeholder="eg. http://example.com">

                        </div>
                        <div class="col-md-3 col-md-12">
                            <span data-id="<?= $index; ?>" class="removeSocialField dashicons dashicons-trash"
                                  title="Remove this item"></span> <span class="adl-move-icon dashicons dashicons-move"></span>
                        </div>
                    </div> <!--   ends .row   &  .atbdp_social_field_wrapper-->

                    <?php
                }

            } else {
                ?>
                <div class="row  atbdp_social_field_wrapper" id="socialID-0">
                    <div class="col-md-3 col-sm-12">
                        <select name="listing[social][0][id]" class="directory_field">
                            <?php foreach ($ATBDP->helper->social_links() as $nameID => $socialName) { ?>
                                <option value='<?= esc_attr($nameID); ?>'> <?= esc_html($socialName); ?></option>;
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <input type="url" name="listing[social][0][url]" class="directory_field atbdp_social_input"
                               value="" placeholder="eg. http://example.com" required="">
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <span data-id="0" class="removeSocialField dashicons dashicons-trash"
                              title="Remove this item"></span>
                        <span class="adl-move-icon dashicons dashicons-move"></span>
                    </div>
                </div> <!--ends .row and .atbdp_social_field_wrapper-->
                <?php
            }
            ?>
        </div> <!--    ends .social_info_sortable_container    -->
<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-default" id="addNewSocial"> <span class="plus-sign">+</span>Social Link</button>
    </div>
</div>


