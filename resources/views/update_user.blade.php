@extends('layouts.main')
@section('main-section')
<div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
  <h6 class="font-semibold mb-0 dark:text-white">Update User</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="#" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">Update User</li>
  </ul>
</div>
    
    <div class="grid grid-cols-12 gap-5">
      <div class="col-span-12">
        <div class="card border-0">
          
          <div class="card-body" id="">
            @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <form method="post" class="grid grid-cols-12 gap-4">
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
					<option @if($editData->user_type=="Admin") selected @endif value="Admin">Admin</option>
					<option @if($editData->user_type=="Surveyor") selected @endif value="Surveyor">Surveyor</option>
					<option @if($editData->user_type=="Data Entry Operator") selected @endif value="DEO">Data Entry Operator</option>
					<option @if($editData->user_type=="District Admin") selected @endif value="District Admin">District Admin</option>
					<option @if($editData->user_type=="Parivar Surveyor") selected @endif value="Parivar Surveyor">Parivar Surveyor</option>
					</select>
                  
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Select State </label>
                <div class="flex">
                  <select class="form-control" name="state" id="state">
					<option value=''>--Select State--</option>
					@foreach($statelist as $value)
						@if($editData->state_id==$value->id)
						<option selected value='{{ $value->id }}'>{{ $value->state }}</option>
						@else
						<option value='{{ $value->id }}'>{{ $value->state }}</option>
						@endif
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
                  <input type="text" name="name" value="{{ $editData->name }}" class="form-control" id="name" required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Mobile </label>
                <div class="flex">
                  <input type="number" name="mobile" value="{{ $editData->contact }}" class="form-control" id="mobile" required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">UserName </label>
                <div class="flex">
                  <input type="text" name="user_name" class="form-control" value="{{ $editData->username }}" id="user_name" required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Password </label>
                <div class="flex">
                  <input type="password" name="password" class="form-control" value="{{ $editData->password }}" id="password" required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">E-Mail </label>
                <div class="flex">
                  <input type="email" name="email" class="form-control" value="{{ $editData->email }}" id="email" required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Address </label>
                <div class="flex">
                  <input type="text" name="address" class="form-control" value="{{ $editData->address }}" id="address" required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Select User Type </label>
                <div class="flex">
                  <select class="form-control" name="login_type">
					<option value=''>--Select Login Type--</option>
					<option @if($editData->login_type=="Offline") selected @endif value="Offline">Offline</option>
					<option @if($editData->login_type=="Online") selected @endif value="Online">Online</option>
				  </select>
                  
                </div>
              </div>
              @if($user_access[0]->fn_update=='Y')
              <div class="col-span-12">
                <button class="btn btn-primary-600" type="submit">Update</button>
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
<script>
				$(document).ready(function(){
					var value=$("#state").val();
					city_by_state(value);
				});
				function city_by_state(value)
				{
					var selected_city="{{$editData->city}}";
					$.ajax
					({
						url:"{{url('/')}}/getcity/"+value,
						dataType:'json',
						success:function(data)
						{
							var msg='<option value="">--Select City--</option>';
							for(var i=0;i<data.length;i++)
							{
								if(selected_city==data[i].city)
								{
									msg=msg+'<option selected value="'+data[i].city+'">'+data[i].city+'</option>';
								}
								else
								{
									msg=msg+'<option value="'+data[i].city+'">'+data[i].city+'</option>';
								}
								
							}
							$("#city").html(msg);
						}
					});
				}
				</script>
@endsection
