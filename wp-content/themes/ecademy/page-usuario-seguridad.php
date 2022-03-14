<?php get_header(); ?> 

<?php if(is_user_logged_in()){ ?>

<?php
    $cliente = new WC_Customer (get_current_user_id());
    $nomUsuario = $cliente->get_display_name();
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
                    <p>Aquí puedes cambiar tus credenciales de acceso a tu Página de Usuario en SBS Digital </p>
                    
                    <?php if(isset($_GET['exito']) && $_GET['exito'] == 1){ ?>
        <div class="alert alert-success" role="alert">
            ¡Tu Contraseña fue cambiada exitosamente!
        </div>
        <?php } ?>
                        
                    
                    
                    
                    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                        <input type="hidden" name="action" value="updusuario">
                        <div class="cuadro-linea-abajo">
                            <h5>Cambiar Correo Página de Usuario SBS Digital</h5>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ingresa tu correo actual</label>
                                <input type="email" class="form-control" name="emailActual" id="emailActual" aria-describedby="emailHelp" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ingresa tu nuevo correo</label>
                                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Confirma tu nuevo correo</label>
                                <input type="email" class="form-control" name="remail" id="remail" aria-describedby="emailHelp" >
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block" style="background-color:#FC6D72">Actualizar correo</button>
                        </div>
                    </form>
                    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                        <input type="hidden" name="action" value="updusuario">
                        <div class="cuadro-linea-abajo">
                            <h5>Cambiar contraseña</h5>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ingresa tu contraseña actual</label>
                                <input type="password" class="form-control" name="passActual" id="passActual" aria-describedby="emailHelp" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ingresa tu nueva contraseña</label>
                                <input type="password" class="form-control" name="pass" id="pass" aria-describedby="emailHelp" >
                                <small class="form-text text-danger" >* Mínimo 5 caracteres</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Confirma tu nueva contraseña</label>
                                <input type="password" class="form-control" name="repass" id="repass" aria-describedby="emailHelp" >
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block" style="background-color:#FC6D72">Actualizar contraseña</button>
                        </div>
                    </form>
                   

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