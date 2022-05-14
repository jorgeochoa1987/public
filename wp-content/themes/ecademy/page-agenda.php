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
      locale:'es' ,
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
  <div class=" container">
      <div class="subcontainer">
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
        </did>
  </div> 

      


<div class="row">
<div class="col-md-6">
    <?php 
    $table_name = $wpdb->prefix.'estudiantes';
    $schools = $wpdb->get_results($wpdb->prepare("SELECT id,nombre,edad,curso,apellido,tutor from $table_name where tutor=%s", $cliente->id));
    foreach ($schools as $s) { 
    $name = $s->nombre;
    $last = $s->apellido;
    $old = $s->edad;
    $course = $s->curso;
    $tutor = $s->tutor;
    ?>
    <?php }?> 
    <h3 class="subtitle"> Estás viendo la agenda de <strong class="blue"> <?php echo $name." ";  echo $last;?></strong></h3>
    <td class="manage-column ss-list-width"><?php echo $row->nombre; ?></td> <td class="manage-column ss-list-width"><?php echo $row->apellido; ?></td>
</div>
<div class="col-md-6">
      <select name="" onclick="return false;" id="" class="choosestudent" name="students" id="student">
      <option value=""  ><i class="fa-solid fa-arrows-rotate"></i>Cambiar de estudiante </option>
      <?php 
      $table_name = $wpdb->prefix.'estudiantes';
      $schools = $wpdb->get_results($wpdb->prepare("SELECT id,nombre,edad,curso,apellido,tutor from $table_name where tutor=%s ", $cliente->id));
      foreach ($schools as $s) { 
      $name = $s->nombre;
      $last = $s->apellido;
      $old = $s->edad;
      $course = $s->curso;
      $tutor = $s->tutor;
      ?>
      <option value=" <?php echo  $name ;echo $last ;?>"> <?php echo  $name ;echo $last ;?></option>

      <?php }?>  
      </select>
</div>
  <div class="col-md-12">
  <div class="info">
        <p class="info">En esta sección puedes agendar tus sesiones de clases online, ver tus sesiones disponibles, cancelar clases y más.</p>
      </div>
  </div>
  
</div>
 
  <div class="row">
    <div class="col-md-12">
       <h4 class="titulo-azul">¿Con cuál profesor quieres agendar tu próxima sesión?</h4>
    </div>
    <div class="col-md-6">
    <input type="checkbox" id="Español" name="Español" value="Español">
			<label for="Español"> Profesor  Luis Sepúlveda
      <img src="../wp-content/themes/ecademy/assets/img/glifing.png" data-id="" alt="Clases Agenda" class="clases-prod-c" />

      </label><br>

    </div>
    <div class="col-md-6">
    <input type="checkbox" id="Español" name="Español" value="Español">
			<label for="Español"> Profesor  Luis Sepúlveda
      <img src="../wp-content/themes/ecademy/assets/img/matific.png" data-id="" alt="Clases Agenda" class="clases-prod-c" />

</label><br>

    </div>
  </div>   
<div class="row">
  <div class="col-md-12">
    <h4 class="titulo-azul"> Haz clic en el calendario y agenda tus sesiones de clases online </h4>
    <div id='calendar'></div>
  </div>
</div>
  <!--Init Section-->

<div class="row">
  <div class="col-md-12">
     <h4 class="titulo-azul">Tus Sesiones disponibles:</h4>
  </div> 
  <!--Boxes-->
    <div class="col-md-6">
      <div class="row clases-estudiantes">
            <div class="col-md-6">
              <div class="center">
                  <img src="../wp-content/themes/ecademy/assets/img/glifing.png" data-id="" alt="Clases Agenda" class="clases-prod" />
                  <p class="text-prod">Profesor/a: <br> Dario Calderón</p>           
              </div>  
            </div>  
            <div class="col-md-6">
                  <div class="background-white">
                    <p class="clasesp">Sesiones Utilizadas 00</p>
                    <p class="clasesp"> Sesiones Agendadas 00</p>
                    <p class="clasesp">Sesiones Disponibles 00</p>
                  </div>
            </div>        
            <div class="col-md-12" style="text-align-last: center;padding: 26px 5px 10px;">
              <a class="buttonblue"href=" ./usuario-store/"> Comprar más sesiones </a>
           </div>   
        </div> 
        
    </div>     
  <!--End Boxes-->
   <!--Boxes-->
   <div class="col-md-6">
      <div class="row clases-estudiantes">
            <div class="col-md-6">
              <div class="center">
                  <img src="../wp-content/themes/ecademy/assets/img/matific.png" data-id="" alt="Clases Agenda" class="clases-prod" />
                  <p class="text-prod">Profesor/a: <br> Dario Calderón</p>           
              </div>  
            </div>  
            <div class="col-md-6">
                  <div class="background-white">
                    <p class="clasesp">Sesiones Utilizadas 00</p>
                    <p class="clasesp"> Sesiones Agendadas 00</p>
                    <p class="clasesp">Sesiones Disponibles 00</p>
                  </div>
            </div>        
            <div class="col-md-12" style="text-align-last: center;padding: 26px 5px 10px;">
              <a class="buttonblue"href=" ./usuario-store/"> Comprar más sesiones </a>
           </div>   
        </div> 
        
    </div>     
  <!--End Boxes-->
