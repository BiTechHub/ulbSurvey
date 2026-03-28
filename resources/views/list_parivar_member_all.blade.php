			@extends('master')
			@section('content');
			
			<!--CONTENT CONTAINER-->
				<!--===================================================-->
				<div id="content-container">
					
					<!--Page Title-->
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<div id="page-title">
						<h1 class="page-header text-overflow">Family Head Details</h1>

						
						
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
										<th>Member Name	</th>
										<th>Father Name</th>
										<th>Relation</th>
										<th>Age</th>
										<th>Gender	</th>
										<th>Business</th>
										<th>Qualification	</th>
										<th>Aadhar Card	</th>
										<th>Abhiyukti	</th>
										<th>Action	</th>
									</tr>
								</thead>
								<tbody>
									@foreach($family_members as $index=>$value)
									<?php
										$from = new DateTime($value->age);
										$to   = new DateTime('today');
										

										# procedural
										//echo ;
									?>
									<tr>
										<td>{{$index + 1 }}</td>
										<td>{{$value->nagarpalika}}</td>
										<td>{{$value->member_name}}</td>
										<td>{{$value->father_husband}}</td>
										<td>{{$value->relation}}</td>
										<td>{{$from->diff($to)->y}}</td>
										<td>{{$value->gender}}</td>
										<td>{{$value->vyvasay}}</td>
										<td>{{$value->education}}</td>
										<td>{{$value->aadhar_num}}</td>
										<td>{{$value->abhiyukti}}</td>
										<td>
											@if($user_access[0]->fn_update=="Y")
											<a class="btn btn-xs btn-success add-tooltip" data-toggle="tooltip" href="{{url('/')}}/Update-Family-Member/{{$value->id}}" data-original-title="Edit" data-container="body" >
				                <i class="fa fa-pencil "></i>
				              </a>
				              @endif
											@if($user_access[0]->fn_delete=="Y")
				              <a class="btn btn-xs btn-danger add-tooltip" data-toggle="tooltip" href="#" data-original-title="Delete" data-container="body" onclick="deleteRow('{{$value->id}}');">
				                <i class="fa fa-trash-o "></i>
				              </a>
				              <form id="delete_form_{{$value->id}}" action="{{url('/')}}/Delete-Family-Member" method="post">
				                {{ csrf_field() }}
				                <input type="hidden" name="deleted_id"  value="{{$value->id}}">
				              </form>
				              @endif
										</td>
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
function deleteRow(id)
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
      $("#delete_form_"+id).submit();
    } else {
      swal("Your data is safe!");
    }
  });
}
function ActiveRow(id)
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
      $("#active_form_"+id).submit();
    } else {
      //swal("Your data is safe!");
    }
  });
  
}
</script>
@endsection