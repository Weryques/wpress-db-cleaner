<?php

class WPress_Menu_Page {

	public function __construct() {
		add_action( 'admin_menu', array($this, 'wpress_options_page') );
		add_action( 'admin_init', array($this, 'initPage' ) );
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
				// output security fields for the registered setting "wporg_options"
				settings_fields( 'wpress_options' );
				// output setting sections and their fields
				// (sections are registered for "wporg", each field is registered to a specific section)
				do_settings_sections( 'wpress' );
				// output save settings button
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
			'wpress',
			array($this, 'wpress_options_page_html'),
			'',
			20
		);
	}

	function initPage(){
		register_setting( 'wpress_configurations', 'api_namespace', array($this, 'sanitize'));
		add_settings_section('configurations-wpress', '', array($this, 'print_namespace_info'), 'wpress_configurations');
		add_settings_field( 'default-api-namespace', 'Namespace da API:', array($this, 'wpress_namespace_callback'), 'wpress_configurations', 'configurations-wpress');
	}

	function wpress_namespace_callback(){
		$default_namespace = get_option('api-namespace')['default-api-namespace'];

		printf('<input type="url" id="default-api-namespace" name="api-namespace[default-api-namespace]" value="%s" />',
			isset( $default_namespace ) ? $default_namespace : ''
		);
	}

	function print_namespace_info(){
		print('Digite abaixo o namespace padrão da API (por exemplo: wp/v2');
	}

	function sanitize( $input ){
		$new_input = array();

		if( isset( $input['default-api-namespace'] ) ){
			$new_input['default-api-namespace'] = sanitize_text_field( $input['default-api-namespace'] );
		}

		return $new_input;
	}

}

?>