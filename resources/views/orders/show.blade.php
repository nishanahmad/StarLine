@extends('layouts.default')
@section('title', 'Order '.$order->id)
@section('content')
@if (session('error'))
<script>	
	bootbox.alert({
		message: '{{session('error')}}',
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
<style>
.tbl {
}
.tbl td {
   padding: 5px;
   width:150px;
}

</style>	
<section class="wrapper">
			<h2><i style="margin-left:20px;" class="fa fa-credit-card"></i>&nbsp;<label id="name">Order-{{$order -> id}}</label>&nbsp;&nbsp;&nbsp;</h2>
            <div class="row content-panel">
              <div class="col-md-6">
                <div class="right-divider hidden-sm hidden-xs">
                  <h4 style="margin-left:50px;">
				  <table class="tbl">
					  <tr>
						<td>Date</td>
						<td>: <b>{{ date('d-m-Y',strtotime($order -> date))}}</b></td>
					  </tr>
					  <tr>
						<td>Client</td>
						<td>: <b>{{ $order -> client -> name}}</b></td>
					  </tr>
					  <tr>
						<td>Item</td>
						<td>: <b>{{ $order -> item -> name}}</b></td>
					  </tr>					  
					  <tr>
						<td>Qty</td>
						<td>: <b>{{ $order -> qty}}</b></td>
					  </tr>					  
					  <tr>
						<td>Remarks</td>
						<td>: <b>{{ $order -> remarks}}</b></td>
					  </tr>					  					  
					  <tr>
						<td>Status</td>
						<td>: <b>{{ $order -> status}}</b></td>
					  </tr>					  					  
					</table>  
                </div>
              </div>
              <div class="col-md-4">
				<br/><br/>
                <a  href="/orders/{{$order->id}}/edit" class="btn btn-theme" style="width:120px"><i class="fa fa-pencil"></i> Edit Order</a>
				<br/><br/>
				<form id="delete_form" action="{{ url('/orders/'.$order->id)}}" method="post">
					{!! method_field('delete') !!}
					{!! csrf_field() !!}
					<button type="submit" class="btn btn-danger" id="delete" style="width:120px"><i class="fa fa-times"></i> Del Order</button>	
				</form>				
              </div>
              <!-- /col-md-4 -->
            </div>
			
	<div class="row mt">
		<div class="content-panel">
			<h4><i class="fa fa-inr"></i>&nbsp;&nbsp;Invoices</h4>
			<section id="unseen">
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<th width="2%;"></th>
							<th>&nbsp;&nbsp;Date</th>
							<th>Invoice No.</th>
							<th>Qty</th>
							<th>CreatedBy</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($invoices as $invoice)
						<tr>
							<td><a href="/invoices/{{ $invoice -> id }}"><i class="fa fa-pencil"></i></a></td>
							<td>{{ date('d-m-Y',strtotime($invoice -> date))}}</td>
							<td>{{ $invoice -> number}}</td>
							<td>{{ $invoice -> qty}}</td>
							<td>{{ $invoice -> user -> name}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div align="center">
					<a  href="/invoices/create/{{$order->id}}" class="btn btn-theme"><i class="fa fa-inr"></i> New Invoice</a><br/><br/>
				</div>	
			</section>
		</div>
	</div>
	
	<div class="row mt">
		<div class="content-panel">
			<h4><i class="fa fa-file-text"></i>&nbsp;&nbsp;Godown Slips</h4>
			<section id="unseen">
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<th width="2%;"></th>
							<th>&nbsp;&nbsp;Date</th>
							<th>Slip No.</th>
							<th>Qty</th>
							<th>Godown</th>
							<th>Lorry</th>
							<th>Driver</th>
							<th>CreatedBy</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($slips as $slip)
						<tr>
							<td><a href="/slips/{{ $slip -> id }}"><i class="fa fa-pencil"></i></a></td>
							<td>{{ date('d-m-Y',strtotime($slip -> date))}}</td>
							<td>{{ $slip -> number}}</td>
							<td>{{ $slip -> qty}}</td>
							<td>{{ $slip -> godown -> name}}</td>
							<td>{{ $slip -> lorry}}</td>
							<td>{{ $slip -> driver }}</td>
							<td>{{ $slip -> user -> name}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div align="center">
					<a  href="/slips/create/{{$order->id}}" class="btn btn-theme"><i class="fa fa-file-text"></i> New Slip</a><br/><br/>
				</div>	
			</section>
		</div>
	</div>
</section>
<div align="center">
<br/><br/><br/><br/>
<script>
$('#delete').click(function () {
	event.preventDefault();
	bootbox.confirm({
		message: "Are you sure you want to delete this order?",
		buttons: {
			cancel: {
				label: 'No',
				className: 'btn-danger'
			},
			confirm: {
				label: 'Yes',
				className: 'btn-success'
			}			
		},
		callback: function (result) {
			if(result == false)
				return true;
			else
				$("#delete_form").submit();
		}
	});
});
</script>
</div>
@stop