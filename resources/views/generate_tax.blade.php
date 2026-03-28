
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
									<h3 class="panel-title">Generate Tax &nbsp;&nbsp;&nbsp;&nbsp;<span id="msg" style="color:red;"></span></h3>
								</div>
					
								<!--Block Styled Form -->
								<!--===================================================-->
									<div class="panel-body">
										<div class="row">
										<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Select Financial Session</label>
													<select class="form-control" name="financial_year" id="financial_year">
								                         <option value="">--Select--</option>
								                         @for($i=2018;$i<=date('Y');$i++)
														<option value="{{$i}}">{{$i}}-{{$i+1}}</option>
														@endfor
													</select>
												</div>
											</div>
										    <div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Nagar Palika</label>
													<select class="form-control" name="ngrpalika" id="nagarpalika" onchange="get_ward_number(this.value);">
								                        <option value="">--Select Nagar Palika--</option>
													</select>
								                </div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="control-label">Select Ward Number</label>
													<select class="form-control" name="wardnum" id="wardnum" >
								                         <option value="">--Select Ward Number--</option>
													</select>
												</div>
											</div>
											
											
										</div>
										
									</div>
									<div class="panel-footer text-right">
										<input type="button" class="btn btn-search btn-primary" value="Generate Tax" onclick="generateTax();">
									</div>
								<!--===================================================-->
								<!--End Block Styled Form -->
					
							</div>
						</div>
					
					</div>
				</div>
					
			</div>		
					
		
	@endsection
	
	@section('script');
	<script>
		$('document').ready(function(e){
			city();
		});
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
			
			$.ajax
			({
				url:"{{url('/')}}/getwardnum/"+value,
				dataType:'json',
				success:function(data)
				{
					var msg='<option value="">--Select Ward Number--</option>';
					for(var i=0;i<data.length;i++)
					{
						msg=msg+'<option value="'+data[i].id+'">'+data[i].ward_number+'->'+data[i].ward_name+'->'+data[i].mohalla_name+'</option>';
					}
					$("#wardnum").html(msg);
				}
			});
		}
		function generateTax()
		{
			$("#msg").html("");
			var city=$("#nagarpalika").val();
			var wardNumber=$("#wardnum").val();
			var session=$("#financial_year").val();
			if(city=="" || city==NaN || city==null)
			{
				$("#msg").html("Please choose city name");
				return false;
			}
			else if(wardNumber=="" || wardNumber==NaN || wardNumber==null)
			{
				$("#msg").html("Please choose Ward Number");
				return false;
			}
			else if(session=="" || session==NaN || session==null)
			{
				$("#msg").html("Please choose session");
				return false;
			}
			$("#msg").html("Please wait while we generate your tax.Please do not close this window or do not open any link");
			$.ajax
			({
				url:"{{url('/')}}/Generate-Tax-Submit",
				type:"get",
				data:"ngrpalika="+city+"&wardnum="+wardNumber+"&financial_year="+session,
				success:function(data)
				{
					$("#msg").html("Total "+data+" tax generated successfully");
				}
			});
		}
		
	</script>

@endsection
			
			

		

		

	
		
		



	
	

