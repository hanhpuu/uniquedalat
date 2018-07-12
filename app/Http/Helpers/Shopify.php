<?php

namespace App\Http\Helpers;

use App;
use App\Http\Models\WpOrder;
use App\Http\Models\WpOrderMeta;
use App\Http\Models\WpTermTaxonomy;

class Shopify 
{
	const SHOPIFY_APP_USENAME = '3b488386a6525673300c6abd674a967a';
	const SHOPIFY_APP_PASSWORD = 'c36f1d2058d9851e75cf812554f47a6a';
	const SHOPIFY_URL = 'boulevard-16.myshopify.com';
	
	public $shopify = '';
	public $PER_PAGE = 250;
	
	public function __construct()
	{
		$this->shopify = App::make('ShopifyAPI', 
				[
					'API_KEY' => self::SHOPIFY_APP_USENAME, 
					'API_SECRET' => self::SHOPIFY_APP_PASSWORD, 
					'SHOP_DOMAIN' => self::SHOPIFY_URL,
					'ACCESS_TOKEN' => self::SHOPIFY_APP_PASSWORD
				]
		); 
	}
	
	public function addParam($url, $key, $val)
	{
		$query = parse_url($url, PHP_URL_QUERY);
		
		// Returns a string if the URL has parameters or NULL if not
		if ($query) {
			parse_str($query, $queryString);
			if(isset($queryString[$key])) {
				$queryString[$key] = $val;
			} else {
				$queryString['page'] = $val;
			}
			$url = str_replace($query, '', $url);
			$url .= urldecode(http_build_query($queryString));
		} else {
			$url .= "?$key=$val";
		}
		
		return $url;
	}
	public function call($args, $extract=false)
	{
		set_time_limit(0);
		$result = [];
		$page = 0;
		do {
			$page++;
			$args['URL'] = $this->addParam($args['URL'], 'page', $page);
			try {
				$data = $this->shopify->call($args);

			} catch (Exception $e) {
				// try one more time
				try {
					$data = $this->shopify->call($args);
				} catch (Exception $ex) {
					$msg = $e->getMessage();
					throw new \Exception($msg);
				}
			}
			
			if($extract && isset($data->{$extract})) {
				$data = $data->{$extract};
			}

			$result = array_merge($result, $data);
		} while(count($data) > 0);
		return $result;
	}
	
	public function tryCall($args, $extract=false)
	{
		try {
				$data = $this->shopify->call($args);
		} catch (Exception $e) {
			// try one more time
			try {
				$data = $this->shopify->call($args);
			} catch (Exception $ex) {
				$msg = $e->getMessage();
				throw new \Exception($msg);
			}
		}
		
		if($extract && isset($data->{$extract})) {
			$data = $data->{$extract};
		}
		
		return $data;
	}
	
	public function getShopifyProductIds()
	{
		$args = [
			'URL' => '/admin/products.json?fields=id',
		];
		$data = $this->call($args, 'products');
		$products = [];
		foreach ($data as $product) {
			$products[] = $product->id;
		}
		return $products;
	}
	
	public function getProductFontsMeta($productIds)
	{
		$result = [];
//		$i = 0;
		foreach ($productIds as $shopify => $wpId) {
			$args = [
				'URL' => "/admin/products/$shopify/metafields.json"
			];
			$meta = $this->shopify->call($args);
			if(!empty($meta->metafields)) {
				foreach ($meta->metafields as $metaField) {
					if($metaField->key != 'fonts') {
						continue;
					}
					$result[$wpId] =  $metaField->value;
				}
			}
//			sleep(1);
//			$i++;
//			if($i == 10) {
//				break;
//			}
		}
		return $result;
	}
	
	public static function importCsvData($filePath)
	{
		set_time_limit(0);
		$fields = [];
		if (($handle = fopen($filePath, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
				if(is_numeric($data[0])) {
					$productId = $data[0];
					$fontString = trim(preg_replace('/\s+/', ' ', $data[1]));
					$fonts = explode(',', $fontString);

					foreach ($fonts as $font) {
						$fontPart = explode(':', $font);
						$fontSlug = str_replace([' ', '/', '-'], '_', strtolower(trim($fontPart[0])));
						$fontDescription = isset($fontPart[1]) ? $fontPart[1] : '';
						if(strlen($fontSlug)) {
							$fields[$productId][$fontSlug] = $fontDescription;
						}
					}
				}
			}
			fclose($handle);
		}	
		return $fields;
	}
	
	public function prepareOrderData()
	{
		$args = [
			'URL' => "/admin/orders.json?fields=order_number,line_items&status=any"
		];
		$orders = $this->call($args, 'orders');	
		$data = [];
		foreach ($orders as $order) {
			if(isset($order->order_number) && isset($order->line_items) && is_array($order->line_items)) {
				$orderId = $order->order_number;
				foreach ($order->line_items as $lineItem) {
					$variantName = $lineItem->name;
					$variantQty = $lineItem->quantity;
					$monograms = [];
					
					// monogram
					if(is_array($lineItem->properties) && count($lineItem->properties)) {
						foreach ($lineItem->properties as $monogramOption) {
							if(!empty($monogramOption->value) && !empty($monogramOption->name)) {
								$monograms[] = $monogramOption->name;
								$monograms[] = $monogramOption->value;
							}
						}
					}
					
					if(count($monograms) > 0) {
						$newData = array_merge([$order->order_number, $variantName, $variantQty], $monograms);
						$data[] = $newData;
					}
				}
			}
			
		}
		
		return $data;
	}
	
	public function saveOrderCustomFields()
	{
		
		$data = $this->prepareOrderData();

		// open the file "demosaved.csv" for writing
		$file = fopen('demosaved.csv', 'w');

		// save each row of the data
		foreach ($data as $row)
		{
			fputcsv($file, $row);
		}

		// Close the file
		fclose($file);
	}
	
	public function importOrderCustomFields()
	{
		set_time_limit(0);
		$filePath = 'demosaved.csv';
		if (($handle = fopen($filePath, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
				if(
					!empty($data[0]) && !empty($data[1])  && !empty($data[2])  && !empty($data[3])  && !empty($data[4]) 
					 && !empty($data[5])  && !empty($data[6])  && !empty($data[7])  && !empty($data[8])
				) {
					$shopifyId = $data[0];
					$lineItemName = $data[1];

					$lineItem = WpOrder::getNotMonogramedLineItem($shopifyId, $lineItemName);
					if($lineItem) {
						// prepare monogram info to input
						$orderItemId = $lineItem->order_item_id;
						
						// insert font
						WpOrderMeta::create([
							'meta_key' => 'pa_fonts', 
							'meta_value' => WpTermTaxonomy::getColorSlug($data[4]),
							'order_item_id' => $orderItemId
						]);
						
						
						// insert text color
						WpOrderMeta::create([
							'meta_key' => 'pa_text-color', 
							'meta_value' => WpTermTaxonomy::getColorSlug($data[6]),
							'order_item_id' => $orderItemId
						]);
						
						// insert text
						WpOrderMeta::create([
							'meta_key' => 'ENTER LETTERS', 
							'meta_value' => $data[8],
							'order_item_id' => $orderItemId
						]);
						
					}
				}
			}
			fclose($handle);
		}	
	}
}