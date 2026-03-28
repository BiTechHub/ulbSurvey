			@extends('master')
			@section('content');
			
			<!--CONTENT CONTAINER-->
				<!--===================================================-->
				<div id="content-container">
					
					<!--Page Title-->
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<div id="page-title">
						<h1 class="page-header text-overflow">Manage Assets</h1>

						
						
					</div>
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<!--End page title-->

					
			<!--===================================================-->
				<div id="page-content">
					
					<!-- Basic Data Tables -->
					<!--===================================================-->
					<div class="panel">
						<div class="panel-body">
						@if($user_access[0]->fn_add=='Y')
						  <div class="row">
						      <div class="col-md-12">
							       <a href="#" data-target="#demo-default-modal" data-toggle="modal" class="btn btn-info pull-right" role="button" onclick="city();">Add/Edit Assets</a>
							  </div>
						  </div>
						  @endif
						  <div class="table-responsive">
							<table class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Sr.no.</th>
										
										<th>Asset Name</th>
										 <th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($asset_name as $index=>$value)
									<tr>
										<td>{{($asset_name->currentpage()-1) * $asset_name->perpage() + $index + 1 }}</td>
										
										<td>{{$value->assets_name}}</td>
										<td>
										@if($user_access[0]->fn_delete=='Y')
										<form method="post" id="delete_form_{{ $value->id }}"
											action="{{ url('/') }}/Delete-Assets">
											{{ csrf_field() }}
											<input type="hidden" name="deleted_id" value="{{ $value->id }}">
											<span onclick="deleteRow('{{ $value->id }}')" type="button"
												class="label label-danger" title="Click to delete this row">Delete</span>
										</form>
										@endif
										@if ($user_access[0]->fn_update == 'Y')
										<a class="label label-success" href="{{ url('/') }}/UpadteAssetsDetail?id={{ $value->id }}">Edit</a>
									   @endif
										</td>
										
										
									</tr>
									@endforeach
								</tbody>
							</table>
							</div>
							{{$asset_name->links()}}
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
					<h4 class="modal-title">Add Assets Details</h4>
				</div>

				<!--Modal body-->
				{!!Form::Open(array('route'=>'Save.Assets'))!!}
				<div class="modal-body">
				  

					<div class="row">
						
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">Assets</label>
								{!!Form::text('asset_name','',array('class'=>'form-control','placeholder'=>'Enter Assets Name'))!!}
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
	<script>
		function deleteRow(id) {
               swal({
                       title: "Are you sure?",
                       text: "Once deleted, you will not be able to recover this imaginary file!",
                       icon: "warning",
                       buttons: true,
                       dangerMode: true,
                   })
                   .then((willDelete) => {
                       if (willDelete) {
                           $("#delete_form_" + id).submit();
                       } else {
                           swal("Your data is safe!");
                       }
                   });
           }
	</script>
	
				<!--===================================================-->
				<!--End page content-->
			@endsection
