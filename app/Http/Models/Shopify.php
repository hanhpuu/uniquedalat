<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Shopify extends Model
{
	protected $table = 'wp_lecsm_import';
	
	public static function getMapping($ids)
	{
		return self::whereIn('id_src', $ids)->get();
	}
	
	public static function getMappingFromWpProducts($ids)
	{
		return self::whereIn('id_desc', $ids)
					->where('type', '=', 'product')
					->get();
	}
	
	public static function getMappingFromWpOrders($ids)
	{
		return self::whereIn('id_desc', $ids)
					->where('type', '=', 'order')
					->get();
	}
	
	public static function getMappingFromShoppifyOrder($shopifyId)
	{
		return self::where('id_src','=', $shopifyId)
					->where('type', '=', 'order')
					->first();
	}
	
	
}
