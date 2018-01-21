@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>
		<div>
		    <h2 style="margin: 10px">Total estimated time: <span id="hours"></span></h2>
		    <h2>Total distance: <strong id="km"></strong></h2>
		</div>
		<div> <button type="button" style="margin: 10px;" id="choose" > Choose location </button> </div>
		<div> <button type="button" style="margin: 10px;" id="del" > Delete the hated one </button> </div>
		<div> <button type="button" style="margin: 10px;" id="add" > Add the deleted location </button> </div>
                <div class="panel-body">
		    <div id="gmap-route" style="with:300px;height:400px;" ></div>
		    <div id="route"> </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
