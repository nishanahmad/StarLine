@extends('layouts.default')
@section('title', 'Orders')
@section('content')
<style>
.dataTables_length{
  display:none;
}
.dataTables_paginate{
  display:none;
}
</style>
@if (session('success'))
<script>	
	BootstrapAlert.success({
		title: "Success!",
		message: '{{ session("success") }}'
	});
</script>
@endif
<div class="row content-panel">
	<div class="col-md-12">
		<h2 style="margin-left:30px;"><i class="fa fa-credit-card"></i> <a href="/orders" style="color:black;">Search orders</a> <i class="fa fa-angle-right"></i> {{$client->name}}</h2>
		<h3 style="margin-left:60px;">
		@if(isset($from))
			@if(isset($to)) 
				{{$from}}
			@else
				From {{$from}}
			@endif
		@endif
		@if(isset($to))
			to {{$to}}
		@endif
		</h3>
		<h4>
		<table align="center">
			<tr>
				<td colspan="4" style="text-align:center;">Orders : <b><input style="border:0;" readonly type="text" class="orderQty"/></b></td>
			</tr>
			<tr>
				<td>Invoiced </td>
				<td>: <b><input style="border:0;" readonly type="text" class="invoiced"/></b></td>
				<td>Slipped </td>
				<td>: <b><input style="border:0;" readonly type="text" class="slipped"/></b></td>
			</tr>			
			<tr>
				<td>Pending Invoices </td> 
				<td>: <b><input style="border:0;" readonly type="text" class="pendingInvoices"/></b></td>
				<td>Pending Slips </td>
				<td>: <b><input style="border:0;" readonly type="text" class="pendingSlips"/></b></td>
			</tr>						
		</table>
		</h4>
	</div>
</div>
<div class="row mt">
	<div class="col-lg-12">
		<div class="content-panel">
			<form id="searchbox" class="form-inline col-md-offset-2">
				<input type="text" data-column="2"  style="width:120px;border-left:50px;" class="form-control" placeholder="Date">
				<input type="text" data-column="4"  style="border-left:20px;" class="form-control" placeholder="Item">
				<input type="text" data-column="5"  style="border-left:20px;" class="form-control" placeholder="Qty">	
				<input type="text" data-column="8"  style="border-left:20px;" class="form-control" placeholder="Invoice/Slip">					
				<input type="text" data-column="9"  style="border-left:20px;" class="form-control" placeholder="Status">					
			</form>	
			
			<section style="margin:40px;">
				<table class="table table-bordered table-condensed cf" id="orders">
					<thead class="cf">
						<tr>
							<th style="width:7%;"/>
							<th style="width:7%;">Id</th>
							<th style="width:10%;">Date</th>
							<th>Client</th>
							<th>Item</th>
							<th>Qty</th>
							<th>Invoices</th>
							<th>Slips</th>
							<th>Numbers</th>
							<th>Status</th>
							<th>Remarks</th>
						</tr>
					</thead>
					<tbody>
					@foreach($orders as $order)
					<tr>
					<td align="center"><a href="{{ url('orders/'.$order->id) }}" class="btn btn-theme" style="padding: 0px 15px;font-size: 13px;">View</a></td>
					<td>{{ $order -> id }}</td>
					<td>{{ date('d-m-Y',strtotime($order -> date)) }}</td>
					<td>{{ $order -> client -> name }}</td>
					<td>{{ $order -> item -> name }}</td>
					<td>{{ $order -> qty }}</td>
					<?php $total = 0; $numbers = null;?>
					@foreach($order->invoices() as $invoice)
						<?php $total = $total + $invoice -> qty;$numbers = $numbers.','.$invoice -> number;?>
					@endforeach				
				    <td>{{$total}}</td>					  
					<?php $total = 0;?>
					@foreach($order->slips() as $slip)
						<?php $total = $total + $slip -> qty;$numbers = $numbers.','.$slip -> number;?>
					@endforeach				
				    <td>{{$total}}</td>	
					<td>{{$numbers}}</td>					
					<td>{{ $order -> status }}</td>
					<td>{{ $order -> remarks}}</td>
					</tr>
					@endforeach	
					</tbody>
				</table>
			</section>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	
	$.fn.dataTable.moment( 'DD-MM-YYYY' );

	var table = $('#orders').DataTable({
		"iDisplayLength": 10000,
		"columnDefs": [
						{ "visible": false, "targets": 8 }
					  ],
		"drawCallback": function( settings ) {
			var api = this.api();
			$(".orderQty").val(api.column( 5, {page:'current'} ).data().sum());
			$(".invoiced").val(api.column( 6, {page:'current'} ).data().sum());
			$(".slipped").val(api.column( 7, {page:'current'} ).data().sum());
			$(".pendingInvoices").val($(".orderQty").val()-$(".invoiced").val());
			$(".pendingSlips").val($(".orderQty").val()-$(".slipped").val());
		}
	});
		
	$("#orders_filter").css("display","none");  // hiding global search box
	$('.form-control').on( 'keyup click', function () {   // for text boxes
		var i =$(this).attr('data-column');  // getting column index
		var v =$(this).val();  // getting search input value
		table.columns(i).search(v).draw();
	} );
	$('.search-input-select').on( 'change', function () {   // for select box
		var i =$(this).attr('data-column');  
		var v =$(this).val();  
		table.columns(i).search(v).draw();
	} );	

} );
</script>
@stop