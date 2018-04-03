<?php

add_filter( 'login_redirect', 'atbdp_send_subscribers_to_dashboard', 10, 3 );

/**
 * If a user trying to login is a subscriber, send him to his dashboard on the front end.
 * @param $redirect_to
 * @param $requested_redirect_to
 * @param $user
 * @return string
 */
function atbdp_send_subscribers_to_dashboard($redirect_to, $requested_redirect_to, $user ) {
    global $user;
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        if ( in_array( 'subscriber', $user->roles ) ) {
            return atbdp_get_user_dashboard_url(); // redirect user
        } else {
            return $redirect_to;
        }
    }
    return $redirect_to;
}