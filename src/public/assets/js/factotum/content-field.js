function generateFieldName(str) {
	return str.replace(/[^a-z0-9]+/gi, '_').replace(/^-*|-*$/g, '').toLowerCase();
}

$('#field_label').on('keyup blur focusout', function() {
	var fieldName = generateFieldName($(this).val());
	$('#field_name, #field_name_hidden').val(fieldName);
});



$(function() {

	if ($('.content_fields_sortable').length > 0) {

		function getOrderItems($list) {
			var orderItems = {};
			$list.find('tr').each(function (index, item) {
				orderItems[$(item).data('id_item')] = index;
			});
			return orderItems;
		}

		$('.content_fields_sortable').sortable({
			items: 'tr',
			update: function (event, ui) {
				var newOrder = getOrderItems(ui.item.parent());
				$.ajax({
					url: sortContentFieldsURL,
					method: 'POST',
					data: {
						_token: window.Laravel.csrfToken,
						new_order: JSON.stringify(newOrder)
					}
				});
			}
		});
	}
});

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


$('#field_type').on('change', function() {
	var $type = $(this).val();

	if ( $type == 'image_upload' || $type == 'gallery' || $type == 'file_upload' ) {
		showFileSection();
	} else {
		hideFileSection();
	}
});

function showFileSection() {
	$('#file_section').removeClass('hidden');
}

function hideFileSection() {
	$('#file_section').addClass('hidden');
}
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

$('#field_type').on('change', function() {
	var $type = $(this).val();

	if ( $type == 'linked_content' || $type == 'multiple_linked_content' ) {
		showLinkedContentSection();
	} else {
		hideLinkedContentSection()
	}
});

function showLinkedContentSection() {
	$('#linked_content_section').removeClass('hidden');
}

function hideLinkedContentSection() {
	$('#linked_content_section').addClass('hidden');
}

//# sourceMappingURL=content-field.js.map
