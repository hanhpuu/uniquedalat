<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class WpOrderMeta extends Model
{
	protected $table = 'wp_woocommerce_order_itemmeta';
	public $timestamps = false;
	protected $primaryKey = 'order_item_id';
	protected $fillable = ['meta_key', 'meta_value', 'order_item_id'];

}