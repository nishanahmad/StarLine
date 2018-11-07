<header class="header black-bg">
	<div class="sidebar-toggle-box">
		<div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
	</div>  
	<a href="{{ url('home') }}" class="logo"><b>STAR<span>LINE</span></b></a>

	<div class="top-menu">
		<ul class="nav pull-right top-menu">
			@if(Auth::check())
				<li>
					<a class="logout" <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				</li>
			@endif	
		</ul>
	</div>
</header>