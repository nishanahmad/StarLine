@extends('layouts.default')
@section('title', 'Day Book')
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
	
	hrf = hrf.slice(0,hrf.indexOf("daybook"));
	
	window.location.href = hrf +"daybook/"+ datepicker + "/" + item;
}		
</script>   
<section class="wrapper">
	<h3><i class="fa fa-book"></i> Day Book</h3>
	<div class="col-sm-2 col-md-offset-3">
		<input type="text" name="date" value="{{date('d-m-Y',strtotime($date))}}" class="form-control" id="datepicker" onchange="return refresh();" autocomplete="off">
	</div>	
	<div class="col-sm-2">
		<select name="item" class="form-control" id="item" onchange="return refresh();">
			<option value="All">All</option>
			@foreach($items as $loop_item)
				@if($loop_item->id == $item)
					<option selected value="{{$loop_item->id}}">{{ $loop_item -> name}}</option>
				@else
					<option value="{{$loop_item->id}}">{{ $loop_item -> name}}</option>
				@endif
			@endforeach
		</select>
	</div>

	<br/><br/>

	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel">
			<h4><i class="fa fa-file-text"></i> Slips</h4>
			<section id="unseen">
				<table class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>SlipNo.</th>
							<th>Client</th>
							<th>Item</th>
							<th>Quantity</th>
							<th>Godown</th>
						</tr>
					</thead>
					<tbody>
						@foreach($slips as $slip)
						<tr>
							<td>{{$slip->number}}</td>
							<td>{{$slip->order->client->name}}</td>
							<td>{{$slip->order->item->name}}</td>
							<td>{{$slip->qty}}</td>
							<td>{{$slip->godown->name}}</td>							
						</tr>
						@endforeach
					</tbody>
				</table>
			</section>
			</div>
		</div>
	</div>
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel">
			<h4><i class="fa fa-truck"></i> Purchases</h4>
			<section id="unseen">
				<table class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>DeliveryNo.</th>
							<th>SlipNo.</th>
							<th>Item</th>							
							<th>Quantity</th>
							<th>Godown</th>
						</tr>
					</thead>
					<tbody>
						@foreach($purchases as $purchase)
						<tr>
							<td>{{$purchase->number}}</td>
							<td>{{$purchase->slip_number}}</td>
							<td>{{$purchase->item->name}}</td>
							<td>{{$purchase->qty}}</td>
							<td>{{$purchase->godown->name}}</td>							
						</tr>
						@endforeach
					</tbody>
				</table>
			</section>
			</div>
		</div>
	</div>	
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel">
				<h4><i class="fa fa-inr"></i> Invoices</h4>
				<section id="no-more-tables">
					<table class="table table-bordered table-condensed cf">
						<thead class="cf">
							<tr>
								<th>InvNo.</th>
								<th>Client</th>
								<th>Item</th>
								<th>Quantity</th>
							</tr>
						</thead>
						<tbody>
							@foreach($invoices as $invoice)
							<tr>
								<td>{{$invoice->number}}</td>
								<td>{{$invoice->order->client->name}}</td>
								<td>{{$invoice->order->item->name}}</td>
								<td>{{$invoice->qty}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</section>
			</div>
		</div>
	</div>
</section>
@stop