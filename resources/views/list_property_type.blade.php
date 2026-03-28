@extends('layouts.main')
@section('main-section')

<div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
  <h6 class="font-semibold mb-0 dark:text-white">Manage Property Type</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="index.html" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">Manage Property Type</li>
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
              
              @if($user_access[0]->fn_add == 'Y')
                <div class="row">
                    <div class="col-md-12">
                        <a href="#" 
                        class="btn btn-info float-end" 
                        role="button" 
                        data-bs-toggle="modal" 
                        data-bs-target="#demoDefaultModal" 
                        onclick="city();">
                            Add Property Type
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
                            <th>Sr.No.</th>
                            <th>Property Type Name</th>
                            <th>Property Tax</th>
                             <th>Action</th>
                        </tr>
                </thead>
                <tbody>
                 @foreach($property_type_name as $index=>$value)
                        <tr>
                            <td>{{($property_type_name->currentpage()-1) * $property_type_name->perpage() + $index + 1 }}</td>

                            <td>{{$value->property_type_name}}</td>
                            <td>{{$value->tax_rate}}</td>
                            <td>
                           
                            @if ($user_access[0]->fn_update == 'Y')
                            <a href="#"
                            class="badge bg-success text-decoration-none"
                            data-bs-toggle="modal"
                            data-bs-target="#editPropertyTypeModal{{ $value->id }}">
                                Edit
                            </a>

                            <!-- Bootstrap 5 Edit Modal -->
                            <div class="modal fade" id="editPropertyTypeModal{{ $value->id }}" tabindex="-1" aria-labelledby="editPropertyTypeModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal header -->
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editPropertyTypeModalLabel">Edit Property Type</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <form id="editPropertyTypeForm" action="{{ route('update.PropertType') }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="id" id="id" value="{{ $value->id }}">

                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="edit_property_type_name" class="form-label">Property Type Name</label>
                                                    <input type="text" name="property_type_name" id="edit_property_type_name" class="form-control" value="{{$value->property_type_name}}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="edit_tax_rate" class="form-label">Property Tax</label>
                                                    <input type="text" name="tax_rate" id="edit_tax_rate" class="form-control" value="{{$value->tax_rate}}" required>
                                                </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success text-uppercase">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                           @endif
                            @if($user_access[0]->fn_delete=='Y')
                            <a href="{{url('/')}}/Delete-Property-Type/{{ $value->id }}" class="badge bg-success text-decoration-none" style="background-color:red !important;">Delete</a>
                            @endif
                            </td>


                        </tr>
                        @endforeach
                </tbody>
              </table>
            </div>
            <div class="mt-4">
                    {{ $property_type_name->links() }}
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
            <!-- Bootstrap 5 Modal -->
                <div class="modal fade" id="demoDefaultModal" tabindex="-1" aria-labelledby="demoDefaultModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoDefaultModalLabel">Add Property Type Name</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Modal body -->
                            <form action="{{ route('Save.PropertType') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="property_type_name" class="form-label">Property Type Name</label>
                                        <input type="text" name="property_type_name" id="property_type_name" class="form-control" placeholder="Enter Property Type Name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tax_rate" class="form-label">Property Tax</label>
                                        <input type="text" name="tax_rate" id="tax_rate" class="form-control" placeholder="Enter Property Tax" required>
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



