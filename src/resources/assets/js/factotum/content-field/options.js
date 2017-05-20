$('#field_type').on('change', function() {
	var $type = $(this).val();

	if ($type == 'select' ||
		$type == 'multiselect' ||
		$type == 'checkbox' ||
		$type == 'multicheckbox' ||
		$type == 'radio' ) {

		showOptionsSection();
		addOptionInList();

		if ($type == 'checkbox') {
			hideAddOptionBtn();
		} else {
			showAddOptionBtn();
		}
	} else {
		hideOptionsSection();
	}
});

function showOptionsSection() {
	$('#options_list').empty();
	$('#options_section').removeClass('hidden');
}

function hideOptionsSection() {
	$('#options_section').addClass('hidden');
	$('#options_list').empty();
}

function showAddOptionBtn() {
	$('#add_option').removeClass('hidden');
}

function hideAddOptionBtn() {
	$('#add_option').addClass('hidden');
}

$('#add_option').on('click', function(event) {
	event.preventDefault();
	addOptionInList();
});

$('.remove_option').on('click', function(event) {
	event.preventDefault();
	removeOptionFromList( $(this) );
});

function addOptionInList() {
	var $option = $('#single_option_template').clone();
	$option.attr( 'data-no', $('#options_list .option').length).removeAttr('id');
	$option.find('.remove_option').val($('#options_list .option').length);
	if ($('#options_list .option').length == 0) {
		$option.find('.remove_option').remove();
	}
	$('#options_list').append($option);
}

function removeOptionFromList($btn) {
	$('.option[data-no="' + $btn.val() + '"]').remove();
}


$(function() {
	if ($('.sortable_options').length > 0) {
		$('.sortable_options').sortable({
			items: '.row'
		});
	}
});

