<?php

namespace exit205;

use exit205\classes\post_types\Beer_Place;
use exit205\classes\plugins\Map;
use exit205\classes\taxonomies\Place_Type;

/**
 * class Exit205
 */

class Exit205 {

	private $classes_dir;
	private $exit205 = null;

	public function init() {
		$this->classes_dir = get_stylesheet_directory() . '/classes/';
		$this->load_classes( [ 'post_types', 'taxonomies', 'plugins' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
		add_action( 'init', [ $this, 'register_post_types' ] );
		add_action( 'init', [ $this, 'register_taxonomies' ] );
	}

	public function enqueue() {
		wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array( 'child-style','bootstrap-css' ) );

		if ( is_page_template( 'page-map.php' ) ) {
			Map::enqueue_scripts();
		}
	}

	public function register_post_types() {
		$beer_place = Beer_Place::init();
	}

	public function register_taxonomies() {
		$place_type = Place_Type::init();
	}

	public function load_classes( $paths = [] ) {

		foreach ( $paths as $path ) {
			/** @var $classes array - grab all php files from directory and include */
			$classes = glob( $this->classes_dir . $path . '/*.php' );
			foreach ( $classes as $class ) {
				if ( is_file( $class ) ) {
					include $class;
				}
			}
		}
	}

	public function instance() {
		if ( is_null( $this->exit205 ) ) {
			$this->exit205 = new Exit205();
		}
		return $this->exit205;
	}

}

$exit205 = new Exit205();
$exit205->init();