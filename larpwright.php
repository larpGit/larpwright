<?php
/**
 * Plugin Name: Larpwright Design Tools
 * Plugin URI: https://www.larpwright.online/
 * Description: The plugin provides several custom post types and further functionality for creating larp scripts in a team.
 * Version 1.0.6
 * Author: Björn-Ole Kamm
 * Author URI: https://www.b-ok.de/
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html 
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Tags: co-creation, collaboration, design, larp, plugin, role-playing, translation-ready, writing
 * Text Domain: larpwright
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/larpGit/larpwright
 */
 
/*
	Copyright 2023, Björn-Ole Kamm

	The statement below within this comment block is relevant to
	this file as well as to all files in this folder and to all files
	in all sub-folders of this folder recursively
	(except: class-tgm-plugin-activation.php, assets/display-post-types.zip; 
	see below).

	The Larpwright Design Tools plugin is free software: you can redistribute
	it and/or modify it under the terms of the GNU General Public License as 
	published by the Free Software Foundation, either version 3 of the License, 
	or (at your option) any later version.
	
	The Larpwright Design Tools plugin is distributed in the hope that it will 
	be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of 
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General 
	Public License for more details.
	
	You should have received a copy of the GNU General Public License along 
	with the Larpwright Design Tools. If not, see https://www.gnu.org/licenses/. 
	
	This plugin includes the TGM-Plugin-Activation library for installing necessary 
	additional plugins. Copyright 2011 Thomas Griffin (https://thomasgriffinmedia.com).

	The plugin bundlles the Display Post Types plugin in a WordPress 6.2+ compatible 
	version. Copyright 2022 vedathemes (https://profiles.wordpress.org/vedathemes/).
*/
 
//========================= 1. REGISTER NEW POST TYPES ===========================//

//========================= CHARACTER CUSTOM POST TYPE ===========================//
// This is the central new post type allowing for the creation of "charactersheets".
// The plugin provides a couple of "reusable blocks" for different characters types, e.g., player and non-player characters.
 
function character_post_type() {
 
// Set UI labels for the Character Post Type
    $labels = array(
        'name'                => _x( 'Characters', 'post type general name', 'larpwright' ),
        'singular_name'       => _x( 'Character', 'post type singular name', 'larpwright' ),
        'menu_name'           => __( 'Characters', 'larpwright' ),
        'parent_item_colon'   => __( 'Parent Character', 'larpwright' ),
        'all_items'           => __( 'All Characters', 'larpwright' ),
        'view_item'           => __( 'View Character', 'larpwright' ),
        'add_new_item'        => __( 'Add New Character', 'larpwright' ),
        'add_new'             => __( 'Add New', 'larpwright' ),
        'edit_item'           => __( 'Edit Character', 'larpwright' ),
        'update_item'         => __( 'Update Character', 'larpwright' ),
        'search_items'        => __( 'Search Character', 'larpwright' ),
        'not_found'           => __( 'Not Found', 'larpwright' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'larpwright' ),
    );
     
// Set other options for the Character Post Type
    $args = array(
        'label'               => __( 'character', 'larpwright' ),
        'description'         => __( 'Character descriptions', 'larpwright' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'comments', 'revisions'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'character-type', 'group', 'profession', 'species'),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-id',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'rewrite'			  => array( 'slug' => 'characters' ),
        'show_in_rest'		  => true,
   		'supports' 			  => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'comments', 'revisions')
    );
     
    // Registering the Character Post Type
    register_post_type( 'character', $args );
}
add_action( 'init', 'character_post_type', 0 );

// Remove "Next" and "Previous" navigation (characters are non-hierarchical but there should be no navigation)
function larpwright_modify_adjacent_links($output, $format, $link, $post) {
    if ('character' === $post->post_type) {
        return '';
    } elseif ('scene' === $post->post_type) {
        $format = str_replace('%title', __('%title', 'larpwright'), $format);
    }
    return $output;
}
add_filter('next_post_link', 'larpwright_modify_adjacent_links', 10, 4);
add_filter('previous_post_link', 'larpwright_modify_adjacent_links', 10, 4);

