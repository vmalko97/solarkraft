<?php

add_action('wp_enqueue_scripts', function (){
    wp_enqueue_style('child_style', get_stylesheet_directory_uri().'/style.css');

    wp_enqueue_script('google_maps', get_stylesheet_directory_uri().'/assets/js/map.js');
    wp_enqueue_script( 'google-places', 'https://maps.googleapis.com/maps/api/js?key=' . get_field( 'google_api_key', 'option' ) . '&callback=initAutocomplete&libraries=places&v=weekly', [], false, true );
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