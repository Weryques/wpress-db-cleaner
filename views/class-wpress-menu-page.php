<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class WPress_Menu_Page {

	/**
	 * WPress_Menu_Page constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array(&$this, 'wpress_options_page') );
		add_action( 'admin_init', array(&$this, 'init_page' ) );
	}

	public function wpress_options_page_html() {
        // check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
        <div class="wrap">
            <h1><?= esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
				<?php
				settings_fields( 'wpress_options' );
				do_settings_sections( 'wpress' );
				submit_button( __('Save Settings') );
				?>
            </form>
        </div>
		<?php
	}

	public function wpress_options_page() {
		add_menu_page(
			'WPress',
			'WPress',
			'manage_options',
			'wpress_menu',
			array(&$this, 'wpress_options_page_html'),
			''
		);
	}

	function init_page(){
		register_setting( 'wpress_options', 'api_namespace', array(&$this, 'sanitize_api_namespace'));
		register_setting( 'wpress_options', 'wpress_prefix', array(&$this, 'sanitize_db_prefix'));

		add_settings_section('wpress-config', '', array(&$this, 'print_namespace_info'), 'wpress');

		add_settings_field( 'default-api-namespace', __('API Namespace:'), array(&$this, 'wpress_namespace_callback'), 'wpress', 'wpress-config');
		add_settings_field('default-db-prefix', __('Database prefix:'), array(&$this, 'wpress_db_prefix_callback'), 'wpress', 'wpress-config');
	}

	function wpress_namespace_callback(){
		$default_namespace = get_option('api_namespace');

		printf('<input type="text" id="default-api-namespace" name="api_namespace[default-api-namespace]" value="%s" />',
            isset( $default_namespace ) ? $default_namespace : ''
		);
	}

	function wpress_db_prefix_callback(){
		$default_db_prefix = get_option('wpress_prefix');

		printf('<input type="text" id="default-db-prefix" name="wpress_prefix[default-db-prefix]" value="%s" />',
			isset( $default_db_prefix ) ? $default_db_prefix : ''
		);
	}

	function print_namespace_info(){
		print(__('Enter the namespace of API (for example: wp/v2) and the prefix of database (for example: wp_)'));
	}

	/**
	 * @param $input
	 *
	 * @return array
	 */
	function sanitize_api_namespace( $input ){
		$new_input = array();

		if( isset( $input['default-api-namespace'] ) ){
			$new_input['default-api-namespace'] = sanitize_text_field( $input['default-api-namespace'] );
		}

		return $new_input;
	}

	function sanitize_db_prefix($input){
	    $new_input = array();

		if (isset( $input['default-db-prefix'])){
			$new_input['default-db-prefix'] = sanitize_text_field( $input['default-db-prefix'] );
		}

		return $new_input;
    }

}

?>