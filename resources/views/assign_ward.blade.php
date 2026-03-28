@extends('layouts.main')
@section('main-section')
	 <div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
  <h6 class="font-semibold mb-0 dark:text-white">Assign ward</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="#" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">Assign ward</li>
  </ul>
</div>
    
    <div class="grid grid-cols-12 gap-5">
      <div class="col-span-12">
        <div class="card border-0">
          
          <div class="card-body" id="">
            @if(session('message'))
            <div class="alert alert-success bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 border-success-600 border-start-width-4-px border-l-[3px] dark:border-neutral-600 px-6 py-[13px] mb-0 font-semibold text-lg rounded flex items-center justify-between" role="alert">
                        <div class="flex items-center gap-2">
                            <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                            {{ session('message') }}
                        </div>
                        <button class="remove-button text-success-600 text-2xl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button>
                    </div>
            @endif
            <form method="post" action="{{ route('update.ward') }}" class="grid grid-cols-12 gap-4">
                @csrf
                @if ($errors->any())
					<div class="alert alert-danger">
						<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
						</ul>
					</div>
				@endif
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Select Nagar Palika </label>
                <div class="flex">
                  <select class="form-control" name="ngrpalika" id="nagarpalika" onchange="get_ward_number(this.value);">
					<option value="">--Select Nagar Palika--</option>
				  </select>
                  
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Select Ward No. </label>
                <div class="flex">
                  <select class="form-control" name="wardnum" id="wardnum" onchange="get_mohalla_list(this.value);">
					<option value="">--Select Ward Number--</option>
				  </select>
                  
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Select Mohalla </label>
                <div class="flex">
                  <select class="form-control" name="mohalla" id="mohalla" onchange="get_surveyor_list();">
					<option value="">--Select Mohalla Name--</option>
				  </select>
                  
                </div>
              </div>
              
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Select Surveyor </label>
                <div class="flex">
                  <select class="form-control" name="surv" id="surv">
					<option value="">--Select Surveyor--</option>
				  </select>
                  
                </div>
              </div>
              
              <div class="col-span-12">
                <button class="btn btn-primary-600" type="submit">Submit form</button>
              </div>
            </form>
            <div class="md:col-span-12 col-span-12" style="width:100%;height:400px;margin-top:20px;" id="map">
                
              </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  @endsection
  @section('script_sec')
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
						msg=msg+'<option value="'+data[i].ward_number+'">'+data[i].ward_number+'->'+data[i].ward_name+'->'+data[i].mohalla_name+'</option>';
					}
					$("#wardnum").html(msg);
				}
			});
		}
		function get_mohalla_list(value)
		{
			var nagarpalika=$("#nagarpalika").val();
			$.ajax
			({
				url:"{{url('/')}}/getmohalla/"+value+"/"+nagarpalika,
				dataType:'json',
				success:function(data)
				{
					var msg='<option value="">--Select Mohalla--</option>';
					for(var i=0;i<data.length;i++)
					{
						msg=msg+'<option value="'+data[i].mohalla_name+'">'+data[i].mohalla_name+'</option>';
					}
					$("#mohalla").html(msg);
				}
			});
		}
		function get_surveyor_list()
		{
			var city = $('#nagarpalika').val();
			//alert(city);
			$.ajax
			({
				url:"{{url('/')}}/getSurveyorlist/"+city,
				dataType:'json',
				success:function(data)
				{
					var msg='<option value="">--Select Surveyor--</option>';
					for(var i=0;i<data.length;i++)
					{
						msg=msg+'<option value="'+data[i].id+'">'+data[i].name+'->'+data[i].username+'</option>';
					}
					$("#surv").html(msg);
				}
			});
		}
	</script>
@endsection

			
			

		

		

	
		
		



	
	

