<?php

namespace Kaleidoscope\Factotum\Helpers;

use Illuminate\Support\Facades\Lang;

class PrintCategoriesTreeHelper {

	public static function print_list( $list )
	{
		self::print_items( $list );
	}

	private static function print_items( $list, $counter = 0)
	{
		foreach( $list as $category ) {

			if ( !$category->parent_id ) {
				$counter = 0;
			}
?>
			<tr data-id_item="<?php echo $category->id; ?>">
				<td width="10%" scope="row"><strong><?php echo $category['id']; ?></strong></td>
				<td width="70%">
					<a href="<?php echo url('/admin/category/edit/' . $category->id); ?>"><?php echo str_repeat('— ', $counter) . $category['label']; ?></a>
				</td>
				<td width="20%">
					<a href="<?php echo url('/admin/category/edit/' . $category->id); ?>"" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
					<a href="<?php echo url('/admin/category/delete/' . $category->id); ?>" class="delete"
                       data-toggle="confirmation"
                       data-title="<?php echo Lang::get('factotum::generic.are_sure'); ?>"
                       data-btn-ok-label="<?php echo Lang::get('factotum::generic.yes'); ?>"
                       data-btn-cancel-label="<?php echo Lang::get('factotum::generic.no'); ?>">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
				</td>
			</tr>
<?php
			if ( $category->childs->count() > 0 ) {
				$counter++;
				self::print_items( $category->childs, $counter );
			}
		}
	}
}