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



        if ($('.book-bar').length) {
            // Booking Bar

            $('.hover .book-bar').hover(
                function () {
                    $(this).parent().find('.section').addClass('over');
                },
                function () {
                    $(this).parent().find('.section').removeClass('over');
                }
            );
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