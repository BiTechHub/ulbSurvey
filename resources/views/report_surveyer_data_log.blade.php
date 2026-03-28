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
					<form method="post" >
						{{csrf_field()}}
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
										
										<input type ="text" Class="form-control" placeholder="From Date" id="datefrm" name="datefrom" readonly="readonly" />
										<span class="input-group-addon">To</span>
										
										<input type="text" Class="form-control" placeholder="To Date" id="dateto"  name="datetoo" readonly="readonly"/>
									</div>
                               </div>
							   </div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<select class="form-control" id="surveyer" name="surveyer">
											<option value="">--All Surveyor--</option>
											</select>

										</div>
									</div>
							
						  
						      
								  <div class="col-sm-2">
								      <div class="text-left">
								         <input class="btn btn-search btn-primary" value="Search" type="submit" name="save"  onclick="get_survey_report();">
										 
							          </div>
								  </div>
							  <!-- <div class="col-sm-2">
							      <div class="text-left">
							         <input class="btn btn-search btn-primary" value="Search" type="button" name="save"  onclick="get_survey_report();">
									 <input class="btn btn-search btn-primary" href="{{url('/')}}/ExportExcel" class="btn btn-search btn-primary" type="submit" Value="Export To Excel">
						          </div>
							  </div> -->
									     
							</div>	
													
						</div>
						</form>
					</div>	   
					  
					<div class="panel"s>
					  
						<div class="panel-body">
							<span style="color:red;" id="totalData"></span>
						  <div class="table-responsive">
							<table class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Sr.no.</th>
										<th>Nagar Palika</th>
										<th>Surveyer</th>
										<th>House Mapping</th>
										<th>Personal Details</th>
										<th>Assets Details</th>
									</tr>
								</thead>
								<tbody>
									@foreach($tabledata as $index=>$value)
									<tr>
										<td>{{$index+1}}</td>
										<td>{{$value['nagarpalika']}}</td>
										<td>{{$value['surveyer_name']}}</td>
										<td>{{$value['total_house_mapping']}}</td>
										<td>{{$value['survey_personal_details']}}</td>
										<td>{{$value['assets_details']}}</td>
									</tr>
									@endforeach
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
								msg=msg+'<option value="'+data[i].ward_number+'">'+data[i].ward_number+'->'+data[i].ward_name+'->'+data[i].mohalla_name+'</option>';
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
								msg=msg+'<option value="'+data[i].id+'">'+data[i].name+'->'+data[i].username+'</option>';
							}
							$("#surveyer").html(msg);
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
									'<td>'+data[i].status+'</td>'+
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

			