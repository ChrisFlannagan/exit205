<?php

namespace exit205;

use exit205\classes\post_types\Beer_Place;

/**
 * class Exit205
 */

class Exit205 {

	private $classes_dir;

	public function __construct() {
		$this->classes_dir = get_stylesheet_directory() . '/classes/post_types/';

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'init', [ $this, 'register_post_types' ] );
	}

	public function enqueue_styles() {
		wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array( 'child-style','bootstrap-css' ) );
	}

	public function register_post_types() {
		require_once $this->classes_dir . 'Beer_Place.php';
		$beer_place = Beer_Place::init();
	}

	public static function init() {
		return new Exit205();
	}

}

Exit205::init();