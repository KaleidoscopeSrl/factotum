
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
	});

	$('.nav-language').on('click', function(){
		$(this).parent().toggleClass('open');
		$('.nav-language + .open-submenu .dropstatus').toggleClass('fa-caret-down').toggleClass('fa-caret-up');
	});

	$('[data-toggle="confirmation"]').confirmation({
		rootSelector: '[data-toggle=confirmation]',
		btnOkIcon: 'fa fa-check',
		btnCancelIcon: 'fa fa-times'
	});

});

function template( templateid, data ){
	return document.getElementById( templateid ).innerHTML
		.replace(
			/%(\w*)%/g, // or /{(\w*)}/g for "{this} instead of %this%"
			function( m, key ){
				return data.hasOwnProperty( key ) ? data[ key ] : "";
			}
		);
}