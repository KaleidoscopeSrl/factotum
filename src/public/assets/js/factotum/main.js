$('#content_type').on('keyup', function() {
	$('#content_type_template').text( $(this).val() );
});
function removeDiacritics (str) {

	var defaultDiacriticsRemovalMap = [
		{'base':'A', 'letters':/[\u0041\u24B6\uFF21\u00C0\u00C1\u00C2\u1EA6\u1EA4\u1EAA\u1EA8\u00C3\u0100\u0102\u1EB0\u1EAE\u1EB4\u1EB2\u0226\u01E0\u00C4\u01DE\u1EA2\u00C5\u01FA\u01CD\u0200\u0202\u1EA0\u1EAC\u1EB6\u1E00\u0104\u023A\u2C6F]/g},
		{'base':'AA','letters':/[\uA732]/g},
		{'base':'AE','letters':/[\u00C6\u01FC\u01E2]/g},
		{'base':'AO','letters':/[\uA734]/g},
		{'base':'AU','letters':/[\uA736]/g},
		{'base':'AV','letters':/[\uA738\uA73A]/g},
		{'base':'AY','letters':/[\uA73C]/g},
		{'base':'B', 'letters':/[\u0042\u24B7\uFF22\u1E02\u1E04\u1E06\u0243\u0182\u0181]/g},
		{'base':'C', 'letters':/[\u0043\u24B8\uFF23\u0106\u0108\u010A\u010C\u00C7\u1E08\u0187\u023B\uA73E]/g},
		{'base':'D', 'letters':/[\u0044\u24B9\uFF24\u1E0A\u010E\u1E0C\u1E10\u1E12\u1E0E\u0110\u018B\u018A\u0189\uA779]/g},
		{'base':'DZ','letters':/[\u01F1\u01C4]/g},
		{'base':'Dz','letters':/[\u01F2\u01C5]/g},
		{'base':'E', 'letters':/[\u0045\u24BA\uFF25\u00C8\u00C9\u00CA\u1EC0\u1EBE\u1EC4\u1EC2\u1EBC\u0112\u1E14\u1E16\u0114\u0116\u00CB\u1EBA\u011A\u0204\u0206\u1EB8\u1EC6\u0228\u1E1C\u0118\u1E18\u1E1A\u0190\u018E]/g},
		{'base':'F', 'letters':/[\u0046\u24BB\uFF26\u1E1E\u0191\uA77B]/g},
		{'base':'G', 'letters':/[\u0047\u24BC\uFF27\u01F4\u011C\u1E20\u011E\u0120\u01E6\u0122\u01E4\u0193\uA7A0\uA77D\uA77E]/g},
		{'base':'H', 'letters':/[\u0048\u24BD\uFF28\u0124\u1E22\u1E26\u021E\u1E24\u1E28\u1E2A\u0126\u2C67\u2C75\uA78D]/g},
		{'base':'I', 'letters':/[\u0049\u24BE\uFF29\u00CC\u00CD\u00CE\u0128\u012A\u012C\u0130\u00CF\u1E2E\u1EC8\u01CF\u0208\u020A\u1ECA\u012E\u1E2C\u0197]/g},
		{'base':'J', 'letters':/[\u004A\u24BF\uFF2A\u0134\u0248]/g},
		{'base':'K', 'letters':/[\u004B\u24C0\uFF2B\u1E30\u01E8\u1E32\u0136\u1E34\u0198\u2C69\uA740\uA742\uA744\uA7A2]/g},
		{'base':'L', 'letters':/[\u004C\u24C1\uFF2C\u013F\u0139\u013D\u1E36\u1E38\u013B\u1E3C\u1E3A\u0141\u023D\u2C62\u2C60\uA748\uA746\uA780]/g},
		{'base':'LJ','letters':/[\u01C7]/g},
		{'base':'Lj','letters':/[\u01C8]/g},
		{'base':'M', 'letters':/[\u004D\u24C2\uFF2D\u1E3E\u1E40\u1E42\u2C6E\u019C]/g},
		{'base':'N', 'letters':/[\u004E\u24C3\uFF2E\u01F8\u0143\u00D1\u1E44\u0147\u1E46\u0145\u1E4A\u1E48\u0220\u019D\uA790\uA7A4]/g},
		{'base':'NJ','letters':/[\u01CA]/g},
		{'base':'Nj','letters':/[\u01CB]/g},
		{'base':'O', 'letters':/[\u004F\u24C4\uFF2F\u00D2\u00D3\u00D4\u1ED2\u1ED0\u1ED6\u1ED4\u00D5\u1E4C\u022C\u1E4E\u014C\u1E50\u1E52\u014E\u022E\u0230\u00D6\u022A\u1ECE\u0150\u01D1\u020C\u020E\u01A0\u1EDC\u1EDA\u1EE0\u1EDE\u1EE2\u1ECC\u1ED8\u01EA\u01EC\u00D8\u01FE\u0186\u019F\uA74A\uA74C]/g},
		{'base':'OI','letters':/[\u01A2]/g},
		{'base':'OO','letters':/[\uA74E]/g},
		{'base':'OU','letters':/[\u0222]/g},
		{'base':'P', 'letters':/[\u0050\u24C5\uFF30\u1E54\u1E56\u01A4\u2C63\uA750\uA752\uA754]/g},
		{'base':'Q', 'letters':/[\u0051\u24C6\uFF31\uA756\uA758\u024A]/g},
		{'base':'R', 'letters':/[\u0052\u24C7\uFF32\u0154\u1E58\u0158\u0210\u0212\u1E5A\u1E5C\u0156\u1E5E\u024C\u2C64\uA75A\uA7A6\uA782]/g},
		{'base':'S', 'letters':/[\u0053\u24C8\uFF33\u1E9E\u015A\u1E64\u015C\u1E60\u0160\u1E66\u1E62\u1E68\u0218\u015E\u2C7E\uA7A8\uA784]/g},
		{'base':'T', 'letters':/[\u0054\u24C9\uFF34\u1E6A\u0164\u1E6C\u021A\u0162\u1E70\u1E6E\u0166\u01AC\u01AE\u023E\uA786]/g},
		{'base':'TZ','letters':/[\uA728]/g},
		{'base':'U', 'letters':/[\u0055\u24CA\uFF35\u00D9\u00DA\u00DB\u0168\u1E78\u016A\u1E7A\u016C\u00DC\u01DB\u01D7\u01D5\u01D9\u1EE6\u016E\u0170\u01D3\u0214\u0216\u01AF\u1EEA\u1EE8\u1EEE\u1EEC\u1EF0\u1EE4\u1E72\u0172\u1E76\u1E74\u0244]/g},
		{'base':'V', 'letters':/[\u0056\u24CB\uFF36\u1E7C\u1E7E\u01B2\uA75E\u0245]/g},
		{'base':'VY','letters':/[\uA760]/g},
		{'base':'W', 'letters':/[\u0057\u24CC\uFF37\u1E80\u1E82\u0174\u1E86\u1E84\u1E88\u2C72]/g},
		{'base':'X', 'letters':/[\u0058\u24CD\uFF38\u1E8A\u1E8C]/g},
		{'base':'Y', 'letters':/[\u0059\u24CE\uFF39\u1EF2\u00DD\u0176\u1EF8\u0232\u1E8E\u0178\u1EF6\u1EF4\u01B3\u024E\u1EFE]/g},
		{'base':'Z', 'letters':/[\u005A\u24CF\uFF3A\u0179\u1E90\u017B\u017D\u1E92\u1E94\u01B5\u0224\u2C7F\u2C6B\uA762]/g},
		{'base':'a', 'letters':/[\u0061\u24D0\uFF41\u1E9A\u00E0\u00E1\u00E2\u1EA7\u1EA5\u1EAB\u1EA9\u00E3\u0101\u0103\u1EB1\u1EAF\u1EB5\u1EB3\u0227\u01E1\u00E4\u01DF\u1EA3\u00E5\u01FB\u01CE\u0201\u0203\u1EA1\u1EAD\u1EB7\u1E01\u0105\u2C65\u0250]/g},
		{'base':'aa','letters':/[\uA733]/g},
		{'base':'ae','letters':/[\u00E6\u01FD\u01E3]/g},
		{'base':'ao','letters':/[\uA735]/g},
		{'base':'au','letters':/[\uA737]/g},
		{'base':'av','letters':/[\uA739\uA73B]/g},
		{'base':'ay','letters':/[\uA73D]/g},
		{'base':'b', 'letters':/[\u0062\u24D1\uFF42\u1E03\u1E05\u1E07\u0180\u0183\u0253]/g},
		{'base':'c', 'letters':/[\u0063\u24D2\uFF43\u0107\u0109\u010B\u010D\u00E7\u1E09\u0188\u023C\uA73F\u2184]/g},
		{'base':'d', 'letters':/[\u0064\u24D3\uFF44\u1E0B\u010F\u1E0D\u1E11\u1E13\u1E0F\u0111\u018C\u0256\u0257\uA77A]/g},
		{'base':'dz','letters':/[\u01F3\u01C6]/g},
		{'base':'e', 'letters':/[\u0065\u24D4\uFF45\u00E8\u00E9\u00EA\u1EC1\u1EBF\u1EC5\u1EC3\u1EBD\u0113\u1E15\u1E17\u0115\u0117\u00EB\u1EBB\u011B\u0205\u0207\u1EB9\u1EC7\u0229\u1E1D\u0119\u1E19\u1E1B\u0247\u025B\u01DD]/g},
		{'base':'f', 'letters':/[\u0066\u24D5\uFF46\u1E1F\u0192\uA77C]/g},
		{'base':'g', 'letters':/[\u0067\u24D6\uFF47\u01F5\u011D\u1E21\u011F\u0121\u01E7\u0123\u01E5\u0260\uA7A1\u1D79\uA77F]/g},
		{'base':'h', 'letters':/[\u0068\u24D7\uFF48\u0125\u1E23\u1E27\u021F\u1E25\u1E29\u1E2B\u1E96\u0127\u2C68\u2C76\u0265]/g},
		{'base':'hv','letters':/[\u0195]/g},
		{'base':'i', 'letters':/[\u0069\u24D8\uFF49\u00EC\u00ED\u00EE\u0129\u012B\u012D\u00EF\u1E2F\u1EC9\u01D0\u0209\u020B\u1ECB\u012F\u1E2D\u0268\u0131]/g},
		{'base':'j', 'letters':/[\u006A\u24D9\uFF4A\u0135\u01F0\u0249]/g},
		{'base':'k', 'letters':/[\u006B\u24DA\uFF4B\u1E31\u01E9\u1E33\u0137\u1E35\u0199\u2C6A\uA741\uA743\uA745\uA7A3]/g},
		{'base':'l', 'letters':/[\u006C\u24DB\uFF4C\u0140\u013A\u013E\u1E37\u1E39\u013C\u1E3D\u1E3B\u017F\u0142\u019A\u026B\u2C61\uA749\uA781\uA747]/g},
		{'base':'lj','letters':/[\u01C9]/g},
		{'base':'m', 'letters':/[\u006D\u24DC\uFF4D\u1E3F\u1E41\u1E43\u0271\u026F]/g},
		{'base':'n', 'letters':/[\u006E\u24DD\uFF4E\u01F9\u0144\u00F1\u1E45\u0148\u1E47\u0146\u1E4B\u1E49\u019E\u0272\u0149\uA791\uA7A5]/g},
		{'base':'nj','letters':/[\u01CC]/g},
		{'base':'o', 'letters':/[\u006F\u24DE\uFF4F\u00F2\u00F3\u00F4\u1ED3\u1ED1\u1ED7\u1ED5\u00F5\u1E4D\u022D\u1E4F\u014D\u1E51\u1E53\u014F\u022F\u0231\u00F6\u022B\u1ECF\u0151\u01D2\u020D\u020F\u01A1\u1EDD\u1EDB\u1EE1\u1EDF\u1EE3\u1ECD\u1ED9\u01EB\u01ED\u00F8\u01FF\u0254\uA74B\uA74D\u0275]/g},
		{'base':'oi','letters':/[\u01A3]/g},
		{'base':'ou','letters':/[\u0223]/g},
		{'base':'oo','letters':/[\uA74F]/g},
		{'base':'p','letters':/[\u0070\u24DF\uFF50\u1E55\u1E57\u01A5\u1D7D\uA751\uA753\uA755]/g},
		{'base':'q','letters':/[\u0071\u24E0\uFF51\u024B\uA757\uA759]/g},
		{'base':'r','letters':/[\u0072\u24E1\uFF52\u0155\u1E59\u0159\u0211\u0213\u1E5B\u1E5D\u0157\u1E5F\u024D\u027D\uA75B\uA7A7\uA783]/g},
		{'base':'s','letters':/[\u0073\u24E2\uFF53\u00DF\u015B\u1E65\u015D\u1E61\u0161\u1E67\u1E63\u1E69\u0219\u015F\u023F\uA7A9\uA785\u1E9B]/g},
		{'base':'t','letters':/[\u0074\u24E3\uFF54\u1E6B\u1E97\u0165\u1E6D\u021B\u0163\u1E71\u1E6F\u0167\u01AD\u0288\u2C66\uA787]/g},
		{'base':'tz','letters':/[\uA729]/g},
		{'base':'u','letters':/[\u0075\u24E4\uFF55\u00F9\u00FA\u00FB\u0169\u1E79\u016B\u1E7B\u016D\u00FC\u01DC\u01D8\u01D6\u01DA\u1EE7\u016F\u0171\u01D4\u0215\u0217\u01B0\u1EEB\u1EE9\u1EEF\u1EED\u1EF1\u1EE5\u1E73\u0173\u1E77\u1E75\u0289]/g},
		{'base':'v','letters':/[\u0076\u24E5\uFF56\u1E7D\u1E7F\u028B\uA75F\u028C]/g},
		{'base':'vy','letters':/[\uA761]/g},
		{'base':'w','letters':/[\u0077\u24E6\uFF57\u1E81\u1E83\u0175\u1E87\u1E85\u1E98\u1E89\u2C73]/g},
		{'base':'x','letters':/[\u0078\u24E7\uFF58\u1E8B\u1E8D]/g},
		{'base':'y','letters':/[\u0079\u24E8\uFF59\u1EF3\u00FD\u0177\u1EF9\u0233\u1E8F\u00FF\u1EF7\u1E99\u1EF5\u01B4\u024F\u1EFF]/g},
		{'base':'z','letters':/[\u007A\u24E9\uFF5A\u017A\u1E91\u017C\u017E\u1E93\u1E95\u01B6\u0225\u0240\u2C6C\uA763]/g}
	];

	for(var i=0; i<defaultDiacriticsRemovalMap.length; i++) {
		str = str.replace(defaultDiacriticsRemovalMap[i].letters, defaultDiacriticsRemovalMap[i].base);
	}

	return str;
}

