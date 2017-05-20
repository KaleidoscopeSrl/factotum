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