//========================= Character Types for Characters ===========================//
// Character types refers to categories such as player character, non-player character, and guided player character.
// These three types will be automatically created but other types can be added, the default types deleted.
 
function character_types_taxonomy() {
 
// Labels part for the UI
  $custom_cats = array(
    'name' => _x( 'Character Types', 'taxonomy general name', 'larpwright' ),
    'singular_name' => _x( 'Character Type', 'taxonomy singular name', 'larpwright' ),
    'search_items' =>  __( 'Search Character Types', 'larpwright' ),
    'all_items' => __( 'All Character Types', 'larpwright' ),
    'parent_item' => __( 'Parent Character Type', 'larpwright' ),
    'parent_item_colon' => __( 'Parent Character Type:', 'larpwright' ),
    'edit_item' => __( 'Edit Character Type', 'larpwright' ), 
    'update_item' => __( 'Update Character Type', 'larpwright' ),
    'add_new_item' => __( 'Add New Character Type', 'larpwright' ),
    'new_item_name' => __( 'New Character Type', 'larpwright' ),
    'menu_name' => __( 'Character Types', 'larpwright' ),
  );    
 
// Now register the hierarchical taxonomy like category.
  register_taxonomy('character-type',array('character'), array(
    'hierarchical' => true,
    'labels' => $custom_cats,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_in_rest'  => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'character-types' ),
  ));
}
add_action( 'init', 'character_types_taxonomy', 0 );


//========================= Species for Characters ===========================//
// Species is another way of differentiating characters, e.g., into humans and elves, or aliens.

function species_taxonomy() { 

// Labels part for the UI 
  $custom_cats = array(
    'name' => _x( 'Species', 'taxonomy general name', 'larpwright' ),
    'singular_name' => _x( 'Species', 'taxonomy singular name', 'larpwright' ),
    'search_items' =>  __( 'Search Species', 'larpwright' ),
    'all_items' => __( 'All Species', 'larpwright' ),
    'parent_item' => __( 'Parent Species', 'larpwright' ),
    'parent_item_colon' => __( 'Parent Species:', 'larpwright' ),
    'edit_item' => __( 'Edit Species', 'larpwright' ), 
    'update_item' => __( 'Update Species', 'larpwright' ),
    'add_new_item' => __( 'Add New Species', 'larpwright' ),
    'new_item_name' => __( 'New Species', 'larpwright' ),
    'menu_name' => __( 'Species', 'larpwright' ),
  );
 
// Now register the hierarchical taxonomy like a category.
  register_taxonomy('species',array('character'), array(
    'hierarchical' => true,
    'labels' => $custom_cats,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_in_rest'  => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'species' ),
  ));
}

add_action( 'init', 'species_taxonomy', 0 );


//========================= Profession for Characters ===========================//
// Profession can refers to jobs, areas of expertise, or classes, depending on the game.

function profession_taxonomy() {

// Labels part for the UI
  $custom_cats = array(
    'name' => _x( 'Professions', 'taxonomy general name', 'larpwright' ),
    'singular_name' => _x( 'Profession', 'taxonomy singular name', 'larpwright' ),
    'search_items' =>  __( 'Search Professions', 'larpwright' ),
    'all_items' => __( 'All Professions', 'larpwright' ),
    'parent_item' => __( 'Parent Profession', 'larpwright' ),
    'parent_item_colon' => __( 'Parent Profession:', 'larpwright' ),
    'edit_item' => __( 'Edit Profession', 'larpwright' ), 
    'update_item' => __( 'Update Profession', 'larpwright' ),
    'add_new_item' => __( 'Add New Profession', 'larpwright' ),
    'new_item_name' => __( 'New Profession', 'larpwright' ),
    'menu_name' => __( 'Professions', 'larpwright' ),
  );    
 
// Now register the hierarchical taxonomy like a category.
  register_taxonomy('profession',array('character'), array(
    'hierarchical' => true,
    'labels' => $custom_cats,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_in_rest'  => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'professions' ),
  ));
}