function generatePermalink(str) {
	str = removeDiacritics(str);
	return str.replace(/[^a-z0-9]+/gi, '-').replace(/^-*|-*$/g, '').toLowerCase();
}

$('#title').on('keyup blur focusout', function() {
	if ( !editingContent ) {
		var permalink = generatePermalink($(this).val());
		$('#url').val(permalink);
		var startURL = $('#abs_url').data('baseurl');
		$('#abs_url').val( startURL + '/' + permalink );
	}
});

$.datetimepicker.setLocale('it');

$(function() {

	if ( $('input.date').length > 0 ) {
		$('input.date').datetimepicker({
			timepicker:false,
			format:'d/m/Y'
		});
	}

	if ( $('input.datetime').length > 0 ) {
		$('input.datetime').datetimepicker({
			format: 'd/m/Y H:i:s'
		});
	}

	if ( $('textarea.wysiwyg').length > 0 ) {
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
	}

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

var uploadMediaLightbox = null;

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

	if ( $('.connectedSortable').length > 0 ) {
		$('.connectedSortable').each(function(index, item) {
			if ($(item).hasClass('source')) {
				var fieldId = $(item).data('field_id');

				$( '#sortable1_' + fieldId ).sortable({
					connectWith: '#sortable2_' + fieldId,
					receive: function( event, ui ) {
						var fieldId = $(ui.item).parent().data('field_id');
						var value = getValueFromSortable( $( '#sortable2_' + fieldId ) );
						value = value.trim(';');
						$('#field_' + fieldId).val( value );
					}
				});

				$( '#sortable2_' + fieldId ).sortable({
					connectWith: '#sortable1_' + fieldId,
					receive: function( event, ui ) {
						var fieldId = $(ui.item).parent().data('field_id');
						var value = getValueFromSortable( $( '#sortable2_' + fieldId ) );
						value = value.trim(';');
						$('#field_' + fieldId).val( value );
					},
					stop: function( event, ui ) {
						var fieldId = $(ui.item).parent().data('field_id');
						var value = getValueFromSortable( $( '#sortable2_' + fieldId ) );
						value = value.trim(';');
						$('#field_' + fieldId).val( value );
					}
				});
			}
		});

		function getValueFromSortable($sortable) {
			var tmp = new Array();
			$sortable.find('li').each(function(index, item) {
				tmp.push( $(item).data('content_id') );
			});
			return tmp.join(';');
		}
	}

	$('.multiselect').select2({
		dropdownAutoWidth : true,
		width: '100%'
	});

	$('.open_media_upload').on('click', function(e) {
		e.preventDefault();

		var fieldName = $(this).data('field_name');
		var val = $(this).closest('.form-group').find('input[type=hidden]').val();
		uploadMediaLightbox = lity( uploadMediaURL + '/' + fieldName + '?selected=' + val );
	});


	$('.delete_media')
		.on('click', function(e) {
			e.preventDefault();
			$(this).confirmation('show');
		})
		.on('confirmed.bs.confirmation', function () {

			var $trigger = $(this),
				fN = $trigger.data('filename');

			$.ajax({
				url: deleteMediaURL + '/' + fN,
				method: 'POST',
				data: {
					_token: window.Laravel.csrfToken,
					filename: fN
				},
				success: function(data) {
					if (data.result == 'ok') {
						$trigger.closest('.media_thumb').remove();
					}
				},
				error: function() {
					alert('Error on deleting media.');
				}
			});

		});


	$('body').on('click', '.remove_media', function(e) {
		e.preventDefault();

		var $trigger = $(e.target),
			$field = $trigger.closest('.form-group'),
			mediaId = $trigger.data('media_id');

		$trigger.closest('.media_thumb').remove();
		$field.find('.open_media_upload').removeAttr('style');

		var val = $field.find('input[type="hidden"]').val().split(',');

		if ( val.length > 0 ) {
			for ( var i = 0; i < val.length; i++ ) {
				if ( mediaId == val[i] ) {
					val.splice( i, 1 );
				}
			}
		}

		$field.find('input[type="hidden"]').val('');

	});

	if ( typeof mediaPopulated !== "undefined" ) {
		$.each(mediaPopulated, function(index, item) {
			if ( Array.isArray(item) ) {
				var tmpFid = item[0].field_id;
				_parseMediaOnEdit( tmpFid, item );
			} else {
				if ( item && typeof item.field_id !== "undefined" ) {
					_parseMediaOnEdit( item.field_id, [ item ] );
				}
			}
		});
	}

});

