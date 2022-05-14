<?php

function estudiante_list() {
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/estudiantesbs/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>VIIILIVE</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=estudiante_crear'); ?>">Nuevo registro</a>
            </div>
            <br class="clear">
        </div>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "estudiantes";

        $rows = $wpdb->get_results("SELECT id,nombre,apellido,edad,curso,tutor from $table_name");
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">Id</th>
                <th class="manage-column ss-list-width">Nombre</th>
                <th class="manage-column ss-list-width">Apellido</th>
                <th class="manage-column ss-list-width">Edad</th>
                <th class="manage-column ss-list-width">Curso</th>
                <th class="manage-column ss-list-width">Tutor</th>

                <th>&nbsp;</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->id; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->nombre; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->apellido; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->edad; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->curso; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->tutor; ?></td>

                    <td><a href="<?php echo admin_url('admin.php?page=estudiante_update&id=' . $row->id); ?>">Actualizar</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}