<?php get_header(); ?>

<?php if(is_user_logged_in()){ ?>

<?php
$url = get_page_uri();
   $cliente = new WC_Customer (get_current_user_id());
   $nomUsuario = $cliente->get_display_name();
   $current_user = wp_get_current_user(); 
   $role =  $current_user->roles[0]; 

?>
<div class="container">
    <div class="subcontainer">
        <div class="row">
            <div class="col-md-12"></div>
        </div>
        <div class="usuario">
        <?php if(isset($_GET['exito'])){ ?>
        <div class="alert alert-success" role="alert">
            Tu solicitud fue enviada correctamente nos pondremos en contacto.
        </div>
        <?php } ?>
        <?php if(isset($_GET['error'])){ ?>
        <div class="alert alert-danger" role="alert">
            Todos los campos del formulario son obligatorios
        </div>
        <?php } ?>
        <h3>¡Bienvenido(a)
            <?php echo $nomUsuario; ?>!, esta es tu página de usuario.</h3>
          <?php if($role=="profesor"){?>
            <div class="cuadro-info">
                <div class="row">
                    <div class="col-md-7">
                    <h4 class="titulo-azul">Estado de publicación en la tienda online de SBS Digital</h4>
                    </div>
                    <div class="col-md-5"><h4 class="titulo-azul">Publicado</div></div>
                    <div class="col-md-12">
                        <ul class="lista-guion">
                            <li><strong class="lista Aprobado"> Aprobado  <i class="fas fa-check"></i> </strong> Personalización del perfil público (descripción, currículum, foto de perfil) </li>
                            <li><strong class="lista revisar"> Revisar  <i class='fa fa-exclamation'></i></strong> Cuenta bancaria para  pagos</li>
                            <li><strong class="lista Aprobado">Aprobado <i class="fas fa-check"></i></strong>  Plataforma a enseñar (Glifing o Matific)</li>
                            <li><strong class="lista revision"> En revisión <i class="fas fa-clock"></i></strong> Valor por hora de clases online</li>
                            <li><strong class="lista Aprobado"> Aprobado <i class="fas fa-check"></i></strong>  Definición de agenda disponible</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">  
                        <a href="">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/listaestudiantes.png"alt="">
                        </a>
                </div>
                <div class="col-md-6"> 
                         <a href="">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/agendaprofesor.png"alt="">
                        </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h4 class="titulo-azul">Software educativo</h4>
                </div>
                <div class="col-md-6">  
                        <a href="">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/irglif.png"alt="">
                        </a>
                </div>
                <div class="col-md-6"> 
                         <a href="">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/irmat.png"alt="">
                        </a>
                </div>
            </div>

       <?php  }else {?>  
        <div class="cuadro-info">
            <h4 class="titulo-azul">Tus Notificaciones
            </h4>
            <p class="negrita">¿Cómo empezar a estudiar con tu suscripción?</p>
            <ul class="lista-guion">
                <li>- Entra a la sección agenda y planifica las próximas sesiones de clases del
                    estudiante.</li>
                <li>- Ingresa al sitio web de la plataforma que te suscribiste.
                </li>
                <li>- Inicia sesión con los accesos que enviamos a tu correo electrónico.</li>
                <li>- Podrás comenzar una ruta de estudio o continuar la que empezaste.</li>
                <li>- Si olvidas tus accesos o quieres acceder a las plataformas, siempre puedes
                    regresar a esta página</li>
            </ul>
        </div>
      
        <hr>
        <div class="cuadro-cursos">
            <h4 class="titulo-azul">Tus Suscripciones</h4>
<?php  
            $user_id =get_current_user_id();
            $args = array( 'customer_id' => $user_id);
            $orders = wc_get_orders($args);
            foreach ( $orders as $orderchild ) {
            // echo $ido = $orderchild->id.'<br>';
            $order_data = $orderchild->get_data(); // The Order data
            $order_id = $order_data['id'];
            $order_currency = $order_data['currency'];
            $order_status = $order_data['status'];    
            foreach ($orderchild->get_items() as $key => $lineItem) {
            $product_id = $lineItem['product_id'];
            $product = wc_get_product( $product_id );
            $name = $lineItem->get_name(); 
            $image = wp_get_attachment_image_src( get_post_thumbnail_id(  $product_id ), 'single-post-thumbnail' );
            if ($image[0]==''){$image[0]="http://localhost:8888/sbs/public/wp-content/uploads/2021/07/placeholder.png";}          
            ?>
            <div class="imagen">
            <a href="<?php if($name=='Agenda y Aula Clases on line') { echo 'http://localhost:8888/sbs/public/agenda/'; }else { echo 'https://www.matific.com/cl/es-ar/login-page/';} ?>" target="_blank">
            <img src="<?php echo $image[0]; ?>" data-id="<?php echo $id; ?>"/> </a>
            </div><?php } } ?> 
            </div>
            <div class="info">
                <a href="./usuario-store/" target="_blank">
                <img src=" http://localhost:8888/sbs/public/wp-content/uploads/2022/04/ir-a-la-tienda.png"/>
                </a>
            </div>
<?php }?>


<div class="row">
<div class="col-md-12">
<div class="info-azul">
<p class="texto-blanco">
<strong>RECUERDA:
</strong>Para iniciar sesión en la plataforma debes usar las credenciales (mail,
contraseña) que enviamos a tu correo electrónico.
</p>
</div> 
</div>
</div>   
        <?php if($role=="profesor"){?>
        <div class="row">
            <div class="col-md-3">
                <div class="iconos">
                    <a href="" data-toggle="modal" data-target="#modalSoporte">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/mensajes.png" alt="">
                        <p class="texto-iconos">MENSAJES</p>
                        <p class="subtexto-iconos">Contacta con tus alumnos</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="iconos">
                    <a href="" data-toggle="modal" data-target="#modalSoporte">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/soporte.png" alt="">
                        <p class="texto-iconos">SOPORTE</p>
                        <p class="subtexto-iconos">Contacta con soporte de SBS Digital</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="iconos">
                    <a href="<?php echo get_site_url(); ?>/usuario-editar/">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/configuraciones.png"alt="">
                        <p class="texto-iconos">CONFIGURACIÓN</p>
                        <p class="subtexto-iconos">Configura tu cuenta</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="iconos">
                    <a href="<?php echo get_site_url(); ?>/agenda">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/estudiantes.png"alt="">
                        <p class="texto-iconos">EDITAR PERFIL</p>
                        <p class="subtexto-iconos">Configura tu perfil de profesor</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="iconos">
                    <a href="<?php echo get_site_url(); ?>/agenda">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/estudiantes.png"alt="">
                        <p class="texto-iconos">PAGOS Y CUENTA BANCARIA</p>
                        <p class="subtexto-iconos"></p>
                    </a>
                </div>
            </div>
        </div>
       
        <?php }else {?>
            <div class="row">
            <div class="col-md-3">
                <div class="iconos">
                    <a href="" data-toggle="modal" data-target="#modalSoporte">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/mensajes.png" alt="">
                        <p class="texto-iconos">MENSAJES</p>
                        <p class="subtexto-iconos">Contacta con tu profesor</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="iconos">
                    <a href="" data-toggle="modal" data-target="#modalSoporte">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/soporte.png" alt="">
                        <p class="texto-iconos">SOPORTE</p>
                        <p class="subtexto-iconos">Contacta con soporte de SBS Digital</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="iconos">
                    <a href="<?php echo get_site_url(); ?>/usuario-editar/">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/configuraciones.png"alt="">
                        <p class="texto-iconos">CONFIGURACIÓN</p>
                        <p class="subtexto-iconos">Configura tu perfil</p>
                    </a>
                </div> 
            </div>
            <div class="col-md-3">
                <div class="iconos">
                    <a href="<?php echo get_site_url(); ?>/usuario-estudiantes/"> 
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/estudiantes.png"alt="">
                        <p class="texto-iconos">ESTUDIANTES</p>
                        <p class="subtexto-iconos">Revisa los estudiantes asociados a tu cuenta</p>

                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <div class="herramientas">
            <p class="herramientas-titulo">Esta es tu página de usuario de SBS Digital. Siempre podrás regresar aquí para:</p>
            <div class="row">
                <div class="herramientas-interno col-md-4">

                    <div class="herramientas-detalle">
                        <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-acceso.svg" alt=""class="img-iconos">
                            <p>Acceder a las plataformas educativas con tu hijo</p>
                        </a>
                    </div>
                </div>
                <div class="herramientas-interno col-md-4">
                    <div class="herramientas-detalle">
                        <a href="https://sbsdigital.cl/usuario-suscripciones/">
                            <img
                                src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-modificar.svg"
                                alt=""
                                class="img-iconos">
                            <p>Modificar suscripción y métodos de pago</p>
                        </a>
                    </div>
                </div>
                <div class="herramientas-interno col-md-4">
                    <div class="herramientas-detalle">
                        <a href="http://localhost:8888/sbs/public/usuario-estudiantes/">
                            <img
                                src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-inscribir.svg"
                                alt=""
                                class="img-iconos">
                            <p>Suscribir más estudiantes a tu cuenta</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="herramientas-interno col-md-4">
                    <div class="herramientas-detalle">
                        <a href="" data-toggle="modal" data-target="#modalSoporte">
                            <img
                                src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-soporte2.svg"
                                alt=""
                                class="img-iconos">
                            <p>Acceder a soporte al usuario</p>
                        </a>
                    </div>
                </div>
                <div class="herramientas-interno col-md-4">
                    <div class="herramientas-detalle">
                        <a href="https://sbsdigital.cl/usuario-accesos/">
                            <img
                                src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-contraseña.svg"
                                alt=""
                                class="img-iconos">
                            <p>Recuperar tu contraseña o recuperar accesos a plataformas</p>
                        </a>
                    </div>
                </div>
                <div class="herramientas-interno col-md-4">
                    <div class="herramientas-detalle">
                        <a href="">
                            <img
                                src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-plataformas.svg"
                                alt=""
                                class="img-iconos">
                            <p>Conocer nuevas plataformas educativas</p>
                        </a>
                    </div>
                </div> 
            </div>

        </div>
            </div>
        </div>
        <?php }?>

       
    </div>
    </div>
</div>


<!-- modal de contacto -->
<div
    class="modal fade"
    id="modalSoporte"
    tabindex="-3"
    role="dialog"
    aria-labelledby="modalSoporte"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 30px;">
            <div class="modal-header">

                <div>
                    <br><br>
                    <h5 class="modal-title azul" id="exampleModalLabel">Cuéntanos en qué te podemos ayudar y pronto nos pondremos en contacto:
                    </h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <form
                    action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
                    method="post">
                    <input type="hidden" name="action" value="soporte">
                    <input
                        type="hidden"
                        name="nomCliente"
                        value="<?php echo $cliente->get_first_name(); ?>">
                    <input
                        type="hidden"
                        name="apellCliente"
                        value="<?php echo $cliente->get_last_name(); ?>">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Motivo de tu mensaje<span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control"
                            id="txtMotivo"
                            name="txtMotivo"
                            aria-describedby="emailHelp"
                            placeholder="Ingrese un motivo"
                            required="required">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mail de contacto<span class="text-danger">*</span></label>
                        <input
                            type="email"
                            class="form-control"
                            id="mailContacto"
                            name="txtMailContacto"
                            aria-describedby="emailHelp"
                            placeholder="Escribe tu correo aquí"
                            required="required">

                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Deja tu mensaje<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="mensaje" name="txtMensaje" rows="3"></textarea>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary especial">Enviar</button>
                        <div class="form-group text-center">
                            <small class="text-danger" id="msjValCont">*Por favor completa todos los campos</small>
                        </div>

                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<?php  }else{ 
    wp_redirect('https://sbsdigital.cl/user-login/');
} ?>

<?php get_footer(); ?>