function _parseMediaOnEdit( fieldId, values ) {

	var $trigger   = $('button[data-field_name="' + fieldId + '"]'),
		isMultiple = ( $trigger.data('type') == 'image_upload' || $trigger.data('type') == 'file_upload' ? false : true ),
		showIcons  = ( $trigger.data('type') == 'file_upload' ? true : false ),
		oldVal     = $('#' + fieldId + '_hidden').val().split(';'),
		val        = [];


	$.each( values, function( index, media ) {
		val.push( media.id );

		if ( oldVal.indexOf( media.id ) == -1 ) {
			var $m = $( template( 'media_thumb_template', {
				MEDIA_ID:          media.id,
				MEDIA_ICON:        media.icon,
				MEDIA_FILENAME:    media.filename,
				MEDIA_SIZE:        media.size,
				MEDIA_LAST_UPLOAD: media.last_upload,
				MEDIA_URL:         media.url
			}) );

			if ( showIcons ) {
				$m.find('img').remove();
				$m.find('.icon_container').removeClass('hidden');
			} else {
				$m.find('img').attr('src', media.thumb);
			}

			$trigger.closest('.form-group').find('.media_thumb_container').append( $m );
		}
	});

	$('#' + fieldId + '_hidden').val( val.join(';') );

	if ( !isMultiple ) {
		$trigger.hide();
	}
}

