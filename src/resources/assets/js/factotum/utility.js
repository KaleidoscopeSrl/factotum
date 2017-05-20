
$(function() {
	$('#menu_bars').on('click', function() {
	    if ($(this).hasClass('active')) {
	        $('.admin-menu').removeClass('slide-in');
	        $(this).removeClass('active');
	        $('body').removeClass('no_scroll');
	        // enableScroll();
	    } else {
	        // disableScroll();
	        $('.admin-menu').addClass('slide-in');
	        $(this).addClass('active');
	        $('body').addClass('no_scroll');
	    }
	});

	$('.open-submenu').on('click', function(){
		$(this).parent().toggleClass('open');
		$('.dropstatus', this).toggleClass('fa-caret-down').toggleClass('fa-caret-up');
	})

	$('.nav-language').on('click', function(){
		$(this).parent().toggleClass('open');
		$('.nav-language + .open-submenu .dropstatus').toggleClass('fa-caret-down').toggleClass('fa-caret-up');
	})
});
/*
function makePermalink(str) {
	return str.replace(/[^a-z0-9]+/gi, '-').replace(/^-*|-*$/g, '').toLowerCase();
}

function checkPermalink(permalink) {

	$.ajax({
		method: 'get',
		url: '/admin/cms/checkPermalink/' + permalink,
		success: function(data) {

			data = JSON.parse(data);

			if (data.result == 'available') {

				$('.unavailable_text').remove();
				$('input#permalink').removeClass('unavailable').addClass('available');
				if ($('.available_text').length == 0) {
					$('input#permalink').after('<span class="available_text">Available</span>');
				}

			} else {

				$('.available_text').remove();
				$('input#permalink').removeClass('available').addClass('unavailable');
				if ($('.unavailable_text').length == 0) {
					$('input#permalink').after('<span class="unavailable_text">Unavailable</span>');
				}
			}
		}
	});

}
*/