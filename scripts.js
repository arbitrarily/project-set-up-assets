(function( root, $, undefined ) {
	"use strict";

	$(function () {

		jQuery.fn.load = function(callback){
			$(window).on("load", callback);
		};

		var ######## = {

			touch: (Modernizr.touchevents ? "touchstart" : "click"),

			init: function() {
				this.fonts();
				// this.magnific_image();
				// this.magnific_video();
				// this.nav_toggle();
				// this.match_height();
				// this.flexslider();
				// this.sticky_nav();
			},

			fonts: function() {
				// Google Fonts
				WebFont.load({
					google: {
						families: ["Open Sans"]
					},
					timeout: 1000,
					classes: false,
					events: false,
					text: "abcdefghijklmnopqrstuvwxyz!@$%&*()[]{}=-_+,.`/\'\"",
					active: function() {
						// Store in Session
						sessionStorage.fonts = true;
					}
				});
				// Check for Font
				var font = new FontFaceObserver("Open Sans", {
					weight: 300
				});
				font.load().then(function() {
					$("html").addClass("font-active");
				});
				// Fallback
				setTimeout(function() {
					if (!$("html").hasClass("font-active")) {
						$("html").addClass("font-active");
					}
				}, 1000);
			},

			magnific_image: function() {
				$("###").not(".grid__item--nav").magnificPopup({
					type: "image",
					mainClass: "mfp-with-zoom",
					zoom: {
						enabled: true,
						duration: 300, // duration of the effect, in milliseconds
						easing: "ease-in-out", // CSS transition easing function
						opener: function(openerElement) {
							return openerElement.is("img") ? openerElement : openerElement.find("img");
						}
					},
					gallery: {
						enabled: true
					},
					closeBtnInside: false,
					closeOnContentClick: true
				});
			},

			magnific_video: function() {
				$(".youtube").magnificPopup({
					items: {
						src: "https://www.youtube.com/watch?v=###"
					},
					type: "iframe",
					iframe: {
						markup: "<div class='mfp-iframe-scaler'>" +
							"<div class='mfp-close'></div>" +
							"<iframe class='mfp-iframe' frameborder='0' allowfullscreen></iframe>" +
							"</div>",
						patterns: {
							youtube: {
								index: "youtube.com/",
								id: "v=",
								src: "//www.youtube.com/embed/%id%?autoplay=1"
							}
						},
						srcAction: "iframe_src",
					}
				});
			},

			flexslider: function() {

				$(window).load(function() {
					if ($("#carousel").length && $("#slider").length) {
						$("#slider").flexslider({
							animation: "slide",
							controlNav: false,
							directionNav: false,
							animationLoop: false,
							slideshow: false,
							sync: "#carousel",
							after: function (slider) {
								$("#carousel li").on(########.touch, function() {
									$("#carousel li").removeClass("flex-active-slide");
									$(this).addClass("flex-active-slide");
								});
							}
						});
						$("#carousel").flexslider({
							animation: "slide",
							controlNav: false,
							animationLoop: false,
							directionNav: false,
							slideshow: false,
							// itemWidth: 100,
							// itemMargin: 0,
							asNavFor: "#slider"
						});
					}
				});
			},

			sticky_nav: function() {
				$(window).scroll(function() {

					var scroll = $(window).scrollTop(),
						header = $(".header"),
						div_top = $("TOPSECTION").offset().top,
						height = $("SECONDSECTION").height();

					if (scroll > ((div_top + height) / 4)) {
						header.addClass("background");
					} else {
						header.removeClass("background");
					}

				});
			},


			smooth_scroll: function() {
				$("a[href*='#']").each(function() {
					$(this).on(########.touch, function() {
						var target = this.hash;
						$("html, body").animate({
							scrollTop: $(target).offset().top - $(".header").height()
						}, 1000);
					});
				});
			},

			nav_toggle: function() {
				$(".nav-toggle, #modal").on(########.touch, function(e) {
					e.preventDefault();
					$('.header, #modal').toggleClass('mobile');
				});
			},


			match_height: function() {
				var options = {
					byRow: true,
					property: "height",
					target: null,
					remove: false
				};
				$(".equal").matchHeight(options);
			}

		};

		########.init();

		$(window).on("beforeunload", function() {
			$("body").addClass("font-active");
		});

		$(window).resize(function() {});

	});

} ( this, jQuery ));
