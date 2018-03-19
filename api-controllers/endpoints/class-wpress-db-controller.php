<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once( __DIR__ . '/../../models/class-wpress-db.php' );

class WPRESS_REST_DB_Controller extends WP_REST_Controller {
	private $wpress_db;

	/**
	 * WPRESS_REST_DB_Controller constructor.
	 *
	 * @param $namespace
	 */
	public function __construct( $namespace ) {
		$this->namespace = $namespace;
		$this->rest_base = 'database';

		$this->wpress_db = new WPress_DB();

		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes() {
		register_rest_route( $this->namespace, '/' . $this->rest_base,
			array(
				array(
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'reset_database' ),
					'permission_callback' => array( $this, 'reset_database_permissions_check' ),
				)
			)
		);
	}

	/**
	 * @return WP_REST_Response
	 */
	public function reset_database() {
		$reseted_tables = $this->wpress_db->reset_database();

		return new WP_REST_Response( $reseted_tables, 200 );
	}

	/**
	 * @return bool
	 */
	public function reset_database_permissions_check() {
		return true;
	}
}

?>