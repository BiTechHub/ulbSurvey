<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Online Survey Portal :: Business Innovations</title>


	<!--STYLESHEET-->
	<!--=================================================-->

	<!--Open Sans Font [ OPTIONAL ] -->
 	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">


	<!--Bootstrap Stylesheet [ REQUIRED ]-->
	<link href="{{url('/')}}/css/bootstrap.min.css" rel="stylesheet">


	<!--Nifty Stylesheet [ REQUIRED ]-->
	<link href="{{url('/')}}/css/nifty.min.css" rel="stylesheet">


	<!--Font Awesome [ OPTIONAL ]-->
	<link href="{{url('/')}}/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">


	<!--Animate.css [ OPTIONAL ]-->
	<link href="{{url('/')}}/plugins/animate-css/animate.min.css" rel="stylesheet">


	<!--Morris.js [ OPTIONAL ]-->
	<link href="{{url('/')}}/plugins/morris-js/morris.min.css" rel="stylesheet">


	<!--Switchery [ OPTIONAL ]-->
	<link href="{{url('/')}}/plugins/switchery/switchery.min.css" rel="stylesheet">


	<!--Bootstrap Select [ OPTIONAL ]-->
	<link href="{{url('/')}}/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
     <link href="{{url('/')}}/plugins/bootstrap-datepicker/bootstrap-datepicker.css" rel="stylesheet">


	<!--SCRIPT-->
	<!--=================================================-->

	<!--Page Load Progress Bar [ OPTIONAL ]-->
	<link href="{{url('/')}}/plugins/pace/pace.min.css" rel="stylesheet">
	<script src="{{url('/')}}/plugins/pace/pace.min.js"></script>


</head>

<body>
	<div id="container" class="effect mainnav-lg">

		<!--NAVBAR-->
		<!--===================================================-->
		<header id="navbar">
			<div id="navbar-container" class="boxed">

				<!--Brand logo & name-->
				<!--================================-->
				<div class="navbar-header">
					<a href="#" class="navbar-brand">
						<img src="{{url('/')}}/img/logo.gif" alt="Nifty Logo" class="brand-icon" style="width:100%">

					</a>
				</div>
				<!--================================-->
				<!--End brand logo & name-->


				<!--Navbar Dropdown-->
				<!--================================-->
				<div class="navbar-content clearfix">
					<ul class="nav navbar-top-links pull-left">

						<!--Navigation toogle button-->
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<li class="tgl-menu-btn">
							<a class="mainnav-toggle" href="#">
								<i class="fa fa-navicon fa-lg"></i>
							</a>
						</li>

					</ul>
					<ul class="nav navbar-top-links pull-right">
                      <!--User dropdown-->
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<li id="dropdown-user" class="dropdown">
							<a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
								<span class="pull-right">
									<img class="img-circle img-user media-object" src="img/av1.png" alt="Profile Picture">
								</span>

								<div class="username hidden-xs">{{ Session('name') }}</div>

							</a>


							<div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">


								<!-- Dropdown footer -->

								<div class="pad-all text-right">
									<a href="{{url('/')}}/logout" class="btn btn-primary">
										<i class="fa fa-sign-out fa-fw"></i> Logout
									</a>
								</div>


							</div>
						</li>
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<!--End user dropdown-->

					</ul>
				</div>
				<!--================================-->
				<!--End Navbar Dropdown-->

			</div>
		</header>
		<!--===================================================-->
		<!--END NAVBAR-->

		<div class="boxed">

			@yield('content')

			<!--MAIN NAVIGATION-->
			<!--===================================================-->
			<nav id="mainnav-container">
				<div id="mainnav">


					<!--Menu-->
					<!--================================-->
					<div id="mainnav-menu-wrap">
						<div class="nano">
							<div class="nano-content">
								<ul id="mainnav-menu" class="list-group">

									<!--Category name-->


									<!--Menu list item-->
									@foreach($menu as $value)
									@if($value['menu_type']=='Main')
									<li>
										<a href="{{url('/')}}/{{$value['url']}}" target="{{$value['target']}}" >
											<i class="{{$value['icon']}}"></i>
											<span class="menu-title">
												<strong>{{$value['menu_name']}}</strong>
											</span>
										</a>
									</li>
									@endif
									@if($value['menu_type']=='Sub')
										<li>
										<a href="#">
											<i class="{{$value['icon']}}"></i>
											<span class="menu-title">{{$value['menu_name']}}</span>
											<i class="arrow"></i>
										</a>
										<ul class="collapse">
											@foreach($value['sub_menu'] as $subvalue)
												<li><a target="{{$subvalue->target}}" href="{{url('/')}}/{{$subvalue->url_name}}">{{$subvalue->sub_menu}}</a></li>
											@endforeach
										</ul>
									</li>
									@endif
									@endforeach
									<!--Menu list item-->


								</ul>



								<!--================================-->
								<!--End widget-->

							</div>
						</div>
					</div>
					<!--================================-->
					<!--End menu-->


			</div>
			</nav>
			<!--===================================================-->
			<!--END MAIN NAVIGATION-->
			@yield('sidebar')
			<!--ASIDE-->
			<!--===================================================-->
		</div>



		<!-- FOOTER -->
		<!--===================================================-->
		<footer id="footer">

			<!-- Visible when footer positions are fixed -->
			<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->




			<!-- Visible when footer positions are static -->
			<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->



			<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
			<!-- Remove the class name "show-fixed" and "hide-fixed" to make the content always appears. -->
			<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

			<p class="pad-lft">&#0169; All right reserved by Business Innovations</p>



		</footer>
		<!--===================================================-->
		<!-- END FOOTER -->


		<!-- SCROLL TOP BUTTON -->
		<!--===================================================-->
		<button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
		<!--===================================================-->



	</div>
	<!--===================================================-->
	<!-- END OF CONTAINER -->






	<!--JAVASCRIPT-->
	<!--=================================================-->

	<!--jQuery [ REQUIRED ]-->
	<script src="{{url('/')}}/js/jquery-2.1.1.min.js"></script>


	<!--BootstrapJS [ RECOMMENDED ]-->
	<script src="{{url('/')}}/js/bootstrap.min.js"></script>


	<!--Fast Click [ OPTIONAL ]-->
	<script src="{{url('/')}}/plugins/fast-click/fastclick.min.js"></script>


	<!--Nifty Admin [ RECOMMENDED ]-->
	<script src="{{url('/')}}/js/nifty.min.js"></script>
