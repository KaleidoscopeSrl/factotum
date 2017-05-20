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