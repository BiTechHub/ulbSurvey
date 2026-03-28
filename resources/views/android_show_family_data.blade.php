<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!--=================================================-->
	<!--Bootstrap Stylesheet [ REQUIRED ]-->
	<link href="{{url('/')}}/css/bootstrap.min.css" rel="stylesheet">
	<!--Nifty Stylesheet [ REQUIRED ]-->
	<link href="{{url('/')}}/css/nifty.min.css" rel="stylesheet">
	
	<!--Font Awesome [ OPTIONAL ]-->
	<link href="{{url('/')}}/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!--Bootstrap Select [ OPTIONAL ]-->
	<link href="{{url('/')}}/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
	<!--Bootstrap Table [ OPTIONAL ]-->
	<link href="{{url('/')}}/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
	
	<!--SCRIPT-->
	<!--=================================================-->
	<!--Page Load Progress Bar [ OPTIONAL ]-->
	<link href="{{url('/')}}/plugins/pace/pace.min.css" rel="stylesheet">
	<script src="{{url('/')}}/plugins/pace/pace.min.js"></script>
</head>
<body>
	<div id="container" class="effect">
		
		<!--NAVBAR-->
		<!--===================================================-->
		
		<!--===================================================-->
		<!--END NAVBAR-->
		
					
					
					
					
					<!--Tiles - Bright Version-->
					<!--===================================================-->
					
					<!--Sort & Format Column-->
					<!--===================================================-->
					<div class="panel-group accordion" id="demo-acc-info-outline">
								
								@if($family_members!=null)
									<div align="center"><a href="#" class="btn btn-purple btn-rounded">Today Total family member : {{sizeof($family_members)}} </a></div>
								@foreach($family_members as $value)
								<div class="panel panel-bordered panel-success">
									<!--Accordion title-->
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-parent="#demo-acc-info-outline" data-toggle="collapse" href="#vehicle{{$value->id}}">
												{{$value->member_name}} - {{$value->gender}}
											</a>
										</h4>
									</div>
								
									<!--Accordion content-->
									<div class="panel-collapse collapse" id="vehicle{{$value->id}}">
										<div class="panel-body">
											पिता / पति :- {{$value->father_husband}}<br/>
											रिश्ता:- {{$value->relation}}<br/>									
											जन्म की तारीख:- {{$value->age}}<br/>
											व्यापार:- {{$value->vyvasay}}<br/>											
											योग्यता :- {{$value->education}}<br/>
											नगर पलिका:- {{$value->nagarpalika}}<br/>
										</div>
									</div>
								</div>
								@endforeach
								@else
								<div class="panel panel-bordered panel-success">
									<!--Accordion title-->
									<div class="panel-heading">
										<h4 class="panel-title">
											डेटा नहीं मिला
										</h4>
									</div>
								</div>
								@endif
							</div>
					
					<!--===================================================-->
					
					
	
		<button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
		<!--===================================================-->
	</div>
	<!--===================================================-->
	<!-- END OF CONTAINER -->
	
	<!--===================================================-->
	<!-- END SETTINGS -->
	
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
	<!--Switchery [ OPTIONAL ]-->
	<script src="{{url('/')}}/plugins/switchery/switchery.min.js"></script>
	
	<script src="{{url('/')}}/plugins/bootbox/bootbox.min.js"></script>
	<!--Bootstrap Select [ OPTIONAL ]-->
	<script src="{{url('/')}}/plugins/bootstrap-select/bootstrap-select.min.js"></script>
	<!--X-editable [ OPTIONAL ]-->
	<script src="{{url('/')}}/plugins/x-editable/js/bootstrap-editable.min.js"></script>
	<!--Bootstrap Table [ OPTIONAL ]-->
	<script src="{{url('/')}}/plugins/bootstrap-table/bootstrap-table.min.js"></script>
	<!--Bootstrap Table Extension [ OPTIONAL ]-->
	<script src="{{url('/')}}/plugins/bootstrap-table/extensions/editable/bootstrap-table-editable.js"></script>
	<!--Bootstrap Table Sample [ SAMPLE ]-->
	<script src="{{url('/')}}/js/demo/tables-bs-table.js"></script>

 
</body>
</html>