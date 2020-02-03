<?php

namespace Kaleidoscope\Factotum\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Library\Utility;

class PrintFieldHelper {

	protected static $field;
	protected static $errors;
	protected static $default;

	public static function print_field( $field, $errors, $default = null )
	{
		self::$field  = $field;
		self::$errors = $errors;

		if ( $default ) {
			self::$default = old( self::$field->name, $default );
		} else {
			self::$default = old( self::$field->name );
		}


		?>
		<div class="form-group<?php echo ($errors->has(self::$field->name) ? ' has-error' : '' ); ?> field-<?php echo $field->type; ?> clearfix" id="form-group-<?php echo $field->name; ?>">

			<div class="col-md-12">
				<?php self::print_label(); ?>
				<?php
				switch ( self::$field->type ) {
					case 'hidden':
						self::print_hidden();
						break;
					case 'text':
						self::print_input();
						break;
					case 'email':
						self::print_email();
						break;
					case 'password':
						self::print_password();
						break;
					case 'textarea':
						self::print_textarea();
						break;
					case 'wysiwyg':
						self::print_textarea( true );
						break;
					case 'date':
						self::print_date();
						break;
					case 'datetime':
						self::print_datetime();
						break;
					case 'checkbox':
						self::print_checkbox();
						break;
					case 'multicheckbox':
						self::print_multicheckbox();
						break;
					case 'select':
						self::print_select();
						break;
					case 'multiselect':
						self::print_multiselect();
						break;
					case 'radio':
						self::print_radio();
						break;
					case 'file_upload':
						self::print_file_upload();
						break;
					case 'image_upload':
						self::print_image_upload();
						break;
					case 'gallery':
						self::print_gallery();
						break;
					case 'linked_content':
						self::print_linked_content();
						break;
					case 'multiple_linked_content':
						self::print_multiple_linked_content();
						break;
					case 'multiple_linked_categories':
						self::print_multiple_linked_content();
						break;
				}

				self::print_errors();
				?>

			</div>
		</div>

		<?php
	}

	private static function print_data_attrs()
	{
		if ( isset(self::$field->data_attrs) && is_array(self::$field->data_attrs) && count(self::$field->data_attrs) > 0 ) {
			foreach ( self::$field->data_attrs as $key => $value ) {
				echo ' data-' . $key . '="' . $value . '" ';
			}
		}
	}

	private static function print_label()
	{
		if ( isset(self::$field->label) && self::$field->label != '' ) {
			?>
			<label for="<?php self::$field->name; ?>"
				   class="control-label">
				<?php echo self::$field->label . (self::$field->mandatory ? ' *' : ''); ?>
				<?php echo(isset(self::$field->hint) && self::$field->hint != '' ? ' - <em>' . self::$field->hint . '</em>' : ''); ?>
			</label>
			<?php
		}
	}

	private static function print_hidden($type = 'text')
	{
		self::print_input('hidden');
	}

	private static function print_input($type = 'text')
	{
		$id = self::$field->name;
		if ( isset(self::$field->id) && !(self::$field instanceof \Kaleidoscope\Factotum\ContentField) ) {
			$id = self::$field->id;
		}
		?>
		<input id="<?php echo $id; ?>"
			   type="<?php echo $type; ?>" class="form-control"
			   name="<?php echo self::$field->name; ?>"
			<?php echo ( isset(self::$field->placeholder) && self::$field->placeholder ? ' placeholder="' . self::$field->placeholder . '"' : ''); ?>
			<?php echo ( isset(self::$field->readonly) && self::$field->readonly ? ' readonly ' : ''); ?>
			<?php echo ( isset(self::$field->maxlength) && self::$field->maxlength ? ' maxlength="' . self::$field->maxlength . '" ' : ''); ?>
			<?php self::print_data_attrs(); ?>
			   value="<?php echo old( self::$field->name, (isset(self::$default) ? self::$default : null)); ?>"
			<?php echo ( self::$field->mandatory ? 'required' : '' ); ?> autofocus>

		<?php
	}

