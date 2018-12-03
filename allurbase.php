
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
function my_rest_prepare_post($data, $post, $request) {
	$_data = $data->data;
  $fields = get_fields($post->ID);
  if($fields){
    foreach ($fields as $key => $value){
      $_data[$key] = get_field($key, $post->ID);
    }
    $data->data = $_data;
  }


	return $data;
  }
  add_filter("rest_prepare_release", 'my_rest_prepare_post', 10, 3);
  add_filter("rest_prepare_studio", 'my_rest_prepare_post', 10, 3);
  add_filter("rest_prepare_series", 'my_rest_prepare_post', 10, 3);
  add_filter("rest_prepare_author", 'my_rest_prepare_post', 10, 3);

// add an ACF options page for the plugin
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page();
	
}


?>
