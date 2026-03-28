@extends('layouts.main')
@section('main-section')
	 <div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
  <h6 class="font-semibold mb-0 dark:text-white">Add Ward/Mohlla</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="#" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">Add Ward/Mohalla</li>
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
            <form method="post" action="{{ route('save.ward-details') }}" class="grid grid-cols-12 gap-4">
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
                <label class="form-label">Select Nagar Plika </label>
                <div class="flex">
                  <select class="form-control" name="ngrpalika" id="nagarpalika" >
					<option value="">--Select Nagar Plika--</option>
														 
								                         
													 
				  </select>
                  
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Ward Number </label>
                <div class="flex">
                  <select class="form-control" name="wardnum">
						<option value="">--Select Ward Number--</option>
						@for($i=1;$i<=100;$i++)
						<option value="{{$i}}">{{$i}}</option>
						@endfor
				  </select>
                  
                </div>
              </div>
              
              
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Ward Name </label>
                <div class="flex">
                  <input type="text" name="wardnam" class="form-control" id="wardnam" placeholder="Enter Ward Name.." required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Mohalla </label>
                <div class="flex">
                  <input type="text" name="mohlla" class="form-control" id="mohlla" placeholder="Enter Mohalla Name.." required>
                </div>
              </div>
              
              @if($user_access[0]->fn_add=='Y')
              <div class="col-span-12">
                <button class="btn btn-primary-600" type="submit">Submit form</button>
              </div>
              @endif
            </form>
            <div class="md:col-span-12 col-span-12" style="width:100%;height:400px;margin-top:20px;" id="map">
                
              </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>

@endsection
			
@section('script')
<script>
	
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
		$('document').ready(function(e){
			city();
		});
	</script>
@endsection	

		

		

	
		
		



	
	

