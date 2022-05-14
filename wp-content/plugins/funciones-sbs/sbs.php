<?php 
 /* 
 Plugin Name: Personalización de sbsdigital.cl 
 Plugin URI: https://sbsdigital.cl
 Description: Plugin con las funciones personalizadas para la web de sbsdigital.cl 
 Version: 1.0.0 
 Author: Pablo Frias 
 Author URI: https://sbs.cl 
 License: GPL 2+ 
 License URI: https://sbs.cl/informatica 
 */ 


//* Personalización de la página de checkout de WooCommerce
// add_action( 'after_setup_theme', 'sbs_custom_checkout_woocommmerce' );

// function sbs_custom_checkout_woocommmerce() {
 	
//     //remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
//     remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
 
    
//     //remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
//     //remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

// };

function pm_add_font_awesome() {
    wp_enqueue_style( 'pm-font-awesome', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css' );

    if(is_404()){
        wp_enqueue_script('script-error',get_template_directory_uri().'/assets/js/404-script.js',array('jquery'),'1.0',true);
    }
} 
add_action( 'wp_enqueue_scripts', 'pm_add_font_awesome' );






// add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
// function custom_override_checkout_fields( $fields ) {

//     unset($fields['billing']['billing_first_name']);
//     unset($fields['billing']['billing_last_name']);
//     unset($fields['billing']['billing_company']);
//     unset($fields['billing']['billing_address_1']);
//     unset($fields['billing']['billing_address_2']);
//     unset($fields['billing']['billing_city']);
//     unset($fields['billing']['billing_postcode']);
//     unset($fields['billing']['billing_country']);
//     unset($fields['billing']['billing_state']);
//     unset($fields['billing']['billing_phone']);
//     //unset($fields['order']['order_comments']);
//     unset($fields['billing']['billing_address_2']);
//     unset($fields['billing']['billing_postcode']);
//     unset($fields['billing']['billing_company']);
//     unset($fields['billing']['billing_last_name']);
//     unset($fields['billing']['billing_email']);
//     unset($fields['billing']['billing_city']);
//     //unset( $tabs['additional_information'] );

//     return $fields;

// }
// add_filter('woocommerce_enable_order_notes_field', '__return_false');




add_action( 'woocommerce_before_checkout_billing_form', 'texto_inicial' );
function texto_inicial() {
	echo ('
        <h4 class="titulo-carro-sbs">Completa el formulario de suscripción.</h4>
        <h3 class="title-especial">¿Eres el apoderado? completa tu registro y el del estudiante</h3>
    ');
}


//CAMPOS DEL FORMULARIO DE REGISTRO
add_action('woocommerce_before_checkout_billing_form','campos_nom_apoderado');
function campos_nom_apoderado($checkout){
    woocommerce_form_field('first_name',array(
        'type' => 'text',
        'required' => true,
        'autocomplete' => 'on',
        'class' => array('form-group','form-row-first'),
        'input_class' => array('form-control'),
        'label' => 'Nombre',
        'label_class' => array('form-label'),
    ), $checkout->get_value('first_name'));
}

add_action('woocommerce_before_checkout_billing_form','campos_apellido_apoderado');
function campos_apellido_apoderado($checkout){
    woocommerce_form_field('last_name',array(
        'type' => 'text',
        'required' => true,
        'class' => array('form-group','form-row-last'),
        'input_class' => array('form-control'),
        'label' => 'Apellidos',
        'label_class' => array('form-label'),
    ), $checkout->get_value('last_name'));
}

add_action('woocommerce_before_checkout_billing_form','campos_rut_apoderado');
function campos_rut_apoderado($checkout){
    woocommerce_form_field('billing_rut',array(
        'type' => 'text',
        'required' => true,
        'class' => array('form-group','form-row-first'),
        'input_class' => array('form-control'),
        'label' => 'Rut',
        'label_class' => array('form-label'),
    ), $checkout->get_value('billing_rut'));
}

add_action('woocommerce_before_checkout_billing_form','campos_telef_apoderado');
function campos_telef_apoderado($checkout){
    woocommerce_form_field('billing_phone',array(
        'type' => 'text',
        'required' => true,
        'class' => array('form-group','form-row-last'),
        'input_class' => array('form-control',),
        'label' => 'Telefono',
        'label_class' => array('form-label'),
    ), $checkout->get_value('billing_phone'));
}

add_action('woocommerce_before_checkout_billing_form','campos_relacion_apoderado');
function campos_relacion_apoderado($checkout){
    woocommerce_form_field('billing_rel_estudiante',array(
        'type' => 'select',
        'options' => array($checkout->get_value('billing_rel_estudiante'),'Padre','Madre','Familiar','Profesor(a)','Otro'),
        'required' => true,
        'class' => array('form-group','form-row-wide'),
        'input_class' => array('form-control'),
        'label' => 'Relacion con el estudiante',
        'label_class' => array('form-label'),
    ), $checkout->get_value('billing_rel_estudiante'));
}

add_action('woocommerce_before_checkout_billing_form','campos_email_apoderado');
function campos_email_apoderado($checkout){
    woocommerce_form_field('billing_email',array(
        'type' => 'text',
        'required' => true,
        'class' => array('form-group','form-row-wide'),
        'input_class' => array('form-control'),
        'label' => 'Email',
        'label_class' => array('form-label'),
    ), $checkout->get_value('billing_email'));
}

add_action('woocommerce_before_checkout_billing_form','campos_remail_apoderado');
function campos_remail_apoderado($checkout){
    woocommerce_form_field('billing_email',array(
        'type' => 'text',
        'required' => true,
        'class' => array('form-group','form-row-wide'),
        'input_class' => array('form-control'),
        'label' => 'Reingrese Email',
        'label_class' => array('form-label'),
    ), $checkout->get_value('billing_email'));
}

add_action('woocommerce_before_checkout_billing_form','campos_pass_cliente');
    function campos_pass_cliente($checkout){
        if(!is_user_logged_in()){
            woocommerce_form_field('passCliente',array(
                'type' => 'password',
                'required' => true,
                'autocomplete' => 'on',
                'class' => array('form-group','form-row-first'),
                'input_class' => array('form-control'),
                'label' => 'Contraseña SBS Digital',
            ), $checkout->get_value('passCliente'));
        }
    }

    add_action('woocommerce_before_checkout_billing_form','campos_repass');
    function campos_repass($checkout){
        if(!is_user_logged_in()){
            woocommerce_form_field('repass',array(
                'type' => 'password',
                'required' => true,
                'autocomplete' => 'on',
                'class' => array('form-group','form-row-last'),
                'input_class' => array('form-control'),
                'label' => 'Reingrese contraseña',
            ), $checkout->get_value('repass'));
        }
    }


//INFORMACION DEL ESTUDIANTE



    add_action( 'woocommerce_after_checkout_billing_form', 'function_woocommerce_after_checkout_billing_form' );
    function function_woocommerce_after_checkout_billing_form() {
        echo ('<br/>');
    }

    


// add_action('woocommerce_after_checkout_billing_form','campos_edad_alumno');
// function campos_edad_alumno($checkout){
//     woocommerce_form_field('edadAlumno',array(
//         'type' => 'text',
//         'required' => true,
//         'autocomplete' => 'on',
//         'class' => array('form-group','form-row-first'),
//         'input_class' => array('form-control'),
//         'label' => 'Edad',
//         'label_class' => array('form-label'),
//     ), $checkout->get_value('edadAlumno'));
// }

// add_action('woocommerce_after_checkout_billing_form','campos_curso_alumno');
// function campos_curso_alumno($checkout){
//     woocommerce_form_field('cursoAlumno',array(
//         'type' => 'select',
//         'required' => true,
//         'autocomplete' => 'on',
//         'options' => array(
//             '' => 'Seleccione curso',
//             '13' => 'Kinder',
//             '1' => '1° Basico',
//             '2' => '2° Basico',
//             '3' => '3° Basico',
//             '4' => '4° Basico',
//             '5' => '5° Basico',
//             '6' => '6° Basico',
//             '7' => '7° Basico',
//             '8' => '8° Basico',
//             '9' => 'I Medio',
//             '10' => 'II Medio',
//             '11' => 'III Medio',
//             '12' => 'IV Medio',
//         ),
//         'class' => array('form-group','form-row-last'),
//         'input_class' => array('form-control'),
//         'label' => 'Curso',
//     ), $checkout->get_value('cursoAlumno'));
// }

add_action( 'woocommerce_after_checkout_form', 'function_woocommerce_after_checkout_billing_form2' );
function function_woocommerce_after_checkout_billing_form2() {
	echo ('<div class="alert alert-warning" role="alert">
        Si deseas activar una segunda suscripción para un estudiante diferente, lo podrás realizar después de terminar esta primera suscripción a la plataforma.
  </div>');
}

add_action('woocommerce_checkout_update_order_meta','sbs_insertar_campos');
function sbs_insertar_campos($order_id){
    $idUsuario = 0;
    //Creo la cuenta del usuario
    if(!empty($_POST['billing_email']) && !empty($_POST['passCliente']) ){

        $usuario = array(
            'user_login' => sanitize_text_field($_POST['billing_email']),
            'user_pass' => sanitize_text_field($_POST['passCliente']),
            'user_email' => sanitize_text_field($_POST['billing_email']),
            'first_name' => sanitize_text_field($_POST['first_name']),
            'last_name' => sanitize_text_field($_POST['last_name'])
        );
        $idUsuario = wp_insert_user($usuario);
    }
    //Guardo los datos en Base de datos
    if($idUsuario != 0){

        //User Meta
        if(!empty($_POST['first_name'])){
            update_user_meta($idUsuario,'first_name',sanitize_text_field($_POST['first_name']));
        }
        if(!empty($_POST['last_name'])){
            update_user_meta($idUsuario,'last_name',sanitize_text_field($_POST['last_name']));
        }
        if(!empty($_POST['billing_rut'])){
            update_user_meta($idUsuario,'billing_rut',sanitize_text_field($_POST['billing_rut']));
        }
        if(!empty($_POST['billing_phone'])){
            update_user_meta($idUsuario,'billing_phone',sanitize_text_field($_POST['billing_phone']));
        }
        if(!empty($_POST['billing_rel_estudiante'])){
            update_user_meta($idUsuario,'billing_rel_estudiante',sanitize_text_field($_POST['billing_rel_estudiante']));
        }
        if(!empty($_POST['billing_email'])){
            update_user_meta($idUsuario,'billing_email',sanitize_text_field($_POST['billing_email']));
        }
    }

        //post META
        if(!empty($_POST['first_name'])){
            update_post_meta($order_id,'sbs_order_first_name',sanitize_text_field($_POST['first_name']));
        }
        if(!empty($_POST['last_name'])){
            update_post_meta($order_id,'sbs_order_last_name',sanitize_text_field($_POST['last_name']));
        }
        if(!empty($_POST['billing_rut'])){
            update_post_meta($order_id,'sbs_order_rut',sanitize_text_field($_POST['billing_rut']));
        }
        if(!empty($_POST['billing_email'])){
            update_post_meta($order_id,'sbs_order_email',sanitize_text_field($_POST['billing_email']));
        }

    

}





// /**
//  * Actualiza la información del pedido con el nuevo campo
//  */
// add_action( 'woocommerce_checkout_update_order_meta', 'actualizar_info_pedido_con_nuevo_campo' );
 
// function actualizar_info_pedido_con_nuevo_campo( $order_id ) {
//     if ( ! empty( $_POST['nif'] ) ) {
//         update_post_meta( $order_id, 'NIF', sanitize_text_field( $_POST['nif'] ) );
//     }
// }