<script src="{{url('/')}}/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

	<!--Morris.js [ OPTIONAL ]-->
	<script src="{{url('/')}}/plugins/morris-js/morris.min.js"></script>
	<script src="{{url('/')}}/plugins/morris-js/raphael-js/raphael.min.js"></script>


	<!--Sparkline [ OPTIONAL ]-->
	<script src="{{url('/')}}/plugins/sparkline/jquery.sparkline.min.js"></script>


	<!--Skycons [ OPTIONAL ]-->
	<script src="{{url('/')}}/plugins/skycons/skycons.min.js"></script>


	<!--Switchery [ OPTIONAL ]-->
	<script src="{{url('/')}}/plugins/switchery/switchery.min.js"></script>


	<!--Bootstrap Select [ OPTIONAL ]-->
	<script src="{{url('/')}}/plugins/bootstrap-select/bootstrap-select.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&region=IN&key=AIzaSyByoxJYY2T8F1D2QSF_IHrdWpAmKJ3JSrE"></script>

	<script src="{{url('/')}}/js/jquery.placepicker.js"></script><!-- THIS CODE IS NECESSARY -->
	<!--Demo script [ DEMONSTRATION ]-->
	<script src="{{url('/')}}/js/demo/nifty-demo.min.js"></script>


	<!--Specify page [ SAMPLE ]-->
	<script src="{{url('/')}}/js/demo/dashboard.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	@yield('script')

	@if(session()->has('message'))
    <script type="text/javascript">
        swal("{{session()->get('message')}}");
    </script>
    @php(session()->forget('message'))
    @endif

    @if(session()->has('errorMsg'))
      <script type="text/javascript">
        swal("{{session()->get('errorMsg')}}");
        //toastr["error"]("{{session()->get('errorMsg')}}")
      </script>
      @php(session()->forget('errorMsg'))
    @endif
</body>
</html>
