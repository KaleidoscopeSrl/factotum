<?php

namespace Kaleidoscope\Factotum\Helpers;

use Illuminate\Support\Facades\Storage;

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
			self::$default = $default;
		} else {
			self::$default = null;
		}


?>
		<div class="form-group<?php echo ($errors->has('status') ? ' has-error' : '' ); ?> field-<?php echo $field->type; ?>" id="form-group-<?php echo $field->name; ?>">
			
			 <div class="col-md-12">
			 <?php self::print_label(); ?>
<?php
				switch ( self::$field->type ) {
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
?>
				<?php if ( isset( self::$field->show_errors ) && self::$field->show_errors ) { ?>
				<span class="help-block error">
					<strong><?php echo $errors->first( self::$field->name ); ?></strong>
				</span>
				<?php } ?>


			 </div>
		</div>

<?php
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



	private static function print_input($type = 'text')
	{
?>
		<input id="<?php echo self::$field->name; ?>" type="<?php echo $type; ?>" class="form-control"
			   name="<?php echo self::$field->name; ?>"
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


	private static function print_textarea( $wysiwyg = false)
	{
?>
		<textarea class="form-control<?php echo ($wysiwyg ? ' wysiwyg' : ''); ?>"
			id="<?php echo self::$field->name; ?>"
			name="<?php echo self::$field->name; ?>"
			<?php echo ( self::$field->mandatory ? 'required' : '' ) . (!$wysiwyg ? ' autofocus' : ''); ?>><?php echo old( self::$field->name, (isset(self::$default) ? self::$default : null)); ?></textarea>

<?php
	}


	private static function print_date()
	{
		if ( self::$default ) {
			self::$default = Utility::convertIsoDateToHuman( self::$default );
		}
?>
		<input id="<?php echo self::$field->name; ?>" type="text" class="form-control date"
			   name="<?php echo self::$field->name; ?>"
			   value="<?php echo old( self::$field->name, (isset(self::$default) ? self::$default : null)); ?>"
			<?php echo ( self::$field->mandatory ? 'required' : '' ); ?> autofocus>
<?php
	}


	private static function print_datetime()
	{
		if ( self::$default ) {
			self::$default = Utility::convertIsoDateTimeToHuman( self::$default );
		}
?>
		<input id="<?php echo self::$field->name; ?>" type="text" class="form-control datetime"
			   name="<?php echo self::$field->name; ?>"
			   value="<?php echo old( self::$field->name, (isset(self::$default) ? self::$default : null)); ?>"
			<?php echo ( self::$field->mandatory ? 'required' : '' ); ?> autofocus>
		<?php
	}


	private static function print_checkbox()
	{
		$options = Utility::convertOptionsTextToAssocArray(self::$field->options);
?>
		<div class="form-control" style="border: none; box-shadow: none;">
            <div class="checkbox">
                <label for="<?php echo self::$field->name; ?>">
                    <input type="checkbox" id="<?php echo self::$field->name; ?>"
                           name="<?php echo self::$field->name; ?>"
                           value="<?php echo key($options); ?>"
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
					<input type="checkbox" id="<?php echo self::$field->name . '_' . $index; ?>"
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
?>
	<div class="select-wrapper">
		<select name="<?php echo self::$field->name; ?>"
				id="<?php echo self::$field->name; ?>"
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
?>
	<div class="select-wrapper">
		<select name="<?php echo self::$field->name; ?>[]" multiple="multiple"
				id="<?php echo self::$field->name; ?>"
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
?>
		<div class="form-control" style="border: none; box-shadow: none;">
<?php
			$index = 0;
			foreach ( $options as $value => $label ) { ?>
				<input type="radio" id="<?php echo self::$field->name . '_' . $index; ?>"
					   name="<?php echo self::$field->name; ?>"
					   value="<?php echo $value; ?>"
					<?php echo ( self::$field->mandatory ? 'required' : '' ); ?>
					<?php echo ( (isset(self::$default) && self::$default == $value) || ( old(self::$field->name) == $value)  ? ' checked' : '' ); ?>>
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

		<div class="needsclick dropzone_cont"
			 data-max-files="1"
			 data-field_id="<?php echo self::$field->id; ?>"
			 data-accepted-files="<?php echo self::$field->allowed_types; ?>"
			 data-mockfile="mockFile<?php echo self::$field->name; ?>"
			 data-fillable-hidden="<?php echo self::$field->name; ?>_hidden">

			<div class="dz-message needsclick">
				Drop files here or click to upload.
			</div>

			<div class="fallback">
				<input id="<?php echo self::$field->name; ?>" type="file" class="form-control"
					   name="<?php echo self::$field->name; ?>" <?php echo $required; ?> autofocus>
			</div>

<?php
			if ( isset(self::$default) && is_array(self::$default) && count(self::$default) > 0 ) {
				$ext = substr(self::$default['filename'], strlen(self::$default['filename'])-3, 3);
?>
				<script type="text/javascript">
                    var mockFile<?php echo self::$field->name; ?> = new Array();
                    mockFile<?php echo self::$field->name; ?>.push({
						name: '<?php echo self::$default['filename']; ?>',
						size: <?php echo Storage::size( self::$default['url'] ); ?>,
						type: '<?php echo self::$default['mime_type']; ?>',
						thumb: '<?php echo asset( 'factotum/images/' . $ext . '.png' ); ?>'
					});
				</script>

			<?php } ?>

		</div>

		<input type="hidden" id="<?php echo self::$field->name; ?>_hidden"
			   name="<?php echo self::$field->name; ?>_hidden"
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

		<div class="needsclick dropzone_cont"
			 data-max-files="1"
			 data-field_id="<?php echo self::$field->id; ?>"
			 data-accepted-files="<?php echo self::$field->allowed_types; ?>"
			 data-mockfile="mockFile<?php echo self::$field->name; ?>"
			 data-fillable-hidden="<?php echo self::$field->name; ?>_hidden">

			<div class="dz-message needsclick">
				Drop files here or click to upload.
			</div>

			<div class="fallback">
				<input id="<?php echo self::$field->name; ?>" type="file" class="form-control" accept="image/*" multiple
					   name="<?php echo self::$field->name; ?>" <?php echo $required; ?> autofocus>
			</div>

			<?php
			if ( isset(self::$default) && is_array(self::$default) && count(self::$default) > 0 ) {
				$filename = substr( self::$default['url'], 0, strlen(self::$default['url']) - 4) . '-thumb';
				$ext = substr( self::$default['url'], strlen(self::$default['url']) - 3, 3);
			?>

				<script type="text/javascript">
                    var mockFile<?php echo self::$field->name; ?> = new Array();
                    mockFile<?php echo self::$field->name; ?>.push({
						name: '<?php echo self::$default['filename']; ?>',
						size: <?php echo Storage::size( self::$default['url'] ); ?>,
						type: '<?php echo self::$default['mime_type']; ?>',
						thumb: '<?php echo asset( $filename . '.' . $ext ); ?>'
					});
				</script>

			<?php } ?>

			<input type="hidden" id="<?php echo self::$field->name; ?>_hidden"
				   name="<?php echo self::$field->name; ?>_hidden"
				   value="<?php echo ( isset(self::$default) && is_array(self::$default) ? self::$default['id'] : '' ); ?>" />

		</div>

<?php

	}


	private static function print_gallery()
	{
		$required = '';
		if ( self::$field->mandatory ) {
			$required = ( !self::$default ? 'required' : '' );
		}

		$tmpIDs = array();
?>

	<div class="needsclick dropzone_cont"
		 data-max-files="999"
		 data-field_id="<?php echo self::$field->id; ?>"
		 data-accepted-files="<?php echo self::$field->allowed_types; ?>"
		 data-mockfile="mockFile<?php echo self::$field->name; ?>"
		 data-fillable-hidden="<?php echo self::$field->name; ?>_hidden">

		<div class="dz-message needsclick">
			Drop files here or click to upload.
		</div>

		<div class="fallback">
			<input id="<?php echo self::$field->name; ?>" type="file" class="form-control" accept="image/*" multiple
				   name="<?php echo self::$field->name; ?>[]" <?php echo $required; ?> autofocus>
		</div>

		<?php if ( isset(self::$default) && is_array(self::$default) && count(self::$default) > 0 ) { ?>
			<script type="text/javascript">
				var mockFile<?php echo self::$field->name; ?> = new Array();
			</script>

			<?php
			foreach ( self::$default as $image ) {
				$filename = substr( $image['url'], 0, strlen($image['url']) - 4) . '-thumb';
				$ext = substr( $image['url'], strlen($image['url']) - 3, 3);
			?>
			<script type="text/javascript">
				mockFile<?php echo self::$field->name; ?>.push({
					name: '<?php echo $image['filename']; ?>',
					size: <?php echo Storage::size( $image['url'] ); ?>,
					type: '<?php echo $image['mime_type']; ?>',
					thumb: '<?php echo asset( $filename . '.' . $ext ); ?>'
				});
			</script>

			<?php
				$tmpIDs[] = $image['id'];
			}
			?>

		<?php } ?>

		<input type="hidden" id="<?php echo self::$field->name; ?>_hidden"
			   name="<?php echo self::$field->name; ?>_hidden"
			   value="<?php echo ( count($tmpIDs) > 0 ? join(';', $tmpIDs) : '' ); ?>" />

	</div>

<?php
	}

	private static function print_linked_content()
	{
		PrintContentsDropdownTreeHelper::print_dropdown(self::$field->options, self::$field->name, self::$default, self::$field->name, 'form-control', false, self::$field->mandatory);
	}

	private static function print_multiple_linked_content()
	{
		self::$default = Utility::convertOptionsTextToArray( self::$default );

		PrintContentsDropdownTreeHelper::print_dropdown(self::$field->options, self::$field->name, self::$default, self::$field->name, 'form-control multiple multiselect', true, self::$field->mandatory);
	}

	private static function print_multiple_linked_categories()
	{
		PrintCategoriesDropdownTreeHelper::print_dropdown(self::$field->options, self::$field->name, self::$default, self::$field->name, 'form-control multiple multiselect', true, self::$field->mandatory);
	}








	private static function print_errors()
	{
		if (self::$errors->has( self::$field->name )) {
?>
			<span class="help-block">
				<strong><?php echo self::$errors->first( self::$field->name ); ?></strong>
            </span>
<?php
		}
	}

}




