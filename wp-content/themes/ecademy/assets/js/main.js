(function($){
	"use strict";
	jQuery(document).on('ready', function () {

        // Header Sticky
		$(window).on('scroll',function() {
            if ($(this).scrollTop() > 120){
                $('.navbar-area').addClass("is-sticky");
            }
            else{
                $('.navbar-area').removeClass("is-sticky");
            }
        });

        // Newsletter Modal JS
        if (jQuery(".newsletter-modal")[0]) {
            var popDisplayed = $.cookie('popDisplayed');
            if(popDisplayed == '1'){
                console.log('');
            }else{
                setTimeout(function(){
                    $("body").addClass('modal-open');
                    $("#newsletter-modal").fadeIn(500);
                }, 3000);
                $.cookie('popDisplayed', '1', { expires: 1 });

                $(".btn-yes").on('click', function () {
                    $("#newsletter-modal").fadeOut(500);
                    $("body").removeClass('modal-open');
                });
            }
        }

        // Odometer JS
        $('.odometer').appears(function(e) {
			var odo = $(".odometer");
			odo.each(function() {
				var countNumber = $(this).attr("data-count");
				$(this).html(countNumber);
			});
        });


        $(".search-submit, .blog_widget #bbp_search_submit").val('');

        // Bbpress Breadcrumbs
        if ($('.bbp-breadcrumb').length > 0) {
            $( '.bbp-breadcrumb' ).appendTo( $(".bbpress-breadcrumbs"));
        }

        // Others Option Responsive JS
        $(".others-option-for-responsive .dot-menu").on("click", function(){
            $(".others-option-for-responsive .container .container").toggleClass("active");
        });

        // Button Hover JS
        $(function() {
            $('.default-btn')
            .on('mouseenter', function(e) {
                var parentOffset = $(this).offset(),
                relX = e.pageX - parentOffset.left,
                relY = e.pageY - parentOffset.top;
                $(this).find('span').css({top:relY, left:relX})
            })
            .on('mouseout', function(e) {
                var parentOffset = $(this).offset(),
                relX = e.pageX - parentOffset.left,
                relY = e.pageY - parentOffset.top;
                $(this).find('span').css({top:relY, left:relX})
            });
        });

        // FAQ Accordion
        $(function() {
            $('.accordion').find('.accordion-title').on('click', function(){
                // Adds Active Class
                $(this).toggleClass('active');
                // Expand or Collapse This Panel
                $(this).next().slideToggle('fast');
                // Hide The Other Panels
                $('.accordion-content').not($(this).next()).slideUp('fast');
                // Removes Active Class From Other Titles
                $('.accordion-title').not($(this)).removeClass('active');
            });
        });

        // Mean Menu
		$('.mean-menu').meanmenu({
			meanScreenWidth: "1199"
        });

        $(".learnpress .become-teacher-form .form-fields .form-field label").first().append("<span>*</span>");
        $(".learnpress .become-teacher-form .form-fields .form-field:nth-child(2) label").append("<span>*</span>");

        // Banner Animation
        window.onload = function() {
            var timeline = new TimelineMax();
            timeline.from(".main-banner-content, .main-banner-courses-list, .banner-wrapper-content, .banner-wrapper-image, .banner-content, .banner-image", 1, {y:60},0)
        }

        // Isotop Js
        var $grid = $('.blog-items, .courses-items').isotope({
            itemSelector: '.grid-item',
            percentPosition: true,
            masonry: {
                // Use outer width of grid-sizer for columnWidth
                columnWidth: '.grid-item'
            }
        });

        // Popup Image
		$('.popup-btn').magnificPopup({
            type: 'image',
            gallery: {
                enabled:true
            }
        });

        // Tabs
        (function ($) {
            $('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');
            $('.tab ul.tabs li a').on('click', function (g) {
                var tab = $(this).closest('.tab'),
                index = $(this).closest('li').index();
                tab.find('ul.tabs > li').removeClass('current');
                $(this).closest('li').addClass('current');
                tab.find('.tab-content').find('div.tabs-item').not('div.tabs-item:eq(' + index + ')').slideUp();
                tab.find('.tab-content').find('div.tabs-item:eq(' + index + ')').slideDown();
                g.preventDefault();
            });
        })(jQuery);

        // Price Range Slider JS
        $(".js-range-of-price").ionRangeSlider({
            type: "double",
            drag_interval: true,
            min_interval: null,
            max_interval: null,
        });

        // Input Plus & Minus Number JS
        $('.input-counter').each(function() {
            var spinner = jQuery(this),
            input = spinner.find('input[type="text"]'),
            btnUp = spinner.find('.plus-btn'),
            btnDown = spinner.find('.minus-btn'),
            min = input.attr('min'),
            max = input.attr('max');

            btnUp.on('click', function() {
                var oldValue = parseFloat(input.val());
                if (oldValue >= max) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue + 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });
            btnDown.on('click', function() {
                var oldValue = parseFloat(input.val());
                if (oldValue <= min) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue - 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });
        });

        // Load More
        $(function () {
            $(".courses-section .col-lg-4").slice(0, 6).show();
            $("body").on('click touchstart', '.load-more-btn .load-more', function (e) {
                e.preventDefault();
                $(".courses-section .col-lg-4:hidden").slice(0, 3).slideDown();
                if ($(".courses-section .col-lg-4:hidden").length == 0) {
                    $(".load-more-btn").css('display', 'none');
                }
                $('html,body').animate({
                    scrollTop: $(this).offset().top
                }, 1000);
            });
        });

        // Nice Select JS
        $('select').niceSelect();

        // Popup Video
		$('.popup-youtube').magnificPopup({
			disableOn: 320,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
        });

        // Go to Top
        $(function(){
            // Scroll Event
            $(window).on('scroll', function(){
                var scrolled = $(window).scrollTop();
                if (scrolled > 300) $('.go-top').addClass('active');
                if (scrolled < 300) $('.go-top').removeClass('active');
            });
            // Click Event
            $('.go-top').on('click', function() {
                $("html, body").animate({ scrollTop: "0" },  500);
            });
        });

       
        $("input#billing_rut").rut({
            formatOn: 'keyup',
            minimumLength: 8, // validar largo mínimo; default: 2
            validateOn: 'change' // si no se quiere validar, pasar null
        });

        $("input#billing_rut").rut().on('rutInvalido', function(e) {
            let ruti = $(this).val();
            $(this).val('');
            alert("El rut " + ruti + " es inválido");
        });

        $("#billing_validate_email").on('paste', function(e){
            e.preventDefault();
            alert('No se puede pegar, escriba su correo electronico');
        })

        /** Crear campos al presionar nuevo alumno **/
        let numero = 1;
        $('#btn-add-estudiante').on('click',function(){
            numero++;
            let newAlumno = `
            <div>
                <h5 class="titulo-alumno">Alumno ${numero}</h5>
                <p class="form-row form-row-first txt-form thwcfd-field-wrapper thwcfd-field-text validate-required" id="additional_nom_alum_field${numero}" data-priority="20"><label for="additional_nom_alum" class="">Nombre&nbsp;<abbr class="required" title="obligatorio">*</abbr></label><span class="woocommerce-input-wrapper"><input type="text" class="input-text " name="additional_nom_alum" id="additional_nom_alum${numero}" placeholder="" value=""></span></p>
                <p class="form-row form-group form-row-last thwcfd-field-wrapper thwcfd-field-text validate-required" id="additional_apell_alum_field${numero}" data-priority="30"><label for="additional_apell_alum" class="">Apellido&nbsp;<abbr class="required" title="obligatorio">*</abbr></label><span class="woocommerce-input-wrapper"><input type="text" class="input-text " name="additional_apell_alum" id="additional_apell_alum${numero}" placeholder="" value=""></span></p>
                <p class="form-row form-group form-row-first thwcfd-field-wrapper thwcfd-field-text validate-required" id="additional_edad_alum_field${numero}" data-priority="40"><label for="additional_edad_alum" class="">Edad&nbsp;<abbr class="required" title="obligatorio">*</abbr></label><span class="woocommerce-input-wrapper"><input type="text" class="input-text " name="additional_edad_alum" id="additional_edad_alum${numero}" placeholder="" value=""></span></p>
                <p class="form-row form-row-last thwcfd-field-wrapper thwcfd-field-select validate-required" id="additional_curso_alum_field${numero}" data-priority="50"><label for="additional_curso_alum" class="">Curso&nbsp;<abbr class="required" title="obligatorio">*</abbr></label><span class="woocommerce-input-wrapper"><select name="additional_curso_alum" id="additional_curso_alum${numero}" class="select thwcfd-enhanced-select select2-hidden-accessible enhanced" data-allow_clear="true" data-placeholder="Seleccione curso" style="display: none;" tabindex="-1" aria-hidden="true">
				<option value="" selected="selected">Seleccione curso</option><option value="13">Kinder</option><option value="1">1° Basico</option><option value="2">2° Basico</option><option value="3">3° Basico</option><option value="4">4° Basico</option><option value="5">5° Basico</option><option value="6">6° Basico</option><option value="7">7° Basico</option><option value="8">8° Basico</option><option value="9">I Medio</option><option value="10">II Medio</option><option value="11">III Medio</option><option value="12">IV Medio</option>
				</select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 405.609px;"><span class="selection"><span class="select2-selection select2-selection--single" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-additional_curso_alum-container" role="combobox"><span class="select2-selection__rendered" id="select2-additional_curso_alum-container${numero}" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">Seleccione curso</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span><div class="nice-select select thwcfd-enhanced-select" tabindex="0"><span class="current">Seleccione curso</span><ul class="list"><li data-value="" class="option selected">Seleccione curso</li><li data-value="13" class="option">Kinder</li><li data-value="1" class="option">1° Basico</li><li data-value="2" class="option">2° Basico</li><li data-value="3" class="option">3° Basico</li><li data-value="4" class="option">4° Basico</li><li data-value="5" class="option">5° Basico</li><li data-value="6" class="option">6° Basico</li><li data-value="7" class="option">7° Basico</li><li data-value="8" class="option">8° Basico</li><li data-value="9" class="option">I Medio</li><li data-value="10" class="option">II Medio</li><li data-value="11" class="option">III Medio</li><li data-value="12" class="option">IV Medio</li></ul></div></span></p>
            </div>
            `;
            
            $('.woocommerce-additional-fields__field-wrapper').append(newAlumno);
        });


        /** Validamos que los campos de pass y validacion sean iguales **/
        $('#billing_val_pass').on('blur',function(){
            //Capturo la contraseña actual
            let pass = $('#billing_pass').val();
            let repass = $(this).val();
            $('#texto-validacion').remove();
            if(pass != repass){
                $('#billing_val_pass_field').append('<small class="texto-rojo" id="texto-validacion" >Las contraseñas no son iguales</small>');
                $(this).val('');
            }
        });


        $('.bajaVentipay').on('click',function(){
            let id = $(this).data('id');
            $('#idSusVenty').val(id);
        });

        $('.updVentipay').on('click',function(){
            let id = $(this).data('id');
            let nombre = $(this).data('nom');
            let interval = $(this).data('interval');
            switch (interval) {
                case "1month":
                    $('#1m').prop('checked')
                    break;
                case "3months":
                    $('#3m').prop('checked')
                    break;
                case "6months":
                    $('#6m').prop('checked')
                    break;
            
                default:
                    break;
            }
            $('#idSusVenty1').val(id);
            $('#nomSusVenty').html(nombre);
        });
        
        //Quita texto del formulario de contacto
        var motivoCont = $('#txtMotivo');
        var mailCont = $('#mailContacto');
        var msjCont = $('#mensaje');
        
        motivoCont.keyup(function(){
           //Capturo las variables
            if(
                motivoCont.val() != '' &&
                mailCont.val() != '' &&
                msjCont.val() != ''
              ){
                $('#msjValCont').hide();
            }else{
                $('#msjValCont').show();
            }
            
        });
        
        mailCont.keyup(function(){
           //Capturo las variables
            if(
                motivoCont.val() != '' &&
                mailCont.val() != '' &&
                msjCont.val() != ''
              ){
                $('#msjValCont').hide();
            }else{
                $('#msjValCont').show();
            }
            
        });
        
        msjCont.keyup(function(){
           //Capturo las variables
            if(
                motivoCont.val() != '' &&
                mailCont.val() != '' &&
                msjCont.val() != ''
              ){
                $('#msjValCont').hide();
            }else{
                $('#msjValCont').show();
            }
            
        });


        $("input[name=confirm]").click(function () {    
            if($('input:radio[name=confirm]:checked').val() == 1){

                $('#btnBaja').removeAttr('disabled');
            }
        });

        
    });

	// WoW JS
	$(window).on ('load', function (){
        if ($(".wow").length) {
            var wow = new WOW ({
                boxClass:     'wow',      // Animated element css class (default is wow)
                animateClass: 'animated', // Animation css class (default is animated)
                offset:       20,         // Distance to the element when triggering the animation (default is 0)
                mobile:       true,       // Trigger animations on mobile devices (default is true)
                live:         true,       // Act on asynchronously loaded content (default is true)
            });
            wow.init();
        }
    });

    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
            // Blog Slides
            $('.blog-slides').owlCarousel({
                loop: true,
                nav: true,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 1,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    }
                }
            });

            // Feedback Slides
            $('.feedback-slides').owlCarousel({
                loop: true,
                nav: false,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                animateOut: 'fadeOut',
                autoHeight: true,
                items: 1,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
            });
            // Sidebar Sticky
            $('.courses-sidebar-sticky').stickySidebar({
                topSpacing: 90,
                bottomSpacing: 90
            });

            // Testimonials Slides
            $('.testimonials-slides').owlCarousel({
                loop: true,
                nav: false,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                animateOut: 'fadeOut',
                autoHeight: true,
                items: 1,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
            });

            // Feedback Slides Two
            $('.feedback-slides-two').owlCarousel({
                loop: true,
                nav: false,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 1,
                    },
                    768: {
                        items: 2,
                    },
                    1200: {
                        items: 2,
                    }
                }
            });

            // Article Image Slides
            $('.article-image-slides').owlCarousel({
                loop: true,
                nav: true,
                dots: false,
                autoplayHoverPause: true,
                autoplay: true,
                animateOut: 'fadeOut',
                items: 1,
                navText: [
                    "<i class='flaticon-chevron'></i>",
                    "<i class='flaticon-right-arrow'></i>"
                ],
            });

            // Courses Slides
            $('.courses-slides').owlCarousel({
                loop: true,
                nav: true,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 1,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    }
                }
            });

            // Advisor Slides Two
            $('.advisor-slides-two').owlCarousel({
                loop: true,
                nav: false,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    }
                }
            });

            // Advisor Slides
            $('.advisor-slides').owlCarousel({
                loop: true,
                nav: false,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 1,
                    },
                    992: {
                        items: 2,
                    }
                }
            });

            // MixItUp Shorting
            $(function(){
                $('.shorting').mixItUp();
            });

            // TweenMax JS
            $('.main-banner, .banner-section, .banner-wrapper-area, .banner-wrapper').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.banner-shape1, .banner-shape2, .banner-shape3, .banner-shape4, .banner-shape5, .banner-shape6, .banner-shape7, .banner-shape8, .banner-shape9, .banner-shape10, .banner-shape11, .banner-shape12, .banner-shape13').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.about-area, .about-area-two, .about-area-three').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.funfacts-and-feedback-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.get-instant-courses-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.view-all-courses-area, .view-all-courses-area-two').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.premium-access-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.slogan-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.subscribe-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.feedback-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.success-story-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });

            $('.health-coaching-banner-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.health-coaching-shape2, .health-coaching-shape4, .health-coaching-shape5, .health-coaching-shape6, .health-coaching-shape7').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.experience-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.experience-shape1, .experience-shape2').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });

            // TweenMax JS
            $('.kindergarten-main-banner').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.kindergarten-banner-image .image img').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });

            // Feedback Slides Three
            $('.feedback-slides-three').owlCarousel({
                loop: true,
                nav: true,
                dots: false,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 0,
                navText: [
                    "<i class='flaticon-chevron'></i>",
                    "<i class='flaticon-right-arrow'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    },
                    1200: {
                        items: 4,
                    },
                    1550: {
                        items: 5,
                    }
                }
            });

            // Services Slides
            $('.services-slides').owlCarousel({
                loop: true,
                nav: true,
                dots: false,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='flaticon-chevron'></i>",
                    "<i class='flaticon-right-arrow'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    }
                }
            });

            // Courses Slides Two
            $('.courses-slides-two').owlCarousel({
                loop: false,
                nav: true,
                dots: false,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='flaticon-chevron'></i>",
                    "<i class='flaticon-right-arrow'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 1,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    }
                }
            });

            $('.gym-banner-slides').owlCarousel({
                items: 1,
                nav: true,
                loop: true,
                dots: false,
                autoplay: false,
                animateIn: 'fadeIn',
                animateOut: 'fadeOut',
                autoplayHoverPause: true,
                onInitialized: sliderCounter, // When the plugin has initialized.
                onTranslated: sliderCounter, // When the translation of the stage has finished.
                navText: [
                    "<i class='flaticon-chevron'></i>",
                    "<i class='flaticon-right-arrow'></i>"
                ],
                responsive: {
                    0: {
                        autoHeight: true
                    },
                    576: {
                        autoHeight: false
                    },
                    768: {
                        autoHeight: false
                    },
                    992: {
                        autoHeight: false
                    }
                }
            });

            function sliderCounter(event) {
                var element = event.target; // DOM element, in this example .owl-carousel
                var items = event.item.count; // Number of items
                var item = event.item.index * 1; // Position of the current item

                // it loop is true then reset counter from 1
                if (item > items) {
                    item = item - items
                }
                $(element).parent().find('.sliderCounter').html("0" + item + "/0" + items)
            }

            // Gym Feedback Slides
            $('.gym-feedback-slides').owlCarousel({
                items: 1,
                nav: true,
                loop: true,
                dots: false,
                autoplay: false,
                autoHeight: true,
                animateOut: 'fadeOut',
                autoplayHoverPause: true,
                navText: [
                    "<i class='flaticon-chevron'></i>",
                    "<i class='flaticon-right-arrow'></i>"
                ],
            });

            // Trainer Slides
            $('.trainer-slides').owlCarousel({
                nav: false,
                margin: 30,
                loop: true,
                dots: false,
                autoplay: false,
                autoplayHoverPause: true,
                navText: [
                    "<i class='flaticon-chevron'></i>",
                    "<i class='flaticon-right-arrow'></i>"
                ],
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 2
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    },
                    1200: {
                        items: 4
                    },
                    1550: {
                        items: 5
                    }
                }
            });

            // Testimonials Slides
            $('.testimonials-slides-two').owlCarousel({
                items: 1,
                nav: true,
                loop: true,
                dots: false,
                autoplay: true,
                autoplayHoverPause: true,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ]
            });

            // Partner Slides
            $('.partner-slides').owlCarousel({
                loop: true,
                nav: false,
                dots: false,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
                responsive: {
                    0: {
                        items: 2
                    },
                    576: {
                        items: 3
                    },
                    768: {
                        items: 4
                    },
                    1200: {
                        items: 5
                    }
                }
            });

            setTimeout(function(){
                $('.shorting-menu .filter.all').trigger('click');
            }, 1000);
        });
    });

    // Preloader
    $(window).on('load', function () {
        $('.preloader').fadeOut();
    });

   


   
  

}(jQuery));



