<div id="sidebar" class="nav-collapse ">
	<ul class="sidebar-menu" id="nav-accordion">
	  <p class="centered"><a href="#"><img src="{{ asset('images/ui-nishan.jpg') }}" class="img-circle" width="80"></a></p>
	  <h5 class="centered">{{ Auth::user()->name }}</h5>
	  <li class="mt">
		<a class="{{ Request::is('/') || Request::is('home') ? 'active' : '' }}" href="/home">
		  <i class="fa fa-dashboard"></i>
		  <span>Dashboard</span>
		  </a>
	  </li>	  	  
	  <li>
		<a class="{{ Request::is('daybook') ? 'active' : '' }}" href="/daybook">
		  <i class="fa fa-book"></i>
		  <span>Day Book</span>
		  </a>
	  </li>	  	  	  
	  <li class="sub-menu">
		<a href="javascript:;" class="{{ Request::is('orders*') ? 'active' : '' }}">
		  <i class="fa fa-credit-card"></i>
		  <span>Orders</span>
		  </a>
		<ul class="sub">
		  <li class="{{ Request::is('orders/create') ? 'active' : '' }}"><a href="{{ url('orders/create') }}">New Order</a></li>
		  <li class="{{ Request::is('orders') ? 'active' : '' }}"><a href="{{ url('orders') }}">Search Orders</a></li>
		</ul>
	  </li>
	  <li class="sub-menu">
		<a href="javascript:;" class="{{ Request::is('purchases*') ? 'active' : '' }}">
		  <i class="fa fa-truck"></i>
		  <span>Purchases</span>
		  </a>
		<ul class="sub">
		  <li class="{{ Request::is('purchases/create') ? 'active' : '' }}"><a href="{{ url('purchases/create') }}">New Purchase</a></li>
		  <li class="{{ Request::is('purchases') ? 'active' : '' }}"><a href="{{ url('purchases') }}">List Purchases</a></li>
		</ul>
	  </li>
	  <li class="sub-menu">
		<a href="javascript:;" class="{{ Request::is('stock*') ? 'active' : '' }}">
		  <i class="fa fa-building"></i>
		  <span>Stock</span>
		  </a>
		<ul class="sub">
		  <li class="{{ Request::is('stock/closing') ? 'active' : '' }}"><a href="{{ url('stock/closing') }}">View Closing Stock</a></li>
		  <li class="{{ Request::is('stock/transfer') ? 'active' : '' }}"><a href="{{ url('stock/transfer') }}">Transfer Stock</a></li>
		  <li class="{{ Request::is('stock/transfer/logs') ? 'active' : '' }}"><a href="{{ url('stock/transfer/logs') }}">Transfer Logs</a></li>
		</ul>
	  </li>
	  <li>
		<a class="{{ Request::is('clients/balance') ? 'active' : '' }}" href="/clients/balance">
		  <i class="fa fa-user"></i>
		  <span>Client Balance</span>
		  </a>
	  </li>	  	  	  	  
	</ul>
</div>