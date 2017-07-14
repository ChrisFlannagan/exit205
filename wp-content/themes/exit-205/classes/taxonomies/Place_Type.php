<?php

namespace exit205\classes\taxonomies;

use exit205\classes\post_types\Beer_Place;

class Place_Type {

	const NAME = 'Place Type';
	const TAXONOMY = 'beer-place-type';

	public function __construct() {
		$labels = [
			'name'              => _x( self::NAME . 's', 'taxonomy general name', 'exit205' ),
			'singular_name'     => _x( self::NAME, 'taxonomy singular name', 'exit205' ),
			'search_items'      => __( 'Search ' . self::NAME . 's', 'exit205' ),
			'all_items'         => __( 'All ' . self::NAME . 's', 'exit205' ),
			'parent_item'       => __( 'Parent ' . self::NAME, 'exit205' ),
			'parent_item_colon' => __( 'Parent ' . self::NAME . ':', 'exit205' ),
			'edit_item'         => __( 'Edit ' . self::NAME, 'exit205' ),
			'update_item'       => __( 'Update ' . self::NAME, 'exit205' ),
			'add_new_item'      => __( 'Add New ' . self::NAME, 'exit205' ),
			'new_item_name'     => __( 'New ' . self::NAME . ' Name', 'exit205' ),
			'menu_name'         => __( self::NAME, 'exit205' ),
		];

		$args = [
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => self::TAXONOMY ],
		];

		register_taxonomy( self::TAXONOMY, [ Beer_Place::POST_TYPE ], $args );
	}

	public static function init() {
		return new Place_Type();
	}

}