$('#field_type').on('change', function() {
	var $type = $(this).val();

	if ( $type == 'image_upload' || $type == 'gallery' ) {
		showImageSection();
	} else {
		hideImageSection();
	}
});

function showImageSection() {
	$('#resize_list').empty();
	$('#image_section').removeClass('hidden');
}

function hideImageSection() {
	$('#image_section').addClass('hidden');
	$('#resize_list').empty();
}

function showAddResizeBtn() {
	$('#add_resize').removeClass('hidden');
}

function hideAddResizeBtn() {
	$('#add_resize').addClass('hidden');
}

$('#add_resize').on('click', function(event) {
	event.preventDefault();
	addResizeInList();
});

$('body').on('click', '.remove_resize', function(event) {
	event.preventDefault();
	removeResizeFromList( $(this) );
});

function addResizeInList() {
	var $resize = $('#single_resize_template').clone();
	$resize.attr( 'data-no', $('#resize_list .resize').length).removeAttr('id');
	$resize.find('.remove_resize').val($('#resize_list .resize').length);
	if ($('#resize_list .resize').length == 0) {
		$resize.find('.remove_resize').remove();
	}
	$('#resize_list').append($resize);
}

function removeResizeFromList($btn) {
	$('.resize[data-no="' + $btn.val() + '"]').remove();
}

$(function() {
	if ($('.sortable_resizes').length > 0) {
		$('.sortable_resizes').sortable({
			items: '.row'
		});
	}
});
