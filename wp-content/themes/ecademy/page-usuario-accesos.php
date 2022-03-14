<?php get_header(); ?> 

<?php if(is_user_logged_in()){ ?>

<?php
    global $wpdb;
    $cliente = new WC_Customer (get_current_user_id());
    $nomUsuario = $cliente->get_display_name();

    $metas = $wpdb->get_results( 
        $wpdb->prepare("SELECT post_id FROM wp_postmeta where meta_key = 'e-mail_apoderado' AND meta_value = '".$cliente->data['email']."' ")
    );
?>

<div class="container">
    <div class="configuracion">
        <div class="row">
            <div class="col-md-3">
                <div class="btn-volver">
                <i class="fa fa-caret-left"></i> <a href="https://sbsdigital.cl/usuario/"> Volver a página de usuario</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?php get_template_part( 'template-parts/menu-sbs' ); ?>
            </div>
            <div class="col-md  9">
                <div class="row">
                <div class="contenido-usuario">

                    <?php if(empty($metas)) { ?>
                    <p>Aquí encontrarás la información para acceder a tu pagina de usuario en SBS Digital, así como las plataformas suscritas. </p>
                    <div class="cuadro-linea-abajo">
                        <h5 class="azul">Estamos generando tu contraseña, la cúal sera enviada durante las próximas 24Hrs hábiles a tu mail. Si luego la olvidas puedes volver a esta página a buscarla</h5>
                    </div>
                    <?php } else { ?>
                        
                    
                    <div class="cuadro-linea-abajo">
                        <h5>Accesos Matific</h5>
                        
                        <?php foreach($metas as $met){  ?>
                            
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Usuario</label>
                                <input type="email" class="form-control" id="inputEmail4" value="<?php echo get_post_meta($met->post_id,'usuario_matific',true); ?>" readonly >
                            </div>
                        
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Contraseña</label>
                                <input type="text" class="form-control" id="inputEmail4" value="<?php echo get_post_meta($met->post_id,'clave_matific',true); ?>" readonly>
                            </div>
                            <a href="https://www.matific.com/cl/es-ar/login-page/" target="_blank" type="button" class="btn btn-primary btn-lg btn-block" style="background-color:#FC6D72; text-transform: none;">Ir a Matific</a>
                        </div>
                        <?php } ?>

                        
                    </div>

                   
                   <?php } ?>

                </div>

                </div>
               

            </div>
        </div>
    </div>
</div>

<?php }else{ 
    wp_redirect('https://sbsdigital.cl/user-login/');
} ?>


<?php get_footer(); ?>