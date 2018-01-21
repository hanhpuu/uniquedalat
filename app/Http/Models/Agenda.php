<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{

	public static function getAllAgendas()
	{
		return [
			'Ngoại ô Đà Lạt' => [
					[
					'name' => 'Thác Voi',
					'lat' => 11.823414,
					'lon' => 108.335087,
					'hour' => 2,   
				],
					[
					'name' => 'Chùa Linh Ấn Tự',
					'lat' => 11.824717,
					'lon' => 108.334160,
					'hour' => 1,   
				],
					[
					'name' => 'Trại nuôi dế',
					'lat' => 11.882753,
					'lon' => 108.355689,
					'hour' => 0.5,
				],
					[
					'name' => 'Dệt lụa tơ tằm',
					'lat' => 11.824341,
					'lon' => 108.339325,
					 'hour' => 1
					    
				],
			],
			'Dâu chân đầu tiên' => [
					[
					'name' => 'Xã Lát',
					'lat' => 12.113155, 
					'lon' => 108.411023,
					'hour' => 1
				],
					[
					'name' => 'Langbiang',
					'lat' => 12.095916,
					'lon' => 108.413252,
					 'hour' => 2
				],
					[
					'name' => 'Ma rừng lữ quán',
					'lat' => 12.011218,
					'lon' => 108.347851,
					 'hour' => 1
				],
					[
					'name' => 'Làng cù lần',
					'lat' => 12.028467,
					'lon' => 108.367633,
					 'hour' => 2
				],
			],
			'Đà Lạt thân quen' => [
					[
					'name' => 'Rừng hoa Đà Lạt',
					'lat' => 11.981861,
					'lon' => 108.453775,
					'hour' => 1
				],
					[
					'name' => 'Thung lũng tình yêu',
					'lat' => 11.978093,
					'lon' => 108.450331,
					'hour' => 1
				],
					[
					'name' => 'XQ Sử Quán',
					'lat' => 11.977254,
					'lon' => 108.448239,
					'hour' => 1
				],
					[
					'name' => 'Đồi Mộng Mơ',
					'lat' => 11.977988,
					'lon' => 108.445610,
					'hour' => 1.5
				],
			]
		];
	}

}
