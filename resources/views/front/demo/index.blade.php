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
					<form class="form-horizontal form-without-legend" role="form">
						<div class="form-group">
							<label for="email" class="col-lg-2 control-label">Ngày đến<span class="require">*</span></label>
							<div class="col-lg-10">
								<input type="text" class="form-control form-control-inline input-small date-picker" name="date_from" data-date-format="dd-mm-yyyy" data-date-viewmode="years" />
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="col-lg-2 control-label">Ngày đi <span class="require">*</span></label>
							<div class="col-lg-10">
								<input type="text" class="form-control form-control-inline input-small date-picker" name="date_from" data-date-format="dd-mm-yyyy" data-date-viewmode="years" />
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-10 col-md-offset-2 padding-left-0 padding-top-20">
								<button type="submit" class="btn btn-primary">Xem lịch trình</button>
							</div>
						</div>
						
					</form>
                </div>
               
			</div>
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END SIDEBAR & CONTENT -->
@endsection