add_action( 'init', 'profession_taxonomy', 0 );

//========================= In-Game Group for Characters ===========================//
// Characters may belong to different groups, such as countries, clubs, or cults.

function group_taxonomy() { 

// Labels part for the UI
  $custom_cats = array(
    'name' => _x( 'In-Game Groups', 'taxonomy general name', 'larpwright' ),
    'singular_name' => _x( 'In-Game Group', 'taxonomy singular name', 'larpwright' ),
    'search_items' =>  __( 'Search Groups', 'larpwright' ),
    'all_items' => __( 'All In-Game Groups', 'larpwright' ),
    'parent_item' => __( 'Parent Group', 'larpwright' ),
    'parent_item_colon' => __( 'Parent Group:', 'larpwright' ),
    'edit_item' => __( 'Edit Group', 'larpwright' ), 
    'update_item' => __( 'Update Group', 'larpwright' ),
    'add_new_item' => __( 'Add New Group', 'larpwright' ),
    'new_item_name' => __( 'New Group Name', 'larpwright' ),
    'menu_name' => __( 'In-Game Groups', 'larpwright' ),
  );
 
// Now register the hierarchical taxonomy like a category.
  register_taxonomy('group',array('character'), array(
    'hierarchical' => true,
    'labels' => $custom_cats,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_in_rest'  => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'groups' ),
  ));
}

add_action( 'init', 'group_taxonomy', 0 );



//========================= Attitude for Characters ===========================//
// Attitudes refers to a character's worldview or motivation.

function attitude_taxonomy() { 

// Labels part for the GUI
  $custom_tags = array(
    'name' => _x( 'Attitudes', 'taxonomy general name', 'larpwright' ),
    'singular_name' => _x( 'Attitude', 'taxonomy singular name', 'larpwright' ),
    'search_items' =>  __( 'Search Attitudes', 'larpwright' ),
    'popular_items' => __( 'Popular Attitudes', 'larpwright' ),
    'all_items' => __( 'All Attitudes', 'larpwright' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Attitude', 'larpwright' ), 
    'update_item' => __( 'Update Attitude', 'larpwright' ),
    'add_new_item' => __( 'Add New Attitude', 'larpwright' ),
    'new_item_name' => __( 'New Attitude', 'larpwright' ),
    'menu_name' => __( 'Attitudes', 'larpwright' ),
  );
 
// Now register the non-hierarchical taxonomy like tag.
  register_taxonomy('attitude','character',array(
    'hierarchical' => false,
    'labels' => $custom_tags,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_in_rest'  => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'attitudes' ),
  ));
}
add_action( 'init', 'attitude_taxonomy', 0 );



//========================= SCENE CUSTOM POST TYPE ===========================//
// Scenes structure the play of some larps. Each scene includes parameters for what will happen.
// Scenes can be part of larger segments of play, such as acts or episodes ("episodic play").

function scene_post_type() {
 
// Set UI labels for the Scene Post Type
    $labels = array(
        'name'                => _x( 'Scenes', 'post type general name', 'larpwright' ),
        'singular_name'       => _x( 'Scene', 'post type singular name', 'larpwright' ),
        'menu_name'           => __( 'Scenes', 'larpwright' ),
        'parent_item_colon'   => __( 'Parent Scene', 'larpwright' ),
        'all_items'           => __( 'All Scenes', 'larpwright' ),
        'view_item'           => __( 'View Scene', 'larpwright' ),
        'add_new_item'        => __( 'Add New Scene', 'larpwright' ),
        'add_new'             => __( 'Add New', 'larpwright' ),
        'edit_item'           => __( 'Edit Scene', 'larpwright' ),
        'update_item'         => __( 'Update Scene', 'larpwright' ),
        'search_items'        => __( 'Search Scene', 'larpwright' ),
        'not_found'           => __( 'Not Found', 'larpwright' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'larpwright' ),
    );
     
// Set other options for the Scene Post Type
    $args = array(
        'label'               => __( 'scene', 'larpwright' ),
        'description'         => __( 'Scene descriptions', 'larpwright' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'comments', 'revisions'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'episode', 'mood'),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-tickets-alt',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'rewrite'			  => array( 'slug' => 'plot' ),
        'show_in_rest'		  => true,
   		'supports' 			  => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'comments', 'revisions')
    );
     
    // Registering the Scene Post Type
    register_post_type( 'scene', $args );
} 
add_action( 'init', 'scene_post_type', 0 );

