// @ts-nocheck
(function () {
    'use strict';

    /* Mobile Bars */
    $('#burguer-bars').click(function(){
        $(this).stop();
        $(this).toggleClass('open');
    });

    /* Window Load */
    window.onload = function() {
        // Preloader Active Code
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });

        /* Modal download book */
        $('#invitationModal').modal('show');

        /* Modal TOS Seminarios Live */
        /*     $('#tosSeminarioModal').modal({
                show: true,
                backdrop: true
            }); */

        /* ************************* */
        /* Owl Carousels */
            /* Home */
                /* Banners Publicitarios */
                    $("#banner-publicitario-slider").owlCarousel ({
                        loop: true,
                        items: 1,
                        slideBy: 1,
                        autoplay: true,
                        mouseDrag: false,
                        touchDrag: false,
                        autoplayTimeout: 4000,
                        animateOut: 'animate__fadeOut',
                        animateIn: 'animate__fadeIn'
                    });
                /* Fin Banners Pub */
                /* Main Articulos */
                    $("#main-articles-slider").owlCarousel ({
                        loop: true,
                        items: 1,
                        slideBy: 1,
                        autoHeight: true,
                        autoplay: true,
                        autoplayTimeout: 3000,
                        margin: 5
                    });
                /* Fin Main Articulos */
                /* Bitacora */
                    $("#bitacora-slider").owlCarousel ({
                        loop: true,
                        items: 1,
                        slideBy: 1,
                        autoplay: false,
                        lazyLoad: true,
                        mouseDrag: false,
                        margin: 7,
                        center: true,
                        responsive: {
                            768: {
                                items: 3,
                                center: false
                            }
                        }
                    });
                /* Fin Bitacora */
                /* Charlas Abiertas */
                    $("#last-charlas-abiertas-slider").owlCarousel ({
                        loop: false,
                        items: 1,
                        slideBy: 1,
                        autoplay: false,
                        mouseDrag: false,
                        margin: 5,
                        responsive: {
                            768: {
                                items: 2
                            }
                        }
                    });
                /* Fin Charlas */
            /* Fin Home */

            /* Cuarentena Videos */
                $('#videos-cuarentena').owlCarousel({
                    items: 1,
                    nav: true,
                    loop: true,
                    navText: ['<i class="fa fa-angle-left owl-left-vid"></i>', '<i class="fa fa-angle-right owl-right-vid"></i>'],
                    center: true
                });
            /* Fin Cuarentea Videos */

            /* Cuarentena Articulos */
                $('#articulos-cuarentena').owlCarousel({
                    loop:true,
                    margin: 15,
                    nav: true,
                    navText: ['<i class="fa fa-chevron-circle-left owl-left-art"></i>', '<i class="fa fa-chevron-circle-right owl-right-art"></i>'],
                    dots: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 3
                        },
                        1000: {
                            items: 4
                        }
                    }
                });
            /* Fin Cuarentena Artículos */

            /* Cursos y Seminarios */
                /* Listado de cursos */
                    $('#slider-mobile-cursos').owlCarousel({
                        loop: true,
                        margin: 10,
                        nav: true,
                        navText: ['<i class="fa fa-chevron-circle-left owl-left-arrow"></i>', '<i class="fa fa-chevron-circle-right owl-right-arrow"></i>'],
                        dots: false,
                        autoplay: true,
                        slideBy: 1,
                        items: 1
                    });
                    $('#cursos-listado').owlCarousel({
                        loop: false,
                        margin: 10,
                        nav: true,
                        navText: ['<i class="fa fa-chevron-circle-left owl-left-arrow"></i>', '<i class="fa fa-chevron-circle-right owl-right-arrow"></i>'],
                        dots: false,
                        rewind: true,
                        slideBy: 1,
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 3
                            },
                            1000: {
                                items: 4
                            }
                        }
                    });
                /* Fin Listdo de Cursos */

                /* Seminarios Listado */
                    $('#slider-mobile-seminarios').owlCarousel({
                        loop: true,
                        margin: 10,
                        nav: true,
                        navText: ['<i class="fa fa-chevron-circle-left owl-left-arrow"></i>', '<i class="fa fa-chevron-circle-right owl-right-arrow"></i>'],
                        dots: false,
                        autoplay: true,
                        slideBy: 1,
                        items: 1
                    });
                    $('#seminarios-listado').owlCarousel({
                        loop: false,
                        margin: 10,
                        nav: true,
                        navText: ['<i class="fa fa-chevron-circle-left owl-left-arrow"></i>', '<i class="fa fa-chevron-circle-right owl-right-arrow"></i>'],
                        dots: false,
                        rewind: true,
                        slideBy: 1,
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 3
                            },
                            1000: {
                                items: 4
                            }
                        }
                    });
                /* Fin Seminarios Listado */
            /* Fin Cursos y Seminarios */

            /* Videos Semanales */
                $('#hero-post-slide').owlCarousel({
                    loop: false,
                    autoplay: true,
                    margin: 10,
                    nav: false,
                    dots: false,
                    rewind: true,
                    slideBy: 1,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 3
                        }
                    }
                });
            /* Fin Videos Semanales */

            /* Seminarios Live */
            $('#temas-box').owlCarousel({
                loop: true,
                autoplay: true,
                margin: 10,
                nav: false,
                dots: false,
                autoplayTimeout: 2500,
                autoplaySpeed: 500,
                responsive: {
                    0: {
                        items: 1
                    },
                    769: {
                        items: 2
                    },
                    1080: {
                        items: 3
                    }
                }
            })

            $('#videos-live').owlCarousel({
                loop: false,
                margin: 10,
                nav: true,
                navText: ['<i class="fa fa-chevron-circle-left owl-left-arrow"></i>', '<i class="fa fa-chevron-circle-right owl-right-arrow"></i>'],
                dots: false,
                rewind: true,
                items: 1,
                slideBy: 1
            });
        /* Fin Seminarios Live */ 

        /* Fin Owl Carousels */


    }

    // :: Fullscreen Active Code
    $(window).on('resizeEnd', function () {
        $(".full_height").height($(window).height());
    });

    $(window).on('resize', function () {
        if (this.resizeTO) clearTimeout(this.resizeTO);
        this.resizeTO = setTimeout(function () {
            $(this).trigger('resizeEnd');
        }, 300);
    }).trigger("resize");

    // :: Sticky Active Code
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 20) {
            $('.header-area').addClass('sticky');
            $('#navbar-brand').attr('src','/img/core-img/logo_texto_blanco.png');
        } else {
            $('.header-area').removeClass('sticky');
            $('#navbar-brand').attr('src','/img/core-img/logo_texto_azul.png')
        }
    });

    // :: Tooltip Active Code
    $('[data-toggle="tooltip"]').tooltip();

    // :: Gallery Menu Style Active Code
    $('.portfolio-menu button.btn').on('click', function () {
        $('.portfolio-menu button.btn').removeClass('active');
        $(this).addClass('active');
    })

    // :: Masonary Gallery Active Code
    if ($.fn.imagesLoaded) {
        $('.sonar-portfolio').imagesLoaded(function () {
            
            // filter items on button click
            $('.portfolio-menu').on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $grid.isotope({
                    filter: filterValue
                });
            });

            // init Isotope
            var $grid = $('.sonar-portfolio').isotope({
                itemSelector: '.single_gallery_item',
                percentPosition: true,
                masonry: {
                    columnWidth: '.single_gallery_item'
                }
            });
        });
    }

    // :: ScrollUp Active Code
    if ($.fn.scrollUp) {
        $.scrollUp({
            scrollSpeed: 1000,
            easingType: 'easeInOutQuart',
            scrollText: '<i class="fa fa-angle-up" aria-hidden="true"></i>'
        });
    }

    // :: PreventDefault <a>2 Click
    $("a[href='#']").on('click', function(e) {
        e.preventDefault();
    });


    /* Descargas */
        if($(window).width() < 576) {
            $('.item-categoria[category="all"]').hide();
        }else {
            $('.item-categoria[category="all"]').addClass('categoria-activa');
        }

        $('.categoria-box-mobile').slideUp();

        $('.item-categoria').click(function(){

            let category_item = $(this).attr('category');

                if($(window).width() < 576) {

                    $('.categoria-box-mobile').stop();
                    $('.categoria-box-mobile').slideUp();                                    

                    if(!($(this).hasClass('categoria-activa'))) {
                        $('.categoria-box-mobile[category='+category_item+']').slideDown();
                    }else {
                        if(!($('.categoria-box-mobile[category='+category_item+']').is(':visible'))) {
                            $('.categoria-box-mobile[category='+category_item+']').slideDown();
                        };
                    }
                    
                }else {
                    $('.card-item').css('opacity','0');
                    setTimeout(function(){
                        $('.card-item').hide();
                    },400)

                    setTimeout(function(){
                        $('.card-item[category='+category_item+']').show();
                        $('.card-item[category='+category_item+']').css('opacity','1');
                    },400)

                    $('.item-categoria[category="all"]').click(function(){
                        setTimeout(function(){
                            $('.card-item').show();
                            $('.card-item').css('opacity','1');
                        },400)
                    });
                }

                $('.item-categoria').removeClass('categoria-activa');
                $(this).addClass('categoria-activa');
        });
    /* Fin Descargas */


    /* check Country Phone Id */

    /* Fin Check Countru Phone Id */
    
})();