@extends('layouts.default')
@section('title', 'Clients Balance')
@section('content')
<section class="wrapper">
	<h3><i class="fa fa-user"></i> Clients Balance</h3>
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel">
			<section id="unseen">
				<table class="table table-bordered table-condensed" style="margin-left:100px;width:30%;">
					<thead>
						<tr>
							<th>Client</th>
							<th>Balance</th>
						</tr>
					</thead>
					<tbody>
						<?php $total = 0;?>
						@foreach($clientMap as $client => $balance)
						<tr>
							<td>{{$client}}</td>
							<td>{{$balance}}</td>
						</tr>
						<?php $total = $total + $balance;?>
						@endforeach
					</tbody>
					<thead>
						<tr>
							<th>Total</th>
							<th>{{$total}}</th>
						</tr>
					</thead>					
				</table>
			</section>
			</div>
		</div>
	</div>
</section>
@stop