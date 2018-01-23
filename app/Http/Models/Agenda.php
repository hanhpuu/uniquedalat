<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{

	public static function getAllAgendas()
	{
		return [
			[
				'name' => 'Dâu chân đầu tiên',
				'data' => [
						[
						'name' => 'Xã Lát',
						'lat' => 12.113155,
						'lng' => 108.411023,
						'hour' => 1
					],
						[
						'name' => 'Langbiang',
						'lat' => 12.095916,
						'lng' => 108.413252,
						'hour' => 2
					],
						[
						'name' => 'Ma rừng lữ quán',
						'lat' => 12.011218,
						'lng' => 108.347851,
						'hour' => 1
					],
						[
						'name' => 'Làng cù lần',
						'lat' => 12.028467,
						'lng' => 108.367633,
						'hour' => 2
					]
				]
			],
			[
				'name' => 'Ngoại ô Đà Lạt',
				'data' => [
						[
						'name' => 'Thác Voi',
						'lat' => 11.823414,
						'lng' => 108.335087,
						'hour' => 1
					],
						[
						'name' => 'Chùa Linh Ấn Tự',
						'lat' => 11.824717,
						'lng' => 108.334160,
						'hour' => 2
					],
						[
						'name' => 'Trại nuôi dế',
						'lat' => 11.882753,
						'lng' => 108.335689,
						'hour' => 1
					],
						[
						'name' => 'Dệt lụa tơ tằm',
						'lat' => 11.824341,
						'lng' => 108.339325,
						'hour' => 2
					]
				]
			]
		];
	}

}
