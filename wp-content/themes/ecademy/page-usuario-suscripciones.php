<?php get_header(); ?> 


<?php if(is_user_logged_in()){ ?>


<?php
    $cliente = new WC_Customer (get_current_user_id());
    $nomUsuario = $cliente->get_display_name();
    $customerId = get_user_meta(get_current_user_id(),'id_cliente_ventipay',true);
    $activar = false;
    $numOrden = '';
    if(!empty($customerId)){
        $activar = true;
        //Obtengo las suscripciones
        $recibeSuscripciones = wp_remote_get('https://api.ventipay.com/v1/subscriptions?customer_id='.$customerId.'&status[]=trialing',[
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode('key_live_9wIGa3q7ZGKe6SpjTaAHTPdtbOl4LvlBnEQnvIJoy2NTWY1wsLxsTlWkJJxiECrP' . ':'),
                'Content-Type' => 'application/json',
            ],
            'timeout' => 45,
            ]
        );
        $suscripciones = json_decode(wp_remote_retrieve_body($recibeSuscripciones));
    }
        
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
                        <?php if(isset($_GET['exito']) && $_GET['exito'] == 1){ ?>
        <div class="alert alert-success" role="alert">
            Ya enviamos tu solicitud de baja de la suscripción. Recibirás un correo con la confirmación.
        </div>
        <?php } ?>

        <?php if(isset($_GET['exito']) && $_GET['exito'] == 2){ ?>
        <div class="alert alert-success" role="alert">
            Ya enviamos tu solicitud de cambio de frecuencia. Recibirás un correo con la confirmación.
        </div>
        <?php } ?>
                            
                        <p>Tus Suscripciones actuales son: </p>

                        <div class="row">
                            <?php 
                            if($activar){
                            foreach($suscripciones->data as $suscrip){ 

                                $numOrden = $suscrip->metadata->wp_order_id;


                                //Obtengo los metadatos de la suscripcion
                                $datos = get_metadata('post',$suscrip->metadata->wp_order_id);

                                switch ($suscrip->status) {
                                    case 'trialing':
                                        $color = 'badge-info';
                                        $nomEstado = 'En Trial';
                                        break;
                                    case 'incomplete':
                                        $color = 'badge-warning';
                                        $nomEstado = 'Incompleta';
                                        break;    
                                    case 'active':
                                        $color = 'badge-success';
                                        $nomEstado = 'Activa';
                                        break;    
                                    case 'unpaid':
                                        $color = 'badge-danger';
                                        $nomEstado = 'Impaga';
                                        break;
                                    case 'candeled':
                                        $color = 'badge-danger';
                                        $nomEstado = 'Cancelada';
                                        break; 
                                    
                                    default:
                                        $color = 'badge-secondary';
                                        $nomEstado = 'Error';
                                        break;
                                }

                                switch ($suscrip->interval) {
                                    case '1month':
                                        $nomTiempo = '/ Mensual';
                                        break;
                                    case '3months':
                                        $nomTiempo = '/cada 3 Meses';
                                        break;
                                    case '6months':
                                        $nomTiempo = '/cada 6 Meses';
                                        break;

                                    
                                    default:
                                        $nomTiempo = '';
                                        break;
                                }

                                switch(trim($suscrip->status_reason)){
                                    case 'canceled_by_merchant':
                                        $status = 'Canelado';
                                        $msjActivo = 1;
                                    default:
                                        $status = '';
                                        $msjActivo = 0;
                                }

                            ?>
    
                            <div class="col-md-6">

                                <div class="tabla-suscripcion">
                                    <ul class="list-group">
                                        <li class="list-group-item disabled" aria-disabled="true">
                                            <small>Licencia</small>
                                            <p class="titulo"><?php echo $suscrip->products[0]->name; ?> <span class="badge <?php echo $color; ?>"> <?php echo $nomEstado; ?> </span>
                                             <?php if(isset($datos['baja_ventipay'][0])){ ?><span class="bagde badge-danger"> <?php echo $datos['baja_ventipay'][0]; ?></span> <?php } ?>
                                            </p>
                                        </li>
                                        <li class="list-group-item">
                                            <small>Valor y frecuencia</small>
                                            <p class="subtitulo">$ <?php echo number_format($suscrip->products[0]->price,0,'.','.').' '.$nomTiempo; ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <small>Fecha de activación</small>
                                            <p class="subtitulo"><?php echo date('d/m/Y',strtotime($suscrip->trial_starts_at)); ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <small>Fecha próxima facturación</small>
                                            <?php if(!isset($datos['baja_ventipay'][0])){ ?> <p class="subtitulo"><?php echo date('d/m/Y',strtotime($suscrip->trial_ends_at)); ?></p> <?php }else{ echo '<p>Suscripción cancelada</p>'; } ?>
                                        </li>
                                        <li class="list-group-item">
                                            <small>Estudiante</small>
                                            <p class="subtitulo"><?php echo $suscrip->metadata->nom_alumno; ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <button type="button" class="btn btn-secondary btn-block btn-sm btn-rosa updVentipay" data-toggle="modal" data-target="#modalFrecuencia" data-id="<?php echo $suscrip->id; ?>" data-nom="<?php echo $suscrip->products[0]->name; ?>" data-interval="$suscrip->interval"><i class="fa fa-random pr-2"></i>CAMBIAR FRECUENCIA</button>
                                            <button type="button" class="btn btn-secondary btn-block btn-amarillo bajaVentipay" data-toggle="modal" data-target="#modalBaja" data-id="<?php echo $suscrip->id; ?>"><i class="fa fa-minus-circle pr-2"></i>DARME DE BAJA</button>
                                            <button onclick="location.href = 'https://sbsdigital.cl/';" type="button" class="btn btn-secondary btn-block btn-celeste"><i class="fa fa-user-plus pr-2"></i>AÑADIR SUSCRIPCIÓN</button>
                                            <div class="pie">
                                                <small>Para añadir una suscripción adicional te redirigiremos al proceso de compra inicial, al momento del checkout, podrás usar tu mail y contraseña para asociar la nueva suscripción a tu cuenta</small>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                            <?php }}else{echo '<div class="alert alert-danger" role="alert">NO existen suscripciones para el usuario!</div>';} ?>
                        </div>

                    </div>
                    <?php
                            // echo '<pre>';
                            // var_dump($suscripciones->data[0]);
                         ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>


