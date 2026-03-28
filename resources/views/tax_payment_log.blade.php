			@extends('master')
			@section('content');
			
			<!--CONTENT CONTAINER-->
				<!--===================================================-->
				<div id="content-container">
					
					<!--Page Title-->
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<div id="page-title">
						<h1 class="page-header text-overflow">Report Payment Tax Details</h1>

						
						
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
										<th>Nagar Palika Name</th>
										<th>Ward Number</th>
										<th>House Number</th>
										<th>Payment Reference Number</th>
										<th>Remark</th>
										<th>Payment</th>
										<th>Payment Mode</th>
										<th>Amount Words</th>
										<th>Payment Date</th>
										<th>Print</th>
									</tr>
								</thead>
								<tbody>
									@foreach($tableData as $index=>$value)
										<tr>
											<td>{{($tableData->currentpage()-1) * $tableData->perpage() + $index + 1 }}</td>
											<td>{{$value->city}}</td>
											<td>{{$value->ward_number}}</td>
											<td>{{$value->house_number_1}}</td>
											<td>{{$value->payment_reference}}</td>
											<td>{{$value->remark}}</td>
											<td>{{$value->payment}}</td>
											<td>{{$value->payment_mode}}</td>
											<td>{{$value->amount_words}}</td>
											<td>{{$value->created_at}}</td>
											<td><a target="_BLANK" class="label label-success" href="{{url('/')}}/PrintInvoice/{{$value->pay_id}}">Print</a></td>

											 
										</tr>
									@endforeach
								</tbody>
							</table>
							</div>
							{{$tableData->links()}}
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
				
				
            </script>
			
			@endsection

			