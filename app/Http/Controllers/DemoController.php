<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Carbon\Carbon;
use App\Http\Constant\Common as CommonConst;
use App\Http\Models\Agenda;

class DemoController extends Controller
{

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
			
			$lat = $request->input('lat');
			$lng = $request->input('lng');
			$location = array('lat' => $lat, 'lng' => $lng);
			Session::put('location', $location);
			
			return redirect()->route('dayPart');
			
		}


		return view('front.demo.index');
	}

	public function dayPart(Request $request)
	{
		if ($request->isMethod('POST')) {
		    Session::forget('date_parts_planned');
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
		$dateParts = Session::get('date_parts_join');
		if($request->isMethod('POST')) {	    
			// update session that contain period need to be worked on
			$datePart = $request->input('date_part');
			$datePartIndex = array_search($datePart, $dateParts);
			unset($dateParts[$datePartIndex]);
			$dateParts = array_values($dateParts);
			Session::put('date_parts_join', $dateParts);
			
			// update session that contain period planed
			$datePartsPlaned = Session::get('date_parts_planned');
			$datePartsPlaned[$datePart] = $request->input('routes');
			Session::put('date_parts_planned', $datePartsPlaned);		
		}
		
		$agendas = Agenda::getAllAgendas();
		$location = $request->session()->get('location');
		
		if(count($dateParts)) {
			
			$currentDateParts = explode(' ', $dateParts[0]);
			$currentDate = $currentDateParts[0];
			$currentPeriod = $currentDateParts[1];
		} else {
			return redirect()->route('result');
		}
		
		return view('front.demo.chooseRoute', [
					'agendas' => $agendas, 
					'agenda_json' => json_encode($agendas), 
					'location' => $location,
					'current_date' => $currentDate,
					'current_period' => $currentPeriod
		]);
		
	}
	
	public function finalData(Request $request)
	{
	    
	    $lat = $request->input('lat');
		$lng = $request->input('lng');
		$location = array('lat' => $lat, 'lng' => $lng);
		Session::put('location', $location);

		return redirect()->route('dayPart');
	}
	
	public function result()
	{
		$datePartsPlaned = Session::get('date_parts_planned');
		return view('front.demo.result', ['datePartsPlaned' => $datePartsPlaned]); 
	}
}
