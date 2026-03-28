@extends('master')
@section('content');

<!--CONTENT CONTAINER-->
	<!--===================================================-->
	<div id="content-container">
		
		<!--Page Title-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<div id="page-title">
			<h1 class="page-header text-overflow">Lat Lng Report</h1>

			
			
		</div>
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<!--End page title-->

		
<!--===================================================-->
	<div id="page-content">
		
		<!-- Basic Data Tables -->
		<!--===================================================-->
		@if($tabledata==null)
		<div class="panel">
		  <div class="panel-body">
		  	<form method="POST" action="{{url('/')}}/LatLng">
		  		{{csrf_field()}}
		      <div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							<select class="form-control" name="nagar_palika" id="nagarpalika" required="required">
						
								<option value="Sitapur">Select Nagar Palika</option>
								@foreach($city as $value)
									<option value="{{$value->city}}">{{$value->city}}</option>
								@endforeach
							</select>
						</div>
				  </div>
			    <div class="col-sm-3">
						<div class="form-group">
							<select class="form-control" name="ward_number" id="ward_number">
						
								<option value="">--Select Ward Number --</option>
							
								@for($i=1;$i<=30;$i++)
									<option value="{{$i}}">{{$i}}</option>
								@endfor
						
							</select>
						</div>
				  </div>
			      <div class="col-sm-3">
				      <div class="form-group">
						 <select class="form-control" name="type" id="type">
								<option value="House">House</option>
								<option value="Assets">Assets</option>
							</select>
						</div>
				  </div>
				  
				  <div class="col-sm-2">
				        
						<input class="btn btn-success text-uppercase" type="submit" value="search" id="search" name="search" >
						
							
					  
				    </div>
				 
			  </div>
			</form>
		  </div>
		</div>
		@else

		<div class="panel">
			@if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
			<div class="panel-body">
			  <div class="table-responsive">
				<table class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Sr.no.</th>
							<th>{{$type}}</th>
							<th>Lat</th>
							<th>Lng</th>							 
						</tr>
					</thead>
					<tbody id="searchData">
						@foreach($tabledata as $index=>$value)
						<tr>
							<td>{{$index+1}}</td>
							@if($type=="House")
								<td>{{$value->house_number}}</td>
							@else
								<td>{{$value->assets_name}}</td>
							@endif
							<td>{{$value->lat}}</td>
							<td>{{$value->lng}}</td>
							
						</tr>
						@endforeach
					</tbody>
				</table>
				</div>
			</div>
		</div>
		@endif
		<!--===================================================-->
		<!-- End Striped Table -->
		
	</div>
	</div>
	<!--===================================================-->
	<!--End page content-->
@endsection

			