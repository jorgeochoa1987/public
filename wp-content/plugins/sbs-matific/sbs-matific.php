<?php
/*
  Plugin Name: SBS - Matific
  Plugin URI:
  Description: Carga de Claves y contraseñas de usuarios matific
  Version: 1.0.0
  Author: Pablo Frias
  Author URI:
  Text Domain: SBS
 */

 

 // Registrar Custom Post Type
function sbs_matific() {

	$labels = array(
		'name'                  => _x( 'Matific', 'Post Type General Name', 'sbsmatific' ),
		'singular_name'         => _x( 'Matific', 'Post Type Singular Name', 'sbsmatific' ),
		'menu_name'             => __( 'Matific', 'sbsmatific' ),
		'name_admin_bar'        => __( 'Matific', 'sbsmatific' ),
		'archives'              => __( 'Archivo', 'sbsmatific' ),
		'attributes'            => __( 'Atributos', 'sbsmatific' ),
		'parent_item_colon'     => __( 'Clase Padre', 'sbsmatific' ),
		'all_items'             => __( 'Todas las Claves', 'sbsmatific' ),
		'add_new_item'          => __( 'Agregar Clave', 'sbsmatific' ),
		'add_new'               => __( 'Agregar Clave', 'sbsmatific' ),
		'new_item'              => __( 'Nueva Clave', 'sbsmatific' ),
		'edit_item'             => __( 'Editar Clave', 'sbsmatific' ),
		'update_item'           => __( 'Actualizar Claves', 'sbsmatific' ),
		'view_item'             => __( 'Ver Clave', 'sbsmatific' ),
		'view_items'            => __( 'Ver Claves', 'sbsmatific' ),
		'search_items'          => __( 'Buscar Claves', 'sbsmatific' ),
		'not_found'             => __( 'No Encontrado', 'sbsmatific' ),
		'not_found_in_trash'    => __( 'No Encontrado en Papelera', 'sbsmatific' ),
		'featured_image'        => __( 'Imagen Destacada', 'sbsmatific' ),
		'set_featured_image'    => __( 'Guardar Imagen destacada', 'sbsmatific' ),
		'remove_featured_image' => __( 'Eliminar Imagen destacada', 'sbsmatific' ),
		'use_featured_image'    => __( 'Utilizar como Imagen Destacada', 'sbsmatific' ),
		'insert_into_item'      => __( 'Insertar en Claves', 'sbsmatific' ),
		'uploaded_to_this_item' => __( 'Agregado en Claves', 'sbsmatific' ),
		'items_list'            => __( 'Lista de Claves', 'sbsmatific' ),
		'items_list_navigation' => __( 'Navegación de Claves', 'sbsmatific' ),
		'filter_items_list'     => __( 'Filtrar Claves', 'sbsmatific' ),
	);
	$args = array(
		'label'                 => __( 'Matific', 'sbsmatific' ),
		'description'           => __( 'Claves de alumnos matific', 'sbsmatific' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-media-spreadsheet',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'sbsmatific_clases', $args );

}
add_action( 'init', 'sbs_matific', 0 );

//Envia el correo al guarda el post
function enviarCorreoMatific($post_id){



	//Envio correo de bienvenida
	$resp = wp_remote_post('http://138.68.40.214/api/correoElectronico/correo/token/8hu8fWMCIhCXyq0U4TP0CMJ9waHkCGNcsrqok8zR/format/json',[

		'headers' => [
		  'Content-Type' => 'application/json',
		],
		'timeout' => 45,
		'body' => wp_json_encode([
		  'plantilla' => 'Mail-bienvenida-SBS-digital1',
		  'correoAsunto' => '¡Bienvenid@ a tu suscripción de Matific con SBS Digital!',
		  'cliente' => get_post_meta($post_id,'nombre_apoderado',true).' '.get_post_meta($post_id,'apellido_apoderado',true), 
     	  'usuarioMatific' => get_post_meta($post_id,'usuario_matific',true),  
		  'claveMatific' => get_post_meta($post_id,'clave_matific',true),
		  'correoEmail' => get_post_meta($post_id,'e-mail_apoderado',true)
		])

	  ]);
}
add_action ('save_post_sbsmatific_clases', 'enviarCorreoMatific');
