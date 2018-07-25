<?php

/**
 * Plugin Name: TSL-extend-REST-api
 * Plugin URI: https://github.com/bahiirwa/TSL-extend-REST-api/
 * Description: Extend the post featured images to the rest API programtically and safely on a high level.
 * Version: 1.1.0
 * Author: Laurence Bahiirwa
 * Author URI: https://omukiga.com
 * Requires at least: 3.0
 * Tested up to: 4.9.5
 * Tags: Extend, REST-api, featured-images
 * Text Domain: tsl
 * License: GPLv2
 *
**/

/* Kudos https://medium.com/@dalenguyen/how-to-get-featured-image-from-wordpress-rest-api-5e023b9896c6 */


add_action('rest_api_init', 'register_rest_images' );

function register_rest_images(){
    register_rest_field( array('post'),
        'fimg_url',
        array(
            'get_callback'    => 'get_rest_featured_image',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function get_rest_featured_image( $object, $field_name, $request ) {
    if( $object['featured_media'] ){
        $img = wp_get_attachment_image_src( $object['featured_media'], 'app-thumb' );
        return $img[0];
    }
    return false;
}
