		@extends('master')
		@section('content')
			<!--CONTENT CONTAINER-->
				<!--===================================================-->
				<div id="content-container">
					
					<!--Page Title-->
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<div id="page-title">
						<h1 class="page-header text-overflow">Update Family Member</h1>

						
						
					</div>
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<!--End page title-->

					<!--Page content-->
					<!--===================================================-->
					<div id="page-content">
						
					
						<div class="row">
							
								<div class="panel">
									
						
									<form method="post">
										{{csrf_field()}}
										<div class="panel-body">
											@if ($errors->any())
								                  <div class="alert alert-danger">
								                      <ul>
								                          @foreach ($errors->all() as $error)
								                              <li>{{ $error }}</li>
								                          @endforeach
								                      </ul>
								                  </div>
								              @endif
											<div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Name</label>
														<input type="text" name="member_name" value="{{$family_members->member_name}}" class="form-control">
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Father's Name</label>
														<input type="text" name="father_husband"  value="{{$family_members->father_husband}}" class="form-control">
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Date Of Birth</label>
														<input type="text" name="date_of_birth" value="{{$family_members->age}}" class="form-control">
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Aadhar Card Number</label>
														<input type="text" name="aadhar_num" value="{{$family_members->aadhar_num}}" class="form-control">
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Name</label>
														<input type="text" name="abhiyukti" value="{{$family_members->abhiyukti}}" class="form-control">
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Business</label>
														<input type="text" name="vyvasay" value="{{$family_members->vyvasay}}" class="form-control">
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Select Gender</label>
														<select class="form-control" name="gender">
														  <option value=''>--Select--</option>
														  <option @if($family_members->gender=="पुरुष") selected @endif value="पुरुष">पुरुष</option>
														  <option @if($family_members->gender=="महिला") selected @endif value="महिला">महिला</option>
														  <option @if($family_members->gender=="अन्य") selected @endif value="अन्य">अन्य</option>
														</select>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Relation</label>
														<select class="form-control" name="relation">
														<option value=''>--Select--</option>
														@foreach($relation as $value)
															@if($value->relation==$family_members->relation)
															<option selected="selected" value='{{$value->relation}}'>{{$value->relation}}</option>
															@else
															<option value='{{$value->relation}}'>{{$value->relation}}</option>
															@endif
														@endforeach
														</select>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Select Education</label>
														<select class="form-control" id="education" name="education">
															<option value=''>--Select--</option>
														@foreach($education as $value)
															@if($value->education==$family_members->education)
															<option selected="selected" value='{{$value->education}}'>{{$value->education}}</option>
															@else
															<option value='{{$value->education}}'>{{$value->education}}</option>
															@endif
														@endforeach
															
															
														</select>
													</div>
												</div>
												
												
											</div>
										</div>
										<div class="panel-footer text-center">
										@if($user_access[0]->fn_add=='Y')
											<input type="submit" name="Update" value="Update" class="btn btn-success">
										@endif
										</div>
									</form>
									<!--===================================================-->
									<!--End Block Styled Form -->
						
								</div>
							
							
						</div>
						
					</div>
					<!--===================================================-->
					<!--End page content-->


				</div>
				
				<!--===================================================-->
				<!--END CONTENT CONTAINER-->
            @endsection
			@section('script')
			<script>
				function city_by_state(value)
				{
					$.ajax
					({
						url:"{{url('/')}}/getcity/"+value,
						dataType:'json',
						success:function(data)
						{
							var msg='<option value="">--Select City--</option>';
							for(var i=0;i<data.length;i++)
							{
								msg=msg+'<option value="'+data[i].city+'">'+data[i].city+'</option>';
							}
							$("#city").html(msg);
						}
					});
				}
				</script>
				@endsection