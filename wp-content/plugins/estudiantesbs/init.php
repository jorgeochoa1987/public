<?php
/*
Plugin Name: SBS Estudiantes
Description: Plugin de creación de estudiantes
Version: 1.0
Author: jorge ochoa
Author URI: https:www.hijorge.com
*/
// function to create the DB / Options / Defaults					
function sb_options_install() {

    global $wpdb; 

    $table_name = $wpdb->prefix . "estudiantes";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
            `id` INT NOT NULL AUTO_INCREMENT,
            `nombre` varchar(100) CHARACTER SET utf8 NOT NULL,  
			`apellido` varchar(100) CHARACTER SET utf8 NOT NULL,            
			`edad` varchar(100) CHARACTER SET utf8 NOT NULL,            
			`curso` varchar(100) CHARACTER SET utf8 NOT NULL,            
			`tutor` varchar(100) CHARACTER SET utf8 NOT NULL,            

            PRIMARY KEY (`id`)
          ) $charset_collate; ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql); 
} 

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'sb_options_install');

//menu items
add_action('admin_menu','sbs_modify_menu');
function sbs_modify_menu() {
	
	//this is the main item for the menu
	add_menu_page('Estudiantes', //page title
	'estudiantes', //menu title
	'manage_options', //capabilities 
	'estudiante_list', //menu slug
	'estudiante_list' //function
	);
	 
	//this is a submenu
	add_submenu_page('estudiante_list', //parent slug
	'Crear nuevo', //page title
	'Nuevo', //menu title
	'manage_options', //capability
	'estudiante_crear', //menu slug
	'estudiante_crear'); //function
	
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Actualizar registro', //page title
	'Actualizar', //menu title
	'manage_options', //capability
	'estudiante_update', //menu slug
	'estudiante_update'); //function
} 
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'sbs-list.php');
require_once(ROOTDIR . 'sbs-create.php');
require_once(ROOTDIR . 'sbs-update.php');
