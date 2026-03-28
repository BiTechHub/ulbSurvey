			@extends('master')
			@section('content');
			
			<!--CONTENT CONTAINER-->
				<!--===================================================-->
				<div id="content-container">
					
					<!--Page Title-->
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<div id="page-title">
						<h1 class="page-header text-overflow">Report Generate Tax</h1>

						
						
					</div>
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<!--End page title-->

					
			<!--===================================================-->
				<div id="page-content">
					
					<!-- Basic Data Tables -->
					<!--===================================================-->
					<div class="panel">
					{!!Form::Open(array('route'=>'export.exportTaxReport'))!!}
					  <div class="panel-body">
					       
                           <div class="row">
								<div class="col-sm-3">
								  <div class="form-group">
									   <select class="form-control" id="session" name="session">
											<option value="">--Select Financial Year--</option>
											@for($i=2018;$i<=date('Y');$i++)
											<option value="{{$i}}">{{$i}}-{{$i+1}}</option>
											@endfor
										</select>
									   
								  </div>
							   </div>
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
									      <option value="">--Select Ward Number--</option>
									    </select>
									   
								  </div>
							   </div>
							  
							  <div class="col-sm-3">
							      <div class="text-left">
							         <input class="btn btn-search btn-primary" value="Search" type="button" name="save"  onclick="get_survey_report();">
									 <input class="btn btn-search btn-primary" href="{{url('/')}}/export-Tax-Report" class="btn btn-search btn-primary" type="submit" Value="Export To Excel">
						          </div>
								</div> 
							</div>
							
													
						</div>
						{!!Form::Close()!!}
					</div>	   
					  
					<div class="panel" id="withoutData" style="display:none;">
						<div class="panel-body">
							<h2>No data found</h2>
						</div>
					</div>
					<div class="panel" id="withData" style="display:none;">
					  
						<div class="panel-body">
						<span style="color:red;" id="totalData"></span><br>
						  <div class="table-responsive">
							<table class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Sr.no.</th>
										<th>Nagar Palika Name</th>
										<th>Owner Name</th>
										<th>House Number</th>
										<th>Financial Session</th>
										<th>Floor</th>
										<th>House tax Rate</th>
										<th>House Tax</th>
										<th>Water tax Rate</th>
										<th>Water Tax </th>
										<th>Total Tax </th>
										<th>Overdue Tax </th>
										<th>Payable Tax </th>
									</tr>
								</thead>
								<tbody id="searchData">
								</tbody>
							</table>
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
			
			@section('script')
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
					//get_surveyor_list();
					$.ajax
					({
						url:"{{url('/')}}/getwardnum/"+value,
						dataType:'json',
						success:function(data)
						{
							var msg='<option value="">--Select Ward Number--</option>';
							for(var i=0;i<data.length;i++)
							{
								msg=msg+'<option value="'+data[i].ward_number+'">'+data[i].ward_number+'->'+data[i].ward_name+'->'+data[i].mohalla_name+'</option>';
							}
							$("#wardnum").html(msg);
						}
					});
				}
				
				
				function get_survey_report()
				{
					//alert();
					$("#withoutData").hide();
					$("#withData").hide();
					var city=$('#nagarpalika').val();
					var wardNumber=$('#wardnum').val();
					var session=$('#session').val();
					
					var DataUri="nagarpalika="+city+"&wardnum="+wardNumber+"&session="+session;
					
					if(session=="" || session==null || session=='')
					{
						alert('Please choose Financial Session.');
						return false;
					}
					if(city=="" || city==null || city=='')
					{
						alert('Please choose city');
						return false;
					}
					if(wardNumber=="" || wardNumber==null || wardNumber=='')
					{
						alert('Please choose Ward Number.');
						return false;
					}
					//alert(DataUri);
					//return false;
					$("#searchData").html("");
					$.ajax
					({
						url:"{{url('/')}}/get-Tax-Report?"+DataUri,
						dataType:'json',
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
									$("#searchData").append('<tr>'+
									'<td>'+(i+1)+'</td>'+
									'<td>'+data[i].city+'</td>'+
									'<td>'+data[i].name+'</td>'+
									'<td>'+data[i].house_number_1+'</td>'+
									
									'<td>'+data[i].session+'-'+(parseInt(data[i].session)+1)+'</td>'+
									'<td>'+data[i].no_of_floor+'</td>'+
									'<td>'+data[i].house_tax_percentage+'%</td>'+
									'<td>'+data[i].house_tax+'</td>'+
									'<td>'+data[i].water_tax_rate+'%</td>'+
									'<td>'+data[i].water_tax+'</td>'+
									'<td>'+data[i].sub_total+'</td>'+
									'<td>'+data[i].overdue_amount+'</td>'+
									'<td>'+data[i].due_amount+'</td>'+
									
									'</tr>');
								}
								$("#withoutData").slideUp(1000);
								$("#withData").slideDown(1000);
								$("#totalData").html("Total "+data.length+" records found..");
							}
						}
					});
				}
            </script>
			
			@endsection

			