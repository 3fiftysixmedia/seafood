<?php
if (!empty($args['listing_info'])) { extract($args['listing_info']); }


//@TODO: I will have to add a text area to get the content for the info window of the map later
$t = get_the_title();
$t = !empty($t)? $t : __('No Title', ATBDP_TEXTDOMAIN);
$tg = !empty($tagline)? esc_html($tagline) : '';
$ad = !empty($address)? esc_html($address) : '';
$image = (!empty($attachment_id[0])) ? "<img src='". esc_url(wp_get_attachment_image_url($attachment_id[0], 'thumbnail'))."'>": '';
$info_content = "<div class='map_info_window'> <h3>{$t}</h3>";
$info_content .= "<p> {$tg}</p>";
$info_content .= $image ; // add the image if available
$info_content .= "<p> {$ad}</p></div>";

// grab social information
$social_info = !empty( $social ) ? $social : array();



?>
<section class="directory_wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="add_listing_form_wrapper">
                    <?php
                    /**
                     * It fires before the listing tagline
                     * @param string $type Page type.
                     * @since 1.1.1
                     **/
                    do_action('atbdp_edit_before_tagline_fields', 'add_listing_page_backend');
                    ?>

                    <div class="row" style="margin-top:20px">
                      <label>Accreditations</label>
                      <br/>

                      <textarea style="width:50%" name="listing[excerpt]" id="atbd_excerpt"  class="directory_field" cols="30" rows="10" placeholder="Accreditations"><?= (!empty($excerpt)) ? esc_textarea(stripslashes($excerpt)) : '' ?></textarea>
                      </div>
                      <div class="row" style="margin-top:20px">
                        <label>Phone Number</label>
                        <br/>
                            <input style="width:50%" type="tel" name="listing[phone][]" value="<?= (!empty($phone[0])) ? esc_attr($phone[0]) : '' ?>" class="directory_field" placeholder="Phone Number"/>
                      </div>
                      <div class="row" style="margin-top:20px">
                        <label>Email address</label>
                        <br/>
                            <input style="width:50%" type="email" name="listing[email]" value="<?= (!empty($email)) ? esc_attr($email) : '' ?>" class="directory_field" placeholder="Enter Email"/>
                          </div>
                          <div class="row" style="margin-top:20px">
                            <label>Web address</label>
                            <br/>
                            <input style="width:50%" type="text" name="listing[website]" value="<?= (!empty($website)) ? esc_attr($website) : '' ?>" class="directory_field" placeholder="Listing website eg. http://example.com"/>
                          </div>
                </div><!--ends add_listing_form_wrapper-->

            </div> <!--ends col-md-12 -->
        </div><!--ends .row-->
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
            //console.log('place has changed and now we are ready to rock on');
            //console.log(place);
            // set the value of input field to save them to the database
            $manual_lat.val(place.geometry.location.lat());
            $manual_lng.val(place.geometry.location.lng());
            map.setCenter(place.geometry.location);
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
                map = new google.maps.Map(document.getElementById('gmap'), {
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

            document.getElementById('generate_admin_map').addEventListener('click', function(e) {
                e.preventDefault();
                geocodeAddress(geocoder, map);
            });


            // This event listener calls addMarker() when the map is clicked.
            google.maps.event.addListener(map, 'click', function(event) {
                // at first delete the old marker if there is any and then add new marker
                deleteMarker();
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
            deleteMarker();// delete all markers

        });
        /**
         * It deletes all the map markers
         * */
        function deleteMarker() {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        }



    }); // ends jquery ready function.







</script>
