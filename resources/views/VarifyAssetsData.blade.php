			@extends('master')
			@section('content');

			<!--CONTENT CONTAINER-->
				<!--===================================================-->
				<div id="content-container">

					<!--Page Title-->
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<div id="page-title">
						<h1 class="page-header text-overflow">Assets Data</h1>



					</div>
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<!--End page title-->


			<!--===================================================-->
				<div id="page-content">
					<div class="panel">

					  <div class="panel-body">

                            <div class="row">

						      <div class="col-sm-3">
							      <div class="form-group">
								       <select class="form-control" name="nagarpalika" id="nagarpalika" onchange="get_ward_number(this.value);">
									      <option value="">--Select Nagar palika--</option>
									    </select>

								  </div>
							   </div>

							   <div class="col-sm-3">
							      <div class="form-group">
								       <select class="form-control" name="wardnum" id="wardnum">

									    </select>

								  </div>
							   </div>
							  <div class="col-sm-3">
							      <div class="form-group">
								       <select class="form-control" name="assets" id="assets">
									      <option value="0">--Select Assets--</option>
									    </select>

								  </div>
							   </div>
							  <div class="col-sm-3">
							      <div class="text-left">
							         <input type="button" class="btn btn-search btn-primary" value="Search" name="search" id="search" onclick="searchassets();">


						          </div>
								</div>
							</div>


						</div>

					</div>
					<!-- Basic Data Tables -->
					<!--===================================================-->
					<div class="panel" id="withoutData" style="display:none;">
						<div class="panel-body">
							<h2>No data found</h2>
						</div>
					</div>
					<div class="panel" id="withData">
						<div class="panel-body">
						   <span style="color:red;" id="totalData"></span>
						  <div class="table-responsive">
							<table class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Sr.no.</th>
										<th>Assets Name</th>
										<th>Landmark</th>
										<th>Ward Number</th>
										<th>Nagarpalika</th>
										<th>Address</th>

										<th>Entry By</th>
										<th>Action</th>

									</tr>
								</thead>
								<tbody id="searchData">
									@foreach($assets_detail_varify as $index=>$value)
									<tr>
										<td>{{($assets_detail_varify->currentpage()-1) * $assets_detail_varify->perpage() + $index + 1 }}</td>
										<td style="display:none">{{$value->id}}</td>
										<td>{{$value->assets_name}}</td>
										<td>{{$value->landmark}}</td>
										<td>{{$value->ward_number}}</td>
										<td>{{$value->city}}</td>
										<td>{{$value->address}}</td>
										<td>{{$value->inserted_name}}</td>

										<td><a class="label label-primary" href="#" data-target="#demo-default-modal" data-toggle="modal" onclick="showImage('{{url('/')}}/new_gis/upload/assets/{{$value->photo}}')">View</a>
										<a class="label label-primary" href="#" data-target="#map-default-modal" data-toggle="modal" onclick="showMap({{$value->lat}},{{$value->lng}})">View On Map</a></td>



									</tr>
									@endforeach
								</tbody>
							</table>
							</div>
							{{$assets_detail_varify->links()}}
						</div>
					</div>
					<!--===================================================-->
					<!-- End Striped Table -->

				</div>
				</div>
	<div class="modal fade"  id="demo-default-modal" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">

				<!--Modal header-->
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button">
					<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title"><span id="address">Assets Picture</span></h4>
				</div>

				<!--Modal body-->
				<div class="modal-body">
				<img src="img/av1.png" id="image" style="width:100%;height:450px">
				</div>

				<!--Modal footer-->
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>

				</div>
			</div>
		</div>
	</div>
	<div class="modal fade"  id="map-default-modal" role="dialog" tabindex="-1" aria-labelledby="map-default-modal" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">

				<!--Modal header-->
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button">
					<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title"><span id="address">Map View</span></h4>
				</div>

				<!--Modal body-->
				<div class="modal-body">
					<div style="height:500px;width:100%;" id="map"></div>
				</div>

				<!--Modal footer-->
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>

				</div>
			</div>
		</div>
	</div>
				<!--===================================================-->
				<!--End page content-->
			@endsection

			@section('script')

			<script>
			 $(document).ready(function(e){
				city();
				assets();
				//setHouse();

				});
			function assets()
				{

					$.ajax
					({
						url:"{{url('/')}}/get-Assets",
						dataType:'json',
						success:function(data)
						{
							var msg='<option value="All">--All Assets--</option>';
							for(var i=0;i<data.length;i++)
							{
								msg=msg+'<option value="'+data[i].assets_name+'">'+data[i].assets_name+'</option>';
							}
							$("#assets").html(msg);
						}
					});
				}
				function city()
				{

					$.ajax
					({
						url:"{{url('/')}}/getnagarpalika",
						dataType:'json',
						success:function(data)
						{
							var msg='<option value="">--Select Nagar Palika--</option>';
							for(var i=0;i<data.length;i++)
							{
								msg=msg+'<option value="'+data[i].city+'">'+data[i].city+'</option>';
							}
							$("#nagarpalika").html(msg);
						}
					});
				}
				function get_ward_number(value)
				{
					//get_surveyor_list();
					$.ajax
					({
						url:"{{url('/')}}/getwardnum/"+value,
						dataType:'json',
						success:function(data)
						{
							var msg='<option value="All">--Select Ward Number--</option>';
							for(var i=0;i<data.length;i++)
							{
								msg=msg+'<option value="'+data[i].ward_number+'">'+data[i].ward_number+'->'+data[i].ward_name+'->'+data[i].mohalla_name+'</option>';
							}
							$("#wardnum").html(msg);
						}
					});
				}

			function showImage(imageName)
			{
				//alert(imageName);
				$("#image").attr('src',imageName);
			}
			function showMap(lat1,lng1)
			{
				var myLatLng = {lat: lat1, lng: lng1};
				initMap(myLatLng);
			}
			function initMap(myLatLng) {


				var map = new google.maps.Map(document.getElementById('map'), {
				  zoom: 20,
				  center: myLatLng,
				  mapTypeId: 'satellite'
				});

				var marker = new google.maps.Marker({
				  position: myLatLng,
				  map: map,
				  title: 'Hello World!'
				});
			  }
			function confirmData(id)
			{
				//alert(id);
				var flag=confirm('Are you sure to verify this data ?');
				if(flag)
				{
					var url="{{url('/')}}/verify?id="+id;
					window.location.assign(url);
				}
			}
			function RejectDatat(id)
			{
				//alert(id);
				var flag=confirm('Are you sure want to reject This Data ?');
				if(flag)
				{
					var url="{{url('/')}}/RejectedSurveyData?id="+id;
					window.location.assign(url);
				}
			}
			function searchassets()
			{
				var city=$("#nagarpalika").val();
				var ward_number=$("#wardnum").val();
				var assets=$("#assets").val();
				$("#searchData").html("");
				$.ajax({
						url:"{{url('/')}}/Assets-Data-Map/"+city+"/"+ward_number+"/"+assets,
						dataType:"JSON",
						success:function(data)
						{
							console.log(data);
							if(data.length==0 || data=='no')
							{
								$("#withoutData").slideDown(1000);
								$("#withData").slideUp(1000);
							}
							else
							{
								for(var i=0;i<data.length;i++)
								{
									var uri="{{url('/')}}/new_gis/upload/assets/"+data[i].photo;

									$("#searchData").append('<tr>'+
										'<td>'+(i+1)+'</td>'+
										'<td style="display:none">'+data[i].id+'</td>'+
										'<td>'+data[i].assets_name+'</td>'+
										'<td>'+data[i].landmark+'</td>'+
										'<td>'+data[i].ward_number+'</td>'+
										'<td>'+data[i].city+'</td>'+
										'<td>'+data[i].address+'</td>'+
										'<td>'+data[i].inserted_name+'</td>'+

								'<td>'+'<a class="label label-primary" href="#" data-target="#demo-default-modal" data-toggle="modal" onclick="showImage('+"'"+uri+"'"+')">View</a>'+
								'<a class="label label-primary" href="#" data-target="#map-default-modal" data-toggle="modal" onclick="showMap('+data[i].lat+','+data[i].lng+')">View On Map</a>'+'</td>'+
										'</tr>');
								}
									$("#withoutData").slideUp(1000);
									$("#withData").slideDown(1000);
									$("#totalData").html("Total "+data.length+" records found...");
							}
						}


					});
			}
			</script>

			@endsection
