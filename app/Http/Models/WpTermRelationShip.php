<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;


class WpTermRelationShip extends Model
{
	protected $table = 'wp_term_relationships';
	
	
	public static function addRelationship($data)
	{
		$record = new WpTermRelationShip();
		$record->object_id = $data['object_id'];
		$record->term_taxonomy_id = $data['term_taxonomy_id'];
		$record->term_order = $data['term_order'];
		$record->save();
		return $record;
	}
}
