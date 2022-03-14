<?php
// const API_ENDPOINT = 'https://api.ventipay.com/v1';
// global $woocommerce;


// $create_suscription = wp_remote_post(
//     API_ENDPOINT . '/subscriptions',
//     [
//       'headers' => [
//         'Authorization' => 'Basic ' . base64_encode('key_test_yru8qJPlQbLGyxIP5KFssp6bHoWQlz6RfoVCCme4j36AV4Vf4JCn5G0VapxNAhLY' . ':'),
//         'Content-Type' => 'application/json',
//       ],
//       'timeout' => 45,
//       'data_format' => 'body',
//       'body' => wp_json_encode([
//         'default_products' => array(
//           [
//             'id' => 'prod_mnSWJHOAluU2hHB2xcgL9Ee6',
//             'quantity' => 1
//           ],
//         ),
//         'billing_cycle_anchor' => 'now',
//         'currency' => 'CLP',
//         'interval'=>'1month',//Modificar segun producto
//         'name' => 'Suscripcion de prueba', //Colocar nombre de producto
//         'proration_behavior'=>'create_prorations',
//         'customer_email'=>'pablo.frias.c@gmail.com', //Colocar el correo del usuario activo
//         'cancel_url' => $return_url,
//         'cancel_url_method' => 'post',
//         'success_url' => $return_url, 
//         'success_url_method' => 'post',
//         'notification_url' => $notification_url,
//         'notification_events' => ['loan_intent.approved', 'loan_intent.rejected', 'loan_intent.canceled'],
//         'metadata' => [
//           'wp_order_id' => $order_id,
//         ],
//       ])
//     ]
//   );

//   $new_suscription = json_decode(wp_remote_retrieve_body($create_suscription));

//   echo '<pre>';
//   print_r($new_suscription);

$userMail = get_post_meta(5210,'sbs_order_email',true);
$order = wc_get_order(5214);
$usuario = get_user_by('login','pablo.frias@trestec.cl');

echo '<pre>';
var_dump($usuario->ID);