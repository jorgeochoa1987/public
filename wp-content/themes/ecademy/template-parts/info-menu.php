<?php get_header(); ?>  



<?php if(is_user_logged_in()){ ?>


<?php
   $cliente = new WC_Customer (get_current_user_id());
   $nomUsuario = $cliente->get_display_name();
?>
<div class="container">
    <div class="usuario">
 <div class="row">
            <div class="col-md-3">
            <div class="iconos">
                    <a href="" data-toggle="modal" data-target="#modalSoporte">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/mensajes.png" alt="">
                        <p class="texto-iconos">MENSAJES</p>
                        <p class="subtexto-iconos"> Contacta con tu profesor</p>


                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="iconos">
                    <a href="" data-toggle="modal" data-target="#modalSoporte">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/soporte.png" alt="">
                        <p class="texto-iconos">SOPORTE</p>
                        <p class="subtexto-iconos">Contacta con soporte
de SBS Digital</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="iconos">
                    <a href="<?php echo get_site_url(); ?>/user-login/">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/configuraciones.png" alt="">
                        <p class="texto-iconos">CONFIGURACIÓN</p>
                        <p class="subtexto-iconos"> Configura tu perfil</p>

                    </a>
                </div>
            </div>
            <div class="col-md-3">
            <div class="iconos">
                    <a href="<?php echo get_site_url(); ?>/agenda" >
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/estudiantes.png" alt="">
                        <p class="texto-iconos">ESTUDIANTES</p>
                        <p class="subtexto-iconos">Revisa los estudiantes
asociados a tu cuenta</p>

                    </a>
                </div>
            </div>
        </div>   
    </div>
</div>

<!-- modal de contacto -->
<div class="modal fade" id="modalSoporte" tabindex="-3" role="dialog" aria-labelledby="modalSoporte" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 30px;" >
      <div class="modal-header">
        
        <div>  
            <br><br>
            <h5 class="modal-title azul" id="exampleModalLabel">Cuéntanos en qué te podemos ayudar y pronto nos pondremos en contacto: </h5>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        
      </div>
      <div class="modal-body">
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <input type="hidden" name="action" value="soporte">
            <input type="hidden" name="nomCliente" value="<?php echo $cliente->get_first_name(); ?>">
            <input type="hidden" name="apellCliente" value="<?php echo $cliente->get_last_name(); ?>">
            

        <div class="form-group">
            <label for="exampleInputEmail1">Motivo de tu mensaje<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="txtMotivo" name="txtMotivo" aria-describedby="emailHelp" placeholder="Ingrese un motivo" required>
           
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Mail de contacto<span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="mailContacto" name="txtMailContacto" aria-describedby="emailHelp" placeholder="Escribe tu correo aquí" required>
           
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Deja tu mensaje<span class="text-danger">*</span></label>
            <textarea class="form-control" id="mensaje" name="txtMensaje" rows="3" ></textarea>
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
