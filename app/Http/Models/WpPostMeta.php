<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\WpTermTaxonomy;
use App\Http\Models\WpPost;

class WpPostMeta extends Model {

    protected $table = 'wp_postmeta';
    public $timestamps = false;
    protected $primaryKey = 'meta_id';
    protected $fillable = ['meta_key', 'meta_value', 'post_id'];

    // remove sku of product has multiple variations
    public static function removeSku() {
        $ids = WpPost::getProductsHaveVariations();
        if (!empty($ids)) {
            self::where('meta_key', '=', '_sku')
                    ->whereIn('post_id', $ids)
                    ->update(['meta_value' => '']);
        }
    }

    // add and modify some product meta data
    public static function changeVariationPostMeta($variationIds) {
        $variaionColors = WpPostMeta::where('meta_key', '=', 'attribute_color')
                        ->whereIn('post_id', $variationIds)
                        ->get()->pluck('meta_value', 'post_id');

        foreach ($variationIds as $variationId) {
            if (isset($variaionColors[$variationId])) {
                // add color option to variation and remove old one
                $metaColor = self::firstOrNew(['meta_key' => 'attribute_pa_color', 'post_id' => $variationId]);
                $metaColor->meta_value = WpTermTaxonomy::getColorSlug($variaionColors[$variationId]); // set pa_color
                $metaColor->save();

                $metaColorOld = self::where('post_id', '=', $variationId)->where('meta_key', '=', 'attribute_color')->first();
                if ($metaColorOld) {
                    $metaColorOld->delete();
                }
            }

            $metaMonogram = self::where('post_id', '=', $variationId)->where('meta_key', '=', 'attribute_monogramming')->first();
            if ($metaMonogram) {
                $metaMonogram->delete();
            }

            // add font option to variation
            $metaFont = self::firstOrNew(['meta_key' => 'attribute_pa_fonts', 'post_id' => $variationId]);
            $metaFont->meta_value = ''; // set pa_fonts
            $metaFont->save();

            // add text color option to variation
            $metaTextColor = self::firstOrNew(['meta_key' => 'attribute_pa_text-color', 'post_id' => $variationId]);
            $metaTextColor->meta_value = ''; // set text color
            $metaTextColor->save();

            // set monogram rectangle
            $meta = self::firstOrNew(['meta_key' => 'rectangle_x_pos', 'post_id' => $variationId]);
            $meta->meta_value = 0.12;
            $meta->save();

            $meta = self::firstOrNew(['meta_key' => 'rectangle_y_pos', 'post_id' => $variationId]);
            $meta->meta_value = 0.71;
            $meta->save();

            $meta = self::firstOrNew(['meta_key' => 'rectangle_real_width', 'post_id' => $variationId]);
            $meta->meta_value = 2;
            $meta->save();

            $meta = self::firstOrNew(['meta_key' => 'rectangle_real_height', 'post_id' => $variationId]);
            $meta->meta_value = 1;
            $meta->save();

            $meta = self::firstOrNew(['meta_key' => 'product_real_width', 'post_id' => $variationId]);
            $meta->meta_value = 8;
            $meta->save();

            $meta = self::firstOrNew(['meta_key' => 'product_real_height', 'post_id' => $variationId]);
            $meta->meta_value = 4;
            $meta->save();
        }
    }

    // get list of product in db that allow monogramming
    public static function getMonogrammedProduct() {
        $result = [];
        $prdAtts = self::where('meta_key', '=', '_product_attributes')->get();
        foreach ($prdAtts as $prdAttr) {
            $attr = unserialize($prdAttr->meta_value);
            if (WpPost::isMonogrammedProduct($attr)) {
                $result[] = $prdAttr->post_id;
            }
        }
        return array_unique($result);
    }

    //	to get all id of main products where NOT TICKED "manage_stock"
    public static function getUnmanagedStockProductIds($main_product_ids) {
        $unmanaged_products = WpPostMeta::where('meta_key', '=', '_manage_stock')
                        ->where('meta_value', '=', 'no')
                        ->whereIn('post_id', $main_product_ids)
                        ->get()->pluck('post_id')->toArray();
        return $unmanaged_products;
    }

    //update stock to 50
    public static function updateStockNumber($product_ids) {
        foreach ($product_ids as $product_id) {
            WpPostMeta::updateOrCreate(['meta_key' => '_stock', 'post_id' => $product_id], ['meta_value' => 50]);
        }
    }

    /*
     * tick the checkbox mange stock for all un-managed stock products
     * @param array $unmanaged_product list of un-managed product ids
     * @return null
     */

    public static function tickManageStockForUnmanagedProducts($unmanaged_product) {
        WpPostMeta::where('meta_key', '=', '_manage_stock')
                ->whereIn('post_id', $unmanaged_product)
                ->update(['meta_value' => 'yes']);
    }

}
