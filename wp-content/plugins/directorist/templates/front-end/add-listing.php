<?php
if (!empty($_REQUEST['listing_id'])) {
    $p_id = absint($_REQUEST['listing_id']);
    $listing  = get_post( $p_id ); //@TODO; ADD security to prevent user from editing other posts from front end and backend (except admin)
    // kick the user out if he tries to edit the listing of other user
    if ($listing->post_author != get_current_user_id()){
        echo '<p class="error">'.__('You do not have permission to edit this listing', ATBDP_TEXTDOMAIN).'</p>';
        return;
    }
    $lf= get_post_meta($p_id, '_listing_info', true);
    $listing_info = (!empty($lf))? aazztech_enc_unserialize($lf) : array();

    extract($listing_info);



//for editing page
    $p_types = wp_get_post_terms($p_id, ATBDP_TYPE);
    $p_locations = wp_get_post_terms($p_id, ATBDP_LOCATION);
    $p_cats = wp_get_post_terms($p_id, ATBDP_CATEGORY);
}
// prevent the error if it is not edit listing page when listing info var is not defined.
if (empty($listing_info )) {$listing_info = array();}

$t = get_the_title();
$t = !empty( $t ) ? esc_html($t) : __('No Title ', ATBDP_TEXTDOMAIN);
$tg = !empty( $tagline ) ? esc_html($tagline) : '';
$ad = !empty( $address ) ? esc_html($address) : '';
$image = (!empty($attachment_id[0])) ? "<img src='". esc_url(wp_get_attachment_image_url($attachment_id[0], 'thumbnail'))."'>": '';
/*build the markup for google map info window*/
$info_content = "<div class='map_info_window'> <h3> {$t} </h3>";
$info_content .= "<p> {$tg} </p>";
$info_content .= $image ; // add the image if available
$info_content .= "<p> {$ad}</p></div>";
// grab social information
$social_info = !empty( $social ) ? (array) $social : array();
$attachment_ids = !empty( $attachment_id ) ? (array) $attachment_id : array();

// get the category and location lists/array
$categories = get_terms(ATBDP_CATEGORY, array('hide_empty' => 0));
$locations = get_terms(ATBDP_LOCATION, array('hide_empty' => 0));
$types = get_terms(ATBDP_TYPE, array('hide_empty' => 0));

// see whats is coming through the post data.

?>

