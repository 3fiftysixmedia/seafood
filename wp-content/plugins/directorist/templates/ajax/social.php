<?php
$id = (array_key_exists('id', $args)) ? $args['id'] : array();
$ATBDP = ATBDP();
?>


<div class="row atbdp_social_field_wrapper" id="socialID-<?= $id; ?>">
    <div class="col-md-3 col-sm-12">
        <select name="listing[social][<?= $id; ?>][id]" class="directory_field">
            <?php foreach ( $ATBDP->helper->social_links() as $nameID => $socialName ) { ?>
                <option value='<?= esc_attr($nameID); ?>'> <?= esc_html($socialName); ?></option>;
            <?php } ?>
        </select>
    </div>
    <div class="col-md-6 col-sm-12">
        <input type="url" name="listing[social][<?= $id; ?>][url]" class="directory_field atbdp_social_input" value="" placeholder="eg. http://example.com" required>
    </div>
    <div class="col-md-3 col-sm-12">
        <span data-id="<?= $id; ?>" class="removeSocialField dashicons dashicons-trash" title="Remove this item"></span>
        <span class="adl-move-icon dashicons dashicons-move"></span>
    </div>
</div>
