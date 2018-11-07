@extends('layouts.default')
@section('title', 'Purchases')
@section('content')
<style>
.dataTables_length{
  display:none;
}
.dataTables_paginate{
  display:none;
}
</style>
@if (session('error'))
<script>	
	bootbox.alert({
		message: '{{ session("error") }}'
	});
</script>
@endif 
@if (session('success'))
<script>	
	BootstrapAlert.success({
		title: "Success!",
		message: '{{ session("success") }}'
	});
</script>
@endif
<div class="row mt">
  <div class="col-lg-12">
	<div class="content-panel">
	  <h2 style="margin-left:30px;"><i class="fa fa-truck"></i> Purchases</h2>
	  <h3 align="center">Total: <input style="border:0;" readonly type="text" class="total"/></h3>
	  <br/>	
		<form id="searchbox" class="form-inline col-md-offset-1">
			<input type="text" data-column="1"  style="width:120px;border-left:50px;" class="form-control" placeholder="Date">
			<input type="text" data-column="2"  style="border-left:20px;" class="form-control" placeholder="Item">
			<input type="text" data-column="3"  style="border-left:20px;" class="form-control" placeholder="Qty">	
			<input type="text" data-column="4"  style="border-left:20px;" class="form-control" placeholder="Delivery No">					
			<input type="text" data-column="5"  style="border-left:20px;" class="form-control" placeholder="Slip No">					
			<input type="text" data-column="7"  style="border-left:20px;" class="form-control" placeholder="Godown">					
		</form>		  
	  <section style="margin:40px;margin-left:100px;">
		<table id="purchases" class="table table-bordered table-condensed cf" style="width:85%;">
		  <thead class="cf">
			<tr>
			  <th style="width:7%;text-align:center">Id</th>
			  <th style="width:10%;">Date</th>
			  <th>Item</th>
			  <th>Qty</th>
			  <th>Delivery No.</th>
			  <th>Slip No.</th>
			  <th>Lorry</th>
			  <th>Godown</th>
			</tr>
		  </thead>
		  <tbody>
		  @foreach($purchases as $purchase)
			<tr>
			  <td style="text-align:center">{{ $purchase -> id }}</td>
			  <td>{{ date('d-m-Y',strtotime($purchase -> date)) }}</td>
			  <td>{{ $purchase -> item -> name }}</td>
			  <td>{{ $purchase -> qty }}</td>
			  <td>{{ $purchase -> number }}</td>
			  <td>{{ $purchase -> slip_number }}</td>
			  <td>{{ $purchase -> lorry }}</td>
			  <td>{{ $purchase -> godown -> name }}</td>
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

	var table = $('#purchases').DataTable({
		"drawCallback": function( settings ) {
			var api = this.api();
			$(".total").val(api.column( 3, {page:'current'} ).data().sum());
		}
	});
		
	$("#purchases_filter").css("display","none");  // hiding global search box
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