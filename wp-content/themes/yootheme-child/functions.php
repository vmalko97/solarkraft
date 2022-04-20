<?php
add_action('wp_enqueue_scripts', function (){
    wp_enqueue_style('child_style', get_stylesheet_directory_uri().'/style.css');
},99);