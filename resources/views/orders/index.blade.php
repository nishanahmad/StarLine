@extends('layouts.default')
@section('title', 'Search Orders')
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
		var pickerOpts1 = { dateFormat:"dd-mm-yy"}; 					
		$( "#from" ).datepicker(pickerOpts1);

		var pickerOpts2 = { dateFormat:"dd-mm-yy"}; 					
		$( "#to" ).datepicker(pickerOpts2);		
	});	
</script>   
@foreach ($errors->all() as $error)
	<p class="alert alert-danger">{{ $error }}</p>
@endforeach	
<div class="row content-panel">
	<form class="form-horizontal style-form"  action="/orders" method="post" autocomplete="off">
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">	
		<div class="form-group">
			<div class="col-md-3 col-md-offset-2">
				<select name="client_id" class="form-control">
				<option value="">--Client--</option>
				@foreach($clients as $client)
					@if(old('client_id') == $client->id)
						<option selected value="{{$client->id}}">{{ $client -> name}}</option>
					@else
						<option value="{{$client->id}}">{{ $client -> name}}</option>
					@endif
				@endforeach
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-md-6 col-md-offset-2">
				<div class="form-group row">
					<div class="col-md-3">
						<input type="text" class="form-control" value="{{old('from')}}" name="from" id="from" placeholder="From...">
					</div>
					<div class="col-md-3">
						<input type="text" class="form-control" value="{{old('to')}}" name="to" id="to" placeholder="To...">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-md-offset-2">
			<br/><br/>
			<button class="btn btn-theme" style="width:150px;margin-left:60px;"><i class="fa fa-search"></i> Search Orders</button>
			<br/><br/>
		</div>
	</form>	
</div>
@stop