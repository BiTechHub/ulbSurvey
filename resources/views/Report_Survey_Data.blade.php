			@extends('master')
			@section('content');
			
			<!--CONTENT CONTAINER-->
				<!--===================================================-->
				<div id="content-container">
					
					<!--Page Title-->
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<div id="page-title">
						<h1 class="page-header text-overflow">Report</h1>

						
						
					</div>
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<!--End page title-->

					
			<!--===================================================-->
				<div id="page-content">
					
					<!-- Basic Data Tables -->
					<!--===================================================-->
					<div class="panel">
					{!!Form::Open(array('route'=>'export.personaldetailSurvey'))!!}
					  <div class="panel-body">
					       
                           <div class="row">
						      <div class="col-sm-4">
							      <div class="form-group">
								       <select class="form-control" name="nagarpalika" id="nagarpalika" onchange="get_ward_number(this.value);">
									      <option value="">--Select Nagar palika--</option>
									    </select>
									   
								  </div>
							   </div>
							   <div class="col-sm-4">
							      <div class="form-group">
								       <select class="form-control" name="wardnum" id="wardnum">
									      <option value="">--All Ward Number--</option>
									    </select>
									   
								  </div>
							   </div>
							   <div id="date_range" class="col-sm-4">
								   <div class="input-daterange input-group" id="datepicker">
										
										<input type ="text" Class="form-control" placeholder="From Date" id="datefrm" name="datefrom"/>
										<span class="input-group-addon">To</span>
										
										<input type="text" Class="form-control" placeholder="To Date" id="dateto"  name="datetoo"/>
									</div>
                               </div>
							   </div>
							   <div class="row">
							  @if(Session('user_type')=='Admin')
									<div class="col-sm-4">
								@else
									<div class="col-sm-4" style="display:none;">
								@endif
							      <div class="form-group">
								       <select class="form-control" id="surv" name="surv">
									      <option value="">--All Surveyor--</option>
									    </select>
									   
								  </div>
							   </div>
							
						  
						      @if(Session('user_type')=='Admin')
									<div class="col-sm-4">
								@else
									<div class="col-sm-4" style="display:none;">
								@endif
							      <div class="form-group">
								       <select class="form-control" id="sts"  name="sts">
											<option value="">---All Survey Data---</option>
											<option value="Pending">Pending Survey Data</option>
										    <option value="Completed">Completed Survey Data</option>
									    </select>
									   
								  </div>
							   </div>
								@if(Session('user_type')=='Admin')
									<div class="col-sm-2">
								@else
									<div class="col-sm-2" style="display:none;">
								@endif
							      <div class="form-group">
								       <select class="form-control" id="verified"  name="verified">
											<option value="">---All Data---</option>
											<option value="No">Pending</option>
										    <option value="Yes">Approved</option>
										    <option value="Rejected">Rejected</option>
									    </select>
									   
								  </div>
							   </div>
							   
							  <div class="col-sm-2">
							      <div class="text-left">
							         <input class="btn btn-search btn-primary" value="Search" type="button" name="save"  onclick="get_survey_report();">
									 <input class="btn btn-search btn-primary" href="{{url('/')}}/ExportExcel" class="btn btn-search btn-primary" type="submit" Value="Export To Excel">
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
							<span style="color:red;" id="totalData"></span>
						  <div class="table-responsive">
							<table class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Sr.no.</th>
										
										<th>Old House Number</th>
										<th>Old Owner Name</th>
										<th>Old Father Name</th>
										<th>House Number</th>
										<th>Owner Name</th>
										<th>Father Name</th>
										<th>Mobile Number</th>
										<th>Rented Person</th>
										<th>Total Area</th>
										<th>Constructed Area</th>
										<th>Business Area</th>
										<th>Common Area</th>
										<th>Number Of Floor</th>
										<th>Number Of Room</th>
										<th>Basement Area</th>
										<th>Ground Area</th>
										<th>Area of First Floor</th>
										<th>Area of Second Floor</th>
										<th>Area of Third Floor</th>
										<th>Length From East</th>
										<th>Length From West</th>
										<th>Length From North</th>
										<th>Length From South</th>
										<th>Localty From East</th>
										<th>Localty From West</th>
										<th>Localty From North</th>
										<th>Localty From South</th>
										<th>Nirman Varsh</th>
										<th>Sadak Ki Chaudai</th>
										<th>Nirman Ki Prakriti</th>
										<th>Farsh Ki Prakriti</th>
										<th>Document</th>
										<th>Status</th>
										<th>Date</th>

										 
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
				$(document).ready(function ()
				{
						$('#date_range .input-daterange').datepicker
					({
						format: "yyyy-mm-dd",
						todayBtn: "linked",
						autoclose: true,
						todayHighlight: true
					});
				});
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
					get_surveyor_list();
					$.ajax
					({
						url:"{{url('/')}}/getwardnum/"+value,
						dataType:'json',
						success:function(data)
						{
							var msg='<option value="">--All Ward Number--</option>';
							for(var i=0;i<data.length;i++)
							{
								msg=msg+'<option value="'+data[i].id+'">'+data[i].ward_number+'->'+data[i].ward_name+'->'+data[i].mohalla_name+'</option>';
							}
							$("#wardnum").html(msg);
						}
					});
				}
				function get_surveyor_list()
				{
					var city = $('#nagarpalika').val();
					//alert(city);
					$.ajax
					({
						url:"{{url('/')}}/getSurveyorlist/"+city,
						dataType:'json',
						success:function(data)
						{
							var msg='<option value="">--All Surveyor--</option>';
							for(var i=0;i<data.length;i++)
							{
								msg=msg+'<option value="'+data[i].username+'">'+data[i].name+'->'+data[i].username+'</option>';
							}
							$("#surv").html(msg);
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
					var surveyor=$('#surv').val();
					var fromDate=$('#datefrm').val();
					var toDate=$('#dateto').val();
					var status=$('#sts').val();
					var verified=$('#verified').val();
					var DataUri="city="+city+"&wardNumber="+wardNumber+"&surveyor="+surveyor+"&fromDate="+fromDate+"&toDate="+toDate+"&status="+status+"&verified="+verified;
					if(city=="" || city==null || city=='')
					{
						alert('Please choose city');
						return false;
					}
					//alert(DataUri);
					//return false;
					$("#searchData").html("");
					$.ajax
					({
						url:"{{url('/')}}/SurveyReportByStatus?"+DataUri,
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
									'<td>'+data[i].old_house_number+'</td>'+
									'<td>'+data[i].old_house_owner_name+'</td>'+
									'<td>'+data[i].old_house_father_name+'</td>'+
									'<td>'+data[i].house_number+'</td>'+
									'<td>'+data[i].name+'</td>'+
									'<td>'+data[i].father_name+'</td>'+
									'<td>'+data[i].mobile_number+'</td>'+
									'<td>'+data[i].rented_person+'</td>'+
									'<td>'+data[i].area_all+'X'+data[i].area_all_width+'</td>'+
									'<td>'+data[i].area_constructed+'X'+data[i].area_constructed_width+'</td>'+
									'<td>'+data[i].area_business+'X'+data[i].area_business_width+'</td>'+
									'<td>'+data[i].area_common_length+'X'+data[i].area_common_width+'</td>'+
									'<td>'+data[i].no_of_floor+'</td>'+
									'<td>'+data[i].no_of_room+'</td>'+
									'<td>'+data[i].basement_area+'X'+data[i].basement_area_width+'</td>'+
									'<td>'+data[i].ground_area+'X'+data[i].ground_area_width+'</td>'+
									'<td>'+data[i].first_area+'X'+data[i].first_area_width+'</td>'+
									'<td>'+data[i].second_area+'X'+data[i].second_area_width+'</td>'+
									'<td>'+data[i].third_area+'X'+data[i].third_area_width+'</td>'+
									'<td>'+data[i].length_east+'</td>'+
									'<td>'+data[i].length_west+'</td>'+
									'<td>'+data[i].length_north+'</td>'+
									'<td>'+data[i].length_south+'</td>'+
									'<td>'+data[i].locality_east+'</td>'+
									'<td>'+data[i].locality_west+'</td>'+
									'<td>'+data[i].locality_north+'</td>'+
									'<td>'+data[i].locality_south+'</td>'+
									'<td>'+data[i].nirmanVarsh+'</td>'+
									'<td>'+data[i].sadakKichoudai+'</td>'+
									'<td>'+data[i].NirmanPrakriti+'</td>'+
									'<td>'+data[i].FarshPrakriti+'</td>'+
									'<td>'+data[i].proof_type+'</td>'+
									'<td>'+data[i].status+'</td>'+
									'<td>'+data[i].created_at+'</td>'+
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

			