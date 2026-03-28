@extends('master')
@section('title')
	<title>Update Image</title>
@endsection
@section('content');

<!--CONTENT CONTAINER-->
	<!--===================================================-->
	<div id="content-container">

		<!--Page Title-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<div id="page-title">
			<h1 class="page-header text-overflow">Update Image</h1>
		</div>
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<!--End page title-->

		<!--===================================================-->
		<div id="page-content">
			<!-- Basic Data Tables -->
			<!--===================================================-->
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div class="panel">
					<div class="panel-body">
						<form method="POST" action="{{url('/')}}/Update-Image" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="row">
								@if ($errors->any())
					                  <div class="alert alert-danger">
					                      <ul>
					                          @foreach ($errors->all() as $error)
					                              <li>{{ $error }}</li>
					                          @endforeach
					                      </ul>
					                  </div>
					              @endif
								<div class="col=sm-12">
									<div class="form-group">
										<label class="control-label">House Number</label>
										<input value="{{$survey_step_1->house_number}}" type="text" class="form-control">
									</div>
									<div class="form-group">
										<label class="control-label">City</label>
										<input value="{{$survey_step_1->city}}" type="text" class="form-control">
									</div>
									<div class="form-group">
										<label class="control-label">Image</label>
										<input name="image_name" value="{{$survey_step_1->house_number}}" accept="image/png" type="file" class="form-control">
									</div>
		                        	<div class="form-group">
										<input name="house_id" value="{{$survey_step_1->id}}" type="hidden">
										<input class="btn btn-primary" value="Update" type="submit">
		            				</div>
		            			</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!--===================================================-->
			<!-- End Striped Table -->

		</div>
	</div>
	<!--===================================================-->
	<!--End page content-->
@endsection