function larpwright_modify_next_scene_link($output, $format, $link, $post) {
    if ('scene' === $post->post_type) {
        $next_scene = __('Next scene', 'larpwright');
        $output = str_replace('Next post', $next_scene, $output);
    }
    return $output;
}
add_filter('next_post_link', 'larpwright_modify_next_scene_link', 10, 4);

function larpwright_modify_previous_scene_link($output, $format, $link, $post) {
    if ('scene' === $post->post_type) {
        $previous_scene = __('Previous scene', 'larpwright');
        $output = str_replace('Previous post', $previous_scene, $output);
    }
    return $output;
}
add_filter('previous_post_link', 'larpwright_modify_previous_scene_link', 10, 4);



//========================= Episodes for Scenes ===========================//
//If the larp is episodic, this taxonomy allows scenes to be linked to these larger structures.

function episode_taxonomy() { 

// Labels part for the UI
  $custom_cats = array(
    'name' => _x( 'Episodes', 'taxonomy general name', 'larpwright' ),
    'singular_name' => _x( 'Episode', 'taxonomy singular name', 'larpwright' ),
    'search_items' =>  __( 'Search Episodes', 'larpwright' ),
    'all_items' => __( 'All Episodes', 'larpwright' ),
    'parent_item' => __( 'Parent Episode', 'larpwright' ),
    'parent_item_colon' => __( 'Parent Episode:', 'larpwright' ),
    'edit_item' => __( 'Edit Episode', 'larpwright' ), 
    'update_item' => __( 'Update Episode', 'larpwright' ),
    'add_new_item' => __( 'Add New Episode', 'larpwright' ),
    'new_item_name' => __( 'New Episode', 'larpwright' ),
    'menu_name' => __( 'Episodes', 'larpwright' ),
  );
 
// Now register the hierarchical taxonomy like category.
  register_taxonomy('episode',array('scene'), array(
    'hierarchical' => true,
    'labels' => $custom_cats,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_in_rest'  => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'episodes' ),
  ));
}

add_action( 'init', 'episode_taxonomy', 0 );


//========================= Mood for Scenes ===========================//
//Moods can help in quickly labelling scene content, e.g., as a happy scene or a tragic scene.

