/* Alpha Hotel: HTML Template by Klaye Morrison (http://klayemorrison.com) */



/******************** Document Ready ********************/

$(document).ready(function () {
	
	'use strict';
	
	// Desktop Detection - Applies '.hover' class to document if non-touch browser
	
	if (!('ontouchstart' in document.documentElement)) { document.documentElement.className += 'hover'; }
	
	
	
	/******************** Header ********************/
	
	// Active Navigation
	
    $('nav li a').each(function () {
        if (this.href == window.location.href.split('#')[0]) {
            $(this).addClass('active');
			$(this).parent().parent().parent().find('> a').addClass('active');
			$(this).parent().parent().parent().parent().parent().find('> a').addClass('active');
        }
	});
	
	// Drop Downs
	
	$('nav li').hover(
		function () {
			if ($(window).width() > 1024) {
				$(this).find('ul:first').css('display','block').stop().animate({opacity:'1'},300,'easeInOutQuart');
			}
		}, 
		function () {
			if ($(window).width() > 1024) {
				$(this).find('ul:first').stop().animate({opacity:'0'},300,'easeInOutQuart', function() {
					$(this).css({display:'none'});
				});
			}
		}
	);
	
	// Mobile Navigation
	
	var menu = $('#mobilenav');
	var nav = $('nav ul:first-child');

	$(menu).on('click', function(e) {
		e.preventDefault();
		nav.stop().slideToggle(300);
	});
	
	// Scroll
	
	$(window).scroll(function() {
		
		if ($(window).scrollTop() > 0) {
			$('header').addClass('scroll');
		}
		else {
			$('header').removeClass('scroll');
		}
		
		if ($('.book-bar').length){
			if ($(window).scrollTop() > $('#book-bar').offset().top) {
				$('body').addClass('scroll');
			}
			else {
				$('body').removeClass('scroll');
				$('body').removeClass('book-slide');
			}
		}
	});
	
	// Languages
	
	if ($(window).width() <= 1024) {
		var langpull = $('#language li:first-child');
		var langmenu = $('#language');
	
		$(langpull).on('click', function(e) {
			e.preventDefault();
			langmenu.toggleClass('active');
		});
	}
    else {
        $('#language').hover(
		function () {
			$(this).toggleClass('active');
		});
    }
	
	
	
	/******************** Date Picker ********************/
	
	var months = 2;

	if ($(window).width() < 1000) {
		var months = 1;
	}
    if (typeof Laracasts !== 'undefined') {
        var hoy = new Date();
        var bandera = true;
        var cont = 0;
        while (bandera) {
            var fecha = hoy.toJSON().slice(0, 10);
            bandera = false;
            for (var i = 0, len = Laracasts.unavailable.length; i < len; i++) {
                if (fecha == Laracasts.unavailable[i]) {
                    bandera = true;
                }
            }
            hoy.setDate(hoy.getDate() + 1);
            cont = cont + 1;
        }

        if ($('.book-bar').length) {

            // Booking Bar

            $('.arrival').datepicker({
                minDate: '0M',
                regional: 'es',
                numberOfMonths: months,
                dateFormat: 'd MM yy',
                beforeShowDay: function (date) {
                    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    return [Laracasts.unavailable.indexOf(string) == -1]
                },
                onSelect: function () {
                    $('.arrival-day').html($('.arrival').val().split(' ')[0]);
                    $('.arrival-month').html($('.arrival').val().split(' ')[1]);
                    var date = $(this).datepicker('getDate');
                    date.setDate(date.getDate() + 1);
                    $('.departure').datepicker('option', 'minDate', date);
                    $('.departure').datepicker('setDate', date);
                    $('.departure-day').html($('.departure').val().split(' ')[0]);
                    $('.departure-month').html($('.departure').val().split(' ')[1]);
                }
            });
            $('.departure').datepicker({
                minDate: '0M',
                regional: 'es',
                numberOfMonths: months,
                dateFormat: 'd MM yy',
                beforeShowDay: function (date) {
                    var dateArribal = $('.arrival').datepicker('getDate');
                    var cont = 0;
                    while( Laracasts.unavailable.indexOf(jQuery.datepicker.formatDate('yy-mm-dd', dateArribal)) == -1 && cont < 60){
                        dateArribal.setDate(dateArribal.getDate() + 1);
                        cont++;
                    }
                    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    return [date <= dateArribal]
                },
                onSelect: function () {
                    var date = $(this).datepicker('getDate');
                    var bandera = false;
                    var dateArribal = $('.arrival').datepicker('getDate');
                    for (var i = 0, len = Laracasts.unavailable.length; i < len; i++) {
                        if (jQuery.datepicker.formatDate('yy-mm-dd', dateArribal) < Laracasts.unavailable[i] && Laracasts.unavailable[i] < jQuery.datepicker.formatDate('yy-mm-dd', date)) {
                            bandera = true;
                        }
                    }
                    if (bandera) {
                        $(".alert-fechas").fadeTo(4000, 500).slideUp(500);
                        dateArribal.setDate(dateArribal.getDate() + 1);
                        $(this).datepicker('setDate', dateArribal);
                    }
                    $('.departure-day').html($('.departure').val().split(' ')[0]);
                    $('.departure-month').html($('.departure').val().split(' ')[1]);
                }
            });


            $('.arrival').datepicker().datepicker('setDate', '' + (cont - 1));
            $('.arrival-day').html($('.arrival').val().split(' ')[0]);
            $('.arrival-month').html($('.arrival').val().split(' ')[1]);

            var date = $('.arrival').datepicker('getDate');
            date.setDate(date.getDate() + 1);
            $('.departure').datepicker('option', 'minDate', date);
            $('.departure').datepicker().datepicker('setDate', '' + cont);

            var date = $('.arrival').datepicker('getDate');
            date.setDate(date.getDate() + 1);
            $('.departure').datepicker('option', 'minDate', date);
            $('.departure-day').html($('.departure').val().split(' ')[0]);
            $('.departure-month').html($('.departure').val().split(' ')[1]);

            $('.date-arrival').click(function () {
                $('.arrival').datepicker('show');
            });
            $('.date-departure').click(function () {
                $('.departure').datepicker('show');
            });
            $('.date-book').click(function () {
                $('form.book-form').submit();
            });

            $('.hover .book-bar').hover(
                function () {
                    $(this).parent().find('.section').addClass('over');
                },
                function () {
                    $(this).parent().find('.section').removeClass('over');
                }
            );
        }

        // Contact Form

        $('.contact-arrival').datepicker({
            minDate: '0M',
            regional: 'es',
            numberOfMonths: months,
            dateFormat: 'd MM yy',
            beforeShowDay: function (date) {
                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                return [Laracasts.unavailable.indexOf(string) == -1]
            },
            onSelect: function () {
                var date = $(this).datepicker('getDate');
                date.setDate(date.getDate() + 1);
                $('.contact-departure').datepicker('option', 'minDate', date);
                $('.contact-departure').datepicker('setDate', date);
                $.ajax({
                    url: RESERVA_URL+'/Precio/' + jQuery.datepicker.formatDate('yy-mm-dd', $(this).datepicker('getDate')) + '/' + jQuery.datepicker.formatDate('yy-mm-dd', date),
                    type: 'GET',
                    dataType: 'json',
                    //cache:false,
                    success: function (data) {
                        if (data['success']) {

                            $('input[name=total]').val(data['precio']+'€');
                        }
                    }
                });
            }
        });
        $('.contact-departure').datepicker({
            minDate: '0M',
            numberOfMonths: months,
            dateFormat: 'd MM yy',
            beforeShowDay: function (date) {

                var dateArribal = $('.contact-arrival').datepicker('getDate');
                var cont = 0;
                while( Laracasts.unavailable.indexOf(jQuery.datepicker.formatDate('yy-mm-dd', dateArribal)) == -1 && cont<60){
                    dateArribal.setDate(dateArribal.getDate() + 1);
                }
                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                return [date <= dateArribal];

            },
            onSelect: function () {
                var date = $(this).datepicker('getDate');
                var bandera = false;
                var dateArribal = $('.contact-arrival').datepicker('getDate');
                for (var i = 0, len = Laracasts.unavailable.length; i < len; i++) {
                    if (jQuery.datepicker.formatDate('yy-mm-dd', dateArribal) < Laracasts.unavailable[i] && Laracasts.unavailable[i] < jQuery.datepicker.formatDate('yy-mm-dd', date)) {
                        bandera = true;
                    }
                }
                if (bandera) {
                    $(".alert-fechas").fadeTo(4000, 500).slideUp(500);
                    dateArribal.setDate(dateArribal.getDate() + 1);
                    $(this).datepicker('setDate', dateArribal);
                }else {

                    $.ajax({
                        url: RESERVA_URL+'/Precio/' + jQuery.datepicker.formatDate('yy-mm-dd', dateArribal) + '/' + jQuery.datepicker.formatDate('yy-mm-dd', date),
                        type: 'GET',
                        dataType: 'json',
                        //cache:false,
                        success: function (data) {
                            if (data['success']) {
                                $('input[name=total]').val(data['precio']+'€');
                            }
                        }
                    });
                }

            }
        });

        $('.fecha-nacimiento').datepicker({
            numberOfMonths: 1,
            regional: 'es',
            dateFormat: 'd MM yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1900:' + hoy.getFullYear(),
            monthNamesShort: ["Ene", "Feb", "Mar", "Abr",
                "May", "Jun", "Jul", "Ago", "Sep",
                "Oct", "Nov", "Dec"],
            dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab']
        });

        $('.fecha-expedicion').datepicker({
            numberOfMonths: 1,
            regional: 'es',
            dateFormat: 'd MM yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1900:' + hoy.getFullYear(),
            monthNamesShort: ["Ene", "Feb", "Mar", "Abr",
                "May", "Jun", "Jul", "Ago", "Sep",
                "Oct", "Nov", "Dec"],
            dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab']
        });

        if ($('.contact-arrival').val() === '') {
            $('.contact-arrival').datepicker().datepicker('setDate', '' + (cont - 1));
        }
        if ($('.contact-departure').val() === '') {
            $('.contact-departure').datepicker().datepicker('setDate', '' + cont);
        }
        if ($('.contact-arrival').length) {
            var date = $('.contact-arrival').datepicker('getDate');
            date.setDate(date.getDate() + 1);
            $('.contact-departure').datepicker('option', 'minDate', date);
        }

        $('.fecha-nacimiento').datepicker().datepicker('setDate', '' + 0);
        $('.fecha-expedicion').datepicker().datepicker('setDate', '' + 0);


    }
	
	/******************** Sections ********************/
    
    // Background Image Replace
    
    $('.back').each(function() {
        var attr = $(this).attr('data-image');
            if (typeof attr !== typeof undefined && attr !== false) {
            $(this).css('background-image', 'url('+attr+')');
        }
    });
	
	// Photo Panel
	
	$('.hover .panel .item .panel-button a').hover(
		function () {
			$(this).parent().parent().parent().addClass('over');
		}, 
		function () {
			$(this).parent().parent().parent().removeClass('over');
		}
	);
	
	$('.hover .panel .item.feature .button').hover(
		function () {
			$(this).parent().parent().parent().addClass('over');
		}, 
		function () {
			$(this).parent().parent().parent().removeClass('over');
		}
	);
	
	$('.section.panel.hero .slider').carouFredSel({
		height: 'variable',
		swipe: true,
		responsive: true,
		scroll: {
			pauseOnHover: true,
			duration: 600,
			fx: 'crossfade'
		},
		items: {
			visible: 1,
			height: 'variable'
		},
		auto: { timeoutDuration: 4000 },
		prev: { button: '.section.panel .prev' },
		next: { button: '.section.panel .next' }
	});
	
	// Carousel
	
		$('.section.carousel.horizontal .slider').carouFredSel({
			width: '100%',
			height: 'variable',
			swipe: true,
			align: false,
			scroll: {
				items: 1,
				pauseOnHover: true,
				easing: 'easeInOutQuart',
				duration: 600
			},
			items: {
				visible: 'variable'
			},
			auto: { timeoutDuration: 4000 },
			prev: { button: '.section.carousel.horizontal .prev' },
			next: { button: '.section.carousel.horizontal .next' }
		});
		
		$('.section.carousel:not(.horizontal) .slider').carouFredSel({
			height: 'variable',
			swipe: true,
			responsive: true,
			scroll: {
				pauseOnHover: true,
				duration: 600,
				fx: 'crossfade'
			},
			items: {
				visible: 1,
				height: 'variable'
			},
			auto: { timeoutDuration: 4000 },
			prev: { button: '.section.carousel:not(.horizontal) .prev' },
			next: { button: '.section.carousel:not(.horizontal) .next' }
		});
	
	// Gallery
	
	/*var $container = $('.gallery'),
	colWidth = function () {
		var w = $container.width(),
		columnNum   = 4,
		columnWidth = 0,
		sizeVar = 0;
		if (w > 1100) { columnNum  = 4; }
		else { columnNum  = 2; }
		columnWidth = Math.floor(w/columnNum);
		function columnSize() {
			if (w < 340) { sizeVar = 25; }
			else if (w < 500) { sizeVar = 40; }
			else if (w < 640) { sizeVar = 50; }
			else if (w < 770) { sizeVar = 60; }
			else if (w < 1024) { sizeVar = 50; }
			else { sizeVar = 64; }
			$container.find('figure').each(function() {
				var $item = $(this),
				multiplier_w = $item.attr('class').match(/item-w(\d)/),
				multiplier_h = $item.attr('class').match(/item-h(\d)/),
				width = multiplier_w ? columnWidth*multiplier_w[1] : columnWidth,
				height = multiplier_h ? columnWidth*multiplier_h[1]*0.72-sizeVar : columnWidth*0.72-(sizeVar/2);
				$item.css({
					width: width,
					height: height
				});
			});
		}
		columnSize();
		return columnWidth;
	};

	function runisotope() {
		$container.isotope({
			layoutMode: 'packery',
			itemSelector: 'figure',
			transitionDuration: '0',
			resizable: true,
			masonry: {
				columnWidth: colWidth()
			}
		});
	}

	runisotope();
	
	$(window).resize(function() {
		runisotope();
    });
	
	function featherOpen() { $('.featherlight-content').addClass('pop'); }
	function featherClose() { $('.featherlight-content').removeClass('pop'); }
	
	$('.gallery figure img').lazyload({
		effect: 'fadeIn',
		failure_limit: 10,
		effectspeed: 300
	});
	
	$('.gallery figure a').featherlightGallery({
		gallery: {
			fadeIn: 300,
			fadeOut: 300
		},
		openSpeed: 300,
		closeSpeed: 300,
		galleryFadeIn: 0,
		galleryFadeOut: 0,
		afterOpen: featherOpen,
		beforeClose: featherClose
	});*/
	
	// Boxes
	
	$('.hover .boxes .item .button').hover(
		function () {
			$(this).parent().parent().parent().addClass('over');
		}, 
		function () {
			$(this).parent().parent().parent().removeClass('over');
		}
	);
	
	$('.hover .boxes .item .thumb a').hover(
		function () {
			$(this).parent().parent().addClass('over');
		}, 
		function () {
			$(this).parent().parent().removeClass('over');
		}
	);
	
	if ( $('.boxes .center').children().length > 1 ) {
		$('.boxes .center').wrecker({
			itemSelector : '.col-3',
			maxColumns : 3,
			responsiveColumns : [
				{1024 : 1}
			]
		});
	}
	
	// Services
	
	$('.services .item').hover(
		function () {
			$(this).parent().addClass('over');
		}, 
		function () {
			$(this).parent().removeClass('over');
		}
	);
	
	// Features
	
	$('.features .item .button').hover(
		function () {
			$(this).parent().parent().parent().addClass('over');
		}, 
		function () {
			$(this).parent().parent().parent().removeClass('over');
		}
	);
	
	$('.hover .features .item .thumb a').hover(
		function () {
			$(this).parent().parent().parent().addClass('over');
		}, 
		function () {
			$(this).parent().parent().parent().removeClass('over');
		}
	);
	
	// Timeline
	
	$('.timeline .item .button').hover(
		function () {
			$(this).parent().parent().parent().addClass('over');
		}, 
		function () {
			$(this).parent().parent().parent().removeClass('over');
		}
	);
	
	$('.timeline .item .thumb a').hover(
		function () {
			$(this).parent().parent().addClass('over');
		}, 
		function () {
			$(this).parent().parent().removeClass('over');
		}
	);
    
    // Accordion
	
    $('.accordion .question').click(function () {
		$(this).parent().stop().toggleClass('reveal');
        $(this).parent().find('.answer').stop().toggle(300, 'easeInOutQuart');
    });
});

