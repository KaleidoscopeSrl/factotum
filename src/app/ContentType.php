<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Kaleidoscope\Factotum\Filters\CapabilityContentTypeFilter;

class ContentType extends Model
{
	use CapabilityContentTypeFilter;

	protected $fillable = [
		'content_type',
		'old_content_type',
		'editable',
		'order_no',
		'icon',
		'sitemap_in'
	];

	public function content_fields() {
		return $this->hasMany('Kaleidoscope\Factotum\ContentField')->orderBy('order_no');
	}

	public function categories() {
		return $this->hasMany('Kaleidoscope\Factotum\Category')->orderBy('order_no');
	}

}