function mood_taxonomy() { 

// Labels part for the UI 
  $custom_tags = array(
    'name' => _x( 'Moods', 'taxonomy general name', 'larpwright' ),
    'singular_name' => _x( 'Mood', 'taxonomy singular name', 'larpwright' ),
    'search_items' =>  __( 'Search Moods', 'larpwright' ),
    'popular_items' => __( 'Popular Moods', 'larpwright' ),
    'all_items' => __( 'All Moods', 'larpwright' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Mood', 'larpwright' ), 
    'update_item' => __( 'Update Mood', 'larpwright' ),
    'add_new_item' => __( 'Add New Mood', 'larpwright' ),
    'new_item_name' => __( 'New Mood', 'larpwright' ),
    'menu_name' => __( 'Moods', 'larpwright' ),
  );
 
// Now register the non-hierarchical taxonomy like tag.
  register_taxonomy('mood','scene',array(
    'hierarchical' => false,
    'labels' => $custom_tags,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_in_rest'  => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'moods' ),
  ));
}
add_action( 'init', 'mood_taxonomy', 0 );


//========================= LOCATION CUSTOM POST TYPE ===========================//
// If a larp rather functions via locations, they can be set via this post type.
// Episodic larps, of course, will have locations, too.
// Locations are defined as hierarchical, so that a room, for example, can be located in a buidling (=parent location). 

function location_post_type() {
 
// Set UI labels for the Location Post Type
    $labels = array(
        'name'                => _x( 'Locations', 'post type general name', 'larpwright' ),
        'singular_name'       => _x( 'Location', 'post type singular name', 'larpwright' ),
        'menu_name'           => __( 'Locations', 'larpwright' ),
        'parent_item_colon'   => __( 'Parent Location', 'larpwright' ),
        'all_items'           => __( 'All Locations', 'larpwright' ),
        'view_item'           => __( 'View Location', 'larpwright' ),
        'add_new_item'        => __( 'Add New Location', 'larpwright' ),
        'add_new'             => __( 'Add New', 'larpwright' ),
        'edit_item'           => __( 'Edit Location', 'larpwright' ),
        'update_item'         => __( 'Update Location', 'larpwright' ),
        'search_items'        => __( 'Search Location', 'larpwright' ),
        'not_found'           => __( 'Not Found', 'larpwright' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'larpwright' ),
    );
     
// Set other options for the Location Post Type
     
    $args = array(
        'label'               => __( 'location', 'larpwright' ),
        'description'         => __( 'Location descriptions', 'larpwright' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'comments', 'revisions'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'size', 'feature'),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-location',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'rewrite'			  => array( 'slug' => 'locations' ),
        'show_in_rest'		  => true,
   		'supports' 			  => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'comments', 'revisions')
    );
     
    // Registering the Location Post Type
    register_post_type( 'location', $args );
}
add_action( 'init', 'location_post_type', 0 );

//========================= Size for Locations ===========================//
//Size can be used to convey information about how many people may fit in a location.
 
function sizes_taxonomy() {

// Labels part for the UI  
  $custom_cats = array(
    'name' => _x( 'Size', 'taxonomy general name', 'larpwright' ),
    'singular_name' => _x( 'Size', 'taxonomy singular name', 'larpwright' ),
    'search_items' =>  __( 'Search Sizes', 'larpwright' ),
    'all_items' => __( 'All Sizes', 'larpwright' ),
    'parent_item' => __( 'Parent Size', 'larpwright' ),
    'parent_item_colon' => __( 'Parent Size:', 'larpwright' ),
    'edit_item' => __( 'Edit Size', 'larpwright' ), 
    'update_item' => __( 'Update Size', 'larpwright' ),
    'add_new_item' => __( 'Add New Size', 'larpwright' ),
    'new_item_name' => __( 'New Size', 'larpwright' ),
    'menu_name' => __( 'Sizes', 'larpwright' ),
  );    
 
// Now register the hierarchical taxonomy like category.
  register_taxonomy('size',array('location'), array(
    'hierarchical' => true,
    'labels' => $custom_cats,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_in_rest'  => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'sizes' ),
  ));
 
}
add_action( 'init', 'sizes_taxonomy', 0 );

//========================= Features for Locations ===========================//
// Features can be used to easily check a location's appropriateness for a scene or
// plot idea. For example, hidden doors or large windows could be such features.

