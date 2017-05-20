<?php
namespace Kaleidoscope\Factotum\Library;

class Utility
{
	public static function debug($x)
	{
		echo '<pre>';
		print_r($x);
		echo '</pre>';
	}

	public static function convertOptionsArrayToText($options)
	{
		return join(';', $options);
	}

	public static function convertOptionsTextToArray($options)
	{
		return explode(';', $options);
	}

	public static function convertOptionsTextToAssocArray($options)
	{
		$result = array();
		$options = explode(';', $options);
		foreach ($options as $opt) {
			if ($opt) {
				list($value, $label) = explode(':', $opt);
				$result[$value] = $label;
			}
		}
		return $result;
	}

	public static function convertOptionsAssocArrayToString($values, $labels)
	{
		$tmp = [];
		foreach ( $values as $index => $value ) {
			$tmp[] = $value . ':' . $labels[ $index ];
		}
		return join(';', $tmp);
	}

	public static function convertHumanDateToIso($date)
	{
		return implode('-', array_reverse(explode('/', $date)));
	}

	public static function convertHumanDateTimeToIso($datetime)
	{
		list($date, $time) = explode(' ', $datetime);
		return self::convertHumanDateToIso($date) . ' ' . $time;
	}

	public static function convertIsoDateToHuman($date)
	{
		return implode('/', array_reverse(explode('-', $date)));
	}

	public static function convertIsoDateTimeToHuman($datetime)
	{
		list($date, $time) = explode(' ', $datetime);
		return self::convertIsoDateToHuman($date) . ' ' . $time;
	}

	public static function flatTree($collection, $tmp = array())
	{
		foreach ( $collection as $item ) {
			if  ( $item->parent_recursive ) {
				$newColl = $item->parent_recursive;
				$item->parent_recursive = null;
				$tmp[] = $item;
				return self::flatTree( $newColl , $tmp);
			}
			$tmp[] = $item;
		}
		return $tmp;
	}

	/**
	 * Format bytes to kb, mb, gb, tb
	 *
	 * @param  integer $size
	 * @param  integer $precision
	 * @return integer
	 */
	public static function formatBytes($size, $precision = 2)
	{
		if ($size > 0) {
			$size = (int) $size;
			$base = log($size) / log(1024);
			$suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

			return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
		} else {
			return $size;
		}
	}
}