<!-- modal darse de baja -->
<div class="modal fade" id="modalBaja" tabindex="-3" role="dialog" aria-labelledby="modalBaja" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 30px;" >
      <div class="modal-header">
        
        <div class="text-center">  
            <br><br>
            <h5 class="modal-title" id="exampleModalLabel"><strong>LAMENTAMOS QUE QUIERAS DARTE DE BAJA</strong></h5>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        
      </div>
      <div class="modal-body">
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <input type="hidden" name="action" value="bajaventy">
            <input type="hidden" name="idSuscripcion" id="idSusVenty" value="">
            <input type="hidden" name="numOrden" id="numOrden" value="<?php echo $numOrden; ?>">
            
             <div class="form-group">
                <label for="exampleFormControlTextarea1">¿Ingresa contraseña SBS Digital?<span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="passSbsDig" name="passSbsDigital" >
            </div>
            
            <div class="form-group">
                <label for="exampleFormControlTextarea1">¿Por qué quieres darte de baja?<span class="text-danger">*</span></label>
                <textarea class="form-control" id="mensaje" name="txtMensaje" rows="3" ></textarea>
            </div>
            
            <div class="form-check">
                <input class="form-check-input" type="radio" name="confirm" id="confirm" value="1">
                <label class="form-check-label" for="confirm">
                Confirmo que quiero dar de baja esta suscripción
                </label>
            </div>
            
            <hr>
            
            <p><strong>IMPORTANTE:</strong>La desuscripción se hará efectiva el último día de tu ciclo de pago actual</p>
            <div class="alert alert-warning" role="alert">
              El historial de trabajo del estudiante se eliminará permanentemente de las plataformas.
            </div>
            <div class="form-group text-center">
                <button type="submit" id="btnBaja" class="btn btn-primary especial" disabled="disabled">DARME DE BAJA</button>
                
            </div>

        </form>
      </div>
    </div>
  </div>
</div>

<!-- modal Cambiar frecuencia -->
<div class="modal fade" id="modalFrecuencia" tabindex="-1" role="dialog" aria-labelledby="modalFrecuencia" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 30px;" >
      <div class="modal-header">
        
        <div class="text-center">  
            <br><br>
            <h5 class="modal-title" id="exampleModalLabel"><strong>Cambia la frecuencia de tu plan</strong></h5>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        
      </div>
      <div class="modal-body">
          <h5 class="azul">Actualmente tienes <spam><strong id="nomSusVenty"></strong> </spam> elije tu nueva frecuencia de pago</h5>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <input type="hidden" name="action" value="updateventy">
            <input type="hidden" name="idSuscripcion" id="idSusVenty1" value="">
            <input type="hidden" name="numPedido" id="numPedido" value="">
            
            <div class="m-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="plan" id="1m" value="1month" >
                    <label class="form-check-label" for="exampleRadios1">
                        Matific licencia mensual por $9.990 al mes <br>
                        <small>Facturado $9.990 al mes</small>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="plan" id="3m" value="3months" >
                    <label class="form-check-label" for="exampleRadios1">
                        Matific licencia trimestral por $8.995 al mes <br>
                        <small>Facturado $26.985 cada 3 meses</small>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="plan" id="6m" value="6months" >
                    <label class="form-check-label" for="exampleRadios1">
                        Matific licencia semestral por $8.320 al mes <br>
                        <small>Facturado $49.920 cada 6 meses</small>
                    </label>
                </div>
            </div>

            <div class="form-group text-center">
                <hr>
                <button type="submit" class="btn btn-primary especial">CAMBIAR PLAN</button>
            </div>
            
            
            <small>Si cambias tu frecuencia de pago, el cambio se hará efectivo al término del ciclo actual</small>

        </form>
      </div>
    </div>
  </div>
</div>



<?php }else{ 
    wp_redirect('https://sbsdigital.cl/user-login/');
} ?>

</div>


<?php get_footer(); ?>

