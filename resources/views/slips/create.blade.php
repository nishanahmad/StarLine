@extends('layouts.default')
@section('title', 'New Godown Slip')
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
	<h2><i class="fa fa-file-text" style="margin-right:.5em;margin-left:.5em;"></i>New Godown Slip</h3>
	@foreach ($errors->all() as $error)
		<p class="alert alert-danger">{{ $error }}</p>
	@endforeach	
	<div class="row mt">
		<div class="col-lg-8">
			<div class="form-panel">
				<h4 class="mb"><i class="fa fa-angle-right" style="margin-right:.5em;"></i>Enter details</h4>
				<form class="form-horizontal style-form"  action="/slips" method="post">
					<input type="hidden" name="_token" value="{!! csrf_token() !!}">
					<input type="hidden" name="order" value="{{$order->id}}">
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Date</label>
						<div class="col-sm-6">
							@if(old('date') != null)
								<input type="text" name="date" value="{{old('date')}}" class="form-control"  id="datepicker" tabindex="1" required>
							@else
								<input type="text" name="date" value="{{date('d-m-Y',strtotime($today))}}" class="form-control" id="datepicker" tabindex="1" required>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Client</label>
						<div class="col-sm-6">
							<input type="text" readonly name="client" value="{{$order->client->name}}" class="form-control">
						</div>
					</div>					
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Item</label>
						<div class="col-sm-6">
							<input type="text" readonly name="item" value="{{$order->item->name}}" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Quantity</label>
						<div class="col-sm-6">
							<input type="text" name="qty" class="form-control" tabindex="2" required value="{{old('qty')}}">
						</div>
					</div>					
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Lorry</label>
						<div class="col-sm-6">
							<input type="text" name="lorry" class="form-control" tabindex="3" value="{{old('lorry')}}">
						</div>
					</div>										
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Driver</label>
						<div class="col-sm-6">
							<input type="text" name="driver" class="form-control" tabindex="4" value="{{old('driver')}}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Loading Time</label>
						<div class="col-sm-6">
							<input type="time" name="time" class="form-control" tabindex="5" value="{{old('time')}}">
						</div>
					</div>					
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Slip No.</label>
						<div class="col-sm-6">
							<input type="text" name="number" class="form-control" required tabindex="6" value="{{old('number')}}">
						</div>
					</div>										
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Godown</label>
						<div class="col-sm-6">
							<select name="godown" class="form-control" tabindex="7" required>
								@foreach($godowns as $godown)
									@if(old('godown') == $godown->id)
										<option selected value="{{$godown->id}}">{{ $godown -> name}}</option>
									@else
										<option value="{{$godown->id}}">{{ $godown -> name}}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>										
					<button type="submit" class="btn btn-primary" style="margin-left:200px;" tabindex="8">Create Slip</button> 
					<a href="/orders/{{$order->id}}" class="btn btn-default" style="margin-left:10px;" tabindex="9">Cancel</a>
					<br/><br/>
				</form>
			</div>
		</div>
	</div>
</section>
@stop