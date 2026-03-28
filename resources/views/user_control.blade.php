@extends('layouts.main')
@section('main-section')

<div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
  <h6 class="font-semibold mb-0 dark:text-white">User Access</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="index.html" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">User Access</li>
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
              <select id="user" name="user" onchange="getDetail(this.value);" class="form-select form-select-sm w-auto dark:bg-dark-2 dark:text-white border-neutral-200 dark:border-neutral-500">
                <option value="">--Select User--</option>
					@foreach($userslist as $value)
					<option value="{{$value->id}}">{{$value->username}}--{{$value->user_type}}</option>
					@endforeach
              </select>
             
            </div>
            <div class="flex flex-wrap items-center gap-3">
              
              <div class="icon-field relative">
                <form method="GET" action="{{ route('searchAccess') }}">
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
                    <th scope="col">Sr No.</th>
					<th scope="col">Menu</th>
					<th scope="col">Sub Menu</th>
					<th scope="col">Add</th>
					<th scope="col">Edit</th>
					<th scope="col">Delete</th>
					<th scope="col">View</th>
					<th scope="col">Excel</th>
                  </tr>
                </thead>
                <tbody id="tData">
											
				</tbody>
              </table>
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
          </div>
        </div>
      </div>
    </div>
  </div>		
<script>
    let debounceTimeout;

    document.getElementById('searchInput').addEventListener('input', function () {
        clearTimeout(debounceTimeout); // Clear the previous timeout
        debounceTimeout = setTimeout(() => {
            this.form.submit(); // Submit the form after the delay
        }, 500); // Adjust delay as needed (500ms in this case)
    });
</script>
	@endsection
	@section('script')
	<script>
		function statusChange(type,id)
		{
			if($('#'+type+''+id).is(':checked')){
				$.ajax({
					url:"{{url('/')}}/changeUserControl",
					data:"id="+id+"&type="+type+"&status=Y",
					type:"get",
					//dataType:'json',
					success:function(data){
						$.niftyNoty({
							type: 'success',
							icon : 'fa fa-check',
							message : "Service Successfully Activated",
							container : 'floating',
							timer : 4000
						});
					}
				});
			 }else{
				  $.ajax({
					url:"{{url('/')}}/changeUserControl",
					data:"id="+id+"&type="+type+"&status=N",
					type:"get",
					//dataType:'json',
					success:function(data){
						$.niftyNoty({
							type: 'danger',
							icon : 'fa fa-warning',
							message : "Service Successfully Deactivated",
							container : 'floating',
							timer : 4000
						});
					}
				});
			 }
			
		}
		function getDetail(id)
		{
			$("#tData").html("");
			$.ajax({
				url:"{{url('/')}}/UserControlList/"+id,
				dataType:'json',
				success:function(data){
					//console.log(data);
					var msg="";
					var fnbtn;
					for(var i=0;i<data.length;i++)
					{
						if(data[i].fn_add=='Y'){fnaddbtn='Checked'}else {fnaddbtn='';}
						if(data[i].fn_delete=='Y'){fndelbtn='Checked'}else {fndelbtn='';}
						if(data[i].fn_update=='Y'){fneditbtn='Checked'}else {fneditbtn='';}
						if(data[i].fn_view=='Y'){fnviewbtn='Checked'}else {fnviewbtn='';}
						if(data[i].fn_excel=='Y'){fnexcelbtn='Checked'}else {fnexcelbtn='';}
						msg=msg+'<tr><td>'+(parseInt(i)+1)+'</td>'+
						'<td>'+data[i].menu_name+'</td>'+
						'<td>'+data[i].sub_menu+'</td>'+
						'<td><input type="checkbox" id="add'+data[i].id+'" onchange="statusChange(\'add\','+data[i].id+');" '+fnaddbtn+'></td>'+
						'<td><input type="checkbox" id="edit'+data[i].id+'" onchange="statusChange(\'edit\','+data[i].id+');" '+fneditbtn+'></td>'+
						'<td><input type="checkbox" id="delete'+data[i].id+'" onchange="statusChange(\'delete\','+data[i].id+');" '+fndelbtn+'></td>'+
						'<td><input type="checkbox" id="view'+data[i].id+'" onchange="statusChange(\'view\','+data[i].id+');" '+fnviewbtn+'></td>'+
						'<td><input type="checkbox" id="excel'+data[i].id+'" onchange="statusChange(\'excel\','+data[i].id+');" '+fnexcelbtn+'></td></tr>';
					}
					$("#tData").html(msg);
				}
			});
		}
	</script>
	@endsection

			
			

		

		

	
		
		



	
	

