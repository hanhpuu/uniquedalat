@extends('layouts.app')

@section('content')
<!-- BEGIN SIDEBAR & CONTENT -->
<div class="row margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-9 col-sm-9">
	<div class="content-form-page" >
	    <div class="row">
		<b>Thông tin chi tiết về địa điểm bạn chọn: </b><br/><br/> 
	    </div>
	    @foreach($agendas as $value1)
	    <?php 
		foreach($value1['data'] as $value2){
		echo '<pre>';
		print_r($value2['name']);
		echo '</pre>';
		
		    }
		    
		    
		
		?>
	     
	    @endforeach
	    die;
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