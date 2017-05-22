<?php

namespace Kaleidoscope\Factotum\Helpers;

use Illuminate\Support\Facades\Lang;

class PrintContentsTreeHelper {

	public static function print_list( $list )
	{
		self::print_items( $list, 0 );
	}

	private static function print_items( $list, $counter = 0)
	{
		foreach( $list as $content ) {

			if ( !$content->parent_id ) {
				$counter = 0;
			}
?>
			<tr data-id_item="<?php echo $content->id; ?>">
				<td width="10%" scope="row"><strong><?php echo $content['id']; ?></strong></td>
				<td width="70%">
					<a href="<?php echo url('/admin/content/edit/' . $content->id); ?>">
						<?php echo ( $content->is_home ? '<i class="fa fa-home homepage-icon"></i>' : ''); ?>
						<?php echo str_repeat('— ', $counter) . $content['title']; ?>
					</a>
				</td>
				<td width="20%">
					<a href="<?php echo url('/admin/content/edit/' . $content->id); ?>" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
					<a href="<?php echo url('/admin/content/delete/' . $content->id); ?>" class="delete"
                       data-toggle="confirmation"
                       data-title="<?php echo Lang::get('factotum::generic.are_sure'); ?>"
                       data-btn-ok-label="<?php echo Lang::get('factotum::generic.yes'); ?>"
                       data-btn-cancel-label="<?php echo Lang::get('factotum::generic.no'); ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
				</td>
				<td class="sort">
					<i class="fa fa-sort" aria-hidden="true"></i>
				</td>
			</tr>
<?php
			if ( $content->childs->count() > 0 ) {
				self::print_items( $content->childs, $counter+1 );
			}
		}
	}
}