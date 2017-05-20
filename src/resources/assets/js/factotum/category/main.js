function generateCategoryName(str) {
	return str.replace(/[^a-z0-9]+/gi, '-').replace(/^-*|-*$/g, '').toLowerCase();
}

$(function() {

	if ( $('#category_label').length > 0 ) {
		$('#category_label').on('keyup blur focusout', function() {
			var permalink = generateCategoryName($(this).val());
			$('#category_name').val(permalink);
		});
	}

});

