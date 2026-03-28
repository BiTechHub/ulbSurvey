			@extends('master')
			@section('content');
			
			<!--CONTENT CONTAINER-->
				<!--===================================================-->
				<div id="content-container">
					
					<!--Page Title-->
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<div id="page-title">
						<h1 class="page-header text-overflow">Pending House Details</h1>

						
						
					</div>
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<!--End page title-->

					
			<!--===================================================-->
				<div id="page-content">
					
					<!-- Basic Data Tables -->
					<!--===================================================-->
					<div class="panel">
						<div class="panel-body">
						  <div class="table-responsive">
							<table class="table table-striped table-bordered" cellspacing="0" width="100%">
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
									    <td style="display:none">{{$value->personal_details_id}}</td>
										<td>{{$value->house_number}}</td>
										<td>{{$value->status}}</td>
										<td>{{$value->DataVarified}}</td>
										<td>{{$value->city}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
							</div>
							{{$surveydata->links()}}
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
				
				var flag=confirm('Are you sure want to Reject this data ?');
				if(flag)
				{
					var url="{{url('/')}}/RejectPersonalDetails?id="+id;
					window.location.assign(url);
				}
			}
			</script>
			
			@endsection

			