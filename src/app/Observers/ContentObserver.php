<?php

namespace Kaleidoscope\Factotum\Observers;

use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentType;

class ContentObserver
{
	/**
	 * Listen to the ContentType created event.
	 *
	 * @param  Content  $content
	 * @return void
	 */
	public function created(Content $content)
	{
	}

	/**
	 * Listen to the ContentType updated event.
	 *
	 * @param  Content  $content
	 * @return void
	 */
	public function updating(Content $content)
	{
	}


	public function saved( Content $content )
	{
		if ( $content::$FIRE_EVENTS ) {
			$this->generateURLs( $content );
		}
	}

	private function generateURLs( Content $content )
	{
		$contentType = ContentType::where( 'content_type', '=', 'page' )->first();

		if ( $content->content_type_id == $contentType->id ) {

			$lang = ( $content->lang != config('factotum.main_site_language') ? $content->lang : '' );

			// Generating pages
			if ( $content->parent_id ) {
				$absUrl = $this->generateHierarchyURL( $content );
				$absUrl = url($lang)
						. '/'
						. $absUrl;
			} else {
				$absUrl = url($lang)
						. '/'
						. $content->url;
			}

			DB::table('contents')
				->where( 'id', $content->id )
				->update([ 'abs_url' => $absUrl ]);

			if ( $content->childs ) {
				$this->updateChildsAbsURL( $content->childs, $content );
			}
		}
	}

	private function generateHierarchyURL( $content )
	{
		$parents = Content::with('parentRecursive')->whereId( $content->id )->get();
		$parents = $parents->toArray();
		$final   = array_reverse(  $this->reverseParentsHierarchy( $parents ) );
		$url     = array();
		if ( count($final) > 0 ) {
			foreach ( $final as $index => $item ) {
				$url[] = $item['url'];
			}
		}
		return join( '/', $url );
	}

	private function reverseParentsHierarchy( $parents, $final = array() )
	{
		foreach ( $parents as $item ) {
			if ( isset($item['parent_recursive']) && $item['parent_recursive'] ) {
				$next = array( $item['parent_recursive'] );
				unset( $item['parent_recursive'] );
				$final[] = $item;
				return $this->reverseParentsHierarchy( $next, $final );
			} else {
				$final[] = $item;
			}
		}
		return $final;
	}

	private function updateChildsAbsURL( $childs, $parent )
	{
		foreach ( $childs as $item ) {
			DB::table('contents')
				->where( 'id', $item->id )
				->update([ 'abs_url' => $parent->abs_url . '/' . $item->url ]);

			if ( $item->childs->count() ) {
				return $this->updateChildsAbsURL( $item->childs, $item );
			}
		}
	}


	/**
	 * Listen to the ContentType deleting event.
	 *
	 * @param  Content  $content
	 * @return void
	 */
	public function deleting(Content $content)
	{
		if ( $content::$FIRE_EVENTS ) {
			if ( $content->childrenRecursive ) {
				$firstLevelChilds = Content::where( 'parent_id' , '=', $content->id )->get();
				if  ( $content->parent_id ) {
					$parentID = $content->parent_id;
				} else {
					$parentID = null;
				}
				foreach ( $firstLevelChilds as $item ) {
					$item->parent_id = $parentID;
					$item->save();
				}
			}
		}
	}
}