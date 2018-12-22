<?php 
/*****
 * HELPERS 
 */

 /**
  * @param WP_Query $query
  * @param WP_REST_Response $response
  */
 function aub_pagination_headers($query, $response){
    $max_pages = $query->max_num_pages;
    $total = $query->found_posts;
    $response->header( 'X-WP-Total', $total ); 
    $response->header( 'X-WP-TotalPages', $max_pages );
    return $response;
 }

/**
* @param WP_REST_Request $request
* @param String  $post_type
*  
*/
 function aub_all_posts_with_type($post_type, $request){
    $posts_per_page = $request['per_page'];
    $page = $request['page'];
    $orderby = $request['orderby'];
    $order = $request['order'];
    $args = array(
        'post_type'         => $post_type,
        'posts_per_page'    => $posts_per_page,
        'paged'             => $page,
        'orderby'           => $orderby,
        'order'             => $order,
    );

    $query = new WP_Query( $args ); 
    $posts = $query->posts;
    if( empty($query->posts) ){
        return array(
            'error' => new WP_Error( 'no_posts', __('No post found'), array( 'status' => 404 ) ),
            'query' => $query
        );
         
    }

    $controller = new WP_REST_Posts_Controller($post_type);

    foreach ( $posts as $post ) {
        $response = $controller->prepare_item_for_response( $post, $request );
        $data[] = $controller->prepare_response_for_collection( $response );  
    }
   
    $response = new WP_REST_Response($data, 200);
    $response = aub_pagination_headers($query, $response);
   // $response->data['request'] = $request['badger'];
    return $response;
 }

 /**
  * @param String  $post_type
  * @param Int $id  
  */
 function aub_post_with_id($post_type, $id){
    $args = array(
        'post_type'         => $post_type,
        'p'                 => $id
    );
    $query = new WP_Query( $args ); 
    $posts = $query->posts;
    if( empty($query->posts) ){
        return array(
            'error' => new WP_Error( 'no_posts', __('No post found'), array( 'status' => 404 ) ),
            'query' => $query
        );
         
    }

    $controller = new WP_REST_Posts_Controller('release');

    foreach ( $posts as $post ) {
        $response = $controller->prepare_item_for_response( $post, $request );
        $data[] = $controller->prepare_response_for_collection( $response );  
    }
   
    $response = new WP_REST_Response($data, 200);
    $response = aub_pagination_headers($query, $response);
    return $response;
 }

 /**
  * ROUTES & CALLBACKS
  */
add_action( 'rest_api_init', 'aub_register_route' );

/* config */
function aub_register_route() {
    register_rest_route( 
        'aub/v1/', 
        'config', 
        array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'aub_config',
        )
    );
    /* all releases */
    register_rest_route( 
        'aub/v1/', 
        'releases', 
        array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'aub_all_releases',
            'args' => array(
                'per_page' => array (
                    'default' => 10
                ),
                'page' => array (
                    'default' => 1
                ),
                'orderby' => array(
                    'default' => 'title'
                ),
                'order' => array(
                    'default' => 'asc'
                )
            )
        )
    );
    /* release with id */
    register_rest_route( 
        'aub/v1/', 
        'releases/(?P<id>\d+)', 
        array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'aub_release_with_id',
            'args' => array(
                'id' => array (
                    'validate_callback' => function($param, $request, $key){
                        return is_numeric($param);
                    }
                )
            )
        )
    );
    /* all authors */
    register_rest_route( 
        'aub/v1/', 
        'authors', 
        array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'aub_all_authors',
            'args' => array(
                'per_page' => array (
                    'default' => 10
                ),
                'page' => array (
                    'default' => 1
                ),
                'orderby' => array(
                    'default' => 'title'
                ),
                'order' => array(
                    'default' => 'asc'
                )
            )
        )
    );
    /* author with id */
    register_rest_route( 
        'aub/v1/', 
        'authors/(?P<id>\d+)', 
        array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'aub_author_with_id',
            'args' => array(
                'id' => array (
                    'validate_callback' => function($param, $request, $key){
                        return is_numeric($param);
                    }
                )
            )
        )
    );
    /* all series*/
    register_rest_route( 
        'aub/v1/', 
        'series', 
        array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'aub_all_series',
            'args' => array(
                'per_page' => array (
                    'default' => 10
                ),
                'page' => array (
                    'default' => 1
                ),
                'orderby' => array(
                    'default' => 'title'
                ),
                'order' => array(
                    'default' => 'asc'
                )
            )
        )
    );
    /* series with id */
    register_rest_route( 
        'aub/v1/', 
        'series/(?P<id>\d+)', 
        array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'aub_series_with_id',
            'args' => array(
                'id' => array (
                    'validate_callback' => function($param, $request, $key){
                        return is_numeric($param);
                    }
                )
            )
        )
    );
}
function aub_config() {
    $intros = get_field('archive_page_static_content', 'option');
    $config= array(
        'front_page' => get_field('front_page', 'option'),
        'archives' => array(
            'releases' => array(
                'intro' => array_filter($intros, function($item){
                    return strtolower( $item['label'] ) === 'releases';
                }),
            ),
            'authors' => array(
                'intro' => array_filter($intros, function($item){
                    return strtolower( $item['label'] ) === 'authors';
                }),
            ),
            'series' => array(
                'intro' => array_filter($intros, function($item){
                    return strtolower( $item['label'] ) === 'series';
                }),
            ),
        ),
    );
    return rest_ensure_response( $config );
}
function aub_all_authors(WP_REST_Request $request){
    $response = aub_all_posts_with_type('author', $request);
    return rest_ensure_response($response);
}
function aub_author_with_id(WP_REST_Request $request){
    $response = aub_post_with_id('author', $request['id']);
    return rest_ensure_response($response);
 }
function aub_all_series(WP_REST_Request $request){
    $response = aub_all_posts_with_type('series', $request);
    return rest_ensure_response($response);
}
function aub_series_with_id(WP_REST_Request $request){
    $response = aub_post_with_id('series', $request['id']);
    return rest_ensure_response($response);
 }
function aub_all_releases(WP_REST_Request $request){
    $response = aub_all_posts_with_type('release', $request);
    return rest_ensure_response($response);
}
function aub_release_with_id(WP_REST_Request $request){
   $response = aub_post_with_id('release', $request['id']);
   return rest_ensure_response($response);
}
