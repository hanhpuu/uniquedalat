<?php

//

use App\Http\Constant\Common as CommonConst;
?>
@extends('layouts.app')

@section('content')
<!-- BEGIN SIDEBAR & CONTENT -->
<div class="row margin-bottom-40">
    <!-- END SIDEBAR -->

    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12">
		<div class="content-form-page">
			<div class="row">
				<?php
				if ($current_period == CommonConst::MORNING) {
					$current_period_text = 'buổi sáng';
				} else if ($current_period == CommonConst::AFTERNOON) {
					$current_period_text = 'buổi trưa';
				} else {
					$current_period_text = 'buổi tối';
				}
				?>
				<h3>Chọn lịch trình cho ngày {{$current_date}} {{$current_period_text}}</h3>
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
									<ul><b>Tổng thời gian dự kiến:</b> 10 giờ  </ul>
								</div>
								<div id="map_{{$i}}" class="map"></div>
							</div>
							@else
							<div class="tab-pane" id="portlet_tab_{{$i}}">
								@if($i==1)
									<div>
										<ul><b>Tổng quãng đường dự kiến:</b> 55.5 km</ul>
										<ul><b>Tổng thời gian dự kiến:</b> 8 giờ </ul>
									</div>
								@elseif($i==2)
									<div>
										<ul><b>Tổng quãng đường dự kiến:</b> 58.1 km </ul>
										<ul><b>Tổng thời gian dự kiến:</b> 7 giờ </ul>
									</div>
								@endif
								<div id="map_{{$i}}" class="map"></div>
							</div>
							@endif
							@endforeach		
						</div>	
					</div>					
					<!-- END CONTENT -->
				</div>
				<form method="POST">
						<input type='hidden' name='_token' value="{{csrf_token()}}">
						<input type="hidden" name="date_part" value="{{$current_date. ' '. $current_period}}">
						<input type='hidden' name='routes' id='routes'>
						<button type="submit" class="btn btn-primary">Chọn lịch trình</button>
				</form>
			</div>
		</div>
	</div>
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