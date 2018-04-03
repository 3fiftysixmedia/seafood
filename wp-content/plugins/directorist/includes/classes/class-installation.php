<?php
/**
 * Install Function
 *
 * @package     Directorist
 * @copyright   Copyright (c) 2017, AazzTech
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if (!class_exists('ATBDP_Installation')):
    class ATBDP_Installation {

        public static function install()
        {
            include  ATBDP_INC_DIR.'review-rating/class-review-rating-database.php';
            $Review_DB = new ATBDP_Review_Rating_DB();
            $Review_DB->create_table();
        }


}

endif;
