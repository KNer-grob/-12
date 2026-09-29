import jQuery from "jquery";
const $ = jQuery;
window.$ = $;
(function($) {



	$(function() {

		var	$window = $(window),
			$body = $('body'),
			$menu = $('#menu'),
			$sidebar = $('#sidebar'),
			$main = $('#main');

			$menu
				.appendTo($body).panel({
					delay: 500,
					hideOnClick: true,
					hideOnSwipe: true,
					resetScroll: true,
					resetForms: true,
					side: 'right',
					target: $body,
					visibleClass: 'is-menu-visible'
				});

		
			

	});

})(jQuery);   