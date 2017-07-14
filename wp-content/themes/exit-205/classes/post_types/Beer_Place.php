<?php

namespace exit205\classes\post_types;

use exit205\classes\taxonomies\Place_Type;

/**
 * Class Beer_Place
 * @package exit205\classes\post_types
 *
 * @author Chris Flannagan
 */
class Beer_Place {

	const NAME = 'Beer Place';
	const POST_TYPE = 'beer-place';

	public $meta;

	public function __construct() {
		$labels = [
			'name'               => _x( 'Beer Places', 'post type general name', 'exit205' ),
			'singular_name'      => _x( 'Beer Place', 'post type singular name', 'exit205' ),
			'menu_name'          => _x( 'Beer Places', 'admin menu', 'exit205' ),
			'name_admin_bar'     => _x( 'Beer Place', 'add new on admin bar', 'exit205' ),
			'add_new'            => _x( 'Add New', 'beer-place', 'exit205' ),
			'add_new_item'       => __( 'Add New Beer Place', 'exit205' ),
			'new_item'           => __( 'New Beer Place', 'exit205' ),
			'edit_item'          => __( 'Edit Beer Place', 'exit205' ),
			'view_item'          => __( 'View Beer Place', 'exit205' ),
			'all_items'          => __( 'All Beer Places', 'exit205' ),
			'search_items'       => __( 'Search Beer Places', 'exit205' ),
			'parent_item_colon'  => __( 'Parent Beer Places:', 'exit205' ),
			'not_found'          => __( 'No Beer Place found.', 'exit205' ),
			'not_found_in_trash' => __( 'No Beer Place found in Trash.', 'exit205' )
		];

		$args = [
			'labels'             => $labels,
			'description'        => __( 'Description.', 'exit205' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => self::POST_TYPE ],
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ],
			'taxonomies'         => [ Place_Type::TAXONOMY ],
		];

		register_post_type( self::POST_TYPE, $args );
		$this->meta = Beer_Place_Meta::init();
	}

	public static function init() {
		return new Beer_Place();
	}

}