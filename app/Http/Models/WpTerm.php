<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class WpTerm extends Model
{
	protected $table = 'wp_terms';
	public $timestamps = false;
	protected $primaryKey = 'term_id';
}
