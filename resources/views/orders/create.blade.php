@extends('layouts.default')
@section('title', 'New Order')
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
	<h2><i class="fa fa-credit-card" style="margin-right:.5em;margin-left:.5em;"></i>New Order</h3>
	@foreach ($errors->all() as $error)
		<p class="alert alert-danger">{{ $error }}</p>
	@endforeach	
	<div class="row mt">
		<div class="col-lg-8">
			<div class="form-panel">
				<h4 class="mb"><i class="fa fa-angle-right" style="margin-right:.5em;"></i>Enter details</h4>
				<form class="form-horizontal style-form"  action="/orders" method="post">
					<input type="hidden" name="_token" value="{!! csrf_token() !!}">
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Date</label>
						<div class="col-sm-6">
							<input type="text" id="datepicker" name="date" value="{{date('d-m-Y',strtotime($today))}}" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Client</label>
						<div class="col-sm-6">
							<select name="client" class="form-control" required>
								<option value=""></option>
								@foreach($clients as $client)
									<option value="{{$client->id}}">{{ $client -> name}}</option>
								@endforeach
							</select>
						</div>
					</div>					
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Item</label>
						<div class="col-sm-6">
							<select name="item" class="form-control" required>
								<option value=""></option>
								@foreach($items as $item)
									<option value="{{$item->id}}">{{ $item -> name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Quantity</label>
						<div class="col-sm-6">
							<input type="text" name="qty" class="form-control" required>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Remarks</label>
						<div class="col-sm-6">
							<input type="text" name="remarks" class="form-control">
						</div>
					</div>						
					<div class="text-center">
						<button type="submit" class="btn btn-primary">Create Order</button> 
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@stop