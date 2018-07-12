<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\WpPostMeta;
use App\Http\Models\WpTerm;
use DB;

class WpTermTaxonomy extends Model
{
	protected $table = 'wp_term_taxonomy';
	public $timestamps = false;
	protected $primaryKey = 'term_taxonomy_id';

	
	static $TAXONOMY_COLOR = 'pa_color';
	static $TAXONOMY_FONT = 'pa_fonts';
	static $TAXONOMY_TEXT_COLOR = 'pa_text-color';
	
	public static function createTermAndTermTaxonomy($taxonomy, $termData)
	{
		DB::transaction(function () use ($taxonomy, $termData) {
			$term = new WpTerm();
			$term->name = $termData['name'];
			$term->slug = $termData['slug'];
			$term->term_group = 0;
			$term->save();

			$termTaxonomy = new WpTermTaxonomy();
			$termTaxonomy->term_id = $term->term_id;
			$termTaxonomy->taxonomy = $taxonomy;
			$termTaxonomy->description = '';
			$termTaxonomy->parent = 0;
			$termTaxonomy->count = 0;
			$termTaxonomy->save();
		});
		
	}
	
	public static function getDbColorsFromList($colors) 
	{
		return self::join('wp_terms', 'wp_term_taxonomy.term_id', '=', 'wp_terms.term_id')
					->where('wp_term_taxonomy.taxonomy', '=', self::$TAXONOMY_COLOR)
					->whereIn('wp_terms.slug', $colors)->get();
	}
	
	public static function getDbFonts()
	{
		return self::join('wp_terms', 'wp_term_taxonomy.term_id', '=', 'wp_terms.term_id')
					->where('wp_term_taxonomy.taxonomy', '=', self::$TAXONOMY_FONT)
					->get();
	}
	
	public static function getDbTextColors()
	{
		return self::join('wp_terms', 'wp_term_taxonomy.term_id', '=', 'wp_terms.term_id')
					->where('wp_term_taxonomy.taxonomy', '=', self::$TAXONOMY_TEXT_COLOR)
					->get();
	}

	// search throught all products and add color to global color
	// only add color if not exist
	public static function addProductColors()
	{
		$productAttributes = WpPostMeta::where('meta_key', '=', '_product_attributes')->get();
		
		$colors = [];
		foreach ($productAttributes as $attr) {
			$attr = unserialize($attr->meta_value);
			if(isset($attr['color']['value'])) {
				$attrs = explode('|', $attr['color']['value']);
				
				foreach ($attrs as $newAttribute) {
					$color = self::getColorName($newAttribute);
					// Capitalize -> lowercase (attribute name -> attribute slug)
					$colors[$color] = self::getColorSlug($newAttribute);
				}
			}
		}
		
		// now we have list of colors
		$dbColors = self::getDbColorsFromList($colors)->pluck('slug')->toArray();
		$colorsNotInDb = array_diff($colors, $dbColors);
		foreach ($colorsNotInDb as $name => $slug) {
			self::createTermAndTermTaxonomy(self::$TAXONOMY_COLOR, [
				'name' => $name,
				'slug' => $slug
			]);
		}
	}
	
	public static function getColorName($name)
	{
		return trim($name);
	}
	
	public static function getColorSlug($name)
	{
		return str_replace([' ', '/', '-'], '_', strtolower(trim($name)));
	}
	
	public static function getColorSlugListFromNames($colors)
	{
		$result = [];
		foreach ($colors as $color) {
			$result[] = self::getColorSlug($color);
		}
		return $result;
	}
}
