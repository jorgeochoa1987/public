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

        <?php 
        $user_id =get_current_user_id();
        $args = array(
            'customer_id' => $user_id
        );
         $orders = wc_get_orders($args);
         foreach ( $orders as $orderchild ) {
          // echo $ido = $orderchild->id.'<br>';
      $order_data = $orderchild->get_data(); // The Order data
      $order_id = $order_data['id']; 

    $user_id = $order_id;
  $field ="additional_nom_alum";

    $wpdb; 
    $results = $wpdb->get_results( "SELECT `meta_value` FROM `wp_postmeta` WHERE meta_key = 'additional_nom_alum' and `post_id` = $user_id;" ); 
    // Utilizando el superglobal  

    echo json_encode($results);
    }
       ?>

        <h3> Estás viendo la agenda de  <?php echo json_encode($results); ?></h3>
        <div class="info">
     
            <p class="negrita">En esta sección puedes agendar tus sesiones de clases online, ver tus sesiones disponibles, cancelar clases y más.
</p>
<h4 class="titulo-azul">¿Con cuál profesor quieres agendar tu próxima sesión?
 </h4>
 <h4 class="titulo-azul"> Haz clic en el calendario y agenda tus sesiones de clases online </h4>
 <div class="calendario">
 <div id='calendar'></div>


 </div> 
        
        </div>
        <hr>
		<h4 class="titulo-azul">Tus Sesiones disponibles:</h4>

        <div class="cuadro-cursos-agenda">

        <?php
       
$user_id =get_current_user_id();
        $args = array(
            'customer_id' => $user_id
        );
        $orders = wc_get_orders($args);
        
           foreach ( $orders as $orderchild ) {
            // echo $ido = $orderchild->id.'<br>';
        $order_data = $orderchild->get_data(); // The Order data
        $order_id = $order_data['id'];
        $order_currency = $order_data['currency'];
        $order_status = $order_data['status'];    
        // echo $order_data ;
        // echo $order_id ;
        // echo $order_currency ;
        // echo $order_status; 

        foreach ($orderchild->get_items() as $key => $lineItem) {
            $product_id = $lineItem['product_id'];
            $product = wc_get_product( $product_id );
            $name = $lineItem->get_name(); 
            $image = wp_get_attachment_image_src( get_post_thumbnail_id(  $product_id ), 'single-post-thumbnail' );
if ($image[0]==''){$image[0]="http://localhost:8888/sbs/public/wp-content/uploads/2021/07/placeholder.png";}
            
            ?> 
            

         <div class="info-azul-bk imagen">
		 <div class="mid-row">
		 <a href="<?php if($name=='Agenda y Aula Clases on line')
                { echo 'http://localhost:8888/sbs/public/agenda/'; }
                else { echo 'https://www.matific.com/cl/es-ar/login-page/';} 
                ?>"target="_blank" >
                <img src="<?php echo $image[0]; ?>" data-id="<?php echo $id; ?>" class="clases-prod" /> </a>
		 </div>
		 <div class="mid-row">
			 <div class="white-box">
				 <p class="clasesp">Sesiones Utilizadas 00</p>
				 <p class="clasesp"> Sesiones Agendadas 00</p>
				 <p class="clasesp">Sesiones Disponibles 00</p>
			 </div>
		 </div>
		<div class="full-row">
		  <a class="buttonblue"href=" http://localhost:8888/sbs/public/shop/"> Comprar más sesiones </a>
		</div>
        </div>


  <?php      }
    } 
     
        ?>
       
           
        
            
        </div>

		<h4 class="titulo-azul">	Conéctate a tus clases online agendadas aquí</h4>
		<div class="cuadro-cursos-agenda">
		<div class="info-white-bk imagen">
		 <div class="mid-row">
		 <img src=" http://localhost:8888/sbs/public/wp-content/uploads/2021/07/placeholder.png" class="clases-prod" /> </a>

		 </div>
		 <div class="mid-row">
			 <div class="white-box">
				 <p class="clasesp">Sesiones Utilizadas 00</p>
				 <p class="clasesp"> Sesiones Utilizadas 00</p>
				 <p class="clasesp">Sesiones Utilizadas 00</p>
			 </div>
		 </div>
		<div class="full-row">
		  <a class="buttonblue"href=""> Ingresar a la sala de clases </a>
		</div>
        </div>
		</div>
    

        <div class="row">
         
</div>


<?php  }else{ 
    wp_redirect('https://sbsdigital.cl/user-login/');
} ?>




<?php get_footer(); ?>
