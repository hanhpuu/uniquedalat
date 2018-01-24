<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model {

    public static function getAllAgendas()
    {
	return [
	    [
		'name' => 'Dấu chân đầu tiên',
		'data' => [
		    [
			'name' => 'Làng cù lần',
			'lat' => 12.028467,
			'lng' => 108.367633,
			'hour' => 2
		    ],
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
		    ]
		]
	    ],
	    [
		'name' => 'Ngoại ô Đà Lạt',
		'data' => [
		    [
			'name' => 'Làng Hoa Vạn Thành',
			'lat' => 11.945704,
			'lng' => 108.418235,
			'hour' => 0.5
		    ],
		    [
			'name' => 'Hoa Sơn Điền Trang',
			'lat' => 11.934284,
			'lng' => 108.372573,
			'hour' => 1.5
		    ],
		    [
			'name' => 'Mê Linh Garden Coffee',
			'lat' => 11.899012,
			'lng' => 108.352832,
			'hour' => 2
		    ],
		    [
			'name' => 'Khu Du Lịch Thác Voi',
			'lat' => 11.824926,
			'lng' => 108.321761,
			'hour' => 2
		    ]
		]
	    ],
	    [
		'name' => 'Vùng chè và Cà phê',
		'data' => [
		    [
			'name' => 'Hầm rượu vang',
			'lat' => 11.942855,
			'lng' => 108.429335,
			'hour' => 0.5
		    ],
		    [
			'name' => 'Nhà máy trà và vườn Atiso',
			'lat' => 11.955955,
			'lng' => 108.477057,
			'hour' => 1.5
		    ],
		    [
			'name' => 'Cánh đồng hoa Cẩm tú cầu',
			'lat' => 11.947222,
			'lng' => 108.518771,
			'hour' => 1
		    ],
		    [
			'name' => 'Cầu đất Farm: trà & cafe',
			'lat' => 11.884908,
			'lng' => 108.569754,
			'hour' => 2
		    ]
		]
	    ]
	];
    }

}