function features_taxonomy() { 

// Labels part for the GUI 
  $custom_tags = array(
    'name' => _x( 'Features', 'taxonomy general name', 'larpwright' ),
    'singular_name' => _x( 'Feature', 'taxonomy singular name', 'larpwright' ),
    'search_items' =>  __( 'Search Features', 'larpwright' ),
    'popular_items' => __( 'Popular Features', 'larpwright' ),
    'all_items' => __( 'All Features', 'larpwright' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Feature', 'larpwright' ), 
    'update_item' => __( 'Update Feature', 'larpwright' ),
    'add_new_item' => __( 'Add New Feature', 'larpwright' ),
    'new_item_name' => __( 'New Feature', 'larpwright' ),
    'menu_name' => __( 'Features', 'larpwright' ),
  );
 
// Now register the non-hierarchical taxonomy like tag.
  register_taxonomy('feature','location',array(
    'hierarchical' => false,
    'labels' => $custom_tags,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_in_rest'  => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'features' ),
  ));
}
add_action( 'init', 'features_taxonomy', 0 );


//========================= PROPS CUSTOM POST TYPE ===========================//
// Any larp will make use of props. This custom post type can help define them
// and link them also to characters, scenes, or locations.
// Props are hierarchical so that elements, e.g. a hat, can be part of a costume (=parent prop).

function prop_post_type() {
 
// Set UI labels for the Prop Post Type
    $labels = array(
        'name'                => _x( 'Props', 'post type general name', 'larpwright' ),
        'singular_name'       => _x( 'Prop', 'post type singular name', 'larpwright' ),
        'menu_name'           => __( 'Props', 'larpwright' ),
        'parent_item_colon'   => __( 'Parent Prop', 'larpwright' ),
        'all_items'           => __( 'All Props', 'larpwright' ),
        'view_item'           => __( 'View Prop', 'larpwright' ),
        'add_new_item'        => __( 'Add New Prop', 'larpwright' ),
        'add_new'             => __( 'Add New', 'larpwright' ),
        'edit_item'           => __( 'Edit Prop', 'larpwright' ),
        'update_item'         => __( 'Update Prop', 'larpwright' ),
        'search_items'        => __( 'Search Prop', 'larpwright' ),
        'not_found'           => __( 'Not Found', 'larpwright' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'larpwright' ),
    );
     
// Set other options for the Prop Post Type
     
    $args = array(
        'label'               => __( 'prop', 'larpwright' ),
        'description'         => __( 'Props descriptions', 'larpwright' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'comments', 'revisions'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'proptype', 'trait'),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-carrot',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'rewrite'			  => array( 'slug' => 'props' ),
        'show_in_rest'		  => true,
   		'supports' 			  => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'comments', 'revisions')
    );
     
    // Registering your Custom Post Type
    register_post_type( 'prop', $args );
}
add_action( 'init', 'prop_post_type', 0 );

//========================= Prop Type for Props ===========================//
// Prop types can be costumes, weapons, tools etc., helping to distinguish between different categories.
 
function prop_type_taxonomy() {
 
// Labels part for the GUI  
  $custom_cats = array(
    'name' => _x( 'Prop Types', 'taxonomy general name', 'larpwright' ),
    'singular_name' => _x( 'Prop Type', 'taxonomy singular name', 'larpwright' ),
    'search_items' =>  __( 'Search Prop Types', 'larpwright' ),
    'all_items' => __( 'All Prop Types', 'larpwright' ),
    'parent_item' => __( 'Parent Prop Type', 'larpwright' ),
    'parent_item_colon' => __( 'Parent Prop Type:', 'larpwright' ),
    'edit_item' => __( 'Edit Prop Type', 'larpwright' ), 
    'update_item' => __( 'Update Prop Type', 'larpwright' ),
    'add_new_item' => __( 'Add New Prop Type', 'larpwright' ),
    'new_item_name' => __( 'New Prop Type', 'larpwright' ),
    'menu_name' => __( 'Prop Types', 'larpwright' ),
  );    
 
// Now register the hierarchical taxonomy like category. 
  register_taxonomy('proptype',array('prop'), array(
    'hierarchical' => true,
    'labels' => $custom_cats,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_in_rest'  => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'proptype' ),
  ));
 
}
add_action( 'init', 'prop_type_taxonomy', 0 );

//========================= Traits for Props ===========================//
// Traits are distinguishable characteristics, for example, important for the plot.
// A prop could be labelled expensive, for example, limiting access to rich characters.

