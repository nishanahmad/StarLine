@extends('layouts.default')
@section('title', 'Closing Stock')
@section('content')
<script>
$(document).ready(function() {
		var pickerOpts = { dateFormat:"dd-mm-yy"}; 					
		$( "#datepicker" ).datepicker(pickerOpts);
	});	
	
function refresh()
{
	var datepicker = document.getElementById("datepicker").value;
	var item = document.getElementById("item").value;
	
	var hrf = window.location.href;
	
	hrf = hrf.slice(0,hrf.indexOf("closing"));
	
	window.location.href = hrf +"closing/"+ datepicker + "/" + item;
}		
</script>   
<div class="row mt">
	<div class="col-lg-12">
		<div class="content-panel">
			<h2 style="margin-left:30px;"><i class="fa fa-building"></i> Closing Stock</h2>
			<br/>
			<div class="col-sm-2 col-md-offset-3">
				<input type="text" name="date" value="{{date('d-m-Y',strtotime($date))}}" class="form-control" id="datepicker" onchange="return refresh();" autocomplete="off">
			</div>	
			<div class="col-sm-2">
				<select name="item" class="form-control" id="item" onchange="return refresh();">
					@foreach($items as $loop_item)
						@if($loop_item->id == $item)
							<option selected value="{{$loop_item->id}}">{{ $loop_item -> name}}</option>
						@else
							<option value="{{$loop_item->id}}">{{ $loop_item -> name}}</option>
						@endif
					@endforeach
				</select>
			</div>
			<br/><br/><br/><br/>
			<section>
				<table class="table table-bordered table-condensed col-md-offset-1" style="width:40%;">
					<thead class="cf">
						<tr>
							<th>Godwn</th>
							<th>Closing Stock</th>
						</tr>
					</thead>
					<tbody>
					<?php $total = 0;?>
					@foreach($godownQtyMap as $godown => $qty)
						<tr>
							<td>{{ $godown}}</td>
							<td>{{ $qty }}</td>
						</tr>
						<?php $total = $total + $qty;?>
					@endforeach	
					</tbody>
				</table>
			</section>
			<br/><br/>
			<section>
				<table class="table table-bordered table-condensed col-md-offset-1" style="width:40%;">
					<thead class="cf">
						<tr>
							<th>Physical Stock</th>
							<th>{{$total}}</th>
						</tr>					
					</thead>
					<tbody>
					@foreach($clientMap as $client => $qty)
						<tr>
							<td>{{ $client}}</td>
							<td>{{ $qty }}</td>
						</tr>
						<?php $total = $total + $qty;?>
					@endforeach	
					</tbody>
					<thead>
						<tr>
							<th>SAP Stock</th>
							<th>{{$total}}</th>
						</tr>										
					</thead>
				</table>
			</section>			
		</div>
	</div>
</div>
@stop