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
	<div class="content-form-page" >
	    <div class="row">
            Lịch trình du lịch bạn đã chọn: <br/><br/> 
	    </div>
	    @foreach($datePartsPlaned as $key => $value)
	    <?php $newValue = json_decode($value);
	    $date= explode(" ",$key);
	    if ($date[1] == 0) {
		$date[1] = "Buổi sáng";
	    } elseif($date[1] == 1) {
		$date[1] = "Buổi chiều";
	    } else {
		$date[1] = "Buổi tối";
	    }
	    echo "<b>Ngày  $date[0] $date[1]</b> <br/>"; 
	    foreach($newValue as $lock) {
	    echo $lock->name.'<br/>' ;}
	    ?> 
	    @endforeach
	    <div class="row">
            <br/>
		Cám ơn bạn đã tạo lịch trình du lịch Đà Lạt với chúng tôi
	    </div>
	</div>
	
    </div>
    <!-- END CONTENT -->
</div>
<!-- END SIDEBAR & CONTENT -->
@endsection


@section('js')
@endsection

@section('css')

@endsection