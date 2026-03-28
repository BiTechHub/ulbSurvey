    @extends('master')
	@section('content');

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				<!--Page Title-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<div id="page-title">
					<h1 class="page-header text-overflow">Assets Details</h1>
				</div>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End page title-->
				<!--Breadcrumb-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Assets Details</a></li>
				</ol>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End breadcrumb-->
				<!--Page content-->
				<!--===================================================-->
				<form method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
				<div id="page-content">
					
				  	@if ($errors->any())
	                  <div class="alert alert-danger">
	                      <ul>
	                          @foreach ($errors->all() as $error)
	                              <li>{{ $error }}</li>
	                          @endforeach
	                      </ul>
	                  </div>
	              @endif
	              @if(isset($msg))
	                  <div class="alert alert-info">
	                      <ul>
	                           <li>{{ $msg }}</li>
	                      
	                      </ul>
	                  </div>
	              @endif
					<div class="row">
						<div class="col-lg-6">
							<div class="panel">
								<div class="panel-body">
									<div class="form-group">
										<label class="control-label">Nagar Palika</label>
										<select class="form-control" id="city" name="city" >
											<option value=""></option>
											@foreach($nagar_palika as $value)
												@if($assets_details->city==$value->city)
												<option selected="selected" value="{{$value->city}}">{{$value->city}}</option>
												@else
												<option value="{{$value->city}}">{{$value->city}}</option>
												@endif
											@endforeach
										</select>
									</div>
								
									<div class="form-group">
										<label class="control-label">Ward Number</label>
										<select class="form-control" id="ward_number" name="ward_number">
											<option value=""></option>
											@for($i=1;$i<=50;$i++)
												@if($assets_details->ward_number==$i)
												<option selected="selected" value="{{$i}}">Ward {{$i}}</option>
												@else
												<option value="{{$i}}">Ward {{$i}}</option>
												@endif
											@endfor
										</select>
									</div>
								
									<div class="form-group">
										<label class="control-label">Assets Type</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
										<select class="form-control" id="assets_type" name="assets_type" >
											<option value=""></option>
											@foreach($assets as $value)
											@if($assets_details->assets_name==$value->assets_name)
												<option selected="selected" value="{{$value->assets_name}}">{{$value->assets_name}}</option>
											@else
												<option value="{{$value->assets_name}}">{{$value->assets_name}}</option>
											@endif
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label class="control-label">Landmark</label><font style="color:red">*&nbsp;&nbsp;<span id="errlandmark"></span></font>
										<input type="text" autocomplete="off" class="form-control" id="landmark" name="landmark" value="{{$assets_details->landmark}}">
									</div>
								</div>
								
							</div>
						</div>
						<div class="col-lg-6">
							<div class="panel">
								<div class="panel-body">
									<div class="form-group">
										<label class="control-label">Lattitude</label>
										<input type="text" autocomplete="off" readonly="readonly" onblur="getAddress();" class="form-control" id="lat" name="lat" value="{{$assets_details->lat}}" >
									</div>
								
									<div class="form-group">
										<label class="control-label">Longitude</label>
										<input type="text" autocomplete="off" readonly="readonly" onblur="getAddress();" class="form-control" id="lng" name="lng" value="{{$assets_details->lng}}">
										<input type="hidden" autocomplete="off" class="form-control" id="address" name="address" value="{{$assets_details->address}}">
									</div>
								
									<div class="form-group">
										<label class="control-label">Assets Photo</label>
										<input type="file" autocomplete="off" class="form-control" id="house_photo" name="assets_photo" accept="image/jpeg">
									</div>
								</div>
							</div>
						</div>
						
								
					
						<div class="row" >
							<div class="col-lg-12">
								<div align="center">
									<input class="btn btn-primary" value="Update Assets Details" name="update" type="submit">
									<input class="btn btn-primary" value="Search Lattitude Longitude" type="button" id="mapBtn" onclick="showMapDiv();">
								</div>
							</div>
						</div>
				 
					</div>
					<br><br>
					<div class="row" style="display: none;" id="mapdiv">
						<div class="col-lg-12">
							<div class="panel">
								<div class="panel-body">
									<div class="col-lg-12">
										<div class="form-group">
											<label class="control-label">Search Address</label>
											<input type="text" onblur="getSearchLatLng();" onchange="getSearchLatLng();" id="searchAddress" name="searchAddress" class="form-control" value="{{$assets_details->address}}">
										</div>
									</div>
									<div class="col-lg-12">
										<div id="map_canvas" style="height:400px;"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>		
				</form>
				<!--===================================================-->
				<!--End page content-->
				
			</div>
			

	@endsection
	@section('script')
	<script type="text/javascript">
	var lat="{{$assets_details->lat}}";
	var lng="{{$assets_details->lng}}";
	var marker;
	var directionsService = new google.maps.DirectionsService();
	
	$(document).ready(function(e){
		$("#searchAddress").placepicker();
		initialize();
	});

	function initialize() {
		directionsDisplay = new google.maps.DirectionsRenderer();
		var lucknow = new google.maps.LatLng(lat,lng);
		var myOptions = {
			zoom:16,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: lucknow
		}

		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		directionsDisplay.setMap(map);
		marker = new google.maps.Marker({
			map: map,
			draggable: true,
			animation: google.maps.Animation.DROP,
			position: {lat: lat, lng: lng}
		});
		marker.addListener('drag', toggleBounce);
		marker.addListener('dragend', getAddress);
	}
	function toggleBounce() {
		var lat = marker.getPosition().lat();
		var lng = marker.getPosition().lng();
		$("#lat").val(lat);
		$("#lng").val(lng);
	}

	function getAddress()
	{
		var lat=$("#lat").val();
		var lng=$("#lng").val();
		$.ajax({
			url:"https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyByoxJYY2T8F1D2QSF_IHrdWpAmKJ3JSrE&latlng="+lat+","+lng+"&sensor=true",
			dataType:"json",
			success:function(data)
			{
				var dt=data.results;
				$("#searchAddress").val(dt[0].formatted_address);
				$("#address").val(dt[0].formatted_address);
				//console.log();
				latlng = new google.maps.LatLng(lat, lng);
				marker.setPosition(latlng);
				map.setCenter(latlng);
			}
		});
	}
	function getSearchLatLng()
	{
		var start=$("#searchAddress").val();
		$.ajax({
			url:"https://maps.googleapis.com/maps/api/geocode/xml?key=AIzaSyByoxJYY2T8F1D2QSF_IHrdWpAmKJ3JSrE&address="+start+"&sensor=false",
			type:"GET",
			//dataType:"JSON",
			success: function(data)
			{
				var xmlData = $(data).find("status").text();
				console.log(xmlData);
				if(xmlData=='OK')
				{
					var lat = $(data).find('lat');
					var startlat=lat[0].innerHTML;
					var lng = $(data).find('lng');
					var startlng=lng[0].innerHTML;
					latlng = new google.maps.LatLng(startlat, startlng);
					marker.setPosition(latlng);
					map.setCenter(latlng);
					//''transition(startlat, startlng)
				}
			}
		});
	}


	function showMapDiv()
	{
		$("#mapBtn").val("Hide");
		$("#mapBtn").attr("onclick","hideMapDiv();");
		$("#mapdiv").slideDown(500);
	}

	function hideMapDiv()
	{
		$("#mapBtn").val("Search Lattitude Longitude");
		$("#mapBtn").attr("onclick","showMapDiv();");
		$("#mapdiv").slideUp(500);
	}

	function enableHouse(data)
	{
		if(data=="" || data==null || data==" ")
		{
			$("#house_number").attr("readonly","readonly");
		}
		else
		{
			$("#house_number").removeAttr("readonly");
		}
	}

	function checkHouse(housenumber)
	{
		var ngpalika=$("#city").val();
		$.ajax
			({
				url:"{{url('/')}}/checkHouseNumber",
				data:"housenumber="+housenumber+"&ngpalika="+ngpalika,
				success:function(data)
				{
					if(data>0)
					{
						alert("House number "+housenumber+" already registered in "+ngpalika);
						$("#house_number").val("");
					}
				}
			});
	}

</script>
@endsection