
@extends('layouts.main')
@section('main-section')

<div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
  <h6 class="font-semibold mb-0 dark:text-white">Manage Tax Rate</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="index.html" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">Manage Tax Rate</li>
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
	     @if ($user_access[0]->fn_add == 'Y')
			<div class="bg-white shadow rounded-lg p-6">
				<h3 class="text-lg font-semibold mb-4">Manage Tax Rate</h3>

				<form action="{{ route('save.TaxRate') }}" method="POST" class="space-y-4">
					@csrf

					<div class="grid grid-cols-4 md:grid-cols-6 gap-4">

						<!-- Nagar Palika -->
						<div>
							<label for="nagarpalika" class="block text-sm font-medium text-gray-700">Nagar Palika</label>
							<select name="ngrpalika" id="nagarpalika" onchange="GetRoadwidth()" required
								class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
								<option value="">--Select Nagar Palika--</option>
							</select>
						</div>

						<!-- Ward Number -->
						<!--<div>
							<label for="ward_number" class="block text-sm font-medium text-gray-700">Ward Number</label>
							<select name="ward_number" id="ward_number" required onchange="GetRoadwidth()"
								class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
								<option value="">--Select Ward Number--</option>
							</select>
						</div>-->

						<!-- Bhavan Ka Prakar -->
						<div>
							<label for="bhavan_parkar" class="block text-sm font-medium text-gray-700">Bhavan Ka Prakar</label>
							<select name="bhavan_parkar" id="bhavan_parkar" required onchange="get_surveyor_list();"
								class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
								<option value="">--Select--</option>
							</select>
						</div>

						<!-- Farsh Ka Prakar -->
						<!--<div>
							<label for="farsh_prakar" class="block text-sm font-medium text-gray-700">Farsh Ka Prakar</label>
							<select name="farsh_prakar" id="farsh_prakar" required
								class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
								<option value="">--Select--</option>
							</select>
						</div>-->

						<!-- Sadak Ki Chaudai -->
						<div>
							<label for="sadak_chaudai" class="block text-sm font-medium text-gray-700">Sadak Ki Chaudai</label>
							<select name="sadak_chaudai" id="sadak_chaudai" required
								class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
								<option value="">--Select--</option>
							</select>
						</div>

						<!-- Rate -->
						<div>
							<label for="rate" class="block text-sm font-medium text-gray-700">Rate</label>
							<input type="text" name="rate" id="rate" placeholder="Enter Rate" required
								class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
						</div>

					</div>

					<!-- Submit Button -->
					<div class="flex justify-end mt-4">
						<button type="submit"
							class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow text-sm uppercase">
							Submit
						</button>
					</div>

				</form>
			</div>
			@endif

	   </div>
	</div>
    <div class="grid grid-cols-12">
      <div class="col-span-12">
          
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
            
            
          </div>
          <div class="card-body">
            <div class="table-responsive scroll-sm">
              <table class="table bordered-table mb-0">
                <thead>
                  <tr>
                    <th>Sr.no.</th>
											 <th>Nagar Palika</th>
											 <th>Bhavan Ka Prakar</th>
											 {{-- <th>Farsh Ka Prakar</th> --}}
											 <th>Sadka Ki Chaudai</th>
											 <th>Rate(Rs.)</th>
											 <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                 @foreach($tax_rate as $index=>$value)
										<tr>
											<td>{{($tax_rate->currentpage()-1) * $tax_rate->perpage() + $index + 1 }}</td>

											<td>{{$value->city}}</td>
											<td>{{$value->bhawan_ka_prakar}}</td>
											{{-- <td>{{$value->farsh_ka_prakar}}</td> --}}
											<td>{{$value->sadak_ki_choudai}}</td>
											<td>{{$value->rate}}</td>
											<td>
											@if($user_access[0]->fn_delete=='Y')
											
											@endif
											@if ($user_access[0]->fn_update == 'Y')
											<a class="btn btn-primary" href="{{ url('/') }}/UpadteTaxRateDetail/{{ $value->id }}">Edit</a>
										   @endif
											</td>


										</tr>
										@endforeach
                </tbody>
              </table>
            </div>
            <div class="mt-4">
                    {{ $tax_rate->links() }}
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
            <!-- Modal -->
                <div class="modal fade" id="demo-default-modal" tabindex="-1" aria-labelledby="demo-default-modal-label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="demo-default-modal-label">Add City/Nagarpalika</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Form -->
                            <form action="{{ route('save.city') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">

                                        <!-- State -->
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Select State</label>
                                                <select class="form-select" name="state">
                                                    <option value="">--Select State--</option>
                                                    <option value="34">Uttar Pradesh</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- ULB Type -->
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">ULB Type</label>
                                                <select class="form-select" name="ulb_type">
                                                    <option value="">--Select--</option>
                                                    <option value="Nagar Palika Parishad">Nagar Palika Parishad</option>
                                                    <option value="Nagar Nigam">Nagar Nigam</option>
                                                    <option value="Nagar Panchayat">Nagar Panchayat</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- City/Nagarpalika -->
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">City/Nagarpalika</label>
                                                <input type="text" class="form-control" name="city" placeholder="Enter city/nagarpalika">
                                            </div>
                                        </div>

                                        <!-- Interest Rate -->
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Interest Rate (%)</label>
                                                <input type="text" class="form-control" name="interest_rate" placeholder="Enter Interest Rate">
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
		function get_ward_number(value)
		{

			$.ajax
			({
				url:"{{url('/')}}/getwardnum/"+value,
				dataType:'json',
				success:function(data)
				{
					var msg='<option value="">--Select Ward Number--</option>';
					for(var i=0;i<data.length;i++)
					{
						msg=msg+'<option value="'+data[i].id+'">'+data[i].ward_number+'->'+data[i].ward_name+'->'+data[i].mohalla_name+'</option>';
					}
					$("#ward_number").html(msg);
				}
			});
		}


	$.ajax({
		url:"{{url('/')}}/new_gis/bpage.php?action=selectHouseDetails",
		dataType:"json",
		success:function(data){
			console.log(data);

			var NirmanPrakriti=data.NirmanPrakriti;
			$("#bhavan_parkar").html();
			for(var i=1;i<NirmanPrakriti.length;i++)
			{
				$("#bhavan_parkar").append('<option value="'+NirmanPrakriti[i]+'">'+NirmanPrakriti[i]+'</option>');
			}
			var FarshPrakriti=data.FarshPrakriti;
			$("#farsh_prakar").html();
			for(var i=1;i<FarshPrakriti.length;i++)
			{
				$("#farsh_prakar").append('<option value="'+FarshPrakriti[i]+'">'+FarshPrakriti[i]+'</option>');
			}
		}
	});
	function GetRoadwidth()
	{

		var city=$("#nagarpalika").val();
		//alert(city);
		$.ajax({
			url:"{{url('/')}}/get-Road-width/"+city,
			dataType:"json",
			success:function(data)
			{
				var msg='<option value="">--Select--</option>';
				for(var i=0;i<data.length;i++)
				{
					msg=msg+'<option value="'+data[i].road_width+'">'+data[i].road_width+'</option>';
				}
				$("#sadak_chaudai").html(msg);
			}
		});
	}
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

   @endsection




















