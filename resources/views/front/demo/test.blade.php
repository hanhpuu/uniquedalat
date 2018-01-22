<?php

//

use App\Http\Constant\Common as CommonConst;
?>
@extends('layouts.app')


@foreach($agendas as $agendaName => $agenda)
<?php
$i = array_search($agendaName, array_keys($agendas));
?>
@if(!$i)
<div class="tab-pane active" id="portlet_tab_{{$i}}">
    @else
    <div class="tab-pane" id="portlet_tab_{{$i}}">
	@endif
	<div> <input type='checkbox' name='Agenda[{{$agendaName}}]' class='agenda'> </div>

	<div id="map[{{$agendaName}}]" class="map"></div>	
    </div>
    @endforeach




    @section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEqDMXEY3pAjm_G5utfzA2ukLvJk-1I7Q"></script>
    <script>
var locations = '';
var myJSON = JSON.parse('{"Ngo\u1ea1i \u00f4 \u0110\u00e0 L\u1ea1t":[["Th\u00e1c Voi",11.823414,108.335087,2],["Ch\u00f9a Linh \u1ea4n T\u1ef1",11.824717,108.33416,1.5],["Tr\u1ea1i nu\u00f4i d\u1ebf",11.882753,108.355689,0.5],["D\u1ec7t l\u1ee5a t\u01a1 t\u1eb1m",11.824341,108.339325,1]],"D\u00e2u ch\u00e2n \u0111\u1ea7u ti\u00ean":[["X\u00e3 L\u00e1t",12.113155,108.411023,1],["Langbiang",12.095916,108.413252,2],["Ma r\u1eebng l\u1eef qu\u00e1n",12.011218,108.347851,1],["L\u00e0ng c\u00f9 l\u1ea7n",12.028467,108.367633,2]],"\u0110\u00e0 L\u1ea1t th\u00e2n quen":[["R\u1eebng hoa \u0110\u00e0 L\u1ea1t",11.981861,108.453775,1],["Thung l\u0169ng t\u00ecnh y\u00eau",11.978093,108.450331,1],["XQ S\u1eed Qu\u00e1n",11.977254,108.448239,1],["\u0110\u1ed3i M\u1ed9ng M\u01a1",11.977988,108.44561,1.5]]}');

    </script>
    <script type="text/javascript" src="/js/demo/chooseRoute.js"></script>
    @endsection

    @section('css')
    <link rel="stylesheet" href="/css/searchMap.css" />

    @endsection    