<?php get_header(); ?> 

<?php if(is_user_logged_in()){ ?>



                <!-- get_template_part( 'template-parts/info-menu' ); -->

 
 
  <div class="container"> 
    <div class="usuario">

<?php echo do_shortcode('[edit_account]');?>
  
</div>
</div>

<?php }else{ 
    wp_redirect('https://sbsdigital.cl/user-login/');
} ?>


<?php get_footer(); ?>