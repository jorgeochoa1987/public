<?php
function capturar_form_soporte(){
 
    //Capturar las variables
    $nombre = sanitize_text_field($_POST['nomCliente']) ;
    $apellido = sanitize_text_field($_POST['apellCliente']);
    $motivo = sanitize_text_field($_POST['txtMotivo']);
    $email = sanitize_text_field($_POST['txtMailContacto']);
    $mensaje = sanitize_text_field($_POST['txtMensaje']);

    if($motivo == '' || $email == '' || $mensaje == ''){

        wp_redirect(add_query_arg(array('error' => '1'),get_home_url().'/usuario'));exit;
    }

    $msj = 'Nombre: '.$nombre.'<br>';
    $msj .= 'Apellido: '.$apellido.'<br>';
    $msj .= 'Motivo: '.$motivo.'<br>';
    $msj .= 'email: '.$email.'<br>';
    $msj .= 'Mensaje: '.$mensaje.'<br>';

    wp_mail('pfrias@sbs.cl','Formulario Soporte Web Matific',$msj);

    wp_redirect(add_query_arg(array('exito' => '1'),get_home_url().'/usuario'));exit;


}
add_action('admin_post_soporte','capturar_form_soporte');
// add_action('admin_post_nopriv_soporte','capturar_form_soporte'); //Usar en caso de necesitar formulario no logueado

function baja_suscripcion_ventipay(){
    //Capturar las variables
    $idSuscripcion = $_POST['idSuscripcion'];
    $txtMensaje = sanitize_text_field($_POST['txtMensaje']);
    $numOrden = sanitize_text_field($_POST['numOrden']);
    $recibeBaja = wp_remote_post('https://api.ventipay.com/v1/subscriptions/'.$idSuscripcion.'/end',[
        'headers' => [
            'Authorization' => 'Basic ' . base64_encode('key_live_9wIGa3q7ZGKe6SpjTaAHTPdtbOl4LvlBnEQnvIJoy2NTWY1wsLxsTlWkJJxiECrP' . ':'),
            'Content-Type' => 'application/json',
        ],
        'timeout' => 45,
        ]
    );
    if(!empty($recibeBaja)){
        $baja = json_decode(wp_remote_retrieve_body($recibeBaja));
        //Guardo en metadata la baja
        update_post_meta($numOrden,'baja_ventipay','cancelado');
        update_post_meta($numOrden,'fecha_baja_ventipay',date('d-m-Y'));
        wp_redirect(add_query_arg(array('exito' => '1'),get_home_url().'/usuario-suscripciones'));exit;
    }else{
        wp_redirect(add_query_arg(array('exito' => '0'),get_home_url().'/usuario-suscripciones'));exit;
    }
}
add_action('admin_post_bajaventy','baja_suscripcion_ventipay');


function actualiza_suscripcion_ventipay(){
    $idSuscripcion = $_POST['idSuscripcion'];
    $intervalo = sanitize_text_field($_POST['plan']);
    $response = wp_remote_request('https://api.ventipay.com/v1/subscriptions/'.$idSuscripcion,[
        'headers' => [
            'Authorization' => 'Basic ' . base64_encode('key_live_9wIGa3q7ZGKe6SpjTaAHTPdtbOl4LvlBnEQnvIJoy2NTWY1wsLxsTlWkJJxiECrP' . ':'),
            'Content-Type' => 'application/json',
        ],
        'method' => 'PUT',
        'timeout' => 45,
        'data_format' => 'body',
        'body' => wp_json_encode([
            'interval' => $intervalo,
        ])
    ]);
    $upd = json_decode(wp_remote_retrieve_body($response));
    wp_redirect(add_query_arg(array('exito' => '2'),get_home_url().'/usuario-suscripciones'));exit;
}
add_action('admin_post_updateventy','actualiza_suscripcion_ventipay');


function actualizar_usuario(){
    //capturo las variables
    if(isset($_POST['email'])){
        $email = sanitize_text_field($_POST['email']);
    }
    if(isset($_POST['pass'])){
        $pass = sanitize_text_field($_POST['pass']);
    }
    if(!empty($email)){
        $datos = array(
            'ID' => get_current_user_id(),
            'user_login' => $email,
            'user_email' => $email
        );
    }else{
        $datos = array(
            'ID' => get_current_user_id(),
            'user_pass' => $pass
        );
    }
    $resp = wp_update_user($datos);
    if(is_wp_error( $resp )){
        wp_redirect(add_query_arg(array('exito' => '0'),get_home_url().'/usuario-seguridad'));exit;
    }else{
        wp_redirect(add_query_arg(array('exito' => '1'),get_home_url().'/usuario-seguridad'));exit;
    }
}
add_action('admin_post_updusuario','actualizar_usuario');