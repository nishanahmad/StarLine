@extends('layouts.default')
@section('title', 'Transfer Logs')
@section('content')
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
	  <br/><br/>
	  <section id="no-more-tables">
		<table class="table table-bordered table-striped table-condensed cf">
		  <thead class="cf">
			<tr>
			  <th style="width:7%;">
			  <th style="width:7%;">Id</th>
			  <th style="width:10%;">Date</th>
			  <th>Item</th>
			  <th>Qty</th>
			  <th>FROM</th>
			  <th>TO</th>
			  <th>Remarks</th>
			</tr>
		  </thead>
		  <tbody>
		  @foreach($logs as $log)
			<tr>
			  <td align="center"><a href="{{ url('logs/'.$log->id) }}" class="btn btn-theme" style="padding: 0px 15px;font-size: 13px;">View</a></td>
			  <td>{{ $log -> id }}</td>
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
@stop