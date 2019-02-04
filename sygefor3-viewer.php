<?php
/*
Plugin Name: Sygefor3 Viewer
Description: Permet de récupérer les sessions enregistrées dans Sygefor3 et de les afficher
Version: 1.0
Author: Conjecto
Author URI: http://www.conjecto.com
*/

if (!defined('ABSPATH')) {
    exit;
}

include_once('Sygefor3Viewer.php');

// initialize plugin datas
register_activation_hook(__FILE__, 'add_datas');

/**
 * add api URL to db when activate the plugin
 */
function add_datas() {
    add_option("sygefor3_api_address", "https://sygefor.reseau-urfist.fr/api/");
}