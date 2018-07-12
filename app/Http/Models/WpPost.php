<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\WpPostMeta;
use App\Http\Models\WpTermTaxonomy;
use App\Http\Models\WpTermRelationShip;
use DB;

class WpPost extends Model {

    protected $table = 'wp_posts';
    static $TAXONOMY_COLOR = 'pa_color';
    static $TAXONOMY_FONT = 'pa_fonts';
    static $TAXONOMY_TEXT_COLOR = 'pa_text-color';

    public static function allOrderIds() {
        return self::where('post_type', '=', 'shop_order')
                        ->get()->pluck('ID');
    }

    public static function removeMonogrammedVariants() {
        // get the list of variants to remove
        $meta = WpPostMeta::where('meta_key', '=', 'attribute_monogramming')
                        ->where('meta_value', '=', 'monogrammed')->get();
        $postIds = $meta->pluck('post_id');
        if (count($postIds) > 0) {
            // remove variant meta
            WpPostMeta::whereIn('post_id', $postIds)->delete();
            // remove variant
            self::whereIn('ID', $postIds)->delete();
        }
    }

    public static function getGlobalFonts() {
        $globalFonts = WpTermTaxonomy::getDbFonts();
        $gFonts = $globalFonts->toArray();

        $result = [];
        foreach ($gFonts as $gFont) {
            $result[$gFont['slug']] = $gFont;
        }
        return $result;
    }

    public static function importShopifyData($productFonts) {
        $prdAtts = WpPostMeta::where('meta_key', '=', '_product_attributes')->get();
        $globalFonts = self::getGlobalFonts();
        $globalTextColors = WpTermTaxonomy::getDbTextColors();
        foreach ($prdAtts as $prdAttr) {
//			$accept = [681];
//			if(!in_array($prdAttr->post_id, $accept)) {
//				continue;
//			}
            $variations = self::getVariationIds($prdAttr->post_id);


            // variable product case
            if (!empty($variations)) {
                $attr = unserialize($prdAttr->meta_value);
                // change all product customized colors to use global colors insead
                self::changeToGlobalColor($prdAttr->post_id, $attr);

                // if product has monogrammed option then set fonts and personalized option
                if (self::isMonogrammedProduct($attr)) {
                    self::changeToGlobalFont($prdAttr->post_id, $attr, $globalFonts, $productFonts);
                    self::selectPersonalizedOption($prdAttr->post_id);
                    self::addTextColor($prdAttr->post_id, $attr, $globalTextColors);
                }

                self::addDefaultVariation($prdAttr->post_id, $attr);
                self::setSwatch($prdAttr->post_id, $attr, $variations, $productFonts, $globalTextColors);

                // change other post meta
                WpPostMeta::changeVariationPostMeta($variations);

                // save product attribute meta data
                self::savePostAtrribute($attr, $prdAttr);
            } else {
                // simple product case
                self::changeToGlobalColor($prdAttr->post_id, $attr);
            }
        }
    }

    /*
     * add text color to single product but have attribute monogramming
     */

    public static function addTextColor($postId, $attr, $globalTextColors) {
        if (isset($attr['monogramming']) && !isset($attr['pa_fonts']) && $globalTextColors->count() > 0) {
            $data = []; // prepare data to insert

            foreach ($globalTextColors as $gTextColor) {
                $data[] = [
                    'object_id' => $postId,
                    'term_taxonomy_id' => $gTextColor->term_taxonomy_id,
                    'term_order' => 0
                ];
            }

            // test find a global font assigned to product, if can't find them insert
            $testRelationship = WpTermRelationShip::where('object_id', '=', $postId)
                            ->where('term_taxonomy_id', $globalTextColors[0]->term_taxonomy_id)->first();

            if (count($data) && !$testRelationship) {
                WpTermRelationShip::insert($data);
            }
        }
    }

    /*
     * add all global text color to variable product (check all )
     */

    public static function addTextColorToVariableProduct($postId, $globalTextColors) {
        if ($globalTextColors->count() > 0) {
            $data = []; // prepare data to insert

            foreach ($globalTextColors as $gTextColor) {
                // test find a global font assigned to product, if can't find them insert
                $testRelationship = WpTermRelationShip::where('object_id', '=', $postId)
                                        ->where('term_taxonomy_id', $gTextColor->term_taxonomy_id)->first();
                if(!$testRelationship) {
                    $data[] = [
                        'object_id' => $postId,
                        'term_taxonomy_id' => $gTextColor->term_taxonomy_id,
                        'term_order' => 0
                    ];
                }
            }
            
            if (count($data)) {
                WpTermRelationShip::insert($data);
            }
        }
    }

    public static function getVariationIds($postId) {
        $vaariations = self::where('post_parent', '=', $postId)
                ->where('post_type', '=', 'product_variation')
                ->get();
        return $vaariations->pluck('ID')->toArray();
    }

