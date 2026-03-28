@extends('layouts.main')
@section('main-section')

<div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
  <h6 class="font-semibold mb-0 dark:text-white">Manage Construction Age</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="index.html" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">Manage Construction Age</li>
  </ul>
</div>
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
        <div class="card border-0">
          <div class="card-header flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-3">
              
              <div class="icon-field relative">
                <form method="GET" action="{{ route('searchWardMohalla') }}">
                <input type="text" name="query" value="{{ old('query', $query ?? '') }}" placeholder="Type to search..." id="searchInput" class="bg-white dark:bg-dark-2 ps-10 border-neutral-200 dark:border-neutral-500 rounded-lg w-auto">
                <span class="icon absolute top-1/2 left-0 text-lg flex">
                  <iconify-icon icon="ion:search-outline"></iconify-icon>
                </span>
                </form>
              </div>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
              
              @if ($user_access[0]->fn_add == 'Y')
                           <div class="row">
								<div class="col-md-12">
									<a href="#" 
									data-bs-toggle="modal" 
									data-bs-target="#demo-default-modal" 
									class="btn btn-info float-end" 
									role="button" 
									onclick="city();">
									Add Construction Year
									</a>
								</div>
							</div>


                       @endif
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive scroll-sm">
              <table class="table bordered-table mb-0">
                <thead>
                  <tr>
                    <th>Sr.no.</th>
										<th>Nagar Palika</th>
										<th>Construction Year</th>
										 <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                 @foreach($asset_name as $index=>$item)
									<tr>
										<td>{{($asset_name->currentpage()-1) * $asset_name->perpage() + $index + 1 }}</td>
										<td>{{$item->nagarpalika}}</td>
										<td>{{$item->age}}</td>
										<td>
										{{-- @if($user_access[0]->fn_delete=='Y')
										<a class="label label-danger" href="#">Delete</a>
										@endif --}}
										@if ($user_access[0]->fn_update == 'Y')
                                                  <a class="btn btn-info pull-right"
													type="button" 
													data-bs-toggle="modal" 
													data-bs-target="#edit_construction_modal{{ $item->id }}">
													Edit
													</a>

													<div class="modal fade" id="edit_construction_modal{{ $item->id }}" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">

																<!-- Modal Header -->
																<div class="modal-header">
																	<h5 class="modal-title">Edit Construction Year</h5>
																	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																</div>

																<!-- Modal Body -->
																<form method="POST" action="{{ route('update.Construction') }}">
																	@csrf
																	<div class="modal-body">
																		<div class="row g-3">

																			<!-- Nagarpalika Dropdown -->
																			<div class="col-12 col-lg-6">
																				<div class="mb-3">
																					<label for="nagarpalika{{ $item->id }}" class="form-label">Select Nagarpalika</label>
																					<select class="form-select" name="nagarpalika" id="nagarpalika{{ $item->id }}">
																						<option value="">--Select Nagarpalika--</option>
																						<option selected value="{{ $item->nagarpalika }}">{{ $item->nagarpalika }}</option>
																						
																					</select>
																				</div>
																			</div>

																			<!-- Construction Year Input -->
																			<div class="col-12 col-lg-6">
																				<div class="mb-3">
																					<label for="construction_year{{ $item->id }}" class="form-label">Construction Year</label>
																					<select class="form-control" name="year" id="year">
																						<option value="0">--Select Year--</option>
																						<option @if($item->age == "0 To 10") selected @endif value="0 To 10">0 To 10</option>
																						<option @if($item->age == "10 To 20") selected @endif value="10 To 20">10 To 20</option>
																						<option @if($item->age == "More Than 20") selected @endif value="More Than 20">More Than 20</option>
																					</select>
																					<input type="hidden" name="id" value="{{ $item->id }}">
																				</div>
																			</div>

																		</div>
																	</div>

																	<!-- Modal Footer -->
																	<div class="modal-footer">
																		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
																		<button type="submit" class="btn btn-success text-uppercase">Submit</button>
																	</div>
																</form>

															</div>
														</div>
													</div>

                                               @endif
										</td>
										
										
									</tr>
									@endforeach
                </tbody>
              </table>
            </div>
            <div class="mt-4">
                    {{ $asset_name->links() }}
                </div>
            <!--<div class="flex flex-wrap items-center justify-between gap-2 mt-6">
              <span>Showing 1 to 10 of 12 entries</span>
              <ul class="pagination flex flex-wrap items-center gap-2 justify-center">
                <li class="page-item">
                  <a class="page-link text-secondary-light font-medium rounded border-0 px-2.5 py-2.5 flex items-center justify-center h-8 w-8 bg-white dark:bg-neutral-700"
                    href="javascript:void(0)"><iconify-icon icon="ep:d-arrow-left" class="text-xl"></iconify-icon></a>
                </li>
                <li class="page-item">
                  <a class="page-link bg-primary-600 text-white font-medium rounded border-0 px-2.5 py-2.5 flex items-center justify-center h-8 w-8"
                    href="javascript:void(0)">1</a>
                </li>
                <li class="page-item">
                  <a class="page-link bg-primary-50 dark:bg-primary-600/25 text-secondary-light font-medium rounded border-0 px-2.5 py-2.5 flex items-center justify-center h-8 w-8"
                    href="javascript:void(0)">2</a>
                </li>
                <li class="page-item">
                  <a class="page-link bg-primary-50 dark:bg-primary-600/25 text-secondary-light font-medium rounded border-0 px-2.5 py-2.5 flex items-center justify-center h-8 w-8"
                    href="javascript:void(0)">3</a>
                </li>
                <li class="page-item">
                  <a class="page-link text-secondary-light font-medium rounded border-0 px-2.5 py-2.5 flex items-center justify-center h-8 w-8 bg-white dark:bg-neutral-700"
                    href="javascript:void(0)"> <iconify-icon icon="ep:d-arrow-right" class="text-xl"></iconify-icon> </a>
                </li>
              </ul>
            </div>-->
            <!-- Modal -->
            <div class="modal fade" id="demo-default-modal" tabindex="-1" aria-labelledby="demo-default-modal-label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">

					<!-- Modal header -->
					<div class="modal-header">
						<h5 class="modal-title" id="demo-default-modal-label">Add Construction Year</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>

					<!-- Modal body -->
					<form action="{{ route('Save.AgeDetails') }}" method="POST">
						@csrf
						<div class="modal-body">
							<div class="row">
								<!-- Nagar Palika -->
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">Nagar Palika</label>
										<select class="form-control" name="ngrpalika" id="nagarpalika" onchange="get_ward_number(this.value);">
											<option value="">--Select Nagar Palika--</option>
										</select>
									</div>
								</div>

								<!-- Year -->
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">Select Construction Year</label>
										<select class="form-control" name="year" id="year">
											<option value="0">--Select Year--</option>
											<option value="0 To 10">0 To 10</option>
											<option value="10 To 20">10 To 20</option>
											<option value="More Than 20">More Than 20</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<!-- Modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success text-uppercase">Submit</button>
						</div>
					</form>

				</div>
			</div>
		</div>



          </div>
        </div>
      </div>
    </div>
  </div>
   @endsection
   @section('script_sec')		
<script>
    let debounceTimeout;

    document.getElementById('searchInput').addEventListener('input', function () {
        clearTimeout(debounceTimeout); // Clear the previous timeout
        debounceTimeout = setTimeout(() => {
            this.form.submit(); // Submit the form after the delay
        }, 500); // Adjust delay as needed (500ms in this case)
    });
</script>
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
	</script>
   @endsection


