<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Directorist
 */

if ( ! is_active_sidebar( 'right-sidebar-listing' ) ) {
	return;
}
?>
<!-- start col-md-4  -->
<div class="col-md-4">
    <div class="sidebar_m">
        <!-- start search -->
        <?php dynamic_sidebar('right-sidebar-listing'); ?>
    </div>
</div>
<!-- end col-md-4  -->