	private static function print_email()
	{
		self::print_input('email');
	}

	private static function print_password()
	{
		self::print_input('password');
	}


	private static function print_textarea( $wysiwyg = false )
	{
		$id = self::$field->name;
		if ( isset(self::$field->id) && !(self::$field instanceof \Kaleidoscope\Factotum\ContentField) ) {
			$id = self::$field->id;
		}
		?>
		<textarea class="form-control<?php echo ($wysiwyg ? ' wysiwyg' : ''); ?>"
				  id="<?php echo $id; ?>"
				  name="<?php echo self::$field->name; ?>"
			<?php echo ( isset(self::$field->placeholder) && self::$field->placeholder ? ' placeholder="' . self::$field->placeholder . '"' : ''); ?>
			<?php echo ( isset(self::$field->readonly) && self::$field->readonly ? ' readonly ' : ''); ?>
			<?php echo ( isset(self::$field->maxlength) && self::$field->maxlength ? ' maxlength="' . self::$field->maxlength . '" ' : ''); ?>
			<?php self::print_data_attrs(); ?>
			<?php echo ( self::$field->mandatory ? 'required' : '' ) . (!$wysiwyg ? ' autofocus' : ''); ?>><?php echo old( self::$field->name, (isset(self::$default) ? self::$default : null)); ?></textarea>

		<?php
	}


	private static function print_date()
	{
		if ( self::$default ) {
			self::$default = Utility::convertIsoDateToHuman( self::$default );
		}

		$id = self::$field->name;
		if ( isset(self::$field->id) && !(self::$field instanceof \Kaleidoscope\Factotum\ContentField) ) {
			$id = self::$field->id;
		}
		?>
		<input id="<?php echo $id; ?>"
			   type="text" class="form-control date"
			   name="<?php echo self::$field->name; ?>"
			<?php echo ( isset(self::$field->placeholder) && self::$field->placeholder ? ' placeholder="' . self::$field->placeholder . '"' : ''); ?>
			<?php echo ( isset(self::$field->readonly) && self::$field->readonly ? ' readonly ' : ''); ?>
			<?php self::print_data_attrs(); ?>
			   value="<?php echo old( self::$field->name, (isset(self::$default) ? self::$default : null)); ?>"
			<?php echo ( self::$field->mandatory ? 'required' : '' ); ?> autofocus>
		<?php
	}


	private static function print_datetime()
	{
		if ( self::$default ) {
			self::$default = Utility::convertIsoDateTimeToHuman( self::$default );
		}

		$id = self::$field->name;
		if ( isset(self::$field->id) && !(self::$field instanceof \Kaleidoscope\Factotum\ContentField) ) {
			$id = self::$field->id;
		}
		?>
		<input id="<?php echo $id; ?>"
			   type="text" class="form-control datetime"
			   name="<?php echo self::$field->name; ?>"
			<?php echo ( isset(self::$field->placeholder) && self::$field->placeholder ? ' placeholder="' . self::$field->placeholder . '"' : ''); ?>
			<?php echo ( isset(self::$field->readonly) && self::$field->readonly ? ' readonly ' : ''); ?>
			<?php self::print_data_attrs(); ?>
			   value="<?php echo old( self::$field->name, (isset(self::$default) ? self::$default : null)); ?>"
			<?php echo ( self::$field->mandatory ? 'required' : '' ); ?> autofocus>
		<?php
	}


