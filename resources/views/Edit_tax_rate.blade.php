
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
    <li class="font-medium dark:text-white">Edit Tax Rate</li>
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
				<h3 class="text-lg font-semibold mb-4">Edit Tax Rate</h3>

				<form action="{{ route('update.TaxRateDetail') }}" method="POST" class="space-y-4">
					@csrf

					<div class="grid grid-cols-4 md:grid-cols-6 gap-4">

						<!-- Nagar Palika -->
						<div>
							<label for="nagarpalika" class="block text-sm font-medium text-gray-700">Nagar Palika</label>
							<select name="ngrpalika" id="" onchange="GetRoadwidth()" required
								class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
								<option value="">--Select Nagar Palika--</option>
								@foreach($cities as $city)
                                <option @if($tax_data[0]->city == $city->city) selected @endif value="{{$city->city}}">{{$city->city}}</option>
								@endforeach
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
                                <option selected value="{{$tax_data[0]->bhawan_ka_prakar}}">{{$tax_data[0]->bhawan_ka_prakar}}</option>
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
                                <option selected value="{{$tax_data[0]->sadak_ki_choudai}}">{{$tax_data[0]->sadak_ki_choudai}}</option>
							</select>
						</div>

						<!-- Rate -->
						<div>
							<label for="rate" class="block text-sm font-medium text-gray-700">Rate</label>
							<input type="text" name="rate" id="rate" value="{{$tax_data[0]->rate}}" required
								class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <input type="hidden" name="id" id="id" value="{{$tax_data[0]->id}}" required
								class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
						</div>

					</div>

					<!-- Submit Button -->
					<div class="flex justify-end mt-4">
						<button type="submit"
							class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow text-sm uppercase">
							Update
						</button>
					</div>

				</form>
			</div>
			@endif

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




















