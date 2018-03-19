<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once(__DIR__ . '/endpoints/class-wpress-db-controller.php');

#TODO get namespace from options
$wpress_rest_db_controller = new WPRESS_REST_DB_Controller(get_option('api-namespace')['default-api-namespace']);

?>