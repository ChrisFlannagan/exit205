<?php

namespace exit205\classes\plugins;

use exit205\classes\post_types\Beer_Place;
use exit205\classes\post_types\Beer_Place_Meta;

class Map {

	const API_URL = 'https://maps.googleapis.com/maps/api/geocode/json';
	const API_KEY = 'AIzaSyCH14eOx26mFcxCJRvJ_FUODFAnS8Kum_k';
	const LAT = '27.26954';
	const LNG = '-82.48904';

	public static function enqueue_scripts( $id = 'beer_map_id', $lat = '', $lng = '', $zoom = '14' ) {

		$lat = $lat === '' ? self::LAT : $lat;
		$lng = $lng === '' ? self::LNG : $lng;

		$map_data = [
			'map_id'  => $id,
			'map_lat' => floatval( $lat ),
			'map_lng' => floatval( $lng ),
			'zoom'    => intval( $zoom ),
			'markers' => self::localize_markers(),
		];
		wp_register_script( 'maps-init-js', get_stylesheet_directory_uri() . '/classes/plugins/map/init.js', [], false, true );
		wp_localize_script( 'maps-init-js', 'exit205_map', $map_data );
		wp_enqueue_script( 'maps-init-js' );
		wp_enqueue_script(
			'google-maps-api',
			'https://maps.googleapis.com/maps/api/js?key=' . self::API_KEY . '&callback=initMap',
			[ 'maps-init-js' ],
			false,
			true
		);

	}

	public static function localize_markers( $markers = [] ) {
		$posts = get_posts( [ 'post_type' => Beer_Place::POST_TYPE ] );

		/**
		 * @var $post \WP_Post
		 */
		foreach ( $posts as $post ) {
			$address = get_field( Beer_Place_Meta::ADDRESS, $post->ID ) . ', Sarasota, FL';
			$geo = self::get_geocoding( $address, $post->ID );

			if ( null != $geo['lat'] && null != $geo['lng'] && '' != $geo['lat'] && '' != $geo['lng'] ) {
				$markers[] = [
					'title'   => $post->post_title,
					'lat' => $geo['lat'],
					'lng' => $geo['lng'],
					'address' => get_field( Beer_Place_Meta::ADDRESS, $post->ID ),
					'website' => get_field( Beer_Place_Meta::WEBSITE, $post->ID ),
				];
			}
		}

		return $markers;
	}

	public static function get_geocoding( $address, $post_id ) {
		$lat = get_field( Beer_Place_Meta::LAT, $post_id );
		$lng = get_field( Beer_Place_Meta::LNG, $post_id );

		if ( strpos( $lat, '.' ) === false || strpos( $lng, '.' ) === false || isset( $_GET['reset_geo'] ) ) {
			$request = wp_remote_get( self::API_URL . '?address=' . urlencode( $address ) . '&key=' . self::API_KEY );
			if ( is_wp_error( $request ) ) {
				throw new \RuntimeException( 'Invalid data return from Geocoding API' );
			}
			$response = json_decode( wp_remote_retrieve_body( $request ), true );

			if ( isset( $response['results'][0]['geometry']['location']['lat'] ) ) {
				$lat = $response['results'][0]['geometry']['location']['lat'];
				$lng = $response['results'][0]['geometry']['location']['lng'];
				update_field( Beer_Place_Meta::LAT, $lat, $post_id );
				update_field( Beer_Place_Meta::LNG, $lng, $post_id );
			}
		}

		return [
			'lat' => $lat,
			'lng' => $lng,
		];
	}

	public static function hook() {
		add_action( 'wp_enqueue_scripts', [ 'exit205\classes\plugins\Map', 'enqueue_scripts' ] );
	}
}