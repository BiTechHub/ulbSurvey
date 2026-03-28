<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>BI:Admin Panel</title>


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


	<!--Demo [ DEMONSTRATION ]-->
	<link href="{{url('/')}}/css/demo/nifty-demo.min.css" rel="stylesheet">




	<!--SCRIPT-->
	<!--=================================================-->

	<!--Page Load Progress Bar [ OPTIONAL ]-->
	<link href="{{url('/')}}/plugins/pace/pace.min.css" rel="stylesheet">
	<script src="{{url('/')}}/plugins/pace/pace.min.js"></script>


	
		

</head>

<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

<body>
	<div id="container" class="cls-container">
		
		<!-- BACKGROUND IMAGE -->
		<!--===================================================-->
		<div id="bg-overlay" class="bg-img img-balloon"></div>
		
		
		<!-- HEADER -->
		<!--===================================================-->
		<div class="cls-header cls-header-lg">
			<div class="cls-brand">
				<a class="box-inline" href="#">
					<!-- <img alt="Nifty Admin" src="img/logo.png" class="brand-icon"> -->
					<span class="brand-title">GIS Survey<span class="text-thin">Admin</span></span>
				</a>
			</div>
		</div>
		<!--===================================================-->
		
		
		<!-- LOGIN FORM -->
		<!--===================================================-->
		<div class="cls-content">
			<div class="cls-content-sm panel">
				<div class="panel-body">
					<p class="pad-btm">Sign In to your account</p>
					{!! Form::open(array('route'=>'android.login')) !!}
						@if ($errors->any())
			                  <div class="alert alert-danger">
			                      <ul>
			                          @foreach ($errors->all() as $error)
			                              <li>{{ $error }}</li>
			                          @endforeach
			                      </ul>
			                  </div>
			              @endif
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-user"></i></div>
								{!! Form::text('username','',array('class'=>'form-control','placeholder'=>'Enter User Name')) !!}
								{!! Form::hidden('imei',$imei) !!}
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
								{!! FORM::password('password',array('class'=>'form-control','placeholder'=>'Enter Password')) !!}
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								{!! app('captcha')->display($attributes) !!}
							</div>
						</div>
						<div class="row">
							
							<div class="col-xs-12">
								<div class="form-group text-right">
								
								{!! Form::submit('Sign In',array('class'=>'btn btn-success text-uppercase'))!!}
								</div>
							</div>
						</div>
						
					{!! Form::close() !!}
				</div>
			</div>
			<!--<div class="pad-ver">
				<a href="#" class="btn-link mar-rgt">Forgot password ?</a>
				<a href="#" class="btn-link mar-lft">Create a new account</a>
			</div>-->
		</div>
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


	<!--Background Image [ DEMONSTRATION ]-->
	<script src="{{url('/')}}/js/demo/bg-images.js"></script>

	
	
		

</body>
</html>
