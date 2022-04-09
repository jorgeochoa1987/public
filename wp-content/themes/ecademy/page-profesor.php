<?php get_header(); ?>  
<link href='/sbs/public/wp-content/themes/ecademy/assets/css/calendar.css' rel='stylesheet' />
<script src='/sbs/public/wp-content/themes/ecademy/assets/js/calendar.js'></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      initialDate: '2020-09-12',
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectMirror: true,
      select: function(arg) {
        var title = prompt('Event Title:');
        if (title) {
          calendar.addEvent({
            title: title,
            start: arg.start,
            end: arg.end,
            allDay: arg.allDay
          })
        }
        calendar.unselect()
      },
      eventClick: function(arg) {
        if (confirm('¿Desea agendar esta clase?')) {
          arg.event.remove()
        }
      },
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: [
        {
          title: 'All Day Event',
          start: '2020-09-01'
        },
        {
          title: 'Profesor1',
          start: '2020-09-07',
          end: '2020-09-10'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-09-09T16:00:00'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-09-16T16:00:00'
        },
        {
          title: 'Profesor2',
          start: '2020-09-11',
          end: '2020-09-13'
        },
        {
          title: 'Profesor3',
          start: '2020-09-12T10:30:00',
          end: '2020-09-12T12:30:00'
        },
        {
          title: 'Profesor1',
          start: '2020-09-12T12:00:00'
        },
        {
			title: 'Profesor1',
          start: '2020-09-12T14:30:00'
        },
        {
			title: 'Profesor1',
          start: '2020-09-12T17:30:00'
        },
        {
			title: 'Profesor1',
          start: '2020-09-12T20:00:00'
        },
        {
			title: 'Profesor1',
          start: '2020-09-13T07:00:00'
        },
        {
			title: 'Profesor1',
          url: 'http://google.com/',
          start: '2020-09-28'
        }
      ]
    });

    calendar.render();
  });

</script>
<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }

</style>

<?php if(is_user_logged_in()){ ?>


	<?php
   $cliente = new WC_Customer (get_current_user_id());

   $nomUsuario = $cliente->get_display_name();


   
?>
<div class="container">
    <div class="usuario">

       

        <h3> ¡Bienvenida <?php echo $nomUsuario; ?>!, esta es tu página de usuario.</h3>
        <div class="info">
     

 <div class="calendario">


 </div> 
        
        </div>
        <hr>
		<h4 class="titulo-azul">Tus Sesiones disponibles:</h4>

        <div class="cuadro-cursos-agenda">

      
         <div class="info-white-bk imagen">
		 <div class="full-row">
		 <a href=""target="_blank" >
         <img src="http://localhost:8888/sbs/public/wp-content/uploads/2022/04/Captura-de-Pantalla-2022-04-05-a-las-1.23.44-p.m..png" data-id="" class="clases-prod" />
		 </div>
		 <div class="mid-row">
			 
		 </div>
		<div class="full-row">
		</div>
        </div>
        <div class="info-white-bk imagen">
		 <div class="full-row">
		 <a href=""target="_blank" >
      <img src="http://localhost:8888/sbs/public/wp-content/uploads/2022/04/Captura-de-Pantalla-2022-04-05-a-las-1.23.49-p.m..png" data-id="" class="clases-prod" />
		 </div>
		 <div class="mid-row">
		
		 </div>
		<div class="full-row">
		</div>
        </div>

       
           
        
            
        </div>

		<h4 class="titulo-azul">	Software educativo</h4>
        <div class="cuadro-cursos-agenda">

      
<div class="info-white-bk imagen">
<div class="full-row">
<a href=""target="_blank" >
<img src="http://localhost:8888/sbs/public/wp-content/uploads/2022/04/Captura-de-Pantalla-2022-04-05-a-las-2.47.54-p.m..png" data-id="" class="clases-prod" />
</div>
<div class="mid-row">
    
</div>
<div class="full-row">
</div>
</div>
<div class="info-white-bk imagen">
<div class="full-row">
<a href=""target="_blank" >
<img src="http://localhost:8888/sbs/public/wp-content/uploads/2022/04/Captura-de-Pantalla-2022-04-05-a-las-2.47.48-p.m..png" data-id="" class="clases-prod" />
</div>
<div class="mid-row">

</div>
<div class="full-row">
</div>
</div>


  

   
</div>
    
<div class="info">
    <a href="http://localhost:8888/sbs/public/shop/" target="_blank" >
        <img src=" http://localhost:8888/sbs/public/wp-content/uploads/2022/04/ir-a-la-tienda.png" /> </a>
        </div>
        <div class="info-azul">
            <p class="texto-blanco"><strong>Recuerda: </strong>Para iniciar sesión en la plataforma debes usar las credenciales (mail, contraseña) que enviamos a tu correo electrónico</p>
        </div>

    

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <div class="iconos">
                    <a href="" data-toggle="modal" data-target="#modalSoporte">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-soporte.svg" alt="">
                        <p class="texto-iconos">SOPORTE</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="iconos">
                    <a href="https://sbsdigital.cl/usuario-accesos">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-configuracion.svg" alt="">
                        <p class="texto-iconos">CONFIGURACIÓN</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>   

    


        <div class="herramientas">
            <p class="herramientas-titulo">Esta es tu página de usuario de SBS Digital. Siempre podrás regresar aquí para:</p>

            <div class="row">

                <div class="herramientas-interno col-md-4">

                    <div class="herramientas-detalle">
                        <a href="">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-acceso.svg" alt="" class="img-iconos">
                            <p>Acceder a las plataformas educativas con tu hijo</p>
                        </a>
                    </div>
                    
                </div>
                <div class="herramientas-interno col-md-4">
                    <div class="herramientas-detalle">
                        <a href="https://sbsdigital.cl/usuario-suscripciones/">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-modificar.svg" alt="" class="img-iconos">
                            <p>Modificar suscripción y métodos de pago</p>
                        </a>
                    </div>
                </div>
                <div class="herramientas-interno col-md-4">
                    <div class="herramientas-detalle">
                        <a href="https://sbsdigital.cl/usuario-suscripciones/">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-inscribir.svg" alt="" class="img-iconos">
                            <p>Suscribir más estudiantes a tu cuenta</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="herramientas-interno col-md-4">
                    <div class="herramientas-detalle">
                        <a href="" data-toggle="modal" data-target="#modalSoporte">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-soporte2.svg" alt="" class="img-iconos">
                            <p>Acceder a soporte al usuario</p>
                        </a>
                    </div>
                </div>
                <div class="herramientas-interno col-md-4">
                    <div class="herramientas-detalle">
                        <a href="https://sbsdigital.cl/usuario-accesos/">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-contraseña.svg" alt="" class="img-iconos">
                            <p>Recuperar tu contraseña o recuperar accesos a plataformas</p>
                        </a>
                    </div>
                </div>
                <div class="herramientas-interno col-md-4">
                    <div class="herramientas-detalle">
                        <a href="">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/icono-plataformas.svg" alt="" class="img-iconos">
                            <p>Conocer nuevas plataformas educativas</p>
                        </a>
                    </div>
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




<?php get_footer(); ?>