<section class="directory_wrapper single_area">
    <div class="<?php echo is_directoria_active() ? 'container': ' container-fluid'; ?>">
        <div class="add_listing_title">
            <h2><?= !empty($p_id) ? __('Update Listing', ATBDP_TEXTDOMAIN) : __('Add Listing', ATBDP_TEXTDOMAIN); ?></h2>
        </div>
        <form action="<?= esc_url($_SERVER['REQUEST_URI']); ?>" method="post">

        <!--add nonce field security -->
            <?php  ATBDP()->listing->add_listing->show_nonce_field(); ?>
            <input type="hidden" name="add_listing_form" value="1">
            <input type="hidden" name="listing_id" value="<?= !empty($p_id) ?  esc_attr($p_id) : ''?>">




        <div class="row">
            <div class="col-md-12">
                <div class="add_listing_form_wrapper">
                    <?php
                    /**
                     * It fires before the listing title
                     * @param string $type Page type.
                     * @since 1.1.1
                     **/
                    do_action('atbdp_edit_before_title_fields', 'add_listing_page_frontend');
                    ?>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <input type="text" name="listing_title" value="<?= !empty($listing->post_title) ? esc_attr($listing->post_title):'';?>" class="directory_field" placeholder="<?= __('Enter a title', ATBDP_TEXTDOMAIN); ?>"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <?php wp_editor(!empty($listing->post_content) ? wp_kses($listing->post_content, wp_kses_allowed_html('post')) :'', 'listing_content'); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <input type="text" name="listing[tagline]" value="<?= !empty($tagline) ? esc_attr($tagline): ''; ?>" class="directory_field" placeholder="<?= __('Organization motto or tag-line', ATBDP_TEXTDOMAIN); ?>"/>
                        </div>
                    </div>

                    <textarea name="listing[excerpt]" id="atbd_excerpt"  class="directory_field" cols="30" rows="10" placeholder="<?= __('Short Description/ Excerpt', ATBDP_TEXTDOMAIN); ?>"><?= !empty($excerpt) ?esc_html( $excerpt): ''; ?></textarea>



                    <!-- MAP or ADDRESS related information starts here -->
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" name="listing[address]" id="address" value="<?= !empty($address) ? $address: ''; ?>" class="directory_field" placeholder="<?= __('Listing address eg. Houghton Street London WC2A 2AE UK', ATBDP_TEXTDOMAIN); ?>"/>
                        </div>
                    </div> <!-- ends .row -->

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <!--@TODO; Refactor to a function later-->
                            <?php if (!empty($p_cats)) {
                                $output = [];
                                foreach ($p_cats as $p_cat) {
                                    $output[]= $p_cat->name;
                                }
                                echo '<p class="c_cat_list">'. __('Current category:', ATBDP_TEXTDOMAIN) .join(', ', $output) .'</p>';
                            } ?>
                            <select name="tax_input[at_biz_dir-category][]" class="directory_field" id="at_biz_dir-category" multiple="multiple">
                                <option value=""><?= __('Select a Category', ATBDP_TEXTDOMAIN); ?></option>
                                <?php
                                foreach ($categories as $category) {
                                    echo "<option id='atbdp_category' value='$category->term_id'>$category->name</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <?php if (!empty($p_locations)) {
                                $output = [];
                                foreach ($p_locations as $p_location) {
                                    $output[]= $p_location->name;
                                }
                                echo '<p class="c_cat_list">'. __('Current Location:', ATBDP_TEXTDOMAIN) .join(', ', $output) .'</p>';
                            } ?>
                            <select name="tax_input[at_biz_dir-location][]" class="directory_field" id="at_biz_dir-location" multiple="multiple">

                                <?php foreach ($locations as $location) {
                                        echo "<option id='atbdp_location' value='$location->term_id'>$location->name</option>";
                                    }
                                ?>
                            </select>
                        </div>


                        <div class="col-md-12 col-sm-12">
                            <?php if (!empty($p_tags)) {
                                $output = [];
                                foreach ($p_tags as $p_tag) {
                                    $output[]= $p_tag->name;
                                }
                                echo '<p class="c_cat_list">'. __('Current Tags:', ATBDP_TEXTDOMAIN) .join(', ', $output) .'</p>';
                            } ?>
                            <select name="tax_input[at_biz_dir-tags][]" class="directory_field" id="at_biz_dir-tags" multiple="multiple" >

                                <?php foreach ($listing_tags as $l_tag) { ?>
                                    <option id='atbdp_tag' value='<?= $l_tag->name ?>'><?= esc_html($l_tag->name); ?></option>;
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <input type="tel" name="listing[phone][]" value="<?= !empty($phone[0]) ? esc_attr($phone[0]): ''; ?>" class="directory_field" placeholder="Phone Number"/>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <input type="email" name="listing[email]" value="<?= !empty( $email ) ? esc_attr($email) : ''; ?>" class="directory_field" placeholder="Enter Email"/>
                        </div>
                    </div> <!--ends .row-->

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <input type="text" name="listing[website]" value="<?= !empty( $website ) ? esc_url($website) : ''; ?>" class="directory_field" placeholder="Listing website eg. http://example.com"/>
                        </div>
                    </div> <!--ends .row-->
                    <!--Social Information-->

                    <!-- add social icon adding field-->
                    <?php
                    /**
                     * It fires before social information fields
                     * @param string $type Page type.
                     * @param array $listing_info Information of the current listing
                     * @since 1.1.1
                     **/
                    do_action('atbdp_edit_before_social_info_fields', 'add_listing_page_frontend', $listing_info);


                    ATBDP()->load_template('meta-partials/social', array('social_info' => $social_info));

                    /**
                     * It fires after social information fields
                     * @param string $type Page type.
                     * @param array $listing_info Information of the current listing
                     * @since 1.1.1
                     **/
                    do_action('atbdp_edit_after_social_info_fields', 'add_listing_page_frontend', $listing_info);

                    ?>




                    <div class="row">
                        <div class="col-md-12">
                            <div class="cor-wrap">
                                <input type="checkbox" name="listing[manual_coordinate]" value="1" id="manual_coordinate"  >
                                <label for="manual_coordinate"> <?php _e('Enter Coordinates ( latitude and longitude) Manually ? or set the marker on the map anywhere by clicking on the map', ATBDP_TEXTDOMAIN); ?> </label>
                            </div>
                        </div>
                        <div id="hide_if_no_manual_cor">

                            <div class="col-md-6 col-sm-12">
                                <label for="manual_lat"> <?php _e('Latitude', ATBDP_TEXTDOMAIN); ?>  </label>
                                <input type="text" name="listing[manual_lat]" id="manual_lat" value="<?= !empty( $manual_lat ) ? esc_attr($manual_lat) : ''; ?>" class="directory_field" placeholder="Enter Latitude eg. 24.89904"/>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label for="manual_lng"> <?php _e('Longitude', ATBDP_TEXTDOMAIN); ?> </label>
                                <input type="text" name="listing[manual_lng]" id="manual_lng" value="<?= !empty( $manual_lng ) ? esc_attr($manual_lng) : ''; ?>" class="directory_field" placeholder="Enter Longitude eg. 91.87198"/>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="lat_btn_wrap">
                                    <button class="btn btn-default" id="generate_admin_map"><?php _e('Generate on Map', ATBDP_TEXTDOMAIN); ?></button>
                                </div>
                            </div> <!-- ends #hide_if_no_manual_cor-->


                        </div> <!--ends .row -->
                    </div> <!--ends .row-->


                    <!--Google map will be generated here using js-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="map_wrapper">
                                <div id="floating-panel">
                                    <button class="btn btn-danger" id="delete_marker"> <?php _e('Delete Marker', ATBDP_TEXTDOMAIN); ?></button>
                                </div>

                                <div id="gmap"></div>
                            </div>
                        </div> <!--ends .col-md-12-->
                    </div><!--ends .row-->
                    <?php
                    /**
                     * It fires after the google map preview area
                     * @param string $type Page type.
                     * @param array $listing_info Information of the current listing
                     * @since 1.1.1
                     **/
                    do_action('atbdp_edit_after_googlemap_preview', 'add_listing_page_frontend', $listing_info);
                    ?>


                    <!--Image Uploader-->
                    <div id="_listing_gallery">
                        <?php  ATBDP()->load_template('media-upload', array('attachment_ids'=> $attachment_ids)); ?>

                    </div>
                    <div class="btn_wrap list_submit">
                        <button type="submit" class="listing_submit_btn btn-lg"><?= !empty($p_id) ? __( 'Update Listing', ATBDP_TEXTDOMAIN) : __( 'Submit listing', ATBDP_TEXTDOMAIN); ?></button>
                    </div>

                    <div class="clearfix"></div>

                </div><!--ends .add_listing_form_wrapper-->

            </div> <!--ends col-md-12 -->
        </div><!--ends .row-->
        </form>
    </div> <!--ends container-fluid-->
</section>
<script>

    // Bias the auto complete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.

    jQuery(document).ready(function ($) {
        // initialize all vars here to avoid hoisting related misunderstanding.
        var placeSearch, map, autocomplete, address_input, markers, info_window, $manual_lat, $manual_lng, saved_lat_lng, info_content;
        $manual_lat = $('#manual_lat');
        $manual_lng = $('#manual_lng');
        saved_lat_lng = {lat:<?= (!empty($manual_lat)) ? floatval($manual_lat) : '51.5073509' ?>, lng: <?= (!empty($manual_lng)) ? floatval($manual_lng) : '-0.12775829999998223' ?> }; // default is London city
        info_content = "<?= $info_content; ?>";
        markers = [];// initialize the array to keep track all the marker
        info_window = new google.maps.InfoWindow({
            content: info_content,
            maxWidth: 400
        });



        address_input = document.getElementById('address');
        address_input.addEventListener('focus', geolocate);
        // this function will work on sites that uses SSL, it applies to Chrome especially, other broweser may allow location sharing without securing.
        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }


        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                (address_input),
                {types: ['geocode']});

            // When the user selects an address from the dropdown, populate the necessary input fields and draw a marker
            autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();

            //console.dir(place);
            /*console.log('place has changed and now we are ready to rock on');
            console.log(place);*/
            // set the value of input field to save them to the database
            $manual_lat.val( place.geometry.location.lat() );
            $manual_lng.val( place.geometry.location.lng() );
            map.setCenter( place.geometry.location );
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location
            });

            marker.addListener('click', function() {
                info_window.open(map, marker);
            });

            // add the marker to the markers array to keep track of it, so that we can show/hide/delete them all later.
            markers.push(marker);
        }

        initAutocomplete(); // start google map place auto complete API call






        function initMap() {
            /* Create new map instance*/
            map = new google.maps.Map( document.getElementById( 'gmap' ), {
                zoom: 16,
                center: saved_lat_lng
            });
            var marker = new google.maps.Marker({
                map: map,
                position:  saved_lat_lng
            });
            marker.addListener('click', function() {
                info_window.open(map, marker);
            });
            // add the marker to the markers array to keep track of it, so that we can show/hide/delete them all later.
            markers.push(marker);

            // create a Geocode instance
            var geocoder = new google.maps.Geocoder();

                document.getElementById( 'generate_admin_map' ).addEventListener( 'click', function(e) {
                e.preventDefault();
                geocodeAddress( geocoder, map );
            });


            // This event listener calls addMarker() when the map is clicked.
            google.maps.event.addListener(map, 'click', function(event) {
                deleteMarker(); // at first remove previous marker and then set new marker;
                // set the value of input field to save them to the database
                $manual_lat.val(event.latLng.lat());
                $manual_lng.val(event.latLng.lng());
                // add the marker to the given map.
                addMarker(event.latLng, map);
            });
        }

        /*
         * Geocode and address using google map javascript api and then populate the input fields for storing lat and long
         * */

        function geocodeAddress(geocoder, resultsMap) {
            var address = address_input.value;
            geocoder.geocode({'address': address}, function(results, status) {
                //console.dir(results);
                if (status === 'OK') {
                    // set the value of input field to save them to the database
                    $manual_lat.val(results[0].geometry.location.lat());
                    $manual_lng.val(results[0].geometry.location.lng());
                    resultsMap.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: resultsMap,
                        position: results[0].geometry.location
                    });

                    marker.addListener('click', function() {
                        info_window.open(map, marker);
                    });

                    // add the marker to the markers array to keep track of it, so that we can show/hide/delete them all later.
                    markers.push(marker);
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }

        initMap();





        // adding features of creating marker manually on the map on add listing page.
        /*var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
         var labelIndex = 0;*/


        // Adds a marker to the map.
        function addMarker(location, map) {
            // Add the marker at the clicked location, and add the next-available label
            // from the array of alphabetical characters.
            var marker = new google.maps.Marker({
                position: location,
                /*label: labels[labelIndex++ % labels.length],*/
                map: map
            });
            marker.addListener('click', function() {
                info_window.open(map, marker);
            });
            // add the marker to the markers array to keep track of it, so that we can show/hide/delete them all later.
            markers.push(marker);
        }

        // Delete Marker
        $('#delete_marker').on('click', function (e) {
            e.preventDefault();
            deleteMarker();

        });

        function deleteMarker() {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        }



    }); // ends jquery ready function.

</script>
