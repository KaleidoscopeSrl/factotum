<?php
namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package Kaleidoscope\Factotum\Models
 */
abstract class BaseModel extends Model
{
	use HasFactory;
}
