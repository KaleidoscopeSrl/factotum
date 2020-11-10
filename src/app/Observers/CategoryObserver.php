<?php

namespace Kaleidoscope\Factotum\Observers;

use Kaleidoscope\Factotum\Category;

class CategoryObserver
{

	/**
	 * Listen to the Category deleting event.
	 *
	 * @param  Category  $content
	 * @return void
	 */
	public function deleting( Category $category )
	{
		if ( $category->childrenRecursive ) {
			$firstLevelChilds = Category::where( 'parent_id' , '=', $category->id )->get();
			$parentID = null;

			if  ( $category->parent_id ) {
				$parentID = $category->parent_id;
			}

			foreach ( $firstLevelChilds as $item ) {
				$item->parent_id = $parentID;
				$item->save();
			}
		}
	}

}