	private static function print_checkbox()
	{
		$options = Utility::convertOptionsTextToAssocArray(self::$field->options);

		$id = self::$field->name;
		if ( isset(self::$field->id) && !(self::$field instanceof \Kaleidoscope\Factotum\ContentField) ) {
			$id = self::$field->id;
		}
		?>
		<div class="form-control" style="border: none; box-shadow: none;">
			<div class="checkbox">
				<label for="<?php echo self::$field->name; ?>">
					<input type="checkbox" id="<?php echo $id; ?>"
						   name="<?php echo self::$field->name; ?>"
						   value="<?php echo key($options); ?>"
						<?php echo ( isset(self::$field->readonly) && self::$field->readonly ? ' readonly ' : ''); ?>
						<?php self::print_data_attrs(); ?>
						<?php echo ( self::$field->mandatory ? 'required' : '' ); ?>
						<?php echo ( (isset(self::$default) && self::$default == key($options)) || ( old(self::$field->name) == key($options) ) ? ' checked' : '' ); ?>>
					<span class="checkbox-material"><span class="check"></span></span>
					<?php echo array_pop($options); ?>
				</label>
			</div>
		</div>
		<?php
	}


	private static function print_multicheckbox()
	{
		$options = Utility::convertOptionsTextToAssocArray(self::$field->options);
		if ( self::$default ) {
			self::$default = Utility::convertOptionsTextToArray(self::$default);
		}

		$id = self::$field->name;
		if ( isset(self::$field->id) && !(self::$field instanceof \Kaleidoscope\Factotum\ContentField) ) {
			$id = self::$field->id;
		}
		?>
		<div class="form-control" style="border: none; box-shadow: none;">
			<?php
			if ( count($options) > 0 ) {

				$index = 0;
				foreach ( $options as $value => $label ) {
					$check = false;
					if ( (isset(self::$default) && in_array($value, self::$default)) ||
						( is_array(old(self::$field->name)) && in_array($value, old(self::$field->name)) ) ) {
						$check = true;
					}
					?>
					<input type="checkbox"
						   id="<?php echo $id . '_' . $index; ?>"
						   name="<?php echo self::$field->name; ?>[]"
						<?php echo ( $check ? 'checked="checked"' : null ); ?>
						<?php //echo ( self::$field->mandatory ? 'required' : '' ); ?>
						   value="<?php echo $value; ?>" />
					<label for="<?php echo self::$field->name . '_' . $index; ?>"><?php echo $label; ?></label>
					<?php
					$index++;
				}
			}
			?>
		</div>
		<?php
	}



	private static function print_select()
	{
		$options = Utility::convertOptionsTextToAssocArray( self::$field->options );

		$id = self::$field->name;
		if ( isset(self::$field->id) && !(self::$field instanceof \Kaleidoscope\Factotum\ContentField) ) {
			$id = self::$field->id;
		}
		?>
		<div class="select-wrapper">
			<select name="<?php echo self::$field->name; ?>"
					id="<?php echo $id; ?>"
				<?php echo ( isset(self::$field->placeholder) && self::$field->placeholder ? ' placeholder="' . self::$field->placeholder . '"' : ''); ?>
				<?php echo ( isset(self::$field->readonly) && self::$field->readonly ? ' readonly ' : ''); ?>
				<?php self::print_data_attrs(); ?>
					class="form-control" autofocus
				<?php echo ( self::$field->mandatory ? 'required' : '' ); ?>>
				<?php
				if ( count($options) > 0 ) {

					foreach ($options as $value => $label) {

						$check = false;
						if ( (isset(self::$default) && self::$default == $value) ||
							( old(self::$field->name) == $value )) {
							$check = true;
						}
						?>
						<option value="<?php echo $value; ?>"
							<?php echo ( $check ? 'selected="selected"' : null ); ?>>
							<?php echo $label; ?>
						</option>
						<?php
					}
				}
				?>
			</select>
		</div>
		<?php

	}



