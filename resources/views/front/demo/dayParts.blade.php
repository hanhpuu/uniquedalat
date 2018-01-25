<?php

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
                <div class="col-md-12 col-sm-12 pull-left">
					<form class="form-horizontal form-without-legend" role="form" method="post">
						<div class="checkbox-list">
							@foreach ($dateParts as $date => $datePart)
							<label><input type="checkbox" name="{{$date. ' '. CommonConst::MORNING}}" value="{{$date. ' '. CommonConst::MORNING}}"> Buổi sáng ngày {{ $date }} </label>
							<label><input type="checkbox" name="{{$date. ' '. CommonConst::AFTERNOON}}" value="{{$date. ' '. CommonConst::AFTERNOON}}"> Buổi chiều ngày {{ $date }}</label>
							<label><input type="checkbox" name="{{$date. ' '. CommonConst::EVENING}}" value="{{$date. ' '. CommonConst::EVENING}}"> Buổi tối ngày {{ $date }} </label>
							@endforeach
						</div>
						<div>
							<div class="padding-top-20">
								<button type="submit" name="submit" class="btn btn-primary">Xem lịch trình</button>
							</div>
						</div>
						<input type="hidden" name="_token" value="{{csrf_token()}}">

					</form>
				</div>

			</div>
		</div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END SIDEBAR & CONTENT -->
@endsection