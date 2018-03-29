<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class WPress_DB {

	/**
	 * @return array
	 */
	public function reset_database() {
		global $wpdb;

		$prefix = get_option( 'wpress_prefix' ) . '%%';

		$db_name = DB_NAME;

		$all_tables = $wpdb->prepare("SHOW TABLES FROM $db_name WHERE Tables_in_$db_name LIKE %s", $prefix);

		$tables = $wpdb->get_results($all_tables, ARRAY_A);

		$exception = ['options', 'users'];
		$reseted_tables = [];
		foreach ( $tables as $table) {
			foreach ($table as $table_name){
				if(!strstr($table_name, $exception[0]) && !strstr($table_name, $exception[1])) {
					$reseted_tables[ $table_name ][] = $wpdb->query( "DELETE FROM $table_name WHERE ID > 0" );
				}
			}
		}

		return $reseted_tables;
	}

}

?>