	private static function print_multiselect()
	{
		$options = Utility::convertOptionsTextToAssocArray( self::$field->options );

		if ( self::$default ) {
			self::$default = Utility::convertOptionsTextToArray(self::$default);
		}

		$id = self::$field->name;
		if ( isset(self::$field->id) && !(self::$field instanceof \Kaleidoscope\Factotum\ContentField) ) {
			$id = self::$field->id;
		}
		?>
		<div class="select-wrapper">
			<select name="<?php echo self::$field->name; ?>[]" multiple="multiple"
					id="<?php echo $id; ?>"
				<?php echo ( isset(self::$field->placeholder) && self::$field->placeholder ? ' placeholder="' . self::$field->placeholder . '"' : ''); ?>
				<?php echo ( isset(self::$field->readonly) && self::$field->readonly ? ' readonly ' : ''); ?>
				<?php self::print_data_attrs(); ?>
					class="form-control multiselect"
				<?php echo ( self::$field->mandatory ? 'required' : '' ); ?>>
				<?php
				if ( count($options) > 0 ) {

					foreach ($options as $value => $label) {

						$check = false;
						if ( ( isset(self::$default) && in_array($value, self::$default) ) ||
							(  is_array(old(self::$field->name)) && in_array($value, old(self::$field->name)) ) ) {
							$check = true;
						}
						?>
						<option value="<?php echo $value; ?>" <?php echo ( $check ? 'selected="selected"' : null ); ?> >
							<?php echo $label; ?>
						</option>
						<?php
					}
				}
				?>
			</select>
		</div>
		<?php
	}


	private static function print_radio()
	{
		$options = Utility::convertOptionsTextToAssocArray(self::$field->options);

		$id = self::$field->name;
		if ( isset(self::$field->id) && !(self::$field instanceof \Kaleidoscope\Factotum\ContentField) ) {
			$id = self::$field->id;
		}
		?>
		<div class="form-control" style="border: none; box-shadow: none;">
			<?php
			$index = 0;
			foreach ( $options as $value => $label ) { ?>
				<input type="radio" id="<?php echo $id . '_' . $index; ?>"
					   name="<?php echo self::$field->name; ?>"
					<?php echo ( isset(self::$field->readonly) && self::$field->readonly ? ' readonly ' : ''); ?>
					<?php self::print_data_attrs(); ?>
					   value="<?php echo $value; ?>"
					<?php echo ( self::$field->mandatory ? 'required' : '' ); ?>
					<?php echo ( (isset(self::$default) && self::$default == $value) || ( old(self::$field->name) == $value)  ? ' checked="checked"' : '' ); ?>>
				<label for="<?php echo self::$field->name . '_' . $index; ?>"><?php echo $label; ?></label>
				<?php
				$index++;
			}
			?>

		</div>
		<?php
	}


	private static function print_file_upload()
	{
		$required = '';
		if ( self::$field->mandatory ) {
			$required = ( !self::$default ? 'required' : '' );
		}
?>

		<button class="btn open_media_upload"
				data-type="file_upload"
				data-field_name="<?php echo self::$field->name; ?>">
			<i class="fa fa-image"></i>
			<?php echo Lang::get('factotum::media.add_media'); ?>
		</button>
		<div class="media_thumb_container clearfix"></div>

		<input type="hidden" id="<?php echo self::$field->name; ?>_hidden"
			   name="<?php echo self::$field->name; ?>_hidden" <?php echo ($required ? ' required' : ''); ?>
			   value="<?php echo ( isset(self::$default) && is_array(self::$default) ? self::$default['id'] : '' ); ?>" />

<?php

	}


	private static function print_image_upload()
	{
		$required = '';
		if ( self::$field->mandatory ) {
			$required = ( !self::$default ? 'required' : '' );
		}

?>

		<button class="btn open_media_upload"
				data-type="image_upload"
				data-field_name="<?php echo self::$field->name; ?>">
			<i class="fa fa-image"></i>
			<?php echo Lang::get('factotum::media.add_media'); ?>
		</button>
		<div class="media_thumb_container clearfix"></div>

		<input type="hidden" id="<?php echo self::$field->name; ?>_hidden"
			   name="<?php echo self::$field->name; ?>_hidden" <?php echo ($required ? ' required' : ''); ?>
			   value="<?php echo ( isset(self::$default) && is_array(self::$default) ? self::$default['id'] : '' ); ?>" />

<?php

	}


