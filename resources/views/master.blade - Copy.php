<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>


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
								
								<div class="username hidden-xs">{{ Session('user_type') }}</div>
								
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
									<li class="active-link">
										<a href="{{url('/')}}/dashboard">
											<i class="fa fa-dashboard"></i>
											<span class="menu-title">
												<strong>Dashboard</strong>
												<span class="label label-success pull-right">Top</span>
											</span>
										</a>
									</li>
						
									<!--Menu list item-->
									<li>
										<a href="#">
											<i class="fa fa-table"></i>
											<span class="menu-title">Master</span>
											<i class="arrow"></i>
										</a>
						
										
										<ul class="collapse">
											<li><a href="{{url('/')}}/Ward-Details-List">Manage Ward/Mohlla</a></li>
											<li><a href="{{url('/')}}/Road-Width-List">Manage Roadwidth</a></li>
											<li><a href="{{url('/')}}/discount">Manage Discount</a></li>
											<li><a href="{{url('/')}}/manageCity">District/Nagarpalika</a></li>
											<li><a href="{{url('/')}}/Assets">Manage Assets</a></li>
											<li><a href="{{url('/')}}/ConstructionDetails">Manage Construction Year</a></li>
											
										</ul>
									</li>
									<li>
										<a href="{{url('/')}}/manageUser">
											<i class="fa fa-th"></i>
											<span class="menu-title">
												<strong>All Users</strong>
											</span>
											
										</a>
						            </li>
									<li>
										<a href="{{url('/')}}/assignWard">
											<i class="fa fa-at" aria-hidden="true"></i>
											<span class="menu-title">
												<strong>Assign Ward</strong>
											</span>
											
										</a>
						            </li>
						            
									<li>
										<a href="#">
											<i class="fa fa-table"></i>
											<span class="menu-title">New House Details</span>
											<i class="arrow"></i>
										</a>
						
										
										<ul class="collapse">
											<li><a href="{{url('/')}}/Survey-Details-NonVerified-List">Not-Verified</a></li>
											<li><a href="{{url('/')}}/Survey-Details-Verified-List">Verified</a></li>
											<li><a href="{{url('/')}}/Survey-Details-Rejected-List">Rejected</a></li>
											
										</ul>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-table"></i>
											<span class="menu-title">Personal Details</span>
											<i class="arrow"></i>
										</a>
						
										
										<ul class="collapse">
											<li><a href="{{url('/')}}/Personal-Details-NonVerified-List">Not-Verified</a></li>
											<li><a href="{{url('/')}}/Personal-Details-Verified-List">Verified</a></li>
											<li><a href="{{url('/')}}/Personal-Details-Rejected-List">Rejected</a></li>
											<li><a href="{{url('/')}}/Personal-Details-Pending-List">Pending</a></li>
										</ul>
									</li>	
									<li>
										<a href="#">
											<i class="fa fa-table"></i>
											<span class="menu-title">Other House Details</span>
											<i class="arrow"></i>
										</a>
						
										
										<ul class="collapse">
											<li><a href="{{url('/')}}/Other-House-Details-NonVerified-List">Not-Verified</a></li>
											<li><a href="{{url('/')}}/Other-House-Details-Verified-List">Verified</a></li>
											<li><a href="{{url('/')}}/Other-House-Details-Rejected-List">Rejected</a></li>
											<li><a href="{{url('/')}}/Other-House-Details-Pending-List">Pending</a></li>
										</ul>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-table"></i>
											<span class="menu-title">Assets Details</span>
											<i class="arrow"></i>
										</a>
						
										
										<ul class="collapse">
											<li><a href="{{url('/')}}/Assets-Details-NonVerified-List">Not-Verified</a></li>
											<li><a href="{{url('/')}}/Assets-Details-Verified-List">Verified</a></li>
											<li><a href="{{url('/')}}/Assets-Details-Rejected-List">Rejected</a></li>
										</ul>
									</li>
									
									<li>
										<a href="#">
											<i class="fa fa-edit"></i>
											<span class="menu-title">Reports</span>
											<i class="arrow"></i>
										</a>
						                <ul class="collapse">
											<li><a href="{{url('/')}}/SurveyReport">Survey Data Report</a></li>
											
										</ul>
										
									</li>
						
									<!--Menu list item-->
									<!--<li>
										<a href="#">
											<i class="fa fa-table"></i>
											<span class="menu-title">Create User</span>
											<i class="arrow"></i>
										</a>
						
										Submenu
										<ul class="collapse">
											<li><a href="{{url('/')}}/createUser">Portal Users</a></li>
											<li><a href="#">Android Users</a></li>
											
											
										</ul>-->
									</li>
						
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
			
			<!--ASIDE-->
			<!--===================================================-->
		</div>	

		

		<!-- FOOTER -->
		<!--===================================================-->
		<footer id="footer">

			<!-- Visible when footer positions are fixed -->
			<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
			<div class="show-fixed pull-right">
				<ul class="footer-list list-inline">
					<li>
						<p class="text-sm">SEO Proggres</p>
						<div class="progress progress-sm progress-light-base">
							<div style="width: 80%" class="progress-bar progress-bar-danger"></div>
						</div>
					</li>

					<li>
						<p class="text-sm">Online Tutorial</p>
						<div class="progress progress-sm progress-light-base">
							<div style="width: 80%" class="progress-bar progress-bar-primary"></div>
						</div>
					</li>
					<li>
						<button class="btn btn-sm btn-dark btn-active-success">Checkout</button>
					</li>
				</ul>
			</div>



			<!-- Visible when footer positions are static -->
			<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
			<div class="hide-fixed pull-right pad-rgt">Currently v2.2</div>



			<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
			<!-- Remove the class name "show-fixed" and "hide-fixed" to make the content always appears. -->
			<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

			<p class="pad-lft">&#0169; 2015 Your Company</p>



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


	<!--Demo script [ DEMONSTRATION ]-->
	<script src="{{url('/')}}/js/demo/nifty-demo.min.js"></script>


	<!--Specify page [ SAMPLE ]-->
	<script src="{{url('/')}}/js/demo/dashboard.js"></script>
	@yield('script')
</body>
</html>
