<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\WpOrderMeta;
use DB;

class WpOrder extends Model
{
	protected $table = 'wp_woocommerce_order_items';
	public $timestamps = false;
	protected $primaryKey = 'order_item_id';

	public static function getMatchingLineItems($shopifyOrderId, $lineItemName)
	{
		return DB::table('wp_lecsm_import')
					->join('wp_woocommerce_order_items', 'wp_lecsm_import.id_desc', '=', 'wp_woocommerce_order_items.order_id')
					->where('wp_lecsm_import.id_src', '=', $shopifyOrderId)
					->where('wp_lecsm_import.type', '=', 'order')
					->where('wp_woocommerce_order_items.order_item_name', '=', $lineItemName)
					->where('wp_woocommerce_order_items.order_item_type', '=', 'line_item')
				    ->orderBy('wp_woocommerce_order_items.order_id', 'asc')
					->get();
	}
	
	public static function getNotMonogramedLineItem($shopifyOrderId, $lineItemName)
	{
		$lineItems = self::getMatchingLineItems($shopifyOrderId, $lineItemName);		
		if(count($lineItems) == 1) {
			return self::isLineItemMonogramed($lineItems[0]) ? null : $lineItems[0];			
		} else {
			// for each line item
			// test if this line item monogrammed or not
			// get the first line item which is not moonogrammed
			foreach ($lineItems as $lineItem) {
				if(!self::isLineItemMonogramed($lineItem)) {
					return $lineItem;
				}
			}
			return null;
		}	
	}
	
	public static function isLineItemMonogramed($lineItem) 
	{
		$itemId = $lineItem->order_item_id;
		$meta = WpOrderMeta::where('order_item_id', '=', $itemId)->where('meta_key', '=', 'pa_fonts')->first();
		if($meta) {
			return true;
		} else {
			return false;
		}
	}
}