<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Shopify;
use App\Http\Models\WpPost;
use App\Http\Models\WpTermTaxonomy;
use App\Http\Models\WpPostMeta;
use App\Http\Models\Shopify as ShopifyModel;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class ShopifyProductController extends Controller
{
	public function exportShopifyFont(Shopify $sh)
	{
		$headers = array(
			"Content-type" => "text/csv",
			"Content-Disposition" => "attachment; filename=file.csv",
			"Pragma" => "no-cache",
			"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
			"Expires" => "0"
		);
		
		$monogrammedProducts = WpPostMeta::getMonogrammedProduct();
		$shopifyMapping = ShopifyModel::getMappingFromWpProducts($monogrammedProducts);
		$shopifyProductIds = $shopifyMapping->pluck('id_desc', 'id_src');
		$fonts = $sh->getProductFontsMeta($shopifyProductIds);
		$columns = array('product_id', 'fonts');

		$callback = function() use ($fonts, $columns)
		{
			$file = fopen('php://output', 'w');
			fputcsv($file, $columns);

			foreach($fonts as $productId => $font) {
				fputcsv($file, array($productId, $font));
			}
			fclose($file);
		};
		return Response::stream($callback, 200, $headers);
	}
	
	public function changeImportedData(Request $request)
	{
		set_time_limit(0);	
		
		if($request->isMethod('post')) {
			$csvFile = $request->get('file');
			$productFonts = Shopify::importCsvData($csvFile);
			// remove monogrammed variants
			WpPost::removeMonogrammedVariants();
			// add all prduct colors to global colors;
			WpTermTaxonomy::addProductColors();
			// remove sku to remove error unique sku
			WpPostMeta::removeSku();
//			 traverse product and make changes
			WpPost::importShopifyData($productFonts);
		} else {
			return view('front.shopify.import-product');
		}
	}

	public function test(Shopify $sh)
	{
//		WpPostMeta::removeSku();
		$args = [
			'URL' => '/admin/orders.json?status=any&ids=211770703884'
		];
		$meta = $sh->shopify->call($args);
		
		echo '<pre>';
		print_r($meta);
		echo '</pre>';
		die;
	}
}