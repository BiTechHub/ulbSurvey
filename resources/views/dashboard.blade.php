		@extends('layouts.main')
		@section('main-section')
		


  <div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
  <h6 class="font-semibold mb-0 dark:text-white">Dashboard</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="index.html" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">GIS Survey Portal</li>
  </ul>
</div>
                <div class="row" style="margin-bottom:10px;">
					<form method="post" action="{{ route('dash.board') }}">
					    @csrf
						<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5 gap-6">
							<div class="form-group">
								<select class="form-control" name="ngpalika" id="nagarpalika">
									
									<option value="">--Select City/Nagar Panchayat/Nagar Palika--</option>
									
									<option value=""></option>
									
								</select>
							</div>
							<input type="submit" name="sub" value="View" style="width:40%;padding:0px;" class="btn btn-primary text-uppercase">
						</div>
						
					</form>
				</div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5 gap-6">
      @if($dashboardMenuData)
	  @if($dashboardMenuData['New House Details Not-Verified']=='Y')
      <div class="card shadow-none border border-gray-200 dark:border-neutral-600 dark:bg-neutral-700 rounded-lg h-full bg-gradient-to-r from-cyan-600/10 to-bg-white">
        <div class="card-body p-5">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
              <p class="font-medium text-neutral-900 dark:text-white mb-1">Today Total New House</p>
              <h6 class="mb-0 dark:text-white">{{$total_survey_today}}</h6>
            </div>
            <div class="w-[50px] h-[50px] bg-cyan-600 rounded-full flex justify-center items-center">
              <iconify-icon icon="gridicons:multiple-users" class="text-white text-2xl mb-0"></iconify-icon>
            </div>
          </div>
          <p class="font-medium text-sm text-neutral-600 dark:text-white mt-3 mb-0 flex items-center gap-2">
            <span class="inline-flex items-center gap-1 text-success-600 dark:text-success-400"><iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon> +{{$total_survey_today}}/{{$total_survey}}</span> 
            From Last Day
          </p>
        </div>
      </div><!-- card end -->
      @endif
	  @if($dashboardMenuData['New House Details Verified']=='Y')
      <div class="card shadow-none border border-gray-200 dark:border-neutral-600 dark:bg-neutral-700 rounded-lg h-full bg-gradient-to-r from-purple-600/10 to-bg-white">
        <div class="card-body p-5">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
              <p class="font-medium text-neutral-900 dark:text-white mb-1">Today Verified New House</p>
              <h6 class="mb-0 dark:text-white">{{$total_verify_house_data_today}}</h6>
            </div>
            <div class="w-[50px] h-[50px] bg-purple-600 rounded-full flex justify-center items-center">
              <iconify-icon icon="fa-solid:award" class="text-white text-2xl mb-0"></iconify-icon>
            </div>
          </div>
          <p class="font-medium text-sm text-neutral-600 dark:text-white mt-3 mb-0 flex items-center gap-2">
            <span class="inline-flex items-center gap-1 text-success-600 dark:text-success-400"><iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon> +{{$total_verify_house_data_today}}/{{$total_verify_house_data}}</span> 
            From Last Day
          </p>
        </div>
      </div><!-- card end -->
      @endif
	  @if($dashboardMenuData['New House Details Not-Verified']=='Y')
      <div class="card shadow-none border border-gray-200 dark:border-neutral-600 dark:bg-neutral-700 rounded-lg h-full bg-gradient-to-r from-blue-600/10 to-bg-white">
        <div class="card-body p-5">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
              <p class="font-medium text-neutral-900 dark:text-white mb-1">Today Unverified New House</p>
              <h6 class="mb-0 dark:text-white">{{$total_unverify_house_data_today}}</h6>
            </div>
            <div class="w-[50px] h-[50px] bg-blue-600 rounded-full flex justify-center items-center">
              <iconify-icon icon="fluent:people-20-filled" class="text-white text-2xl mb-0"></iconify-icon>
            </div>
          </div>
          <p class="font-medium text-sm text-neutral-600 dark:text-white mt-3 mb-0 flex items-center gap-2">
            <span class="inline-flex items-center gap-1 text-success-600 dark:text-success-400"><iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon> +{{$total_unverify_house_data_today}}/{{$total_unverify_house_data}}</span> 
            From Last Day
          </p>
        </div>
      </div><!-- card end -->
      @endif
      @if($dashboardMenuData['New House Details Rejected']=='Y')
      <div class="card shadow-none border border-gray-200 dark:border-neutral-600 dark:bg-neutral-700 rounded-lg h-full bg-gradient-to-r from-success-600/10 to-bg-white">
        <div class="card-body p-5">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
              <p class="font-medium text-neutral-900 dark:text-white mb-1">Today Rejected New House</p>
              <h6 class="mb-0 dark:text-white">{{$total_rejected_house_data_today}}</h6>
            </div>
            <div class="w-[50px] h-[50px] bg-success-600 rounded-full flex justify-center items-center">
              <iconify-icon icon="solar:wallet-bold" class="text-white text-2xl mb-0"></iconify-icon>
            </div>
          </div>
          <p class="font-medium text-sm text-neutral-600 dark:text-white mt-3 mb-0 flex items-center gap-2">
            <span class="inline-flex items-center gap-1 text-success-600 dark:text-success-400"><iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon> +{{$total_rejected_house_data_today}}/{{$total_rejected_house_data}}</span> 
            From Last Day
          </p>
        </div>
      </div><!-- card end -->
      @endif
	  @if($dashboardMenuData['Personal Details Not-Verified']=='Y')
      <div class="card shadow-none border border-gray-200 dark:border-neutral-600 dark:bg-neutral-700 rounded-lg h-full bg-gradient-to-r from-red-600/10 to-bg-white">
        <div class="card-body p-5">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
              <p class="font-medium text-neutral-900 dark:text-white mb-1">Today Total Personal Details</p>
              <h6 class="mb-0 dark:text-white">{{$total_personal_detail_today}}</h6>
            </div>
            <div class="w-[50px] h-[50px] bg-red-600 rounded-full flex justify-center items-center">
              <iconify-icon icon="fa6-solid:file-invoice-dollar" class="text-white text-2xl mb-0"></iconify-icon>
            </div>
          </div>
          <p class="font-medium text-sm text-neutral-600 dark:text-white mt-3 mb-0 flex items-center gap-2">
            <span class="inline-flex items-center gap-1 text-success-600 dark:text-success-400"><iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon> +{{$total_personal_detail_today}}/{{$total_personal_data}}</span> 
            From Last Day
          </p>
        </div>
      </div><!-- card end -->
      @endif
	  @if($dashboardMenuData['Personal Details Verified']=='Y')
      <div class="card shadow-none border border-gray-200 dark:border-neutral-600 dark:bg-neutral-700 rounded-lg h-full bg-gradient-to-r from-cyan-600/10 to-bg-white">
        <div class="card-body p-5">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
              <p class="font-medium text-neutral-900 dark:text-white mb-1">Today Verified Personal Details</p>
              <h6 class="mb-0 dark:text-white">{{$total_verify_personal_data_today}}</h6>
            </div>
            <div class="w-[50px] h-[50px] bg-cyan-600 rounded-full flex justify-center items-center">
              <iconify-icon icon="gridicons:multiple-users" class="text-white text-2xl mb-0"></iconify-icon>
            </div>
          </div>
          <p class="font-medium text-sm text-neutral-600 dark:text-white mt-3 mb-0 flex items-center gap-2">
            <span class="inline-flex items-center gap-1 text-success-600 dark:text-success-400"><iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon> +{{$total_verify_personal_data_today}}/{{$total_verify_personal_data}}</span> 
            From Last Day
          </p>
        </div>
      </div>
      @endif
	  @if($dashboardMenuData['Personal Details Not-Verified']=='Y')
      <div class="card shadow-none border border-gray-200 dark:border-neutral-600 dark:bg-neutral-700 rounded-lg h-full bg-gradient-to-r from-cyan-600/10 to-bg-white">
        <div class="card-body p-5">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
              <p class="font-medium text-neutral-900 dark:text-white mb-1">Today Unverified Personal Details</p>
              <h6 class="mb-0 dark:text-white">{{$total_unverify_personal_data_today}}</h6>
            </div>
            <div class="w-[50px] h-[50px] bg-cyan-600 rounded-full flex justify-center items-center">
              <iconify-icon icon="gridicons:multiple-users" class="text-white text-2xl mb-0"></iconify-icon>
            </div>
          </div>
          <p class="font-medium text-sm text-neutral-600 dark:text-white mt-3 mb-0 flex items-center gap-2">
            <span class="inline-flex items-center gap-1 text-success-600 dark:text-success-400"><iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon> +{{$total_unverify_personal_data_today}}/{{$total_unverify_personal_data}}</span> 
            From Last Day
          </p>
        </div>
      </div><!-- card end -->
      @endif
	  @if($dashboardMenuData['Personal Details Rejected']=='Y')
      <div class="card shadow-none border border-gray-200 dark:border-neutral-600 dark:bg-neutral-700 rounded-lg h-full bg-gradient-to-r from-purple-600/10 to-bg-white">
        <div class="card-body p-5">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
              <p class="font-medium text-neutral-900 dark:text-white mb-1">Today Rejected Personal Details</p>
              <h6 class="mb-0 dark:text-white">{{$total_rejected_personal_data_today}}</h6>
            </div>
            <div class="w-[50px] h-[50px] bg-purple-600 rounded-full flex justify-center items-center">
              <iconify-icon icon="fa-solid:award" class="text-white text-2xl mb-0"></iconify-icon>
            </div>
          </div>
          <p class="font-medium text-sm text-neutral-600 dark:text-white mt-3 mb-0 flex items-center gap-2">
            <span class="inline-flex items-center gap-1 text-success-600 dark:text-success-400"><iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon> +{{$total_rejected_personal_data_today}}/{{$total_rejected_personal_data}}</span> 
            From Last Day
          </p>
        </div>
      </div><!-- card end -->
      @endif
	  
      @endif
    </div>

    

  </div>
    
  </div>

	@endsection
	@section('script_sec');
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