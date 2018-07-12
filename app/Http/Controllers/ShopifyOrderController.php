<?php

namespace App\Http\Controllers;

use App\Http\Models\WpPost;
use App\Http\Helpers\Shopify;


class ShopifyOrderController extends Controller
{
	function saveOrderData(Shopify $sh)
	{
		$sh->saveOrderCustomFields();
	}
	
	function importOrderData(Shopify $sh)
	{
		$sh->importOrderCustomFields();
	}
}