</div>  
  <!--End Section-->


<div class="col-md-12">
<p class="orange-alert">  <i class='fas fa-exclamation-circle'></i>
Recueda que puedes uttilizar tus sesiones hasta el 30 de marzo,para obeter mas días, renueva tu suscripción aquí</p>
</div>
<div class="row">
<div class="col-md-12">
  <h4 class="titulo-azul">	Conéctate a tus clases online agendadas aquí</h4>
  <p class="info"> Tus proximas sesiones</p>
</div>
<!---->
<div class="row">
  <div class="col-md-6">
      <div class="border-color">
          <div class="row">
              <div class="col-md-4">
                  <img class="imgperfil-2" src="http://localhost:8888/sbs/public/wp-content/uploads/2021/07/team_2.jpg" alt="">
              </div>
              <div class="col-md-8">
                    <p> Próxima sesión de clases  </p>
                    <div class="col-md-12">
                      <img src="../wp-content/themes/ecademy/assets/img/glifing.png" data-id="" alt="Clases Agenda" class="clases-prod" style="width: 41% !important;">
                    </div>
                      <p> Asignatura: <strong > Matemática  </strong> </p>
                      <p> Estudiante: <strong > Simona Grez  </strong> </p>
                      <p> profesor/a: <strong >Darío Calderón </strong> </p>
              </div>
          </div>
          <div class="row">
          <div class="col-md-12">
               <p class="pink_result">
               Martes 06
de marzo   18:30 hrs. 
               </p> 
              </div>
              <div class="col-md-12">
              <button type="button" style="width: 100%;" class="btn btn-pink">Ingresar a la sala de clases</button> </div>
              <div class="col-md-12" style="text-align-last: center;">
              <a href="" data-toggle="modal" data-target="#modalSoporte"> Si tienes problemas para  asistir a esta clase haz clic aquí.</a>
              </div>
            
          </div>
    </div>   
  </div>
  <div class="col-md-6">
      <div class="border-color">
          <div class="row">
              <div class="col-md-4">
                  <img class="imgperfil-2" src="http://localhost:8888/sbs/public/wp-content/uploads/2021/07/team_2.jpg" alt="">
              </div>
              <div class="col-md-8">
                    <p> Próxima sesión de clases  </p>
                    <div class="col-md-12">
                      <img src="../wp-content/themes/ecademy/assets/img/glifing.png" data-id="" alt="Clases Agenda" class="clases-prod" style="width: 41% !important;">
                    </div>
                      <p> Asignatura: <strong > Matemática  </strong> </p>
                      <p> Estudiante: <strong > Simona Grez  </strong> </p>
                      <p> profesor/a: <strong >Darío Calderón </strong> </p>
              </div>
          </div>
          <div class="row">
          <div class="col-md-12">
               <p class="pink_result">
               Martes 02
de marzo   18:30 hrs. 
               </p> 
              </div>
              <div class="col-md-12">
              <button type="button" style="width: 100%;" class="btn btn-pink">Ingresar a la sala de clases</button> </div>
              <div class="col-md-12" style="text-align-last: center;">
              <a href="" data-toggle="modal" data-target="#modalSoporte"> Si tienes problemas para  asistir a esta clase haz clic aquí.</a>
              </div>
            
          </div>
    </div>   
  </div>


</div> 

<!---->
<br><br><br><br><br>

<div class="col-md-6">
<div class="cuadro-cursos-agenda">

</div>
</div>

</div>

</div>  





<?php  }else{ 
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
                    <h5 class="modal-title azul" id="exampleModalLabel">Cancelar sesión de clases agendada
                    </h5>
                    <p> Puedes cancelar una clase con hasta 6 horas de anticipación y reagendar una nueva en el calendario.
</p>
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
                  
                    <div class="form-group">
                      
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Motivo<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="mensaje" name="txtMensaje" rows="3"></textarea>
                    </div>
                    <div class="form-group text-center">
                            <small class="text-danger" id="msjValCont"> Si cancelas una clase con menos de 6 horas de anticipación o no atiendes la sesión agendada, esta se considerará utilizada.
</small>
                        </div>
                    <div class="form-group text-center">
                        <button type="submit" class="buttonclose">Cancelar Clase</button>
                        <div class="form-group text-center">
                            <small class="text-danger" id="msjValCont">*Por favor completa todos los campos</small>
                        </div>

                    </div>

                </form>
            </div>

        </div>
    </div>
</div>