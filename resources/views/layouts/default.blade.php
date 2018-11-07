<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>
<section id="container">
@include('includes.header')
@if(Auth::check())
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
