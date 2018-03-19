<?php

/*
Plugin Name: WP Cypress DB Cleaner
Plugin URI:
Description: Adds in you api a route to reset the database, for use with Cypress or similar programs.
Version: 1.0
Author: Weryques S. Silva
Author URI: https://github.com/Weryques
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once(__DIR__ . '/views/class-wpress-menu-page.php');
require_once(__DIR__ . '/api-controllers/class-wpress-api-creator.php');

$menu_page = new WPress_Menu_Page();