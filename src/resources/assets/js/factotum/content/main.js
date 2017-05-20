function generatePermalink(str) {
	return str.replace(/[^a-z0-9]+/gi, '-').replace(/^-*|-*$/g, '').toLowerCase();
}

$('#title').on('keyup blur focusout', function() {
	var permalink = generatePermalink($(this).val());
	$('#url').val(permalink);
	var startURL = $('#abs_url').data('baseurl');
	$('#abs_url').val( startURL + '/' + permalink );
});

$.datetimepicker.setLocale('it');

$(function() {

	$('input.date').datetimepicker({
		timepicker:false,
		format:'d/m/Y'
	});

	$('input.datetime').datetimepicker({
		format:'d/m/Y H:i:s'
	});

	$('textarea.wysiwyg').froalaEditor({
		height: 300,
		imageManagerDeleteParams: { _token: window.Laravel.csrfToken },
		imageManagerDeleteURL: deleteMediaURL,
		imageUploadParam: 'media',
		imageUploadParams: { _token: window.Laravel.csrfToken },
		imageUploadURL: uploadMediaURL,
		imageManagerLoadURL: getMediaURL,
		videoInsertButtons: [ 'videoBack', '|', 'videoByURL', 'videoEmbed' ]
	});

});

$('#page_operation').on('change', function() {
	var op = $(this).val();

	switch (op) {
		case 'show_content':
			$('#form-group-content_type_to_list, #form-group-content_to_show').hide();
			$('#form-group-content_list_pagination, #form-group-content_list_order, #form-group-content_list_categories').hide();
			$('#form-group-link, #form-group-link_title, #form-group-link_open_in').hide();
			$('#form-group-page_template').show();
			$('#form-group-action').hide();
			break;
		case 'single_content':
			$('#form-group-content_type_to_list, #form-group-content_to_show').show();
			$('#form-group-content_list_pagination, #form-group-content_list_order, #form-group-content_list_categories').hide();
			$('#form-group-link, #form-group-link_title, #form-group-link_open_in').hide();
			$('#form-group-page_template').show();
			$('#form-group-action').hide();
			break;
		case 'content_list':
			$('#form-group-content_type_to_list').show();
			$('#form-group-content_to_show').hide();
			$('#form-group-content_list_pagination, #form-group-content_list_order, #form-group-content_list_categories').show();
			$('#form-group-link, #form-group-link_title, #form-group-link_open_in').hide();
			$('#form-group-page_template').show();
			$('#form-group-action').hide();
			break;
		case 'link':
			$('#form-group-content_type_to_list, #form-group-content_to_show').hide();
			$('#form-group-content_list_pagination, #form-group-content_list_order, #form-group-content_list_categories').hide();
			$('#form-group-link, #form-group-link_title, #form-group-link_open_in').show();
			$('#form-group-page_template').hide();
			$('#form-group-action').hide();
			break;
		case 'action':
			$('#form-group-content_type_to_list, #form-group-content_to_show').hide();
			$('#form-group-content_list_pagination, #form-group-content_list_order, #form-group-content_list_categories').hide();
			$('#form-group-link, #form-group-link_title, #form-group-link_open_in').hide();
			$('#form-group-page_template').show();
			$('#form-group-action').show();
			break;
	}

}).trigger('change');

$('#content_type_to_list').on('change', function() {
	var contentTypeID = $(this).val();

	if ( contentTypeID != null && contentTypeID != "null" ) {
		$.ajax({
			url: getContentTypeCategoriesURL,
			method: 'POST',
			data: {
				_token: window.Laravel.csrfToken,
				content_type_id: contentTypeID
			},
			success: function(data) {
				if (data.length > 0 ) {
					$('#form-group-content_list_categories').find('.sol-container').remove();
					$('#content_list_categories').replaceWith(data);
					$('#content_list_categories').select2({
						dropdownAutoWidth : true,
						width: '100%'
					});
				}
			}
		});
	}
}).trigger('change');


$(function() {

	if ($('.contents_sortable').length > 0) {
		function getOrderItems($list) {
			var orderItems = {};
			$list.find('tr').each(function (index, item) {
				orderItems[$(item).data('id_item')] = index;
			});
			return orderItems;
		}

		$('.contents_sortable').sortable({
			items: 'tr',
			update: function (event, ui) {
				var newOrder = getOrderItems(ui.item.parent());
				$.ajax({
					url: sortContentsURL,
					method: 'POST',
					data: {
						_token: window.Laravel.csrfToken,
						new_order: JSON.stringify(newOrder)
					}
				});
			}
		});
	}

	$('.multiselect').select2({
  		dropdownAutoWidth : true,
    	width: '100%'
	});

	Dropzone.options.imageUpload = {
		sending: function(file, xhr, formData) {
			formData.append('_token', window.Laravel.csrfToken );
		}
	};

	if ( $('.dropzone_cont').length > 0 ) {

		$('.dropzone_cont').each(function(index, item) {

			var $item = $(item),
				maxFiles = $item.data('max-files'),
				acceptedFiles = ( $item.data('accepted-files') == '*' ? null : $item.data('accepted-files') ),
				mockFile = undefined;

			try {
				mockFile = eval( $item.data('mockfile') );
			} catch (ex) { }

			$item.dropzone({
				url: uploadMediaURL,
				paramName: 'media',
				addRemoveLinks: true,
				maxFiles: maxFiles,
				acceptedFiles: acceptedFiles,
				init: function () {
					if ( typeof mockFile !== "undefined" ) {
						if (typeof mockFile.length !== "undefined") {
							for (var i = 0; i < mockFile.length; i++) {
                                this.emit('addedfile', mockFile[i]);
                                this.emit('complete', mockFile[i]);
                                this.options.maxFiles = this.options.maxFiles - 1;
                                this.options.thumbnail.call(this, mockFile[i], mockFile[i].thumb);
                                this.files.push(mockFile[i]);
								mockFile[i].previewElement.classList.add('dz-success');
								mockFile[i].previewElement.classList.add('dz-complete');
							}
						}
					}
                    this.on('removedfile', function (file) {
                        this.options.maxFiles = this.options.maxFiles + 1;
                        $('#' + $item.data('fillable-hidden')).val('');
                    });
				},
				sending: function (file, xhr, formData) {
					formData.append( 'field_id', $($(this)[0].element).data('field_id') );
					formData.append( '_token', window.Laravel.csrfToken );
				},
				removedfile: function(file) {
					$.ajax({
						url: deleteMediaURL,
						method: 'POST',
						data: {
							_token: window.Laravel.csrfToken,
							filename: file.name
						},
						success: function(data) {
							if (data.result == 'ok') {
								$(file.previewElement).remove();
								if ( $item.data('max-files') == 0 ) {
                                    $item.attr('data-max-files', 1);
								}
							}
						}
					});
				},
				complete: function (file) {
					var hiddenField = $($(this)[0].element).data('fillable-hidden'),
						maxFiles    = $($(this)[0].element).data('max-files');

					if ( typeof file.xhr !== "undefined" ) {
						var response = JSON.parse(file.xhr.response);

						if ( response.status == 'ok' && $('#' + hiddenField).length > 0 ) {

							var val = $('#' + hiddenField).val();
							if (val != '') {
								val = val.split(';');
								val.push(response.id);
								val = val.join(';');
							} else {
								val = response.id;
							}
							$('#' + hiddenField).val( val );

							if (file.previewElement) {
								return file.previewElement.classList.add('dz-complete');
							}
						}

					}
				}
			});
		});

	}

});