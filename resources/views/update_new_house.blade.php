    @extends('master')
	@section('content');

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				<!--Page Title-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<div id="page-title">
					<h1 class="page-header text-overflow">Update New House Details</h1>
				</div>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End page title-->
				<!--Breadcrumb-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Update New House Details</a></li>
				</ol>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End breadcrumb-->
				<!--Page content-->
				<!--===================================================-->
				<div id="page-content">
					
				  {!!Form::Open(array('route'=>'update.Newhouse'))!!}
					<div class="row">
						<div class="col-lg-12">
							<div class="panel">
								<div class="panel-body">
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">House Number</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$data[0]->house_number}}" autocomplete="off" class="form-control" id="makan_no" name="makan_no">
											<input type="text" readonly value="{{$data[0]->id}}" autocomplete="off" class="form-control" id="surv_id" name="surv_id" style="display:none">
										</div>
									</div>
								
									<div class="col-lg-6">
									    <div class="form-group">
											<label class="control-label">Ward Number</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>																				
												<input type="text" value="{{$data[0]->ward_number}}" autocomplete="off" class="form-control" id="ward_num" name="ward_num" placeholder="Enter Full Name" readonly>	
										</div>	
									</div>
									
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">Basement</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$data[0]->basement}}" autocomplete="off" class="form-control" id="basement" name="basement" placeholder="Enter Full Name">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">Number Of floor</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$data[0]->no_of_floor}}" autocomplete="off" class="form-control" id="nof" name="nof" placeholder="Enter Full Name">
										</div>
									</div>
									
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">House Type</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<select class="form-control" id="house_type" name="house_type" >
												<option value=""></option>
												<option @if($data[0]->house_type=="Residential") selected @endif value="Residential">Residential</option>
												<option @if($data[0]->house_type=="Commercial") selected @endif value="Commercial">Commercial</option>
												<option @if($data[0]->house_type=="Goverenment") selected @endif value="Goverenment">Goverenment</option>
												<option @if($data[0]->house_type=="Plot") selected @endif value="Plot">Plot</option>
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">Ward Name</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<select class="form-control" id="ward_name" name="ward_name" >
												<option value=""></option>
												@foreach($ward_details as $value)
													@if($data[0]->ward_name==$value->ward_name)
														<option selected  value="{{$value->ward_name}}">{{$value->ward_name}}</option>
													@else
														<option value="{{$value->ward_name}}">{{$value->ward_name}}</option>
													@endif
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">Mohalla Name</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<select class="form-control" id="mohalla" name="mohalla" >
												<option value=""></option>
												@foreach($ward_details as $value)
													@if($data[0]->mohalla==$value->mohalla_name)
														<option selected  value="{{$value->mohalla_name}}">{{$value->mohalla_name}}</option>
													@else
														<option value="{{$value->mohalla_name}}">{{$value->mohalla_name}}</option>
													@endif
												@endforeach
											</select>
										</div>
									</div>
									
									
									<div class="col-lg-6">
									
										<div class="form-group">
											<label class="control-label">Nagar Palika</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$data[0]->city}}" autocomplete="off" class="form-control" id="lengthpura" name="lengthpura" placeholder="Length" readonly>
											
										</div>
									</div>
									
                                </div>
							</div>
						</div>
						
					</div>					
					
				
					<input type="hidden" name="id" value="" >
					<div align="center">
					@if($user_access[0]->fn_update=='Y')
						<input type='hidden' id='city' value='{{$data[0]->city}}'>
					<input class="btn btn-primary" value="Update House Details" name="update" type="submit">
                   @endif
					
					
					<input class="btn btn-primary" value="Reset" type="reset"></div>
				 {!!Form::Close()!!}
				</div>
				<!--===================================================-->
				<!--End page content-->
				
			</div>
			

	@endsection
	