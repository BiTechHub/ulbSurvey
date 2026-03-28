@extends('layouts.main')
@section('main-section')
	 <div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
  <h6 class="font-semibold mb-0 dark:text-white">Create User</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="#" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">Create User</li>
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
            <form method="post" action="{{ route('admin.saveUser') }}" class="grid grid-cols-12 gap-4">
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
                <label class="form-label">Select User Type </label>
                <div class="flex">
                  <select class="form-control" name="user_type">
					<option value=''>--Select User Type--</option>
					<option value="Admin">Admin</option>
					<option value="Surveyor">Surveyor</option>
					<option value="DEO">Data Entry Operator</option>
					<option value="District Admin">District Admin</option>
					<option value="Parivar Surveyor">Parivar Surveyor</option>
					</select>
                  
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Select State </label>
                <div class="flex">
                  <select class="form-control" name="state" onchange="city_by_state(this.value);">
					<option value=''>--Select State--</option>
					@foreach($statelist as $value)
					<option value='{{ $value->id }}'>{{ $value->state }}</option>
					@endforeach
				  </select>
                  
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Select City </label>
                <div class="flex">
                  <select class="form-control" id="city" name="city">
															
															
															
				  </select>
                  
                </div>
              </div>
              
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Name </label>
                <div class="flex">
                  <input type="text" name="name" class="form-control" id="name" required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Mobile </label>
                <div class="flex">
                  <input type="number" name="mobile" class="form-control" id="mobile" required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">UserName </label>
                <div class="flex">
                  <input type="text" name="user_name" class="form-control" id="user_name" required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Password </label>
                <div class="flex">
                  <input type="password" name="password" class="form-control" id="password" required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">E-Mail </label>
                <div class="flex">
                  <input type="email" name="email" class="form-control" id="email" required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Address </label>
                <div class="flex">
                  <input type="text" name="address" class="form-control" id="address" required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Select User Type </label>
                <div class="flex">
                  <select class="form-control" name="login_type">
					<option value=''>--Select Login Type--</option>
					<option value="Offline">Offline</option>
					<option value="Online">Online</option>
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
<script>
				function city_by_state(value)
				{
					$.ajax
					({
						url:"{{url('/')}}/getcity/"+value,
						dataType:'json',
						success:function(data)
						{
							var msg='<option value="">--Select City--</option>';
							for(var i=0;i<data.length;i++)
							{
								msg=msg+'<option value="'+data[i].city+'">'+data[i].city+'</option>';
							}
							$("#city").html(msg);
						}
					});
				}
</script>
@endsection
