@extends('layouts.default')
@section('title', 'Edit Order')
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
<script>
$(document).ready(function() {
		var pickerOpts = { dateFormat:"dd-mm-yy"}; 					
		$( "#datepicker" ).datepicker(pickerOpts);
	});	
</script>   
<section class="wrapper">
	<h2><i class="fa fa-credit-card" style="margin-right:.5em;margin-left:.5em;"></i>Edit Order</h3>
	@foreach ($errors->all() as $error)
		<p class="alert alert-danger">{{ $error }}</p>
	@endforeach	
	<div class="row mt">
		<div class="col-lg-8">
			<div class="form-panel">
				<h4 class="mb"><i class="fa fa-angle-right" style="margin-right:.5em;"></i>Enter details</h4>
				<form class="form-horizontal style-form"  action="/orders/{{$order->id}}" method="post">
					<input type="hidden" name="_token" value="{!! csrf_token() !!}">
					<input type="hidden" name="item" value="{{$order->item->id}}" class="form-control">
					<input type="hidden" name="client" value="{{$order->client->id}}" class="form-control">
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Date</label>
						<div class="col-sm-6">
							<input type="text" id="datepicker" name="date" value="{{$order->date}}" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Client</label>
						<div class="col-sm-6">
							<input type="text" value="{{$order->client->name}}" class="form-control" readonly>
						</div>
					</div>					
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Item</label>
						<div class="col-sm-6">
							<input type="text" value="{{$order->item->name}}" class="form-control" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Quantity</label>
						<div class="col-sm-6">
							<input type="text" name="qty" class="form-control" value="{{$order->qty}}" required>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Remarks</label>
						<div class="col-sm-6">
							<input type="text" name="remarks" value="{{$order->remarks}}" class="form-control">
						</div>
					</div>
					<br/>					
					<div class="col-md-offset-3">
						<button type="submit" class="btn btn-primary">Update Order</button> 
						<a href="/orders/{{$order->id}}" class="btn btn-default" style="margin-left:10px;" tabindex="5">Cancel</a>
					</div>
					<br/>
				</form>
			</div>
		</div>
	</div>
</section>
@stop