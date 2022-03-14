<?php
/**
 * Template for displaying download button.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/certificates/buttons.php.
 *
 * @author  ThimPress
 * @package LearnPress/Templates/Certificates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $certificate ) ) {
	return;
}
?>

<ul class="certificate-actions">
	<li class="download" data-type-download="<?php echo get_option( 'learn_press_lp_cer_down_type', 'image' ); ?>">
		<a href="javascript:void(0)" data-cert="<?php echo $certificate->get_uni_id(); ?>"><?php echo esc_html_e( 'Download Certificate', 'ecademy-toolkit' ); ?></a>
	</li>

	<li>

		<div style="display:none" id="5545"></div>
		<button class="lp_print_cer_btn"> <?php echo esc_html_e( 'Print Certificate', 'ecademy-toolkit' ); ?></button>
        <script type="text/javascript">
            (function($){
                "use strict";
                    $(".lp_print_cer_btn").click(function(){

                        var cookieValue = document.getElementById('5545'); var textContent = cookieValue.textContent;

                        function VoucherSourcetoPrint() {

                            return "<html><head><script>function step1(){\n" +
                                    "setTimeout('step2()', 10);}\n" +
                                    "function step2(){window.print();window.close()}\n" +
                                    "</scri" + "pt></head><body onload='step1()'>\n" +
                                    "<img src='" + textContent + "' /></body></html>";
                        }
                        var pwa = window.open();
                        pwa.document.open();
                        pwa.document.write(VoucherSourcetoPrint(textContent));
                        pwa.document.close();
                    });
            }(jQuery));
        </script>
        <style>
            .certificate-actions li a, .lp_print_cer_btn {
                padding: 10px 25px !important;
                display: inline-block;
                background: #2e8a17 !important;
                height: auto !important;
                border: none;
                line-height: 24px;
                color: #fff !important;
                font-weight: normal;
                border: 1px solid #fff;
                margin-right: 2px;
                cursor: pointer;
                transition: 0.4s;
                border-radius: 6px;
                font-size: 16px !important;
                font-family: normal !important;
            }
            .certificate-actions li.download a:hover, .lp_print_cer_btn:hover {
                background: #000 !important;
            }
        </style>
	</li>

	<?php
	if ( isset( $socials ) && $socials ) {
		foreach ( $socials as $social ) {
			?>
			<li class="share-social-cert">
				<?php echo $social; ?>
			</li>
			<?php
		}
	}
	?>
</ul>

