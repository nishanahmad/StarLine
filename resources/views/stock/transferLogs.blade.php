@extends('layouts.default')
@section('title', 'Transfer Logs')
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
	  <h2 style="margin-left:30px;"><i class="fa fa-truck"></i> Transfer Logs</h2>
	  <h3 align="center">Total Transferred: <input style="border:0;" readonly type="text" class="total"/></h3>
	  <br/>	
		<form id="searchbox" class="form-inline col-md-offset-2">
			<input type="text" data-column="0"  style="width:120px;border-left:50px;" class="form-control" placeholder="Date">
			<input type="text" data-column="1"  style="border-left:20px;" class="form-control" placeholder="Item">
			<input type="text" data-column="2"  style="border-left:20px;" class="form-control" placeholder="Qty">	
			<input type="text" data-column="3"  style="border-left:20px;" class="form-control" placeholder="Transferred from">					
			<input type="text" data-column="4"  style="border-left:20px;" class="form-control" placeholder="Transferred to">					
		</form>	
			
	  <section style="margin:20px;">
		<table id="logs" class="table table-bordered table-condensed cf">
		  <thead class="cf">
			<tr>
			  <th style="width:10%;">Date</th>
			  <th>Item</th>
			  <th>Qty</th>
			  <th>Transferred from</th>
			  <th>Transferred to</th>
			  <th>Remarks</th>
			</tr>
		  </thead>
		  <tbody>
		  @foreach($logs as $log)
			<tr>
			  <td>{{ date('d-m-Y',strtotime($log -> date)) }}</td>
			  <td>{{ $log -> item -> name }}</td>
			  <td>{{ $log -> qty }}</td>
			  <td>{{ $godownNameMap[$log -> from] }}</td>
			  <td>{{ $godownNameMap[$log -> to] }}</td>
			  <td>{{ $log -> remarks }}</td>
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

	var table = $('#logs').DataTable({
		"drawCallback": function( settings ) {
			var api = this.api();
			$(".total").val(api.column( 2, {page:'current'} ).data().sum());
		}
	});
		
	$("#logs_filter").css("display","none");  // hiding global search box
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