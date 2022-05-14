<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

<a id="login" class="woocommerce-button button woocommerce-form-login__submit"
    value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?> </a>

<link href='/sbs/public/wp-content/themes/ecademy/assets/css/calendar.css' rel='stylesheet' />
<script src='/sbs/public/wp-content/themes/ecademy/assets/js/calendar.js'></script>
<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to ecademy/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */


defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<div class="container">
    <div class="subcontainer">

        <?php do_action( 'woocommerce_edit_account_form_start' ); ?>
        <?php
	  $cliente = new WC_Customer (get_current_user_id());
	  $nomUsuario = $cliente->get_display_name();
	   $current_user = wp_get_current_user();
	   $role =  $current_user->roles[0];
	?>
        <h3>Personaliza tu perfil público</h3>
        <p class="info">
            En esta sección puedes editar la información que los apoderados verán sobre ti, así como tus horarios
            disponibles y tarifar por sesión de clases online.
        <p>
        <form action="" method="post" name="contact-me" id="updatebasic">
            <div class="row">
                <div class="col-md-6">
                    <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                        <label for="account_first_name"><?php esc_html_e( 'Nombre', 'ecademy' ); ?>&nbsp;<span
                                class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control"
                            name="account_first_name" id="account_first_name" autocomplete="given-name"
                            value="<?php echo esc_attr( $user->first_name ); ?>" />
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
                        <label for="account_last_name"><?php esc_html_e( 'Apellido', 'ecademy' ); ?>&nbsp;<span
                                class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control"
                            name="account_last_name" id="account_last_name" autocomplete="family-name"
                            value="<?php echo esc_attr( $user->last_name ); ?>" />
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label
                            for="account_display_name"><?php esc_html_e( 'Nombre de usuario', 'ecademy' ); ?>&nbsp;<span
                                class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control"
                            name="account_display_name" id="account_display_name"
                            value="<?php echo esc_attr( $user->display_name ); ?>" />
                    <p class="info" style="font-size: 10px;">
                        <em><?php esc_html_e( 'Así será como se mostrará tu nombre en la sección de cuenta y en las reseñas', 'ecademy' ); ?></em>
                    </p>
                    </p>
                    <div class="clear"></div>
                </div>
                <div class="col-md-6">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="account_email"><?php esc_html_e( 'Correo', 'ecademy' ); ?>&nbsp;<span
                                class="required">*</span></label>
                        <input type="email" class="woocommerce-Input woocommerce-Input--email input-text form-control"
                            name="account_email" id="account_email" autocomplete="email"
                            value="<?php echo esc_attr( $user->user_email ); ?>" />
                    </p>

                    <div class="clear"></div>
                </div>
                <div class="col-md-12">
                    <input type="hidden" name="id" value="<?php echo get_current_user_id(); ?>"
                        style="display: none; visibility: hidden; opacity: 0;">
                    <input type="hidden" name="action" value="update_data"
                        style="display: none; visibility: hidden; opacity: 0;">
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
                <p id="basicdata"></p>
        </form>
    </div>

    <!--formulario foto-->
    <form class="woocommerce-EditAccountForm edit-account" action="" method="post"
        <?php do_action( 'woocommerce_edit_account_form_tag' ); ?>>
        <div class="row">
            <div class="col-md-6">
                <h3><?php esc_html_e( 'Actualizar contraseña', 'ecademy' ); ?></h3>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label
                        for="password_current"><?php esc_html_e( 'Escribe tu contraseña actual', 'ecademy' ); ?></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control"
                        name="password_current" id="password_current" autocomplete="off" />
                </p>
            </div>

        </div>
        <div class="row">

            <div class="col-md-6">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password_1"><?php esc_html_e( 'Escribe tu contraseña nueva', 'ecademy' ); ?></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control"
                        name="password_1" id="password_1" autocomplete="off" />
                </p>
            </div>
            <div class="col-md-6">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password_2"><?php esc_html_e( 'Confirma tu contraseña nueva', 'ecademy' ); ?></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control"
                        name="password_2" id="password_2" autocomplete="off" />
                </p>
            </div>
        </div>
        <div class="row">
            <div class="clear"></div>
            <?php do_action( 'woocommerce_edit_account_form' ); ?>
            <p>
                <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
                <button type="submit" class="btn btn-success" name="save_account_details"
                    value="<?php esc_attr_e( 'Actualizar Contraseña', 'ecademy' ); ?>"><?php esc_html_e( 'Actualizar Contraseña', 'ecademy' ); ?></button>
                <input type="hidden" name="action" value="save_account_details" />
            </p>
        </div>
        <?php do_action( 'woocommerce_edit_account_form_end' ); ?>
        <?php if ($role=='profesor'){?>
        <div class="row">
            <div class="col-md-12">
                <h3>Actualiza tu foto de perfil</h3>
                <div class="col-md-12">
                    <p class="info"> Esta imagen aparecerá públicamente en la tienda de SBS Digital. Se pueden
                        cargar imágenes de hasta 2MB.</p>
                </div>
                <div class="col-md-6">
                    <img class="imgperfil"
                        src="<?php 	  $foto = the_field('fotografia', 'user_' . $current_user->ID); ?>" alt="" />
                </div>
            </div>
            <div class="col-md-12">
                <button type="button" class="btn btn-primary">Cargar Imagen</button>
                <button type="button" class="btn btn-success">Guardar Cambios</button>
            </div>
        </div>
        </form>
                <!--end Formulario 2-->
 
        <!--Formulario 3-->
        <form action="" method="post" id="updateform3">
            <div class="row">
                <div class="col-md-6">
                    <h3>Software educativo de tus clases</h3>
                    <label class="switch">
                        <?php  $matific = get_field('matific','user_' . $current_user->ID);  
                        if($matific){?>
                        <input name="matific" id="matific" value="1" type="checkbox" checked>
                        <?php } else {?>
                        <input  name="matific" id="matific" value="" type="checkbox" ><?php } ?>
                        <span class="slider round"></span>
                    </label>
                    <?php if($matific){?>
                        <img class="switchimg" src="../wp-content/themes/ecademy/assets/img/matific.png" />
                    <?php } else { ?>
                        <img class="switchimg" src="../wp-content/themes/ecademy/assets/img/blackmatific.png" />
                        <?php } ?>

                    <label class="switch">
                    <?php  $glifting = get_field('glifting','user_' . $current_user->ID);
                    if($glifting){?>
                        <input id="glifting"  name="glifting" value="1" type="checkbox" checked>
                        <?php }else {?>
                        <input id="glifting" name="glifting" value="" type="checkbox" ><?php } ?>
                        <span class="slider round"></span>
                    </label>
                    <?php if($glifting){?>
                    <img class="switchimg" src="../wp-content/themes/ecademy/assets/img/glifing.png" />
                    <?php } else { ?>
                    <img class="switchimg" src="../wp-content/themes/ecademy/assets/img/blackglifing.png" />
                        <?php } ?>
                    <p class="info small">Si quieres agregar una plataforma adicional, haz clic aquí</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Descripción</h3>
                    <textarea class="woocommerce-Input woocommerce-Input--email input-text form-control" name="descripcion" id=""
                        cols="100" rows="5"> <?php
    $field = the_field('descripcion', 'user_' . $current_user->ID);
    echo $field;
    ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Experiencia de trabajo</h3>
                    <textarea class="woocommerce-Input woocommerce-Input--email input-text form-control" name="experiencia" id=""
                        cols="100" rows="5">
    <?php
    $field = the_field('experiencia', 'user_' . $current_user->ID);
    echo $experiencia;
    ?>
    </textarea>
                    <p class="orange-alert"> <i class='fas fa-exclamation-circle'></i>
                        Este campo no ha sido aprobado por SBS, si tienes dudas contactanos aquí
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Estudios</h3>
                </div>
                <textarea class="woocommerce-Input woocommerce-Input--email input-text form-control" name="estudios" id=""
                    cols="100" rows="5">
    <?php
    $field = the_field('estudios', 'user_' . $current_user->ID);
    ?>
    </textarea>
            </div>
 
            <input type="hidden" name="id" value="<?php echo get_current_user_id(); ?>"
                style="display: none; visibility: hidden; opacity: 0;">
            <input type="hidden" name="action" value="update_form3"
                style="display: none; visibility: hidden; opacity: 0;">
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <p id="basicdataform3"></p>
        </form>
        <!---->





<!-- Form 4 -->
<form action="" method="post" id="updateform4">
        <div class="row">
            <div class="col-md-6" >
                <h3>¿En qué asignaturas te especializas?</h3>
                <div class="col-md-6">
<?php $allCheckbox = get_field('asignaturas','user_' . $current_user->ID); //Checked value from backen
$field_key = "field_625f741a4c5c5"; //Get value using key ?>
 <input type="hidden" name="field_especializa" value="<?php echo $field_key ?>"
 style="display: none; visibility: hidden; opacity: 0;">
<?php
$field = get_field_object($field_key);
foreach($field['choices'] as $lab => $val){
 
    if(in_array($lab, $allCheckbox)){
        $checked = 'checked = "checked"';   
        $enable = ''; 
        $value = 'True' ;
    } else {
        $checked = '';
        $enable = '';
        $value = 'False';
    }?>
     <input type="checkbox" id="<?php echo $val; ?>" name="<?php echo $field_key.'_'.$val; ?>" value="<?php echo $value; ?>"  <?php echo $enable; ?> <?php echo $checked; ?>>
    <label for="<?php echo $val; ?>"> <?php echo $lab; ?></label><br>

<?php } ?>


</div>
            </div>
            <div class="col-md-6">
                <h3>Tu dominio en idiomas</h3>
                <div class="row">
                <div class="col-md-6" style="columns: 2;">
                <?php $allCheckbox = get_field('idiomas','user_' . $current_user->ID); //Checked value from backend 
                $field_key = "field_625f747a3f0e2"; //Get value using key                ?>
              
                <input type="hidden" name="field_idioma" value="<?php echo $field_key ?>"
                style="display: none; visibility: hidden; opacity: 0;">
<?php

$field = get_field_object($field_key);
foreach($field['choices'] as $lab => $val){
 
    if(in_array($lab, $allCheckbox)){
        $checked = 'checked = "checked"';   
        $enable = '';       
    } else {
        $checked = '';
        $enable = '';
    }?>
     <input type="checkbox" id="<?php echo $val; ?>" name="<?php echo $val; ?>" value="<?php echo $val; ?>"  <?php echo $enable; ?> <?php echo $checked; ?>>
    <label for="<?php echo $val; ?>"> <?php echo $lab; ?></label><br>

<?php } ?>
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>¿En qué niveles puedes impartir clases?</h3>
            </div>
            <div class="col-md-12" style="columns: 3;">
            <?php $allCheckbox = get_field('niveles','user_' . $current_user->ID); //Checked value from backend
            $field_key = "field_625f74d9b692c"; //Get value using key ?>

            <input type="hidden" name="field_nivel" value="<?php echo $field_key ?>"
            style="display: none; visibility: hidden; opacity: 0;">
            <?php
$field = get_field_object($field_key);
foreach($field['choices'] as $lab => $val){
 
    if(in_array($lab, $allCheckbox)){
        $checked = 'checked = "checked"';   
        $enable = '';       
    } else {
        $checked = '';
        $enable = '';
    }?>
     <input type="checkbox" id="<?php echo $val; ?>" name="<?php echo $val; ?>" value="<?php echo $val; ?>"  <?php echo $enable; ?> <?php echo $checked; ?>>
    <label for="<?php echo $val; ?>"> <?php echo $lab; ?></label><br>

<?php } ?>
                
            </div>
            <div class="col-md-3">
               
            </div>
            <div class="col-md-3">
               
            </div>
            <input type="hidden" name="id" value="<?php echo get_current_user_id(); ?>"
                style="display: none; visibility: hidden; opacity: 0;">
            <input type="hidden" name="action" value="update_form4"
                style="display: none; visibility: hidden; opacity: 0;">
                <p id="basicdataform4"></p>

        </div>
        <div class="row">
            
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
        </div>
</form> 
<!-- End Form 4 -->

        <h3>Define la tarifa para tus sesiones de clases</h3>
        <!--formulario 5-->
<form action="" method="post" id="updateform5">
        <div class="row">
            <div class="col-md-6 ">
                <div class="info-blue">
                    <p class="blue"><strong>1er tramo:</strong> Hasta $19.990 por hora.</p>

                    <p class="blue"><strong>2do tramo:</strong> Entre $19.000 y $22.990 por hora.</p>

                    <p class="blue"><strong>3er tramo:</strong> Más de $30.000 por hora.</p>
                </div>
            </div>


            <div class="col-md-6">
                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                    <label
                        for="account_first_name"><?php esc_html_e( '	Tu tarifa líquida por hora:', 'ecademy' ); ?>&nbsp;<span
                            class="required">*</span></label>

                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control"
                        name="tarifa" id="account_first_name" autocomplete="given-name"
                        value="<?php echo  $field = the_field('tarifa', 'user_' . $current_user->ID);?>" />
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                    <label
                        for="account_first_name"><?php esc_html_e( 'Tu tarifa para el usuario publicada en la tienda', 'ecademy' ); ?>&nbsp;<span
                            class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control"
                        name="tarifapublico" id="account_first_name" autocomplete="given-name"
                        value="<?php echo  $field = the_field('tarifapublico', 'user_' . $current_user->ID);?>" disabled />
                </p>
            </div>
            
            <input type="hidden" name="id" value="<?php echo get_current_user_id(); ?>"
                style="display: none; visibility: hidden; opacity: 0;">
            <input type="hidden" name="action" value="update_form5"
                style="display: none; visibility: hidden; opacity: 0;">
          

            <div>
                <div class="col-md-12">
                    <p class="info">La tarifa para el usuario incluye el costo de los honorarios del docente, así
                        como el 20% de comisión por hora de SBS Digital.</p>
                    <p class="red-alert"> <i class='fas fa-exclamation-circle'></i>Debes completar esta campo para
                        poder publicar tu perfil.</p>
                        <button type="submit" class="btn btn-success">Confirmar tarifa</button>
            <p id="basicdataform5"></p>
        </form>

        
<!--end formulario 5-->                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Configura tu agenda disponible</h3>
                <p class="info">Selecciona los días y tramos horarios que tendrás disponibles para tus sesiones de
                    clases online en SBS Digital.
                    Recuerda que los usuarios podrán agendar sesiones de clases en los horarios que fijes
                    disponibles. </p>
                <div id='calendar'></div>

                <button type="button" class="btn btn-success">Guardar Cambios</button>
            </div>


        </div>
        <?php } ?>

    </form>

    <?php do_action( 'woocommerce_after_edit_account_form' ); ?>


</div>
</div>

<script>
  $(document).ready(function() {
  //set initial state.
  $('#matific').val($(this).is(':checked'));

  $('#matific').change(function() {
    $('#matific').val($(this).is(':checked'));
  });
  $('#glifting').val($(this).is(':checked'));

$('#glifting').change(function() {
  $('#glifting').val($(this).is(':checked'));
});

//   $('#matific').click(function() {
//     if (!$(this).is(':checked')) {
//       return confirm("Are you sure?");
//     }
//   });
});
</script>