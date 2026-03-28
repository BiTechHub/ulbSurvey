@extends('layouts.main')
@section('main-section')
<div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
  <h6 class="font-semibold mb-0 dark:text-white">Pending Personal Details</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="index.html" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">Pending Personal Details</li>
  </ul>
</div>

    {{-- Page Content --}}
    <div class="grid grid-cols-12">
	   <div class="col-span-12">
            @if(session('message'))
            
            <div class="alert alert-success bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 border-success-600 border-start-width-4-px border-l-[3px] dark:border-neutral-600 px-6 py-[13px] mb-0 font-semibold text-lg rounded flex items-center justify-between" role="alert">
                        <div class="flex items-center gap-2">
                            <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                            {{ session('message') }}
                        </div>
                        <button class="remove-button text-success-600 text-2xl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button>
                    </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="panel-body">
               
            <div class="card border-0">
          <div class="card-header flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-3">
              
                <form method="POST" action="{{url('/')}}/SearchPersonalDetailsList">
					  		{{csrf_field()}}
					      <div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<select class="form-control" name="nagar_palika" id="nagarpalika" required="required">
									
											<option value="">--Select Nagar Palika--</option>
										
											<option value=""></option>
									
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
									 <input type="text" class="form-control" id="housenumber" name="house_number" placeholder="Enter House Number">	
									 <input type="hidden" class="form-control" name="search_type" value="No">	
									
									</div>
							  </div>
							  
							  <div class="col-sm-2">
							        
									<input class="btn btn-success text-uppercase" type="submit" value="search" id="search" name="search" >
									
										
								  
							    </div>
							 
						  </div>
						</form>
          
            </div>
            
            
          </div>
                <div class="card-body">
            <div class="table-responsive scroll-sm">
              <table class="table bordered-table mb-0">
                        <thead>
									<tr>
										<th>Sr.no.</th>
										
										<th>House Number</th>
										<th>Status</th>
										<th>Verified</th>
										<th>City</th>
										
										 
									</tr>
								</thead>
								<tbody>
									@foreach($surveydata as $index=>$value)
									<tr>
										<td>{{($surveydata->currentpage()-1) * $surveydata->perpage() + $index + 1 }}</td>
									    <td style="display:none">{{$value->survey_id}}</td>
										<td>{{$value->house_number}}</td>
										<td>{{$value->status}}</td>
										<td>{{$value->DataVerified}}</td>
										<td>{{$value->city}}</td>
									</tr>
									@endforeach
								</tbody>

                    </table>
                </div>
                {{ $surveydata->links() }}
            </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script_sec')
<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByoxJYY2T8F1D2QSF_IHrdWpAmKJ3JSrE&callback=initMap">
</script>
<script>
			function confirmData(id)
			{
				
				var flag=confirm('Are you sure to verify this data ?');
				if(flag)
				{
					var url="{{url('/')}}/verifyData?id="+id;
					window.location.assign(url);
				}
			}
			function RejectData(id)
			{
				swal("Write Rejection Reason here:", {
				  content: "input",
				})
				.then((value) => {
				  var url="{{url('/')}}/RejectPersonalDetails?id="+id+"&reason="+value;
				  //alert(url);
					window.location.assign(url);
				});
			}
			function searchdata()
		{
			var housenumber=$("#housenumber").val();
			var ngpalika=$("#nagarpalika").val();
			//alert(ngpalika);
			$("#searchData").html("");
			var uri="housenumber="+housenumber+"&ngpalika="+ngpalika;
			$.ajax
			({
				url:"{{url('/')}}/search-notvarified-house-details?"+uri,
				dataType:'json',
				success:function(data)
				{
					if(data=='')
					{
						$("#searchData").append('<tr>'+'<td colspan="33">No Record Found</td>'+'</tr>');
					}
					else
					{
						for(var i=0;i<data.length;i++)
						{
							$("#searchData").append('<tr>'+
										'<td>'+(i+1)+'</td>'+
										'<td>'+'<a  class="label label-primary" href="{{url('/')}}/UpdateDetails?id='+data[i].survey_id+'">Edit</a>'
										+'<a class="label label-danger" href="#" onclick="confirmData('+data[i].survey_id+');">Verify</a>'+'</td>'+
										'<td>'+data[i].house_number+'</td>'+
										'<td>'+data[i].name+'</td>'+
										'<td>'+data[i].father_name+'</td>'+
										'<td>'+data[i].mobile_number+'</td>'+
										'<td>'+data[i].rented_person+'</td>'+
										'<td>'+data[i].rented_person_name+'</td>'+
										'<td>'+data[i].area_all+'X'+data[i].area_all_width+'</td>'+
										'<td>'+data[i].area_constructed+'X'+data[i].area_constructed_width+'</td>'+
										'<td>'+data[i].area_business+'X'+data[i].area_business_width+'</td>'+
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
										'<td>'+data[i].DataVerified+'</td>'+
										'</tr>');
						}
					}
			    }
				
			});
		}
			function showImage(imageName,id)
			{
				$("#image").attr('src',imageName);
				$("#clock").attr('href',"javascript:RotateClockwise('"+id+"');");
				$("#anticlock").attr('href',"javascript:RotateAntiClockwise('"+id+"');");
			}

			function showDocument(imageName,id,proof)
			{
				$("#document_image").attr('src',imageName);
				$("#proof_type").html(proof);
				$("#documentclock").attr('href',"javascript:RotateDocumentClockwise('"+id+"');");
				$("#documentanticlock").attr('href',"javascript:RotateDocumentAntiClockwise('"+id+"');");
			}

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
			function RotateClockwise(id)
			{
				//alert(id);
				var flag=confirm('Are you sure want to rotate this photo ?');
				if(flag)
				{
					var url="{{url('/')}}/RotateClockwise/"+id;
					window.location.assign(url);
				}
			}
			function RotateAntiClockwise(id)
			{
				//alert(id);
				var flag=confirm('Are you sure want to rotate this photo ?');
				if(flag)
				{
					var url="{{url('/')}}/RotateAntiClockwise/"+id;
					window.location.assign(url);
				}
			}

			function RotateDocumentClockwise(id)
			{
				//alert(id);
				var flag=confirm('Are you sure want to rotate this photo ?');
				if(flag)
				{
					var url="{{url('/')}}/RotateDocumentClockwise/"+id;
					window.location.assign(url);
				}
			}
			function RotateDocumentAntiClockwise(id)
			{
				//alert(id);
				var flag=confirm('Are you sure want to rotate this photo ?');
				if(flag)
				{
					var url="{{url('/')}}/RotateDocumentAntiClockwise/"+id;
					window.location.assign(url);
				}
			}
	</script>
@endsection
