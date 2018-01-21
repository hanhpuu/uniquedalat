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
					'lat' => 11,
					'lon' => 12
				],
					[
					'name' => 'Chùa Linh Ứng',
					'lat' => 11,
					'lon' => 12
				],
					[
					'name' => 'Trại nuôi dế',
					'lat' => 11,
					'lon' => 12
				],
					[
					'name' => 'Dệt lụa tơ tằm',
					'lat' => 11,
					'lon' => 12
				],
			],
			'Dâu chân đầu tiên' => [
					[
					'name' => 'Xã Lát',
					'lat' => 11,
					'lon' => 12
				],
					[
					'name' => 'Langbiang',
					'lat' => 11,
					'lon' => 12
				],
					[
					'name' => 'Ma rừng lữ quán',
					'lat' => 11,
					'lon' => 12
				],
					[
					'name' => 'Làng cù lần',
					'lat' => 11,
					'lon' => 12
				],
			],
			'Đà Lạt thân quen' => [
					[
					'name' => 'Rừng hoa Đà Lạt',
					'lat' => 11,
					'lon' => 12
				],
					[
					'name' => 'Thung lũng tình yêu',
					'lat' => 11,
					'lon' => 12
				],
					[
					'name' => 'XQ Sử Quán',
					'lat' => 11,
					'lon' => 12
				],
					[
					'name' => 'Đồi Mộng Mơ',
					'lat' => 11,
					'lon' => 12
				],
			]
		];
	}

}