// Section Fade

if ($(window).width() > 1024) {
	
	var timer;
	function fader() {
		
		'use strict';
		
		// Visible Items
		
		var visibleitems = function() {
			$('.fade').each(function() {
				if ($(this).visible(true)) {
					$(this).addClass('visible');
				}
			});
		};
		visibleitems();
		
		$(window).scroll(function () {
			visibleitems();
		});
	}
	
	setTimeout(function(){
		
		'use strict';
		
		$(window).off('load.fader');
		fader();
	},3000);

}



/******************** Window Load ********************/

$(window).load(function () {
	
	'use strict';
	
	// Testimonials
	
	$('.testimonials .center').isotope({
		layoutMode: 'packery',
		itemSelector: '.item',
		transitionDuration: '0',
		resizable: false
	});
	
	// Refreshes browser when resizing between desktop and tablet. Not necessary, but handy for responsive testing as different JS is being loaded.

    var oExpReg = /(.*)Galeria$/gi;
    var sUrl    = location.href;

    if(!oExpReg.test(sUrl)){
        if ($(window).width() > 1024) {
            var browsersize = 'desktop';
        }
        else {
            var browsersize = 'tablet';
        }
        $(window).resize(function () {
            if ($(window).width() > 1024) {
                if (browsersize == 'tablet') {
                    location.href = location.href
                }
            }
            else {
                if (browsersize == 'desktop') {
                    location.href = location.href
                }
            }
        });
    }
	
	// Fixes slider loading issues in some browsers
	
	$(window).trigger('resize');
	
	// Section Fade
	
	clearTimeout(timer);
    fader();
	
});