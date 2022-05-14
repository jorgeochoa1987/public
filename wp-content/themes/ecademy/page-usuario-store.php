<?php get_header(); ?> 
<style>
    .modal-dialog {
    max-width: 800px !important;
    margin: 1.75rem auto;
}
p {
    color: #606060;
    margin-bottom: 15px;
    line-height: 1.7;
    font-size: 14px;
    line-height: ;
}
   </style> 
<?php if(is_user_logged_in()){ ?>

<?php
    global $wpdb;
    $count =0;
    $cliente = new WC_Customer (get_current_user_id());
    $nomUsuario = $cliente->get_display_name();

    $metas = $wpdb->get_results( 
        $wpdb->prepare("SELECT post_id FROM wp_postmeta where meta_key = 'e-mail_apoderado' AND meta_value = '".$cliente->data['email']."' ")
    );
?> 
<form method="get" action="./checkout/">
<div class="container">
    <div class="subcontainer">
    <div class="configuracion">
        <div class="row">
            <div class="col-md-12">
        <h3>Tienda SBS Digital</h3>
        <h4 class="titulo-azul"> Estás viendo la agenda de Simona Grez</h4>
        Selecciona al estudiante para el cual necesitas nuevas sesiones de clases o meses de software adicional.
        <div class="grid">
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
                // echo"<br>". $name ; 
        ?>

    <label class="card">
        <input name="plan" class="radio" type="radio" checked>
        <span class="plan-details">
        <span class="plan-cost color-<?php echo $count;?>"><?php echo $count;?></span>
        <span class="tinombre">Estudiante <?php echo $count;?></span>
        <span class="nombre"><?php echo $name; ?></span>
        </span>
    </label>
    <?php }?>  
    </div></div></div>
<div class="row">
    <div class="col-md-12">
    <h4 class="titulo-azul">Si necesitas más meses de suscripción, puedes agregarlos al carrito y comprar aquí:</h4>
    </div>
    <div class="col-md-12">
    <div class="grid2">
<?php
       
       $user_id =get_current_user_id();
               $args = array(
               );
               $orders = wc_get_orders($args);
               
                  foreach ( $orders as $orderchild ) {
                   // echo $ido = $orderchild->id.'<br>';
               $order_data = $orderchild->get_data(); // The Order data
               $order_currency = $order_data['currency'];
               $order_status = $order_data['status'];    
               foreach ($orderchild->get_items() as $key => $lineItem) {
                   $product_id = $lineItem['product_id'];
                   $product = wc_get_product( $product_id );
                   $name = $lineItem->get_name(); 
                   $image = wp_get_attachment_image_src( get_post_thumbnail_id(  $product_id ), 'single-post-thumbnail' );
       if ($image[0]==''){$image[0]="http://localhost:8888/sbs/public/wp-content/uploads/2021/07/placeholder.png";}
                   
                   ?> 
                    <label class="card">
                            <input name="plan" class="radio" type="radio" checked>
                            <span class="plan-details">
                            <img class="imgstore" src="<?php echo $image[0]; ?>" data-id="<?php echo $id; ?>" />                            
                            </span>
                            <button type="button" class="btn btn-primary center full">Agregado Al plan</button>

                           
 
                    </label>

                
       
       
         <?php      }
           } 
            
               ?>    
</div> 
     </div>
