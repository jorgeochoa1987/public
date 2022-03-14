<?php get_header(); ?> 

<?php if(is_user_logged_in()){ ?>


<?php
    $cliente = new WC_Customer (get_current_user_id());
    $nomUsuario = $cliente->get_display_name();
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
                
                    <div class="contenido-usuario">
                        
                        <p>Si deseas cambiar tu método de pago o revisar o revisar tu historial de transacciones, en la plataforma de pago Ventipay puede entrar con tu mail y administrar tu suscripción. </p>
                        <h6> <strong>Método de pago actual:</strong></h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="img-container">
                                    <img width="70%" src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/plugin-woocommerce-icon-cards.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="metodos-pago">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <button class="btn btn-secondary btn-rosa" onclick="window.open('https://pay.ventipay.com/wallet/')" > Ver historial de cobros </button>
                                <button class="btn btn-secondary btn-celeste" onclick="window.open('https://pay.ventipay.com/wallet/')"> Ver método de pago </button>
                            </div>
              
                            <hr>
                        </div>
                        
                    </div>
                    
                
            </div>
        </div>
    </div>
</div>

<?php }else{ 
    wp_redirect('https://sbsdigital.cl/user-login/');
} ?>

<?php get_footer(); ?>