	private static function print_gallery()
	{
		$required = '';
		if ( self::$field->mandatory ) {
			$required = ( !self::$default ? 'required' : '' );
		}

		$tmpIDs = [];

		if ( isset(self::$default) && is_array(self::$default) && count(self::$default) > 0 ) {
			foreach (self::$default as $image) {
				$tmpIDs[] = $image['id'];
			}
		}
?>

		<button class="btn open_media_upload"
				data-type="gallery"
				data-field_name="<?php echo self::$field->name; ?>">
			<i class="fa fa-image"></i>
			<?php echo Lang::get('factotum::media.add_media'); ?>
		</button>
		<div class="media_thumb_container clearfix"></div>

		<input type="hidden" id="<?php echo self::$field->name; ?>_hidden"
			   name="<?php echo self::$field->name; ?>_hidden" <?php echo ($required ? ' required' : ''); ?>
			   value="<?php echo ( count($tmpIDs) > 0 ? join(';', $tmpIDs) : '' ); ?>" />

<?php
	}

	private static function print_linked_content()
	{
		PrintContentsDropdownTreeHelper::print_dropdown(self::$field->options, self::$field->name, self::$default, self::$field->name, 'form-control', false, self::$field->mandatory);
	}

	private static function print_multiple_linked_content()
	{
		self::$default = Utility::convertOptionsTextToArray( self::$default );

		$tmp    = [];
		$tmpIDs = '';

		if ( isset(self::$default) && count(self::$default) > 0 ) {
			$tmpIDs = Utility::convertOptionsArrayToText(self::$default);

			foreach ( self::$default as $def ) {

				if (isset(self::$field->options)) {
					foreach (self::$field->options as $opt) {
						if ( $def == $opt['id'] ) {
							$tmp[] = $opt;
						}
					}
				}
			}
		}

		?>

		<div class="row clearfix">

			<div class="col col-xs-12 col-sm-6">
				<p><?php echo Lang::get('factotum::content.select_content'); ?></p>
				<ul id="sortable1_<?php echo self::$field->id; ?>" class="connectedSortable source"
					data-field_id="<?php echo self::$field->id; ?>">
					<?php if ( isset(self::$field->options) ) { ?>
						<?php foreach ( self::$field->options as $opt ) { ?>
							<?php if ( !in_array($opt['id'], self::$default) ) { ?>
								<li class="ui-state-default" data-content_id="<?php echo $opt['id']; ?>"><?php echo $opt['title']; ?></li>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</ul>
			</div>

			<div class="col col-xs-12 col-sm-6">
				<p><?php echo Lang::get('factotum::content.to_content'); ?></p>
				<ul id="sortable2_<?php echo self::$field->id; ?>" class="connectedSortable"
					data-field_id="<?php echo self::$field->id; ?>">
					<?php if ( count($tmp) > 0 ) { ?>
						<?php foreach ( $tmp as $opt ) { ?>
							<li class="ui-state-highlight" data-content_id="<?php echo $opt['id']; ?>"><?php echo $opt['title']; ?></li>
						<?php } ?>
					<?php } ?>
				</ul>
			</div>

		</div>

		<input id="field_<?php echo self::$field->id; ?>" type="hidden"
			   name="<?php echo self::$field->name; ?>"
			   value="<?php echo old( self::$field->name, (isset(self::$default) ? $tmpIDs : null)); ?>">
		<?php
	}

	private static function print_multiple_linked_categories()
	{
		PrintCategoriesDropdownTreeHelper::print_dropdown(self::$field->options, self::$field->name, self::$default, self::$field->name, 'form-control multiple multiselect', true, self::$field->mandatory);
	}

	private static function print_errors()
	{
		if ( isset( self::$field->show_errors ) && self::$field->show_errors && self::$errors->has( self::$field->name )) {
			?>
			<span class="help-block error">
				<strong><?php echo self::$errors->first( self::$field->name ); ?></strong>
            </span>
			<?php
		}
	}

}