function setMediaFieldValue( fieldId, values ) {
	_parseMediaOnEdit( fieldId, values );

	uploadMediaLightbox.close();
}
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

$(function() {

	$('#menu_bars').on('click', function() {
	    if ($(this).hasClass('active')) {
	        $('.admin-menu').removeClass('slide-in');
	        $(this).removeClass('active');
	        $('body').removeClass('no_scroll');
	        // enableScroll();
	    } else {
	        // disableScroll();
	        $('.admin-menu').addClass('slide-in');
	        $(this).addClass('active');
	        $('body').addClass('no_scroll');
	    }
	});

	$('.open-submenu').on('click', function(){
		$(this).parent().toggleClass('open');
		$('.dropstatus', this).toggleClass('fa-caret-down').toggleClass('fa-caret-up');
	});

	$('.nav-language').on('click', function(){
		$(this).parent().toggleClass('open');
		$('.nav-language + .open-submenu .dropstatus').toggleClass('fa-caret-down').toggleClass('fa-caret-up');
	});

	$('[data-toggle="confirmation"]').confirmation({
		rootSelector: '[data-toggle=confirmation]',
		btnOkIcon: 'fa fa-check',
		btnCancelIcon: 'fa fa-times'
	});

});

function template( templateid, data ){
	return document.getElementById( templateid ).innerHTML
		.replace(
			/%(\w*)%/g, // or /{(\w*)}/g for "{this} instead of %this%"
			function( m, key ){
				return data.hasOwnProperty( key ) ? data[ key ] : "";
			}
		);
}
//# sourceMappingURL=main.js.map