function trait_taxonomy() { 

// Labels part for the GUI 
  $custom_tags = array(
    'name' => _x( 'Traits', 'taxonomy general name', 'larpwright' ),
    'singular_name' => _x( 'Trait', 'taxonomy singular name', 'larpwright' ),
    'search_items' =>  __( 'Search Traits', 'larpwright' ),
    'popular_items' => __( 'Popular Traits', 'larpwright' ),
    'all_items' => __( 'All Traits', 'larpwright' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Trait', 'larpwright' ), 
    'update_item' => __( 'Update Trait', 'larpwright' ),
    'add_new_item' => __( 'Add New Trait', 'larpwright' ),
    'new_item_name' => __( 'New Trait', 'larpwright' ),
    'menu_name' => __( 'Traits', 'larpwright' ),
  );
 
// Now register the non-hierarchical taxonomy like tag.
  register_taxonomy('trait','prop',array(
    'hierarchical' => false,
    'labels' => $custom_tags,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_in_rest'  => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'trait' ),
  ));
}
add_action( 'init', 'trait_taxonomy', 0 );

//========================= List Sort Order ===========================//
// Sort the above custom post types in wp_list_table by column in ascending or descending order. */
function custom_post_order($query){
    /* 
        Set post types.
        _builtin => true returns WordPress default post types. 
        _builtin => false returns custom registered post types. 
    */
    $post_types = get_post_types(array('_builtin' => false), 'names');
    /* The current post type. */
    $post_type = $query->get('post_type');
    /* Check post types. */
    if(in_array($post_type, $post_types)){
        /* Post Column: e.g. title */
        if($query->get('orderby') == ''){
            $query->set('orderby', 'date');
        }
        /* Post Order: ASC / DESC */
        if($query->get('order') == ''){
            $query->set('order', 'ASC');
        }
    }

return $query;

}

if(is_admin()){
    add_action('pre_get_posts', 'custom_post_order', 99);
}

function adjust_queries($query){
   if ( ! is_admin() && is_tax() && $query->is_main_query() ) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC');
   }
}
add_action( 'pre_get_posts', 'adjust_queries' );

//========================= 2. ACTIVATION PROCEDURES ===========================//

//========================= Check for Necessary Plugins ===========================//
// To function properly, the Larpwright Design Tools depent on the following four plugins:
// Custom Related Posts: To create relationships between characters.
// Display Post Types: To list up characters involved in scenes.
// RDV Category Image: To add logos or other images to customs taxonomies like groups.
// Visual Term Description Editor: So that descriptions of custom taxonomies can be more
// sophisticated.
// The function below checks that they are installed.

require_once plugin_dir_path(__FILE__) . 'class-tgm-plugin-activation.php';

function larpwright_register_required_plugins() {
    $plugins = array(
        array(
            'name'      => 'Custom Related Posts',
            'slug'      => 'custom-related-posts',
            'required'  => true,
        ),
        array(
            'name'      => 'Display Post Types',
            'slug'      => 'display-post-types',
            'source'    => plugin_dir_url(__FILE__) . 'assets/display-post-types.zip',
            'required'  => true,
        ),
        array(
            'name'      => 'RDV Category Image',
            'slug'      => 'rdv-category-image',
            'required'  => true,
        ),
        array(
            'name'      => 'Visual Term Description Editor',
            'slug'      => 'visual-term-description-editor',
            'required'  => true,
        ),
    );

    $config = array(
        'id'           => 'larpwright',          // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
    	'parent_slug'  => 'plugins.php',            // Parent menu slug.
    	'capability'   => 'manage_options',         // Capability needed to view plugin install page.
    	'has_notices'  => true,                     // Show admin notices or not.
    	'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
    	'dismiss_msg'  => '',                       // If 'dismissable' is false, this message will be output at top of nag.
    	'is_automatic' => true,                     // Automatically activate plugins after installation or not.
    	'message'      => '',                       // Message to output right before the plugins table.
	);

	tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'larpwright_register_required_plugins');



//========================= Import Reusable Block Templates ===========================//
// This imports reusable blocks for layouting the character, scene, and location pages.

