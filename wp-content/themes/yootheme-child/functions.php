<?php

add_action('wp_enqueue_scripts', function (){
    wp_enqueue_style('slider-style', get_stylesheet_directory_uri().'/assets/css/jquery-ui.min.css');
    wp_enqueue_style('ccpicker-style', get_stylesheet_directory_uri().'/assets/css/jquery.ccpicker.css');
    wp_enqueue_style('child_style', get_stylesheet_directory_uri().'/style.css', [],15);

    wp_enqueue_script( 'jquery-3', get_stylesheet_directory_uri().'/assets/js/jquery-3.6.0.min.js', [], false, true );
	wp_enqueue_script('ccpicker', get_stylesheet_directory_uri().'/assets/js/jquery.ccpicker.min.js', ['jquery-3']);
    wp_enqueue_script('google_maps', get_stylesheet_directory_uri().'/assets/js/map.js', ['jquery-3']);
    wp_enqueue_script('slider', get_stylesheet_directory_uri().'/assets/js/jquery-ui.min.js', ['jquery-3']);
    wp_enqueue_script( 'google-places', 'https://maps.googleapis.com/maps/api/js?key=' . get_field( 'google_api_key', 'option' ) . '&callback=initGMap&libraries=places&v=weekly', [], false, true );
    wp_enqueue_script( 'main', get_stylesheet_directory_uri().'/assets/js/main.js', [], time(), true );
    wp_localize_script( 'main', 'wp_ajax',
        array(
            'url' => admin_url('admin-ajax.php')
        )
    );
    },99);

add_action('init', function (){

    if( function_exists('acf_add_options_page') ) {

        acf_add_options_page([
            'page_title' 	=> 'Theme General Settings',
            'menu_title'	=> 'Theme Settings',
            'menu_slug' 	=> 'theme-general-settings',
            'capability'	=> 'edit_posts',
            'redirect'		=> false
        ]);

    }
});

function curl_fetch_data($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result);
}
function google_geocoding(){
    $request = filter_input(INPUT_POST,'request');
    $formattedAddr = str_replace(' ', '+', $request);
    //Send request and receive json data by address
    $map_key = get_field('google_api_key','option');
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$map_key.'&address=' . $formattedAddr . '&sensor=false';
    $output = curl_fetch_data($url);

    //Get latitude and longitute from json data
    $data['latitude'] = $output->results[0]->geometry->location->lat;
    $data['longitude'] = $output->results[0]->geometry->location->lng;
    //Return latitude and longitude of the given address
    if (!empty($data)) {
        exit(json_encode($data));
    } else {
        exit(false);
    }
}
add_action('wp_ajax_google_geocoding', 'google_geocoding');
add_action('wp_ajax_nopriv_google_geocoding', 'google_geocoding');

function google_get_static_map_img_url ($coordinates, $marker, $zoom, $size, $map_type){

    $map_key = get_field('google_api_key','option');
    $url = 'https://maps.googleapis.com/maps/api/staticmap?key='.$map_key.'&center=' . $coordinates . '&zoom='.$zoom.'&size='.$size.'&maptype='.$map_type.'&markers='.$marker;
    return $url;
}

add_action('init', function (){
    register_post_type('solar_order', [
        'labels' => [
            'name' => 'Solar Orders',
            'singular_name' => 'Solar Order',
            'add_new' => 'Add order',
            'add_new_item' => 'Add New order',
            'edit_item' => 'Edit order',
            'new_item' => 'New order',
            'all_items' => 'Solar Orders',
            'view_item' => 'View order',
            'search_items' => 'Find order',
            'not_found' => 'Orders not found.',
            'not_found_in_trash' => 'There are any orders in trash.',
            'menu_name' => 'Solar Orders'
        ],
        'public' => true,
        'menu_icon' => 'dashicons-text-page',
        'has_archive' => false,
        'supports' => array(
            'title',
        ),
    ]);
});

function acf_google_map_api( $api ){
    $map_key = get_field('google_api_key','option');
    $api['key'] = $map_key;

    return $api;
}

add_filter('acf/fields/google_map/api', 'acf_google_map_api');

function async_create_solar_order(){
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$address = $_POST['address'];
$name = $_POST['name'];
$phone = $_POST['phoneField'];
$phone_code = $_POST['phoneField_phoneCode'];
$email = $_POST['email'];
$message = $_POST['message'];

$coordinates = implode(',', [$latitude, $longitude]);
$img_url = google_get_static_map_img_url($coordinates, $coordinates,19,"640x640","satellite");

    $solar_order = wp_insert_post([
        "post_title" => "Order #",
        'post_status' => 'publish',
        'post_type' => 'solar_order',
    ]);
    wp_update_post(wp_slash([
        'ID' => $solar_order,
        'post_title' => "Order #" . $solar_order,
    ]));

    if (function_exists('update_field')) {
        update_field('latitude', $latitude, $solar_order);
        update_field('longitude', $longitude, $solar_order);
        update_field('address', $address, $solar_order);
        update_field('full_name', $name, $solar_order);
        update_field('phone', '+'.$phone_code.$phone, $solar_order);
        update_field('email', $email, $solar_order);
        update_field('map', [
            'address' => $address,
            'lat' => $latitude,
            'lng' => $longitude,
            'zoom' => 19,
        ],$solar_order);
    }

    /** Add snapshot **/
    $imageurl = $img_url;
    $img_type = explode('/', getimagesize($imageurl)['mime']);
    $imagetype = end($img_type);
    $uniq_name = date('dmY') . '' . (int)microtime(true) . $solar_order;
    $filename = $uniq_name . '.' . $imagetype;

    $uploaddir = wp_upload_dir();
    $uploadfile = $uploaddir['path'] . '/' . $filename;
    $contents = file_get_contents($imageurl);
    $savefile = fopen($uploadfile, 'w');
    fwrite($savefile, $contents);
    fclose($savefile);

    $wp_filetype = wp_check_filetype(basename($filename), null);
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => $filename,
        'post_content' => '',
        'post_status' => 'inherit'
    );

    $attach_id = wp_insert_attachment($attachment, $uploadfile);
    $imagenew = get_post($attach_id);
    $fullsizepath = get_attached_file($imagenew->ID);
    $attach_data = wp_generate_attachment_metadata($attach_id, $fullsizepath);
    wp_update_attachment_metadata($attach_id, $attach_data);

    update_field('snapshot', $attach_id, $solar_order);

    $admin_email = get_field('admin_email','option');
    $map_snapshot = get_field('snapshot', $solar_order);
    $message = "
    <span>Address: $address</span><br/>
    <span>Latitude: $latitude</span><br/>
    <span>Longitude: $longitude</span><br/>
    <span>Name: $name</span><br/>
    <span>Phone: +".$phone_code.$phone."</span><br/>
    <span>Email: $email</span><br/>
    <span>Message: $message</span><br/>
    <img src='".$map_snapshot."'>";
    wp_mail($admin_email,'New Solar Order', $message, ['content-type: text/html']);
    wp_mail($email,'New Solar Order', $message, ['content-type: text/html']);

exit(json_encode([
    'latitude' => $latitude,
    'longitude' => $longitude,
    'address' => $address,
    'coordinates' => $coordinates,
    'img_url' => $img_url
]));
}

add_action('wp_ajax_solar_order', 'async_create_solar_order');
add_action('wp_ajax_nopriv_solar_order', 'async_create_solar_order');