    public static function setSwatch($postId, $attr, $varitionIds, $productFonts, $globalTextColors) {
        $data = [];

        if (isset($attr['color'])) {
            $data[md5(self::$TAXONOMY_COLOR)] = self::getColorSwatch($postId, $attr, $varitionIds);
        }

        // set fonts swatch
        if (self::isMonogrammedProduct($attr)) {
            if (!empty($productFonts[$postId])) {
                $data[md5(self::$TAXONOMY_FONT)] = self::getFontSwatch($productFonts[$postId]);
            }
            $data[md5(self::$TAXONOMY_TEXT_COLOR)] = self::getTextColorSwatch($globalTextColors);
        }

        if (count($data)) {
            $swatchTypeOptionMeta = WpPostMeta::firstOrNew(['meta_key' => '_swatch_type_options', 'post_id' => $postId]);
            $swatchTypeOptionMeta->meta_value = serialize($data);
            $swatchTypeOptionMeta->save();

            $swatchTypeMeta = WpPostMeta::firstOrNew(['meta_key' => '_swatch_type', 'post_id' => $postId]);
            $swatchTypeMeta->meta_value = 'pickers';
            $swatchTypeMeta->save();
        }
    }

    // assign product color to product color swatch
    public static function getColorSwatch($postId, $attr, $varitionIds) {
        $prdColors = explode('|', $attr['color']['value']);
        $colors = WpTermTaxonomy::getColorSlugListFromNames($prdColors);
        $variationsColorThumbnails = self::matchVariationsColorAndThumbnail($varitionIds);

        $colorSwatch = [];
        foreach ($colors as $color) {
            $colorSwatch[md5($color)] = [
                'type' => 'image',
                'color' => '#FFFFFF',
                'image' => isset($variationsColorThumbnails[$color]) ? $variationsColorThumbnails[$color] : 0
            ];
        }

        return [
            'type' => 'product_custom',
            'layout' => 'default',
            'size' => 'thumbnail',
            'attributes' => $colorSwatch
        ];
    }

    public static function getTextColorSwatch($globalTextColors) {
        $textColorSwatch = []; // prepare data to insertư
        foreach ($globalTextColors as $gTextColor) {
            $textColorSwatch[md5($gTextColor->slug)] = [
                'type' => 'color',
                'color' => '#FFFFFF',
                'image' => 0
            ];
        }
        return [
            'type' => 'term_options',
            'layout' => 'default',
            'size' => 'swatches_image_size',
            'attributes' => $textColorSwatch
        ];
    }

    // assign all fonts to the product font swatch
    public static function getFontSwatch($fonts) {
        $fontSwatch = []; // prepare data to insert
        foreach ($fonts as $slug => $description) {
            $fontSwatch[md5($slug)] = [
                'type' => 'color',
                'color' => '#FFFFFF',
                'image' => 0
            ];
        }
        return [
            'type' => 'term_options',
            'layout' => 'default',
            'size' => 'swatches_image_size',
            'attributes' => $fontSwatch
        ];
    }

    public static function matchVariationsColorAndThumbnail($varitionIds) {
        $variationThumbnails = WpPostMeta::where('meta_key', '=', '_thumbnail_id')
                        ->whereIn('post_id', $varitionIds)
                        ->get()->pluck('meta_value', 'post_id');
        $variaionColors = WpPostMeta::where('meta_key', '=', 'attribute_color')
                        ->whereIn('post_id', $varitionIds)
                        ->get()->pluck('meta_value', 'post_id');
        $result = [];
        foreach ($variaionColors as $postId => $color) {
            $slug = WpTermTaxonomy::getColorSlug($color);
            $result[$slug] = $variationThumbnails[$postId];
        }
        return $result;
    }

    // choose default variation for product
    public static function addDefaultVariation($postId, $attr) {
        $defaultMeta = WpPostMeta::where('meta_key', '=', '_default_attributes')
                ->where('post_id', '=', $postId)
                ->first();
        if ($defaultMeta) {
            $defaultMeta->meta_value = serialize([
                self::$TAXONOMY_COLOR => self::getFirstColorSlugFromAttr($attr),
                self::$TAXONOMY_FONT => 'bookman',
                self::$TAXONOMY_TEXT_COLOR => 'blind'
            ]);
            $defaultMeta->save();
        }
    }

    // select personalized option for the post
    public static function selectPersonalizedOption($postId) {
        $meta = WpPostMeta::firstOrNew(['meta_key' => '_product_meta_id', 'post_id' => $postId]);
        $meta->meta_value = 1; // the id of Boulevard option predefined by Woocommerce addon plugin
        $meta->save();
    }

    public static function isMonogrammedProduct($prdAttr) {
        if (isset($prdAttr['monogramming'])) {
            return true;
        }
        return false;
    }

    public static function getFirstColorSlugFromAttr($attr) {
        if (isset($attr['color'])) {
            $prdColors = explode('|', $attr['color']['value']);
            $colors = WpTermTaxonomy::getColorSlugListFromNames($prdColors);
            if (!empty($colors)) {
                return $colors[0];
            } else {
                return '';
            }
        }
    }

    /*
     * save _product_attributes meta_key to use global color and monogram instead
     */