function import_reusable_blocks() {
    $reusable_blocks_folder = trailingslashit(plugin_dir_path(__FILE__)) . 'assets/';

    if (!file_exists($reusable_blocks_folder)) {
        return;
    }

    $json_files = glob($reusable_blocks_folder . '*.json');

    if (!empty($json_files)) {
        require_once(ABSPATH . 'wp-admin/includes/post.php');

        foreach ($json_files as $json_file) {
            $file_contents = file_get_contents($json_file);
            $reusable_block_data = json_decode($file_contents, true);

            if (!$reusable_block_data || !isset($reusable_block_data['title']) || !isset($reusable_block_data['content'])) {
                continue;
            }

            if (!post_exists($reusable_block_data['title'], '', '', 'wp_block')) {
                wp_insert_post(
                    array(
                        'post_title' => wp_strip_all_tags($reusable_block_data['title']),
                        'post_content' => $reusable_block_data['content'],
                        'post_type' => 'wp_block',
                        'post_status' => 'publish',
                    )
                );
            }
        }
    }
}

function larpwright_import_reusable_blocks_activation() {
    import_reusable_blocks();
}

//========================= Create Sample Taxonomy Entries ===========================//
// This creates three sample character type items, PCs, NPCs, and GPCs.

function create_character_types_terms() {
    $taxonomy = 'character-type';
    $terms = array(
        array(
            'name' => 'Player Character',
            'slug' => 'pc',
        ),
        array(
            'name' => 'Non-Player Character',
            'slug' => 'npc',
        ),
        array(
            'name' => 'Guided Player Character',
            'slug' => 'gpc',
        ),
    );

    foreach ($terms as $term) {
        $term_name = $term['name'];
        $term_slug = $term['slug'];

        // Check if the term already exists
        if (!term_exists($term_name, $taxonomy)) {
            // Create the term
            wp_insert_term(
                $term_name,
                $taxonomy,
                array(
                    'slug' => $term_slug,
                )
            );
        }
    }
}

function larpwright_create_terms_activation() {
    // Ensure the taxonomy is registered before creating terms
    if (!taxonomy_exists('character-type')) {
        character_types_taxonomy();
    }
    create_character_types_terms();
}



//========================= Register Activation Hooks ===========================//

register_activation_hook(__FILE__, 'larpwright_import_reusable_blocks_activation');
register_activation_hook(__FILE__, 'larpwright_create_terms_activation');

// Activation hook transient
function larpwright_activation() {
    set_transient('larpwright_activated', true, 5);
}
register_activation_hook(__FILE__, 'larpwright_activation');




//========================= 3. MISCELLANEOUS ===========================//

//========================= Permalink Notice ===========================//
// This will notify admins how to best change their permalink options.

function larpwright_permalink_notice() {
    // Check if the plugin was just activated
    if (get_transient('larpwright_activated')) {
        delete_transient('larpwright_activated');
        return;
    }

    global $wp_rewrite;

    $recommended_permalink_structure = '/%category%/%postname%/';
    if ($wp_rewrite->permalink_structure !== $recommended_permalink_structure) {
        echo '<div class="notice notice-warning">';
        echo '<p><strong>Larpwright Design Tools</strong> recommends changing the permalink structure to <code>' . $recommended_permalink_structure . '</code> for optimal performance. You can change this setting <a href="' . admin_url('options-permalink.php') . '">here</a>.</p>';
        echo '</div>';
    }
}

add_action('admin_notices', 'larpwright_permalink_notice');


//========================= Switch Comments on for all Post Types ===========================//
// This will allow the team to comment on each other's work. Will only work for new posts
// created after plugin activation.

function enable_comments_on_all_post_types($post_content, $post) {
    if ('publish' === $post->post_status) {
        $supported_post_types = array('post', 'page', 'character', 'scene', 'location', 'prop');
        if (in_array($post->post_type, $supported_post_types)) {
            $post->comment_status = 'open';
        }
    }

    return $post_content;
}
add_filter('default_content', 'enable_comments_on_all_post_types', 10, 2);

//========================= Load the Print CSS ===========================//
// The print css file ensures that print outs of the custom post types look good.

function larpwright_enqueue_print_styles() {
    wp_enqueue_style('larpwright-print-styles', plugin_dir_url(__FILE__) . 'css/print.css', array(), '1.0.0', 'print');
}

add_action('wp_enqueue_scripts', 'larpwright_enqueue_print_styles');
