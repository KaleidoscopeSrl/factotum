<?php

namespace Kaleidoscope\Factotum\Models;

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
		'sitemap_in',
		'label',
		'visible',
		'static_content'
	];

	public function content_fields() {
		return $this->hasMany('Kaleidoscope\Factotum\Models\ContentField')->orderBy('order_no');
	}

	public function categories() {
		return $this->hasMany('Kaleidoscope\Factotum\Models\Category')->orderBy('order_no');
	}

}
