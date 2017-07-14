<?php

namespace exit205\classes\post_types;

/**
 * Class Beer_Place_Meta
 * @package exit205\classes\post_types
 *
 * @author Chris Flannagan
 */
class Beer_Place_Meta {

	const NAME = 'beer_place_meta';
	const TITLE = 'Beer Place Information';

	const ADDRESS = 'beer_place_address';
	const WEBSITE = 'beer_place_website';

	public function get_value( $post_id, $key ) {
		return get_field( $post_id, $key );
	}

	/**
	 * @return array
	 */
	public function group_config(){
		acf_add_local_field_group( [
			'key' => 'group_' . self::NAME,
			'title' => self::TITLE,
			'fields' => [
				$this->get_address_field(),
				$this->get_website_field(),
			],
			'location' => [
				[
					[
						'param' => 'post_type',
						'operator' => '==',
						'value' => Beer_Place::POST_TYPE,
					],
				],
			],
		] );
	}

	public function get_address_field() {
		return [
			'key' => self::ADDRESS,
			'label' => 'Street',
			'name' => 'street',
			'type' => 'text',
		];
	}

	public function get_website_field() {
		return [
			'key' => self::WEBSITE,
			'label' => 'Website',
			'name' => 'website',
			'type' => 'text',
		];
	}

	public static function init() {
		$meta = new Beer_Place_Meta();
		$meta->group_config();
		return $meta;
	}

}