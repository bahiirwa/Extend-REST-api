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
    
    register_rest_field( array('post'),
        'featimgs_url',
        array(
            'get_callback'    => 'get_rest_attached_images',
            'update_callback' => null,
            'schema'          => null,
        )
    );
	
    register_rest_field( array('post'),
        'attached_imgs_url',
        array(
            'get_callback'    => 'get_rest_attached_images_minus_feat',
            'update_callback' => null,
            'schema'          => null,
        )
    );
	
    register_rest_field( array('post'),
        'user_display_name',
        array(
            'get_callback'    => 'get_rest_user_display_name',
            'update_callback' => null,
            'schema'          => null,
        )
    );
	
    register_rest_field( array('post'),
        'author_user_description',
        array(
            'get_callback'    => 'get_rest_user_description',
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

function get_rest_attached_images() {
    $media = get_attached_media('image', get_the_ID());
    return $media;
}

//All other attached images minus the featured image.
function get_rest_attached_images_minus_feat() {
	$output = "";
    if( has_post_thumbnail() ): 
            $output = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
        else:   
            if($attachment):
                foreach($attachments as $attachment):
                    $output = wp_get_attachment_url( $attachment->ID);
                     
                endforeach;
            endif;
            wp_reset_postdata();
        endif;
 
    $attachments = get_posts(array(
        'post_type'=> 'attachment',
        'posts_per_page' => -1,
        'post_parent' => get_the_ID()
        ));
    return $output;
}

function get_rest_user_display_name() {
	return the_author();
}


function get_rest_user_description() {
	return the_author_description();
}
