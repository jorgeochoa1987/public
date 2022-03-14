<?php
    global $wp;
    $slug = add_query_arg( array(), $wp->request );

?>
<div class="vertical-menu">
    <div class="menu-link titulo">
        <p>CONFIGURACIÓN</p>
    </div>

    <div class="menu-link">
        <a href="https://sbsdigital.cl/usuario-accesos/" <?php echo ($slug === 'usuario-accesos') ? 'class="active"':''; ?> ><i class="fa fa-user"></i> Accesos</a>
    </div>
    <div class="menu-link">
        <a href="https://sbsdigital.cl/usuario-seguridad/" <?php echo ($slug === 'usuario-seguridad') ? 'class="active"':''; ?>><i class="fa fa-lock"></i> Seguridad</a>
    </div>
    <div class="menu-link">
        <a href="https://sbsdigital.cl/usuario-suscripciones/" <?php echo ($slug === 'usuario-suscripciones') ? 'class="active"':''; ?>> <i class="fa fa-calculator"></i> Tus suscripciones</a>
    </div>
    <div class="menu-link">
        <a href="https://sbsdigital.cl/usuario-pago/" <?php echo ($slug === 'usuario-pago') ? 'class="active"':''; ?>><i class="fa fa-credit-card"></i> Método de pago </a>
    </div>

</div>