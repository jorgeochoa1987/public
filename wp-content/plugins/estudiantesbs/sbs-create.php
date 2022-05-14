<?php

function estudiante_crear() {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $last = $_POST["last"];
    $course = $_POST["course"];
    $old = $_POST["old"];
    $tutor = $_POST["tutor"];

    //insert
    if (isset($_POST['insert'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . "estudiantes";

        $wpdb->insert(
                $table_name, //table
                array('id' => $id, 'nombre' => $name,'apellido' => $last,'edad' => $old,'curso' => $course,'tutor' => $tutor), //data
                array('%s', '%s') //data format			
        ); 
        $message.="registro almacenado correctamente";
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/estudiantesbs/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Nuevo registro estudiante</h2>
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <p>Código alfa-númerico para el ID</p>
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th class="ss-th-width">Id</th>
                    <td><input type="text" name="id" value="<?php echo $id; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Nombre</th>
                    <td><input type="text" name="name" value="<?php echo $name; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Apellido</th>
                    <td><input type="text" name="last" value="<?php echo $last; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Edad</th>
                    <td><input type="text" name="old" value="<?php echo $old; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Curso</th>
                    <td><input type="text" name="course" value="<?php echo $course; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Tutor</th>
                    <td><input type="text" name="tutor" value="<?php echo $tutor; ?>" class="ss-field-width" /></td>
                </tr>
            </table>
            <input type='submit' name="insert" value='Guardar registro' class='button'>
        </form>
    </div>
    <?php
}