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
				<div class="portlet box red">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-gift"></i>Lịch trình 
						</div>
						<ul class="nav nav-tabs">
						@foreach($agendas as $agendaName => $agenda)
							<?php
								$i = array_search($agendaName,array_keys($agendas));
							?>
							@if(!$i)
							<li class="active">
							@else
							<li>
							@endif						
								<a href="#portlet_tab_{{$i}}" data-toggle="tab" aria-expanded="true">{{$agendaName}}</a>
							</li>
							
						@endforeach
						</ul>
							
						
					</div>
					<div class="portlet-body">
						<div class="tab-content">
							@foreach($agendas as $agendaName => $agenda)
								<?php
									$i = array_search($agendaName,array_keys($agendas));
								?>
								<div class="tab-pane" id="portlet_tab_{{$i}}">
									<p> Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit
										praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet
										dolore magna aliquam erat volutpat.ut laoreet dolore magna ut laoreet dolore magna. ut laoreet dolore magna. ut laoreet dolore magna. </p>
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
