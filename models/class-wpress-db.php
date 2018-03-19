<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class WPress_DB {

	/**
	 * @return array
	 */
	public function reset_database() {
		global $wpdb;

		$tables = $wpdb->tables('all', $wpdb->prefix);

		$reseted_tables = [];
		foreach ($tables as $table){
			$reseted_tables[$table][] = $wpdb->delete($table, ['ID' => '> -1']);
		}

		return $reseted_tables;
	}

}

?>