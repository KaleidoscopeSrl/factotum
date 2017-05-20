$(function() {

	if ( $('.resize_media_bar').length > 0 ) {


		var totalResizable = resizableMedia.length,
			resizableCount = 1,
			resizableSuccesses = 0,
			resizableErrors = 0,
			resizableFailedList = new Array(),
			resizableContinue = true,
			totalResizabletime = 0,
			resizableResultText = '',
			resizableTimeStart = new Date().getTime(),
			resizableTimeEnd = 0;


		// Create the progress bar
		$('.resize_media_bar .percentage').text('0%');

		// Stop button
		$('#resize-media-stop').click(function () {
			resizableContinue = false;
			$('#resize-media-stop').val('Stopping...');
		});

		// Clear out the empty list element that's there for HTML validation purposes
		$('#resize-media-debuglist li').remove();

		// Called after each resize. Updates debug information and the progress bar.
		function ResizeMediaUpdateStatus(id, success, response) {

			$('.resize_media_bar .bar').css('width', ( resizableCount / totalResizable ) * 100 + '%');
			$('.resize_media_bar .percentage').text(Math.round(( resizableCount / totalResizable ) * 1000) / 10 + '%');
			resizableCount = resizableCount + 1;

			if (success) {
				resizableSuccesses = resizableSuccesses + 1;
				$('.resize_media_success').text(resizableSuccesses);
				$('.resize_media_debuglist').append(
					'<li>' +
					'<strong>' + response.filename + '</strong> ' +
					'( #ID ' + response.id + ' ) was successfully resized in ' + response.time + ' seconds.' +
					'</li>'
				);
			} else {
				resizableErrors = resizableErrors + 1;
				resizableFailedList.push(id);
				console.log(response);
				$('.resize_media_failure').text(resizableErrors);
				$('.resize_media_debuglist').append( '<li>' + response.error + '</li>' );
			}
		}

		// Called when all images have been processed. Shows the results and cleans up.
		function ResizeMediaFinishUp() {
			resizableTimeEnd = new Date().getTime();
			totalResizabletime = Math.round(( resizableTimeEnd - resizableTimeStart ) / 1000);

			$('#resize-media-stop').hide();

			if ( resizableErrors > 0 ) {
				resizableResultText = 'All done!<br>' +
									resizableSuccesses + ' image(s) were successfully resized in ' +
									totalResizabletime + ' seconds and there were ' + resizableErrors + 'failure(s).<br>' +
									'To try regenerating the failed images again, ' +
									'<a href="' + resizeMediaBaseURL + '?ids=' + resizableFailedList.join(',') + '">click here</a>.';
			} else {

				resizableResultText = 'All done!<br>' +
					resizableSuccesses + ' image(s) were successfully resized in ' +
					totalResizabletime + ' seconds and there were 0 failures.<br>';

			}

			$( '.message' ).html('<p><strong>' + resizableResultText + '</strong></p>').show();
		}

		// Regenerate a specified image via AJAX
		function ResizeMedia(id) {
			$.ajax({
				type: 'POST',
				url: resizeMediaURL,
				data: {
					_token: window.Laravel.csrfToken,
					id: id
				},
				success: function (response) {

					if (response.status == 'ok') {
						ResizeMediaUpdateStatus(id, true, response);
					} else {
						ResizeMediaUpdateStatus(id, false, response);
					}

					if (resizableMedia.length && resizableContinue) {
						ResizeMedia( resizableMedia.shift() );
					} else {
						ResizeMediaFinishUp();
					}
				},
				error: function (response) {

					ResizeMediaUpdateStatus( id, false, response.responseJSON );

					if ( resizableMedia.length && resizableContinue ) {
						ResizeMedia( resizableMedia.shift() );
					} else {
						ResizeMediaFinishUp();
					}

				}
			});
		}

		ResizeMedia( resizableMedia.shift() );

	}

});