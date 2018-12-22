
<?php
/*
Plugin Name: AllUrBase
*/

include('includes/author.php');
include('includes/release.php');
include('includes/studio.php');
include('includes/series.php');
include('includes/custom-rest.php');

// Using ACF to manage custome meta fields
add_filter('acf/settings/save_json', function() {
    return dirname(__FILE__) . '/acf';
});
 
add_filter('acf/settings/load_json', function($paths) {
    $paths[] = dirname(__FILE__) . '/acf';
    return $paths;
});

// make ACF metadata appear in the cpts
function aub_add_acf_meta_to_post($data, $post, $request){
  //error_log(print_r($post), true);
  $_data = $data->data;
  $fields = get_fields($post->ID);
  if($fields){
    $_data['meta'] = array();
    foreach ($fields as $key => $value){
      $field = get_field_object($key);
      $_data['meta'][$key] = array(
        'label' => $field['label'],
        'value' => get_field($key, $post->ID)
      ) ;
    }
    $data->data = $_data;
  }
	return $data;
}

/**
 * strip the returned object right back to just what we need.
 */
function aub_rest_prepare_release($data, $post, $request){
  $_data = [];
  $_data['id'] = $post->ID;
  $_data['title'] = $post->post_title;
  $_data['description'] = $post->post_content;
  //...add more as needed

  $data->data = $_data;

  $data = aub_add_acf_meta_to_post($data, $post, $request);

  return $data;
}
function aub_rest_prepare_author($data, $post, $request){
  $_data = [];
  $_data['id'] = $post->ID;
  $_data['title'] = $post->post_title;
  $_data['description'] = $post->post_content;
  //...add more as needed

  $data->data = $_data;

  $data = aub_add_acf_meta_to_post($data, $post, $request);

  return $data;
}
function aub_rest_prepare_studio($data, $post, $request){
  $_data = [];
  $_data['id'] = $post->ID;
  $_data['title'] = $post->post_title;
  $_data['description'] = $post->post_content;
  //...add more as needed

  $data->data = $_data;

  $data = aub_add_acf_meta_to_post($data, $post, $request);

  return $data;
}
function aub_rest_prepare_series($data, $post, $request){
  $_data = [];
  $_data['id'] = $post->ID;
  $_data['title'] = $post->post_title;
  $_data['description'] = $post->post_content;
  //...add more as needed

  $data->data = $_data;

  $data = aub_add_acf_meta_to_post($data, $post, $request);

  return $data;
}

add_filter("rest_prepare_release", 'aub_rest_prepare_release', 10, 3);
add_filter("rest_prepare_author", 'aub_rest_prepare_release', 10, 3);
add_filter("rest_prepare_studio", 'aub_rest_prepare_studio', 10, 3);
add_filter("rest_prepare_series", 'aub_rest_prepare_series', 10, 3);


// add an ACF options page for the plugin
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page();
	
}


?>
