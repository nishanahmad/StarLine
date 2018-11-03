@extends('layouts.default')
@section('title', 'Purchases')
@section('content')
        <div class="row mt">
          <div class="col-lg-12">
            <div class="content-panel">
              <h2 style="margin-left:30px;"><i class="fa fa-truck"></i> Purchases</h2>
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
					  <th>Delivery No.</th>
					  <th>Slip No.</th>
					  <th>Lorry</th>
					  <th>Godown</th>
                    </tr>
                  </thead>
                  <tbody>
				  @foreach($purchases as $purchase)
                    <tr>
					  <td align="center"><a href="{{ url('purchases/'.$purchase->id) }}" class="btn btn-theme" style="padding: 0px 15px;font-size: 13px;">View</a></td>
                      <td>{{ $purchase -> id }}</td>
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
@stop