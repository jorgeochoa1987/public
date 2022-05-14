<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to ecademy/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

<div class="u-columns col2-set" id="customer_login">

    <div class="row">
        <div class="u-column1 col-6">

        <?php endif; ?>

           

            <form class="woocommerce-form woocommerce-form-login login" method="post">

                <?php do_action( 'woocommerce_login_form_start' ); ?>
                <div class="content">
                    <div class='row'>
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="username" class="login"><?php esc_html_e( 'Correo Electrónico', 'ecademy' ); ?>&nbsp;<span class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                            </p>
                        </div>
                        <div class="col-md-5">
                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="password" class="login"><?php esc_html_e( 'Contraseña', 'ecademy' ); ?>&nbsp;<span class="required">*</span></label>
                                <input class="woocommerce-Input woocommerce-Input--text input-text form-control" type="password" name="password" id="password" autocomplete="current-password" />
                            </p>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>

                
                <?php do_action( 'woocommerce_login_form' ); ?>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <p class="form-row">
                            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme" >
                                <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span class="login"><?php esc_html_e( 'Recordarme', 'ecademy' ); ?></span>
                            </label>
                            <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                            <button type="submit" class="woocommerce-button button woocommerce-form-login__submit btn btn-primary order-btn login" name="login" value="<?php esc_attr_e( 'Acceder', 'ecademy' ); ?>"><?php esc_html_e( 'Acceder', 'ecademy' ); ?></button>
                        </p>
                        <p class="woocommerce-LostPassword lost_password">
                            <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="login"><?php esc_html_e( 'Recuperar Contraseña', 'ecademy' ); ?></a>
                        </p>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <?php do_action( 'woocommerce_login_form_end' ); ?>

            </form>

            <hr>
            
            <div class="content ml-5">
                <div class="row">
                    
                    <div class="col-md-11" style="margin-left:90px">
                        <h5 class="login">Si aún no tienes usuario.</h5>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row">
                    
                    <div class="col-md-11" style="margin-left:90px">
                        <h5 class="azul">Conoce nuestras plataformas de aprendizaje online y suscríbete a SBS Digital aquí</h5>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row">
                    <div class="col-md-4 ml-2">
                        <div class="imagen">
                            <a href="https://www.matific.com/cl/es-ar/login-page/" target="_blank">
                                <img style="margin-left:80px;" src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/banner-matific.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4" style="display:none">
    
                        <div class="imagen">
                            <a href="https://www.matific.com/cl/es-ar/login-page/" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sbs/banner-glifing.png" alt="">
                            </a>
                        </div>
    
                    </div>
                    <div class="col-md-4">
    
                    </div>
                </div>
            </div>
        


        <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

        </div>

        <div class="u-column2 col-6">

            <h3 class="title"><?php esc_html_e( 'Register', 'ecademy' ); ?></h3>

            <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

                <?php do_action( 'woocommerce_register_form_start' ); ?>

                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_username"><?php esc_html_e( 'Username', 'ecademy' ); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                    </p>

                <?php endif; ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_email"><?php esc_html_e( 'Email address', 'ecademy' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </p>

                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_password"><?php esc_html_e( 'Password', 'ecademy' ); ?>&nbsp;<span class="required">*</span></label>
                        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="password" id="reg_password" autocomplete="new-password" />
                    </p>

                <?php else : ?>

                    <p><?php esc_html_e( 'A password will be sent to your email address.', 'ecademy' ); ?></p>

                <?php endif; ?>

                <?php do_action( 'woocommerce_register_form' ); ?>

                <p class="woocommerce-FormRow form-row">
                    <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                    <button type="submit" class="woocommerce-Button button btn btn-primary order-btn" name="register" value="<?php esc_attr_e( 'Register', 'ecademy' ); ?>"><?php esc_html_e( 'Register', 'ecademy' ); ?></button>
                </p>

                <?php do_action( 'woocommerce_register_form_end' ); ?>

            </form>

        </div>
    </div>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