    public static function savePostAtrribute($attr, $prdAttr) {
        $data = [];
        if (isset($attr['color'])) {
            $data['pa_color'] = [
                'name' => 'pa_color',
                'value' => '',
                'position' => 0,
                'is_visible' => 1,
                'is_variation' => 1,
                'is_taxonomy' => 1
            ];
        }

        if (isset($attr['monogramming'])) {
            $data['pa_fonts'] = [
                'name' => 'pa_fonts',
                'value' => '',
                'position' => 1,
                'is_visible' => 1,
                'is_variation' => 1,
                'is_taxonomy' => 1
            ];
            $data['pa_text-color'] = [
                'name' => 'pa_text-color',
                'value' => '',
                'position' => 2,
                'is_visible' => 1,
                'is_variation' => 1,
                'is_taxonomy' => 1
            ];
        }

        if (!empty($data)) {
            $prdAttr->meta_value = serialize($data);
            $prdAttr->save();
        }
    }

    // Force product use global defined color instead of customized color
    public static function changeToGlobalColor($postId, $attr) {
        if (isset($attr['color']['value'])) {
            $prdColors = explode('|', $attr['color']['value']);
            $colors = WpTermTaxonomy::getColorSlugListFromNames($prdColors);

            // Assune that all colors above is already in golbal colors, now we only need to assign global color to the post
            // by adding records to wp_term_relationships table
            $globalColors = WpTermTaxonomy::getDbColorsFromList($colors);
            if (!$globalColors->isEmpty()) {
                // test find a global color assigned to product, if can't find them insert
                $testRelationship = WpTermRelationShip::where('object_id', '=', $postId)
                                ->where('term_taxonomy_id', $globalColors[0]->term_taxonomy_id)->first();

                if (!$testRelationship) {
                    $data = []; // prepare data to insert
                    foreach ($globalColors as $gColor) {
                        $data[] = [
                            'object_id' => $postId,
                            'term_taxonomy_id' => $gColor->term_taxonomy_id,
                            'term_order' => 0
                        ];
                    }
                    if (count($data)) {
                        WpTermRelationShip::insert($data);
                    }
                }
            }
        }
    }

    // assign all fonts to monogrammed product
    public static function changeToGlobalFont($postId, $attr, $globalFonts, $productFonts) {
        if (isset($attr['monogramming']) && !isset($attr['pa_fonts']) && count($globalFonts) > 0) {
            $data = []; // prepare data to insert
            if (!empty($productFonts[$postId])) {
                $firstProductFont = key($productFonts[$postId]);
                foreach ($productFonts[$postId] as $slug => $desc) {
                    if (isset($globalFonts[$slug])) {
                        $data[] = [
                            'object_id' => $postId,
                            'term_taxonomy_id' => $globalFonts[$slug]['term_taxonomy_id'],
                            'term_order' => 0
                        ];
                    }
                }
            }

            if (strlen($firstProductFont) > 0 && !empty($globalFonts[$firstProductFont])) {
                // test find a global font assigned to product, if can't find then insert
                $testRelationship = WpTermRelationShip::where('object_id', '=', $postId)
                        ->where('term_taxonomy_id', $globalFonts[$firstProductFont]['term_taxonomy_id'])
                        ->first();
            }

            if (count($data) && !$testRelationship) {
                WpTermRelationShip::insert($data);
            }
        }
    }

    public static function getProductsHaveVariations() {
        $products = DB::table('wp_posts as p1')
                        ->join('wp_posts as p2', 'p1.ID', '=', 'p2.post_parent')
                        ->select('p1.ID')->distinct()->get();
        return array_map(function($product) {
            return $product->ID;
        }, $products);
    }

// more exact one
    public static function getProductIdOfVariationMonogramnProducts() {
        $products_id_have_variations = self::getProductsHaveVariations();
        $product_attribute_have_variations = WpPostMeta::where('meta_key', '=', '_product_attributes')
                        ->whereIn('post_id', $products_id_have_variations)
                        ->get()->pluck('meta_value', 'post_id')->toArray();
        $result = [];
        foreach ($product_attribute_have_variations as $post_id => $meta_value) {
            $product_attribute = unserialize($meta_value);
            if (array_key_exists('pa_text-color', $product_attribute)) {
                $result[] = $post_id;
            }
        }
        return $result;
    }

    public static function addTextColorAttributeAndSwatch($data) {
        $globalTextColors = WpTermTaxonomy::getDbTextColors();
        foreach ($data as $post_id) {
                // to add color        
                WpPost::addTextColorToVariableProduct($post_id, $globalTextColors);

                // to add swatch color
                $swatchTypeOptionMeta = WpPostMeta::where('meta_key', '=', '_swatch_type_options')
                                ->where('post_id', '=', $post_id)->first();

                $array = unserialize($swatchTypeOptionMeta->meta_value);
                $array[md5(self::$TAXONOMY_TEXT_COLOR)] = self::getTextColorSwatch($globalTextColors);
                $swatchTypeOptionMeta->meta_value = serialize($array);
                $swatchTypeOptionMeta->save();
            
        }
    }

}
