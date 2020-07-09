<?php

    function load_stylesheets()
    {
        wp_register_style('style', get_template_directory_uri() . '/style.css', array(), false, 'all');
        wp_enqueue_style('style');
    }
    add_action('wp_enqueue_scripts', 'load_stylesheets');

    function load_javascript()
    {
        wp_register_script('customjs', get_template_directory_uri() . '/js/app.js', '', 1, true);
        wp_enqueue_script('customjs');

        // wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?&key=AIzaSyAx04NtoyYgnm6kBsk7JTi6T4GAYZ-Ar28&callback=initMap', array(), '', false);
        // wp_enqueue_script('googlemaps');
    }
    add_action('wp_enqueue_scripts', 'load_javascript');
?>