<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>
<section id="container">
@if(Auth::check())
	@include('includes.header')
    <aside>
      <div id="sidebar" class="nav-collapse ">
			@include('includes.sidebar')
      </div>
	</aside>
@endif
	<section id="main-content">
      <section class="wrapper">
            @yield('content')
      </section>
	</section>  	
</div>
</body>
</html>
