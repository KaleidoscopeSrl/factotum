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
