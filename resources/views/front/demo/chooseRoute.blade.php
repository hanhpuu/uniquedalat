<?php

//

use App\Http\Constant\Common as CommonConst;
?>
@extends('layouts.app')

@section('content')
<ul class="breadcrumb">
    <li><a href="index.html">Home</a></li>
    <li><a href="#">Pages</a></li>
    <li class="active">Login</li>
</ul>
<!-- BEGIN SIDEBAR & CONTENT -->
<div class="row margin-bottom-40">
    <!-- BEGIN SIDEBAR -->
    <div class="sidebar col-md-3 col-sm-3">
	<div class="margin-bottom-10"><button type="button" class="btn green">Green</button></div>
	<div class="margin-bottom-10"><button type="button" class="btn green">Green</button></div>
	<div class="margin-bottom-10"><button type="button" class="btn green">Green</button></div>
    </div>
    <!-- END SIDEBAR -->

    <!-- BEGIN CONTENT -->
    <div class="col-md-9 col-sm-9">
	<div class="content-form-page">
	    <div class="row">
		<div class="portlet box red">
		    <div class="portlet-title">
			<div class="caption">
			    <i class="fa fa-gift"></i>Lịch trình 
			</div>
			<ul class="nav nav-tabs ul-map">
			    @foreach($agendas as $i => $agenda)	    
			    @if(!$i)
			    <li class="active">
				@else
			    <li>
				@endif						
				<a href="#portlet_tab_{{$i}}" data-toggle="tab" aria-expanded="true" data-index="{{$i}}">
				    {{$agenda['name']}}
				</a>
			    </li>

			    @endforeach
			</ul>


		    </div>
		    <div class="portlet-body">
			<div class="tab-content">
			    @foreach($agendas as $i => $agenda)    
			    @if(!$i)
			    <div class="tab-pane active" id="portlet_tab_{{$i}}">
				<div>
				    <ul><b>Tổng quãng đường dự kiến:</b> 89.0 km</ul>
				    <ul><b>Tổng thời gian dự kiến:</b> 4 giờ 8 phút </ul>
				</div>
				@else

				<div class="tab-pane" id="portlet_tab_{{$i}}">
				    @endif
				    @if($i==1)
				    <div>
					<ul><b>Tổng quãng đường dự kiến:</b> 55.5 km</ul>
					<ul><b>Tổng thời gian dự kiến:</b> 1 giờ 43 phút </ul>
				    </div>
				    @elseif($i==2)
				    <div>
					<ul><b>Tổng quãng đường dự kiến:</b> 58.1 km </ul>
					<ul><b>Tổng thời gian dự kiến:</b> 1 giờ 55 phút </ul>
				    </div>
				    @endif	   
	 <!--<div> <input type='checkbox' name='Agenda[{{$agenda['name']}}]' class='agenda'> </div>-->

				    <div id="map_{{$i}}" class="map"></div>	
				</div>
				@endforeach
			    </div>
			    <div class="col-lg-10 col-md-offset-2 padding-left-0 padding-top-20">

				<form method="POST">
				    <input type='hidden' name='_token' value="{{csrf_token()}}">
				    <input type='hidden' name='routes' id='routes'>
				    <button type="submit" value="Xem lịch trình" class="btn btn-primary">Xem lịch trình</button>
				</form>
			    </div>
			</div>
		    </div>

		</div>
	    </div>
	</div>
	<!-- END CONTENT -->
    </div>
    <!-- END SIDEBAR & CONTENT -->
    @endsection

    @section('js')
    <!--<script src="https://maps.googleapis.com/maps/api/js"></script>-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEqDMXEY3pAjm_G5utfzA2ukLvJk-1I7Q"></script>
    <script>
var locations = '';
var myJSON = JSON.parse('{!! $agenda_json !!}');
var lat = {{$location['lat']}};
var lng = {{$location['lng']}};
$(document).ready(function(){
$("form").submit(function(){
var index = $('.ul-map').find('.active').find('a').attr('data-index');
var data = myJSON[index]['data'];
var stringData = JSON.stringify(data);
document.getElementById("routes").value = stringData;
});
});
    </script>
    <script type="text/javascript" src="/js/demo/gmap.js"></script>
    <script type="text/javascript" src="/js/demo/chooseRoute.js"></script>
    @endsection

    @section('css')
    <link rel="stylesheet" href="/css/searchMap.css" />

    @endsection