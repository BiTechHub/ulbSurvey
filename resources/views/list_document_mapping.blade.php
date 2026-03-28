@extends('master')
@section('content');

<!--CONTENT CONTAINER-->
	<!--===================================================-->
	<div id="content-container">
		
		<!--Page Title-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<div id="page-title">
			<h1 class="page-header text-overflow">Upload Document Report</h1>

			
			
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
		  	<form method="POST" >
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
							<select class="form-control" name="ward_number" id="ward_number" required="required">
						
								<option value="">--Select Ward Number --</option>
							
								@for($i=1;$i<=30;$i++)
									<option value="{{$i}}">{{$i}}</option>
								@endfor
						
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
							<th>House Number</th>
							<th>Ward Number</th>
							<th>City</th>
							<th>Document Type</th>
							<th>Document</th>
						</tr>
					</thead>
					<tbody id="searchData">
						@php($i=0)
						@foreach($tabledata as $index=>$value)
						@if($value->proof_name==null || $value->proof_name=="")
							@php($i++)
						@endif
							<tr>
						  	<td>{{$index+1}}</td>
								<td>{{$value->house_number}}</td>
								<td>{{$value->ward_number}}</td>
								<td>{{$value->city}}</td>
								@if($value->proof_name==null)
								<td>-------</td>
								<td>-------</td>
								@else
								<td>{{$value->proof_type}}</td>
								<td>{{$value->proof_name}}</td>
								@endif
							</tr>							
						@endforeach
					</tbody>
				</table>
				</div>
				<span>Total Blank Document {{$i}}</span>
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

			