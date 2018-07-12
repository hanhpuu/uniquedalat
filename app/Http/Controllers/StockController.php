<?php

namespace App\Http\Controllers;

use App\Http\Models\WpPost;
use App\Http\Models\WpPostmeta;
use App\Http\Models\WpTermTaxonomy;

class StockController extends Controller {

    public function setMassStock() {
        try {
           //to get all id of main products from table wp_posts  
           $main_product_ids = WpPost::where('post_type', '=', 'product')->select('id')->get()->pluck('id')->toArray();
           $unmanaged_products = WpPostmeta::getUnmanagedStockProductIds($main_product_ids);
           WpPostmeta::tickManageStockForUnmanagedProducts($unmanaged_products);
           WpPostmeta::updateStockNumber($main_product_ids);
        } catch(\Exception $e) {
            var_dump($e);
        }
        echo 'success';
    }
    
    public function addColorOption() {         
        $products = WpPost::getProductIdOfVariationMonogramnProducts();
        WpPost::addTextColorAttributeAndSwatch($products);
        echo 'success';

    }
}
