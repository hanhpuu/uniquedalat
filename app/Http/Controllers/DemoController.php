<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Carbon\Carbon;
use App\Http\Constant\Common as CommonConst;

class DemoController extends Controller {

    public function index(Request $request)
    {
	if ($request->isMethod('POST')) {

	    $today = date('d-m-Y');
	    $startDate = $request->input('start_date', $today);
	    $endDate = $request->input('end_date', $today);

	    $start = Carbon::createFromFormat('d-m-Y', $startDate);
	    $end = Carbon::createFromFormat('d-m-Y', $endDate);

	    $dateParts = [];
	    while ($end->gte($start)) {
		$dateParts[$start->format('d-m-Y')] = [CommonConst::MORNING, CommonConst::AFTERNOON, CommonConst::EVENING];
		$start->addDay();
	    }

	    Session::put('date_parts', $dateParts);
	    return redirect()->route('dayPart');
	}


	return view('front.demo.index');
    }

    public function dayPart(Request $request)
    {
	if ($request->isMethod('POST')) {
	    $array = $request->all();
	    $dateParts = [];
	    foreach ($array as $key => $value) {
		$arrayDate = explode(" ", $value);
		if (\DateTime::createFromFormat('d-m-Y', $arrayDate[0]) !== FALSE) {
		    if ($arrayDate[1] = CommonConst::MORNING || CommonConst::AFTERNOON || CommonConst::AFTERNOON) {
			$dateParts[] = $value;
		    }
		}
	    }
	    Session::put('date_parts_join', $dateParts);
	    return redirect()->route('date_parts_join');
	}
	$dateParts = Session::get('date_parts');
	return view('front.demo.dayParts', ['dateParts' => $dateParts]);
    }

    public function chooseRoute(Request $request)
    {
	$dateParts = Session::put('date_parts_join', $dateParts);
	return view('front.demo.chooseRoute', ['dateParts' => $dateParts]);
    }
}
