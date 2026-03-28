
@extends('master')
@section('content');

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				
				<div id="page-content">
					
				
					<div class="row">
						<div class="col-sm-12">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Print Tax Notice</h3>
								</div>
					
								<!--Block Styled Form -->
								<!--===================================================-->
								<form action="Tax-Payment-Bulk-List" method="post">
									{{csrf_field()}}
									<div class="panel-body">
										<div class="row">
										    <div class="col-sm-3">
												<div class="form-group">
													<label class="control-label">NagarPalika</label>
													<select class="form-control" name="nagar_palika" id="nagarpalika" >
								                         <option value="">--Select Nagar Plika--</option>
												    </select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label class="control-label">Ward Number</label>
													<select class="form-control" name="ward_number">
								                         <option value="">--Select Ward Number--</option>
														 @for($i=1;$i<=30;$i++)
								                         <option value="{{$i}}">{{$i}}</option>
													 @endfor
								                    </select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label class="control-label">City Name</label>
													<input type="text" class="form-control" required name="city_name" placeholder="नगर पंचायत / नगर पालिका परिषद्">
												</div>
											</div>
										</div>
										
									</div>
									<div class="panel-footer text-right">
									@if($user_access[0]->fn_view=='Y')
										{!!Form::submit('Print',array('class'=>'btn btn-danger text-uppercase'))!!}
									@endif
									</div>
								</form>
								<!--===================================================-->
								<!--End Block Styled Form -->
					
							</div>
						</div>
					
					</div>
				</div>
					
			</div>		
					
		
	

@endsection
			
@section('script')
<script>
	
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
		$('document').ready(function(e){
			city();
		});
	</script>
@endsection	

		

		

	
		
		



	
	

