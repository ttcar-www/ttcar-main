/*------------------------------------------------------------------
[Table of contents]

- Author:  Andrey Sokoltsov
- Profile:	http://themeforest.net/user/andreysokoltsov
--*/

(function() {

	"use strict";

	let Core = {

		initialized: false,

		initialize: function() {

			if (this.initialized) return;
			this.initialized = true;

			this.build();

		},

		build: function() {

			//Placeholder for IE
			$('input, textarea').placeholder();
			
			// Dropdown menu
			this.dropdownhover();
			
			// Page preloader
			this.initPagePreloader();
			
			// Equal Height
			this.setEqualHeight();
			
			// Slider
			this.initSlider();

			// Owl Carousel
			this.initOwlCarousel();
			
			// bxSlider
			this.initBxSlider();
			
			// Tabs
			this.initTabs();
			
			// Collapse Blocks
			this.initCollapsible();
			
			// Counter
			this.initNumberCounter();
			
			// Go to top
			this.initGoToTop();
			
			
		},

		dropdownhover: function(options) {
			/** Extra script for smoother navigation effect **/
			if ($(window).width() > 798) {
				$('.navbar-main-slide').on('mouseenter', '.navbar-nav-menu > .dropdown', function() {
					"use strict";
					$(this).addClass('open');
				}).on('mouseleave', '.navbar-nav-menu > .dropdown', function() {
					"use strict";
					$(this).removeClass('open');
				});
			}
		},

		initPagePreloader: function(options) {
			let $preloader = $('#page-preloader'),
			$spinner = $preloader.find('.spinner-loader');
			$spinner.fadeOut();
			$preloader.delay(500).fadeOut('slow');
			window.scrollTo( 0, 0 );
		},

		setEqualHeight: function(){
			let equalHeight = $('body').data('equal-height');
			if(equalHeight && equalHeight.length){
				let columns = $(equalHeight);
				let tallestcolumn = 0;
				columns.each(
					function(){
						let currentHeight = $(this).height();
						if(currentHeight > tallestcolumn){
							tallestcolumn = currentHeight;
						}
					}
				);
				columns.height(tallestcolumn);
			}
		},

		initSlider: function(options){
			let slider = $('.slider').length;
			if(slider){
		        jQuery(".slider").slider({
		            min: 100,
		            max: 1000,
		            values: [0,1000],
		            range: true,
		            slide: function(event, ui){
		                $(".ui-slider-handle span.min").text(ui.values[0]);
		                $(".ui-slider-handle span.max").text(ui.values[1]);
		            },
		            stop:function(event, ui){
		                $("input.j-min").val(ui.values[0]);
		                $("input.j-max").val(ui.values[1]);
		            }
		        });
		        $(".ui-slider-handle:first-of-type").append("<span class='min'>100</span>");
		        $(".ui-slider-handle:last-of-type").append("<span class='max'>1000</span>");
			}
		},
		
		initOwlCarousel: function(options) {
			$(".enable-owl-carousel").each(function(i) {
				let $owl = $(this);
				
				let itemsData = $owl.data('items');
				let autoPlayData = $owl.data('auto-play');
				let navigationData = $owl.data('navigation');
				let stopOnHoverData = $owl.data('stop-on-hover');
				let itemsDesktopData = $owl.data('items-desktop');
				let itemsDesktopSmallData = $owl.data('items-desktop-small');
				let itemsTabletData = $owl.data('items-tablet');
				let itemsTabletSmallData = $owl.data('items-tablet-small');

				$(document).ready(function () {
					(function ($) {
						$owl.owlCarousel({
							items: itemsData,
							pagination: false,
							navigation: navigationData,
							autoPlay: autoPlayData,
							stopOnHover: stopOnHoverData,
							navigationText: ["",""],
							itemsCustom:[
								[0, 1],
								[500, itemsTabletSmallData],
								[710, itemsTabletData],
								[992, itemsDesktopSmallData],
								[1199, itemsDesktopData]
							],
						});
					})(jQuery);
				});

			});
		},
		
		initBxSlider: function(options) {
			$(".enable-bx-slider").each(function(i) {
				let $bx = $(this);
				let pagerCustomData = $bx.data('pager-custom');
				let modeData = $bx.data('mode');
				let pagerSlideData = $bx.data('pager-slide');
				let modePagerData = $bx.data('mode-pager');
				let pagerQtyData = $bx.data('pager-qty');
				
				
				let realSlider = $bx.bxSlider({
					pagerCustom: pagerCustomData,
					mode: modeData,
				});
				if(pagerSlideData){
					let realThumbSlider=$(pagerCustomData).bxSlider({
						mode: modePagerData,
						minSlides: pagerQtyData,
						maxSlides: pagerQtyData,
						moveSlides: 1,
						slideMargin: 20,
						pager:false,
						infiniteLoop:false,
						hideControlOnEnd:true,
						nextText:'<span class="fa fa-angle-down"></span>',
						prevText:'<span class="fa fa-angle-up"></span>'
					});
					linkRealSliders(realSlider,realThumbSlider,pagerCustomData);
					if($(pagerCustomData+" a").length <= pagerQtyData ){
						$(pagerCustomData+" .bx-next").hide();
					}
				}
			});
			function linkRealSliders(bigS,thumbS,sliderId){
				$(sliderId).on("click","a",function(event){
					event.preventDefault();
					let newIndex=$(this).data("slide-index");
					bigS.goToSlide(newIndex);
				});
			}
		},
		
		initTabs: function(options) {
			$(document).on('click', '.j-tab', function(e){
				let to = $($(this).attr('data-to'));
				if(to.length > 0){
					if(to.css('display') == 'none'){
						let tabs = to.parent().find('.j-tab');
						if(tabs.length > 0){
							tabs.each(function(i,e){
								if($(e).hasClass('m-active')){
									$(e).removeClass('s-lineDownCenter');
									$(e).removeClass('m-active');                        
								}
								let to2 = $($(e).attr('data-to'));
								if(to2.css('display') == 'block')
									to2.css('display','none');
							});
						}
						to.css('display','block');
						if(!(($(this).hasClass('owl-next')) || ($(this).hasClass('owl-prev'))))
							$(this).addClass('m-active s-lineDownCenter');
						else{
							$('.b-auto__main-toggle').each(function(i,e){
								if($(e).attr('data-to').replace('#','') == to.attr('id')){
									$(e).addClass('m-active s-lineDownCenter');
								}
							})
						}      
					}
				}
				e.preventDefault();
			});
		},
		
		initCollapsible: function(options) {
			let collapse = $('.j-more').length;
			if(collapse){
				$(document).on('click', '.j-more', function(e){
					let inside = $(this).parent().parent().find('.j-inside');
					let span = $(this).find('span.fa');
					if(inside.length > 0){
						span.toggleClass('fa-angle-left');
						span.toggleClass('fa-angle-down');
						$(this).parent().toggleClass('m-active');
						inside.toggleClass('m-active');
					}
					e.preventDefault();
				});
			}
		},
		
		initNumberCounter: function(options) {
			if ($('body').length) {
				let waypointScroll = $('.percent-blocks').data('waypoint-scroll');
				if(waypointScroll){
					$(window).on('scroll', function() {
						let winH = $(window).scrollTop();
						$('.percent-blocks').waypoint(function() {
							$('.chart').each(function() {
								CharsStart();
							});
						}, {
							offset: '80%'
						});
					});
				}
			}
			function CharsStart() {
				$('.chart').easyPieChart({
					barColor: false,
					trackColor: false,
					scaleColor: false,
					scaleLength: false,
					lineCap: false,
					lineWidth: false,
					size: false,
					animate: 3000,
					onStep: function(from, to, percent){
						$(this.el).find('.percent').text(Math.round(percent));
					}
				});
			}
		},

		initGoToTop: function(options) {
			// Show/Hide Button on Window Scroll event.
			$(window).on('scroll', function(){
				let fromTop = $(this).scrollTop();
				let display = 'none';
				if(fromTop > 650){
					display = 'block';
				}
				$('#to-top').css({'display': display});
			});
			$("#to-top").smoothScroll();
		},
	};

	Core.initialize();

})();
