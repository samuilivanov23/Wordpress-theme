<?php

    function load_stylesheets()
    {
        wp_register_style('style', get_template_directory_uri() . '/style.css', array(), false, 'all');
        wp_enqueue_style('style');
    }
    add_action('wp_enqueue_scripts', 'load_stylesheets');
?>