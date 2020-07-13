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

        $map_api_key = "AIzaSyAx04NtoyYgnm6kBsk7JTi6T4GAYZ-Ar28";
        wp_enqueue_script('googleapis', esc_url( add_query_arg( 'key', $map_api_key.'&callback=initMap', '//maps.googleapis.com/maps/api/js' )), array(), null, true );
    }
    add_action('wp_enqueue_scripts', 'load_javascript');

    //adding defer and async tags to the google map api script
    function add_async_defer_attribute($tag, $handle) {
        if ( 'googleapis' !== $handle )
        return $tag;
        return str_replace( 'src', 'async defer src', $tag );
    }
    add_filter('script_loader_tag', 'add_async_defer_attribute', 10, 2);
?>