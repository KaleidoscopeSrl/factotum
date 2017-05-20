<?php

namespace Kaleidoscope\Factotum\Helpers;

class PrintCategoriesDropdownTreeHelper {

	protected static $current;
	protected static $name;
	protected static $multiple;
	protected static $toExclude;

	public static function print_dropdown( $options, $name, $current = '', $id = '', $class = '', $multiple = false, $required = false, $toExclude = null )
	{
		self::$current  = $current;
		self::$name     = $name;
		self::$multiple = $multiple;
		self::$toExclude = $toExclude;

?>
		<div class="select-wrapper">
			<select name="<?php echo $name . ($multiple ? '[]' : ''); ?>"
					id="<?php echo $id; ?>"
					class="<?php echo $class; ?> " autofocus
				<?php echo ( $multiple ? ' multiple': '' ) . ( $required ? ' required' : '' ); ?>>

				<?php if ( !$multiple ) { ?>
					<option value="">Seleziona la voce padre</option>
				<?php } ?>

				<?php self::print_options( $options, 0 ); ?>
			</select>
		</div>
<?php

	}

	protected static function print_options( $options, $counter = 0)
	{
		foreach( $options as $opt ) {

//			if ( !$opt['parent_id'] ) {
//				$counter = 0;
//			}

			$selected = '';
			if (self::$multiple) {
				if (( is_array(old(self::$name)) && in_array($opt['id'], old(self::$name)) ) ||
					( self::$current == $opt['id'] ) ||
					( is_array(self::$current) && in_array($opt['id'], self::$current) )
				) {
					$selected = ' selected';
				}
			} else {
				$selected = (self::$current == $opt['id'] || old(self::$name) == $opt['id'] ? ' selected' : '');
			}


			if ( self::$toExclude ) {
				if ( self::$toExclude != $opt['id'] ) {
					self::print_single_opt( $opt, $counter, $selected );
				}
			} else {
				self::print_single_opt( $opt, $counter, $selected );
			}

			if ( isset($opt['childs']) && count($opt['childs']) > 0) {
				self::print_options($opt['childs'], $counter+1);
			}

		}
	}

	protected static function print_single_opt( $opt, $counter, $selected )
	{
		//$counter = ( !$opt['parent_id'] ? 0 : $counter );
?>
		<option value="<?php echo $opt['id']; ?>"<?php echo $selected; ?>>
			<?php echo str_repeat('— ', $counter) . ( isset($opt['title']) ? $opt['title'] : $opt['label'] ); ?>
		</option>
<?php
	}

}