<?php

use App\Http\Constant\Common as CommonConst;
?>
@extends('layouts.app')

@section('content')
<!-- BEGIN SIDEBAR & CONTENT -->
<div class="row margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12">
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