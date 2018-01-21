<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class DemoController extends Controller
{

    public function index(Request $request)
    {
		if($request->isMethod('post')) {
			$today = date('Y-m-d');
			$startDate = $request->input('start_date', $today);
			$endDate = $request->input('end_date', $today);
		}
        return view('front.demo.index');
    }

}