</div>
<div class="row">
    <div class="col-md-12">
    <h4 class="titulo-azul">Si necesitas más sesiones con tu profesor de matemática en Matific, puedes agregarlos al carrito y comprar aquí:</h4>
    </div>
    <div class="col-md-12">
    <div class="row docentes"> 
    <div class="col-md-12 center">
    <img class="switchimg"  src="../wp-content/themes/ecademy/assets/img/matific.png" />
    </div>
    <div class="grid3">
    <label class="card">
            <input name="plan" class="radio" type="radio" checked>
            <span class="plan-details p2">
               <a  data-toggle="modal" data-target="#modalSoporte" href="#"> <img class="imgstore" src="http://localhost:8888/sbs/public/wp-content/uploads/2021/07/team_2.jpg" />
                <span class="tinombre">profesor :jorge ochoa </span></a>
                <span class="tinombre">
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod 
                </span>
                <span class="plan">
                2 Clases por  $25.000
                <button type="button" class="btn btn-primary">Agregado Al plan</button>
                </span>
                <span class="plan">
                4 Clases por  $48.000
                <button type="button" class="btn btn-primary">Agregado Al plan</button>
                </span>
                <span class="plan">
                6 Clases por  $60.000
                <button type="button" class="btn btn-primary">Agregado Al plan</button>

                </span>
            </span>
        </label>
    </div>
</div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    <h4 class="titulo-azul">Si necesitas más sesiones con tu profesor de lectura en Glifing, puedes agregarlos al carrito y comprar aquí:</h4>
    </div>
    <div class="col-md-12">
    <div class="row docentes"> 
    <div class="col-md-12 center">
    <img class="switchimg"  src="../wp-content/themes/ecademy/assets/img/glifing.png" />
    </div>
    <div class="grid3">
        <label class="card">
            <input name="plan" class="radio" type="radio" checked>
            <span class="plan-details p2">
            <a  data-toggle="modal" data-target="#modalSoporte" href="#">  <img class="imgstore" src="http://localhost:8888/sbs/public/wp-content/uploads/2021/07/team_2.jpg" />
                <span class="tinombre">profesor :jorge ochoa </span></a>
                <span class="tinombre">
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod 
                </span>
                <span class="plan">
                2 Clases por  $25.000
                <button type="button" class="btn btn-primary">Agregado Al plan</button>
                </span>
                <span class="plan">
                4 Clases por  $48.000
                <button type="button" class="btn btn-primary">Agregado Al plan</button>
                </span>
                <span class="plan">
                6 Clases por  $60.000
                <button type="button" class="btn btn-primary">Agregado Al plan</button>

                </span>
            </span>
        </label>
    </div>
</div>
    </div>
</div>



</div> 


<a href="http://localhost:8888/sbs/public/checkout/"> </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12" style="text-align-last: center;"><button  type="submit" style="width: 25%;" class="btn btn-success">Completar compra</button>
 </div>
</div>   
</div> 
        </form>
<?php }else{ 
    wp_redirect('https://sbsdigital.cl/user-login/');
} ?>


<?php get_footer(); ?>

<!-- <!-Modales-> -->

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
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Perfil Profesor
                            </h5>
                            <br> 
                        </div>
                        <div class="col-md-3">
                             <img  style="width: 100%;" class="imgstore" src="http://localhost:8888/sbs/public/wp-content/uploads/2021/07/team_2.jpg" />
                        </div>
                        <div class="col-md-5">
                             <span class="modal-title azul">profesor :jorge ochoa </span></a>
                             Software con el que trabaja:                       <img src="../wp-content/themes/ecademy/assets/img/glifing.png" data-id="" alt="Clases Agenda" class="clases-prod" style="width: 41% !important;">

Experiencia: 6 años
Asignaturas de: Matemáticas
Cursos: Kinder, 1ro básico, 2do básico
Idiomas: Español, Inglés
                        </div>
                        <div class="col-md-4"></div>

                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                   <strong> Un poco sobre mi:</strong><br>
                   <p>  <br>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis.</p>
<br>   </div> <br>
                    <div class="col-md-12">
                        <strong>Mi experiencia de trabajo:</strong><br>
                        <br>    <p>   Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>
                        <br>
                    </div><br>
                    <div class="col-md-12">
                    <strong>Mis estudios:</strong><br>
                    <br>   <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>
                    <br>   </div>
                    <div class="col-md-12"><br>
                <button type="button blue" style="float: left;/* background: dodgerblue; */" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="buttonclose" aria-hidden="true">Volver</span>
                </button></div>
                </div>
               
</div> 

        </div>
    </div>
</div>
<!-- <!-Finmodales--> 