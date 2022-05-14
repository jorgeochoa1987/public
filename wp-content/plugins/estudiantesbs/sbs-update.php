<?php

function estudiante_update() {
    global $wpdb;
    $table_name = $wpdb->prefix . "estudiantes";
    $id = $_GET["id"];
    $name = $_POST["nombre"]; 
    $last = $_POST["apellido"];
    $old = $_POST["edad"];
    $course = $_POST["curso"];
 
//update
    if (isset($_POST['update'])) {
        $name = $_POST["nombre"]; 
        $last = $_POST["apellido"];
        $old = $_POST["edad"];
        $course = $_POST["curso"];
        global $wpdb; 
        $table_name = $wpdb->prefix.'estudiantes';
        $data_update = array('nombre' => $name ,'apellido' => $last,'edad' => $old,'curso' => $course);
        $data_where = array('id' => $id);
        $wpdb->update($table_name , $data_update, $data_where);

        
    }
//delete
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));
    } else {//selecting value to update	
        $schools = $wpdb->get_results($wpdb->prepare("SELECT id,nombre,edad,curso,apellido,tutor from $table_name where id=%s", $id));
        foreach ($schools as $s) { 
            $name = $s->nombre;
            $last = $s->apellido;
            $old = $s->edad;
            $course = $s->curso;
            $tutor = $s->tutor;



        }
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/sinetiks-schools/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Actualizar registro demo</h2>

        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Registro eliminado</p></div>
            <a href="<?php echo admin_url('admin.php?page=estudiante_list') ?>">&laquo; Volver al listado</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>Registro actualizado</p></div>
            <a href="<?php echo admin_url('admin.php?page=estudiante_list') ?>">&laquo; Volver al listado</a>

        <?php } else { ?>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                <tr><th>Tutor</th><td><input type="text" name="tutor" value="<?php echo $tutor; ?>" readonly/></td></tr>
  
                <tr><th>Nombre</th><td><input type="text" name="nombre" value="<?php echo $name; ?>"/></td></tr>
                    <tr><th>Apellido</th><td><input type="text" name="apellido" value="<?php echo $last; ?>"/></td></tr>
                    <tr><th>Edad</th><td><input type="text" name="edad" value="<?php echo $old; ?>"/></td></tr>
                    <tr><th>Curso</th><td><input type="text" name="curso" value="<?php echo $course; ?>"/></td></tr>
 
                </table>
                <input type='submit' name="update" value='Actualizar' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Eliminar' class='button' onclick="return confirm('&iquest;Est&aacute;s seguro de borrar este elemento?')">
            </form>
        <?php } ?>

    </div>
    <?php
}