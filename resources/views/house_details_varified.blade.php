			@extends('master')
			@section('content');
			
			<!--CONTENT CONTAINER-->
				<!--===================================================-->
				<div id="content-container">
					
					<!--Page Title-->
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<div id="page-title">
						<h1 class="page-header text-overflow">Varify House Details</h1>

						
						
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
										<th>Ward Number</th>
										<th>Ward Name</th>
										<th>Mohlla Name</th>
										<th>Nirman Bhavan Ka Prakar</th>
										<th>Malik</th>
										<th>Kirayedar</th>
										<th>Panjkaran</th>
										<th>Smaptti Shrni</th>
										<th>Samptti Prakar</th>
										
										<th>Type Of Road</th>
										<th>Gas Connection</th>
										<th>Bijli Meter</th>
										<th>Religion</th>
										<th>Cost</th>
										<th>Water Supply</th>
										<th>Rashan Card</th>
										<th>Nagar Palika</th>
										<th>Varyfied</th>
										
										 
									</tr>
								</thead>
								<tbody>
									@foreach($house_detail_varify as $index=>$value)
									<tr>
										<td>{{($house_detail_varify->currentpage()-1) * $house_detail_varify->perpage() + $index + 1 }}</td>
									    
										<td>{{$value->house_number}}</td>
										<td>{{$value->wardNumber}}</td>
										<td>{{$value->wardName}}</td>
										<td>{{$value->mohallaName}}</td>
										<td>{{$value->nirmanBhavanKaPrakar}}</td>
										<td>{{$value->malik}}</td>
										<td>{{$value->kirayedaar}}</td>
										<td>{{$value->panjikaran}}</td>
										<td>{{$value->sampattiShreni}}</td>
										<td>{{$value->sampattiPrakar}}</td>
										
										<td>{{$value->sadakKePrakar}}</td>
										<td>{{$value->gasConnection}}</td>
										<td>{{$value->bijliMeter}}</td>
										<td>{{$value->dharm}}</td>
										<td>{{$value->jati}}</td>
										<td>{{$value->jalapurti}}</td>
										<td>{{$value->rashanCard}}</td>
										<td>{{$value->city}}</td>
										<td>{{$value->DataVarified}}</td>
										
										</tr>
									@endforeach
								</tbody>
							</table>
							</div>
							{{$house_detail_varify->links()}}
						</div>
					</div>
					<!--===================================================-->
					<!-- End Striped Table -->
					
				</div>
				</div>
			
				<!--===================================================-->
				<!--End page content-->
			@endsection
			
			

			