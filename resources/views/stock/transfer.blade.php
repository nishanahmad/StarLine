@extends('layouts.default')
@section('title', 'Transfer Stock')
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
		$( "#date" ).datepicker(pickerOpts);
	});	
</script>   
<section class="wrapper">
	<h2><i class="fa fa-building" style="margin-right:.5em;margin-left:.5em;"></i><i class="fa fa-angle-double-right" style="margin-right:.5em;margin-left:.5em;"></i>Transfer Stock</h3>
	@foreach ($errors->all() as $error)
		<p class="alert alert-danger">{{ $error }}</p>
	@endforeach	
	<div class="row mt">
		<div class="col-lg-8">
			<div class="form-panel">
				<h4 class="mb"><i class="fa fa-angle-right" style="margin-right:.5em;"></i>Enter details</h4>
				<form class="form-horizontal style-form"  action="/stock/transfer" method="post">
					<input type="hidden" name="_token" value="{!! csrf_token() !!}">
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Date</label>
						<div class="col-sm-6">
							@if(old('date') != null)
								<input type="text" name="date" id="date" value="{{date('d-m-Y',strtotime(old('date')))}}" class="form-control" required>
							@else
								<input type="text" name="date" id="date" value="{{date('d-m-Y',strtotime($today))}}" class="form-control" required>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Item</label>
						<div class="col-sm-6">
							<select name="item" class="form-control" required>
								<option value=""></option>
								@foreach($items as $item)
									@if(old('item') == $item->id)
										<option selected value="{{$item->id}}">{{ $item -> name}}</option>
									@else
										<option value="{{$item->id}}">{{ $item -> name}}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>										
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Quantity</label>
						<div class="col-sm-6">
							<input type="text" name="qty" class="form-control" value="{{old('qty')}}" required>
						</div>
					</div>					
					<div class="form-group">
						<div class="col-sm-3 col-md-offset-1">
							<select name="from" class="form-control" required>
								<option value="">--- FROM ---</option>
								@foreach($godowns as $godown)
									@if(old('from') == $godown->id)
										<option selected value="{{$godown->id}}">{{ $godown -> name}}</option>
									@else
										<option value="{{$godown->id}}">{{ $godown -> name}}</option>
									@endif
								@endforeach
							</select>
						</div>
						<div class="col-sm-1 control-label">
							<i class="fa fa-angle-double-right"></i><i class="fa fa-angle-double-right"></i>
						</div>
						<div class="col-sm-3">
							<select name="to" class="form-control" required>
								<option value="">--- TO ---</option>
								@foreach($godowns as $godown)
									@if(old('to') == $godown->id)
										<option selected value="{{$godown->id}}">{{ $godown -> name}}</option>
									@else
										<option value="{{$godown->id}}">{{ $godown -> name}}</option>
									@endif
								@endforeach
							</select>
						</div>						
					</div>					
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label">Remarks</label>
						<div class="col-sm-6">
							<input type="text" name="remarks" value="{{old('remarks')}}" class="form-control">
						</div>
					</div>						
					<div class="text-center">
						<button type="submit" class="btn btn-primary">Transfer</button> 
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@stop