<?php 
add_action( 'rest_api_init', 'aub_register_route' );
function aub_register_route() {
    register_rest_route( 'aub-config', 'front-page', array(
                    'methods' => 'GET',
                    'callback' => 'aub_get_front_page',
                )
            );
}
function aub_get_front_page() {

    return rest_ensure_response( get_field('front_page', 'option') );
}
