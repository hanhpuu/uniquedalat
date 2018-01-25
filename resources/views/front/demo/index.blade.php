@extends('layouts.app')

@section('content')
<!-- BEGIN SIDEBAR & CONTENT -->
<div class="row margin-bottom-40">

    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12">
	<div class="content-form-page">
	    <div class="row">
                <div class="col-md-12 col-sm-12 pull-left">
		    <form class="form-horizontal form-without-legend form-plan" role="form" method="post" action="/" >
			<div class="form-group">
			    <label for="email" class="col-lg-2 control-label">Ngày đến<span class="require">*</span></label>
			    <div class="col-lg-10">
				<input type="text" class="form-control form-control-inline input-small date-picker" name="start_date" data-date-format="dd-mm-yyyy" data-date-viewmode="years" />
			    </div>
			</div>
			<div class="form-group">
			    <label for="password" class="col-lg-2 control-label">Ngày đi <span class="require">*</span></label>
			    <div class="col-lg-10">
				<input type="text" class="form-control form-control-inline input-small date-picker" name="end_date" data-date-format="dd-mm-yyyy" data-date-viewmode="years" />
			    </div>
			</div>
			<div class="form-group">
			    <div class="col-lg-10 col-lg-offset-2 padding-left-0">
				<div id="map" style="height:500px;width: 100%;"></div>
			    </div>

			</div>
			<div class="row">
			    <div class="col-lg-10 col-md-offset-2 padding-left-0 padding-top-20">
				<button type="submit" class="btn btn-primary">Xem lịch trình</button>
			    </div>
			</div>

			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<input type='hidden' name='lat' id='lat'>
			<input type='hidden' name='lng' id='lng'>
		    </form>
                </div>

	    </div>
	</div>
	<div>
	    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
	    <div id="map"></div>
	</div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END SIDEBAR & CONTENT -->
@endsection


@section('js')
<script type="text/javascript" src="/js/demo/demo.js"></script>
<script type="text/javascript" src="/js/demo/searchMap.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEqDMXEY3pAjm_G5utfzA2ukLvJk-1I7Q&libraries=places&callback=initAutocomplete"
async defer></script>
@endsection

@section('css')
<link rel="stylesheet" href="/css/searchMap.css" />

@endsection