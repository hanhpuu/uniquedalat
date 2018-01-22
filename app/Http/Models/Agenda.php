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
					'Thác Voi',
					11.823414,
					108.335087,
					2,   
				],
					[
					'Chùa Linh Ấn Tự',
					11.824717,
					108.334160,
					1.5,   
				],
					[
					'Trại nuôi dế',
					11.882753,
					108.355689,
					0.5,
				],
					[
					'Dệt lụa tơ tằm',
					11.824341,
					108.339325,
					1
					    
				],
			],
			'Dâu chân đầu tiên' => [
					[
					 'Xã Lát',
					 12.113155, 
					 108.411023,
					 1
				],
					[
					 'Langbiang',
					 12.095916,
					 108.413252,
					 2
				],
					[
					 'Ma rừng lữ quán',
					 12.011218,
					 108.347851,
					 1
				],
					[
					 'Làng cù lần',
					 12.028467,
					 108.367633,
					 2
				],
			],
			'Đà Lạt thân quen' => [
					[
					'Rừng hoa Đà Lạt',
					11.981861,
					108.453775,
					1
				],
					[
					'Thung lũng tình yêu',
					11.978093,
					108.450331,
					1
				],
					[
					'XQ Sử Quán',
					11.977254,
					108.448239,
					1
				],
					[
					'Đồi Mộng Mơ',
					11.977988,
					108.445610,
					1.5
				],
			]
		];
	}

}
