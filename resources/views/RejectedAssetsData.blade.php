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

					<!-- Basic Data Tables -->
					<!--===================================================-->
					<div class="panel">
						<div class="panel-body">
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
										<th>City</th>
										<th>Entry By</th>

									</tr>
								</thead>
								<tbody>
									@foreach($assets_detail_rejected as $index=>$value)
									<tr>
										<td>{{($assets_detail_rejected->currentpage()-1) * $assets_detail_rejected->perpage() + $index + 1 }}</td>
										<td style="display:none">{{$value->id}}</td>
										<td>{{$value->assets_name}}</td>
										<td>{{$value->landmark}}</td>
										<td>{{$value->ward_number}}</td>
										<td>{{$value->city}}</td>
										<td>{{$value->address}}</td>
										<td>{{$value->inserted_name}}</td>

										<td><a class="label label-primary" href="#" data-target="#demo-default-modal" data-toggle="modal" onclick="showImage('{{url('/')}}/new_gis/upload/assets/{{$value->photo}}')">View</a>
										<a class="label label-primary" href="#" data-target="#map-default-modal" data-toggle="modal" onclick="showMap({{$value->lat}},{{$value->lng}})">View On Map</a>



									</tr>
									@endforeach
								</tbody>
							</table>
							</div>
							{{$assets_detail_rejected->links()}}
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
			function showImage(imageName)
			{
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
			</script>

			@endsection
