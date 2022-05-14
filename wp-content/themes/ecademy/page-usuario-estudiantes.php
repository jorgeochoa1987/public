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
    <div class="subcontainer">
        <div class="row">
            <div class="col-md-12">
                 <h3>Estas viendo los estudiantes asociados tu cuenta</h3>
            </div>
        </div>
        <div class="row">

        <?php  
        $table_name = $wpdb->prefix.'estudiantes';
        $schools = $wpdb->get_results($wpdb->prepare("SELECT id,nombre,edad,curso,apellido,tutor from $table_name where tutor=%s ", $cliente->id));
        foreach ($schools as $s) { 
            $name = $s->nombre;
            $last = $s->apellido;
            $old = $s->edad;
            $course = $s->curso;
            $tutor = $s->tutor;
            $count ++;
       ?>
<div class="col-md-3">
    <label class="card">
        <input name="plan" class="radio" type="radio" checked>
        <span class="plan-details">
        <span class="plan-cost color-<?php echo $count;?>"><?php echo $count;?></span>
        <span class="tinombre">Estudiante <?php echo $count;?></span>
        <span class="nombre"><?php echo $name.' '.$last;  ?></span>
        </span>
    </label>
</div>
<?php }?>  
<div class="col-md-3"> 
    <label class="card">
        <input name="plan" class="radio" type="radio" checked>
        <span class="plan-details blue">
        <span class="plan-cost color-4"><i class="fas fa-user-plus white" style="font-size: 58px;"></i></span>
        <a href="" data-toggle="modal" data-target="#modalSoporte">
 <span class="tinombre boxwhite">Agregar nuevo estudiante</span> </a>
        </span>
    </label>
</div>

        </div>
    <div>
</div>
<div class="configuracion">
        <div class="row">

        

        </div>
    </div>
</div>

<?php }else{ 
    wp_redirect('https://sbsdigital.cl/user-login/');
} ?>


<?php get_footer(); ?>




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
                    <h5 class="modal-title azul" id="exampleModalLabel">Agregar nuevo estudiante
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
                        <label for="exampleInputEmail1">Nombre de estudiante<span class="text-danger">*</span></label>
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
                        <label for="exampleInputEmail1">Apellido<span class="text-danger">*</span></label>
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
                        <label for="exampleInputEmail1">Curso<span class="text-danger">*</span></label>
                        <input
                            type="email"
                            class="form-control"
                            id="mailContacto"
                            name="txtMailContacto"
                            aria-describedby="emailHelp"
                            placeholder="Escribe tu correo aquí"
                            required="required">

                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="buttonclose">Crear Estudiante</button>
                      

                    </div>

                </form>
            </div>

        </div>
    </div>
</div>