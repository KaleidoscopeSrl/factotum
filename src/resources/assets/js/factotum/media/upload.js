$(function() {

	Dropzone.options.imageUpload = {
		sending: function(file, xhr, formData) {
			formData.append('_token', window.Laravel.csrfToken );
		}
	};

	var previewTemplate = $('#dz_template').html();

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
				thumbnailWidth: 400,
				thumbnailHeight: 400,
				timeout: 180000,
				previewTemplate: previewTemplate,
				dictInvalidFileType: 'FILE TYPE NOT SUPPORTED',
				dictFileTooBig: 'MAXIMUM SIZE EXCEEDED',
				dictRemoveFileConfirmation: 'Are you sure you want to delete this content?',
				init: function () {

					if ( typeof mockFile !== "undefined" ) {
						if (typeof mockFile.length !== "undefined") {
							for (var i = 0; i < mockFile.length; i++) {
								this.emit('addedfile', mockFile[i]);
								this.emit('complete', mockFile[i]);
								this.options.maxFiles = this.options.maxFiles - 1;
								this.files.push(mockFile[i]);

								var ext = mockFile[i].name.substr(-3);
								$(mockFile[i].previewElement).find('.dz-details').prepend(
									'<div class="dz-filetype file-' + ext + '"></div>'
								);

								mockFile[i].previewElement.classList.add('dz-success');
								mockFile[i].previewElement.classList.add('dz-complete');

								if ( mockFile[i].type != 'image/jpeg' ) {
									mockFile[i].previewElement.classList.remove('dz-image-preview');
									mockFile[i].previewElement.classList.add('dz-file-preview');
								} else {
									this.options.thumbnail.call(this, mockFile[i], mockFile[i].thumb);
								}
							}
						}
					}

					this.on('addedfile', function(file) {
						if (file.previewElement) {
							var $dzCont = $(file.previewElement).closest('.dropzone_cont');
							$dzCont.find('.dz-filename').text(file.name);
						}
					});

					this.on('removedfile', function (file) {
						this.options.maxFiles = this.options.maxFiles + 1;
						$('input[name="' + $item.data('fillable-hidden') + '"]').val('');
					});

				},

				uploadprogress: function(file, progress, bytesSent) {
					if (file.previewElement) {
						var progressElement = file.previewElement.querySelector('[data-dz-uploadprogress]');
						progressElement.style.width = progress + '%';
						progressElement.querySelector('.progress-text').textContent = parseInt(progress) + '%';
						if ( parseInt(progress) == 100 ) {
							progressElement.querySelector('.progress-text').textContent = 'working...';
						}
					}
				},

				sending: function (file, xhr, formData) {
					formData.append( 'field_name', $($(this)[0].element).data('field_name') );
					formData.append( '_token', window.Laravel.csrfToken );
				},

				removedfile: function(file) {
					var $dzCont = $(file.previewElement).closest('.dropzone_cont');
					$dzCont.removeClass('dz-error');

					$.ajax({
						url: deleteMediaURL + '/' + file.name,
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
						},
						error: function() {
							$(file.previewElement).remove();
							if ( $item.data('max-files') == 0 ) {
								$item.attr('data-max-files', 1);
							}
						}
					});
				},

				complete: function (file) {

					if ( typeof file.xhr !== "undefined" ) {
						var response = JSON.parse(file.xhr.response);
						_parseMedia( response.media, true, true );
					}

					if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
						showListTab();
					}

					return;
				},

				error: function error(file, message) {
					if (file.previewElement) {
						var $dzCont = $(file.previewElement).closest('.dropzone_cont');
						$dzCont.addClass('dz-error');
						var $preview = $(file.previewElement);
						$preview.addClass('dz-error');

						if (typeof message !== "String" && message.error) {
							message = message.error;
						}
						$preview.find('.dz-error-message').text(message);
					}
				}

			});

		});
	}

	$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
		if ( $(e.target).attr('href') == '#list' ) {
			loadMedia();
		}
	});

	function inputStatusChange() {
		$('.media_thumb').removeClass('checked');

		$('input').each(function(index, item) {
			if ( $(item).is(':checked') ) {
				$(item).closest('.media_thumb').addClass('checked');
			}
		});

		checkInsertButton();
	}

	$( 'body' ).on('change', '#media_list_container input', function() {
		inputStatusChange();
	});


	function _parseMedia( mediaList, prepend, forceCheck ) {
		for ( var i = 0; i < mediaList.length; i++ ) {
			var media = mediaList[i];

			var $m = $( template( 'single_media_template', {
				MEDIA_ID:          media.id,
				MEDIA_ICON:        media.icon,
				MEDIA_FILENAME:    media.filename,
				MEDIA_SIZE:        media.size,
				MEDIA_LAST_UPLOAD: media.last_upload,
				MEDIA_URL:         media.url
			}) );

			if ( media.thumb ) {
				$m.find('#media_thumb_' + media.id).attr('src', media.thumb);
			} else {
				$m.find('#media_thumb_' + media.id).remove();
				$m.find('.icon_container').removeClass('hidden');
			}


			if ( forceCheck ) {
				$m.find('input').prop('checked', 'checked');
			}

			if ( prepend ) {
				$('#media_list_container').prepend($m);
			} else {
				$('#media_list_container').append($m);
			}
		}

		if ( forceCheck ) {
			inputStatusChange();
		}
	}

	// LOAD ON LIST
	var load = false;
	function loadMedia() {
		if ( !load ) {
			load = true;
			$.ajax({
				url: getMediaPaginatedURL,
				method: 'GET',
				data: {
					_token: window.Laravel.csrfToken,
					offset: mediaOffset,
					field_name: fieldName
				},
				success: function(data) {
					if (data.length > 0 ) {
						load = false;

						_parseMedia( data );

						mediaOffset += data.length;
					}
				}
			});
		}
	}

	function showListTab() {
		$('.upload_wrapper a[href="#media_list"]').tab('show');
	}

	function checkInsertButton() {
		var checked = 0;
		$('input[name="selected_images[]"]').each(function() {
			if ( $(this).is(':checked') ) {
				checked++;
			}
		});
		if ( checked > 0 ) {
			$('#set_media').removeAttr('disabled');
		} else {
			$('#set_media').attr('disabled', 'disabled');
		}
	}

	function getValues() {
		var values = [];
		$('input[name="selected_images[]"]').each(function() {
			if ( $(this).is(':checked') ) {
				values.push({
					id:          $(this).val(),
					thumb:       $(this).closest('.media_thumb').find('img').attr('src'),
					icon:        $(this).closest('.media_thumb').find('.icon_container span').attr('class'),
					filename:    $(this).closest('.media_thumb').data('filename'),
					size:        $(this).closest('.media_thumb').data('size'),
					last_upload: $(this).closest('.media_thumb').data('last_upload'),
					url:         $(this).closest('.media_thumb').data('url'),
				});
			}
		});

		return values;
	}

	$('#set_media').on('click', function(e) {
		e.preventDefault();

		if ( parent ) {
			var fN = $(this).data('field_name');
			parent.setMediaFieldValue( fN, getValues() );
		}
	});

	if ( $('#media_list_container').length > 0 ) {
		checkInsertButton();

		$(window).on('scroll', function() {
			loadMedia();
		});
	}

});