<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\ContentField;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\Http\Controllers\Admin\Controller as MainAdminController;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\Library\Utility;


class Controller extends MainAdminController
{
	protected $fieldTypes = array(
		'text'                       => 'Text',
		'textarea'                   => 'Textarea',
		'wysiwyg'                    => 'Wysiwyg Editor',
		'select'                     => 'Select',
		'multiselect'                => 'Multi Select',
		'checkbox'                   => 'Checkbox',
		'multicheckbox'              => 'Multi Checkbox',
		'radio'                      => 'Radio',
		'date'                       => 'Date',
		'datetime'                   => 'Date and Time',
		'file_upload'                => 'File Upload',
		'image_upload'               => 'Image Upload',
		'gallery'                    => 'Gallery',
		'linked_content'             => 'Linked Content',
		'multiple_linked_content'    => 'Multiple Linked Content',
		//'multiple_linked_categories' => 'Categories'
	);

	protected $imageOperations = array(
		'null'   => 'None',
		'resize' => 'Resize',
		'crop'   => 'Crop',
		'fit'    => 'Fit'
	);

	protected $basicRules = [
		'label' => 'required',
		'name'  => 'required',
		'type'  => 'required',
	];

	protected $optionsRules = [
		'option_value' => 'required_if:type,select,multiselect,checkbox,multicheckbox,radio',
		'option_label' => 'required_if:type,select,multiselect,checkbox,multicheckbox,radio',
	];

	protected $fileRules = [
		'max_file_size' => 'required_if:type,file_upload,image_upload,gallery|numeric',
		'allowed_types' => 'required_if:type,file_upload,image_upload,gallery|allowed_types'
	];

	protected $imageRules = [
		'min_width_size'  => 'required_if:type,image_upload,gallery|numeric',
		'min_height_size' => 'required_if:type,image_upload,gallery|numeric',
		'image_operation' => 'required_if:type,image_upload,gallery',
	];


	protected $messages = [
		'allowed_types'  => 'The field :attribute is not in the right format.',
	];

	// TODO: lato frontend aggiungere controllo che non esista :/; all'interno delle options
	protected function _save( Request $request, $contentField )
	{
		$data = $request->all();

		$contentField->label     = $data['label'];
		$contentField->name      = $data['name'];
		$contentField->type      = $data['type'];
		$contentField->hint      = $data['hint'];
		$contentField->mandatory = (isset($data['mandatory']) ? true : false);

		$contentField = $this->_setUploadableData($data, $contentField);
		$contentField = $this->_setImageData($data, $contentField);
		$contentField = $this->_setOptionsData($data, $contentField);
		$contentField = $this->_setLinkedContentData($data, $contentField);

		$contentField->save();
		return $contentField;
	}

	private function _setUploadableData($data, $contentField)
	{
		if ($data['type'] == 'file_upload' || $data['type'] == 'image_upload' || $data['type'] == 'gallery') {
			$contentField->max_file_size = $data['max_file_size'];
			$contentField->allowed_types = $data['allowed_types'];
		} else {
			$contentField->max_file_size = null;
			$contentField->allowed_types = null;
		}

		return $contentField;
	}

	private function _setImageData($data, $contentField)
	{
		if ( in_array($data['type'], array('image_upload', 'gallery' ) ) ) {
			$contentField->min_width_size   = $data['min_width_size'];
			$contentField->min_height_size  = $data['min_height_size'];
			$contentField->image_operation  = ( $data['image_operation'] == 'null' ? null : $data['image_operation'] );

			if ( isset($data['width_resize']) && isset($data['height_resize']) &&
				$data['width_resize'] != '' && $data['height_resize'] != '' ) {
				$contentField->resizes = Utility::convertOptionsAssocArrayToString( $data['width_resize'], $data['height_resize'] );
			} else {
				$contentField->resizes = '';
			}

		} else {
			$contentField->min_width_size   = null;
			$contentField->min_height_size  = null;
			$contentField->image_operation  = null;
			$contentField->resizes          = null;
		}

		return $contentField;
	}

	private function _setOptionsData($data, $contentField)
	{
		if ( in_array($data['type'], array('select', 'multiselect', 'checkbox', 'multicheckbox', 'radio') ) ) {
			$contentField->options = ( count($data['option_value']) > 0 ? Utility::convertOptionsAssocArrayToString( $data['option_value'], $data['option_label'] ) : '' );
		} else {
			$contentField->options = null;
		}

		return $contentField;
	}

	private function _setLinkedContentData($data, $contentField)
	{
		if ( in_array($data['type'], array('linked_content', 'multiple_linked_content') ) ) {
			$contentField->linked_content_type_id = $data['linked_content_type_id'];
		} else {
			$contentField->linked_content_type_id = null;
		}

		return $contentField;
	}


	protected function validator(array $data, $id = null)
	{
		$rules = array_merge($this->basicRules, $this->optionsRules, $this->fileRules, $this->imageRules);

		$rules = $this->_setNameRules($data, $rules, $id);
		$rules = $this->_setImagesRules($data, $rules);
		$validator = Validator::make($data, $rules);
		return $validator;
	}

	private function _setImagesRules( $data, $rules )
	{
		if ( isset($data['width_resize']) && isset($data['height_resize']) &&
			$data['width_resize'] != '' && $data['height_resize'] != '' ) {
			$rules['width_resize'] = 'required_if:type,image_upload,gallery';
			$rules['height_resize'] = 'required_if:type,image_upload,gallery';
		}
		return $rules;
	}

	private function _setNameRules( $data, $rules, $id = null )
	{
		$rules['name'] .= '|not_in:' . join(',', config('factotum.factotum.prohibited_content_field_names'));

		if ($id) {
			$contentField = ContentField::where('name', $data['name'])
										->where('content_type_id', $data['content_type_id'])
										->first();
			if ($contentField && $contentField->id != $id ) {
				$rules['name'] .= '|unique:content_fields,name,NULL,id,content_type_id,' . $data['content_type_id'];
			}
		} else {
			$rules['name'] .= '|unique:content_fields,name,NULL,id,content_type_id,' . $data['content_type_id'];
		}
		return $rules;
	}
}
