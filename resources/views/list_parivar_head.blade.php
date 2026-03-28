			@extends('master')
			@section('content');
			
			<!--CONTENT CONTAINER-->
				<!--===================================================-->
				<div id="content-container">
					
					<!--Page Title-->
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					@if(session()->get('user_type')=='Admin')
					<<form method="post" action="{{url('/')}}/Search-Parivar">
						{{ csrf_field() }}
						<div id="page-title">
							<h1 class="page-header text-overflow">Family Head Details</h1>
							
							<div class="searchbox">
									
								<div class="input-group custom-search-form">
									
									<input type="text" class="form-control" name="keyword"  placeholder="Search Key Word .....">
									<span class="input-group-btn">
										<button class="text-muted" type="submit"><i class="fa fa-search"></i></button>
									</span>
									
								</div>
							</div>	
							
						</div>
						</form>
						@else
						<div id="page-title">
							<h1 class="page-header text-overflow">Family Head Details</h1>
						</div>
						@endif
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
										<th>Family Head	</th>
										<th>House Number	</th>
										<th>Ward Number	</th>
										<th>Ward Name	</th>
										<th>Mohalla	</th>
										<th>Mobile Number</th>
										<th>Electricity	</th>
										<th>Gas	</th>
										<th>Ration Card</th>
										<th>All Member</th>
									</tr>
								</thead>
								<tbody>
									@foreach($family_members as $index=>$value)
									<tr>
										<td>{{($family_members->currentpage()-1) * $family_members->perpage() + $index + 1 }}</td>
										<td>{{$value->nagarpalika}}</td>
										<td>{{$value->name}}</td>
										<td>{{$value->house_number}}</td>
										<td>{{$value->wardNumber}}</td>
										<td>{{$value->wardName}}</td>
										<td>{{$value->mohallaName}}</td>
										<td>{{$value->mobile_number}}</td>
										<td>{{$value->bijliMeter}}</td>
										<td>{{$value->gasConnection}}</td>
										<td>{{$value->rashanCard}}</td>
										<td>
											<a class="btn btn-xs btn-default add-tooltip" data-toggle="tooltip" data-original-title="ALL Member" data-container="body" target="_BLANK" href="{{url('/')}}/GetAllFamilyMember/{{$value->house_id}}"><i class="fa fa-eye "></i></a>
											<a target="_BLANK" class="btn btn-xs btn-warning add-tooltip" data-toggle="tooltip" data-original-title="Print" data-container="body" href="{{url('/')}}/PrintParivarRegister/{{$value->house_id}}"><i class="fa fa-print "></i></a>
											<a class="btn btn-xs btn-danger add-tooltip" data-toggle="tooltip" href="#" data-original-title="Reject" data-container="body" onclick="RejectRow('{{$value->house_id}}');">
				                <i class="fa fa-times "></i>
				              </a>
				              <form id="reject_form_{{$value->house_id}}" action="{{url('/')}}/ActionParivarRejected" method="post">
				                {{ csrf_field() }}
				                <input type="hidden" name="id"  value="{{$value->house_id}}">
				              </form>
				              <a class="btn btn-xs btn-success add-tooltip" data-toggle="tooltip" href="#" data-original-title="Approve" data-container="body" onclick="ApproveRow('{{$value->house_id}}');">
				                <i class="fa fa-check "></i>
				              </a>
				              <form id="approve_form_{{$value->house_id}}" action="{{url('/')}}/ActionParivarApproved" method="post">
				                {{ csrf_field() }}
				                <input type="hidden" name="id"  value="{{$value->house_id}}">
				              </form>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
							</div>
							{{$family_members->links()}}
						</div>
					</div>
					<!--===================================================-->
					<!-- End Striped Table -->
					
				</div>
				</div>
				<div class="modal fade" id="demo-default-modal" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

				<!--Modal header-->
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button">
					<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Add City/Nagarpalika</h4>
				</div>

				<!--Modal body-->
				{!!Form::Open(array('route'=>'save.city'))!!}
				<div class="modal-body">
				  

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Select State</label>
								<select class="form-control" name="state">
								 <option value="">--Select State--</option>
								 <option value="34">Uttar Pradesh</option>
								</select>
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">City/Nagarpalika</label>
								{!!Form::text('city','',array('class'=>'form-control','placeholder'=>'Enter city/nagarpalika'))!!}
							</div>
						</div>
					</div>
				 
				</div>

				<!--Modal footer-->
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
					{!!Form::submit('Submit',array('class'=>'btn btn-success text-uppercase'))!!}
					
				</div>
				{!!Form::Close()!!}
			</div>
		</div>
	</div>
				<!--===================================================-->
				<!--End page content-->
			@endsection
@section('script')
<script type="text/javascript">
function RejectRow(id)
{
  swal({
    title: "Are you sure?",
    text: "Once deleted, you will not be able to recover this imaginary file!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $("#reject_form_"+id).submit();
    } else {
      swal("Your data is safe!");
    }
  });
}
function ApproveRow(id)
{
  swal({
    title: "Are you sure?",
    text: "You want to change status",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $("#approve_form_"+id).submit();
    } else {
      //swal("Your data is safe!");
    }
  });
  
}
</script>
@endsection