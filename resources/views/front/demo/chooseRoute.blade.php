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
			<ul class="nav nav-tabs">
			    @foreach($agendas as $i => $agenda)	    
			    @if(!$i)
			    <li class="active">
				@else
			    <li>
				@endif						
				<a href="#portlet_tab_{{$i}}" data-toggle="tab" aria-expanded="true" class="tab-map" data-index="{{$i}}">
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
			    @else
				<div class="tab-pane" id="portlet_tab_{{$i}}">
			    @endif
				    <div> <input type='checkbox' name='Agenda[{{$agenda['name']}}]' class='agenda'> </div>

				    <div id="map_{{$i}}" class="map"></div>	
				</div>
			    @endforeach
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
    
    </script>
    <script type="text/javascript" src="/js/demo/chooseRoute.js"></script>

    @endsection

    @section('css')
    <link rel="stylesheet" href="/css/searchMap.css" />

    @endsection