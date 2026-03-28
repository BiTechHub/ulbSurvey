@extends('layouts.main')
@section('main-section')

<div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
  <h6 class="font-semibold mb-0 dark:text-white">Manage Road Width</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="index.html" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">Manage Road Width</li>
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
              
              @if($user_access[0]->fn_add=='Y')
              <a href="#" data-bs-toggle="modal" data-bs-target="#road-width-modal"
                class="btn btn-sm text-white bg-primary-600 hover:bg-primary-700 flex items-center gap-2">
                    <i class="ri-add-line"></i> Add/Edit Road Width
                </a>
   
              
              @endif
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive scroll-sm">
              <table class="table bordered-table mb-0">
                <thead>
                  <tr>
                    
					<th scope="col">Sr.no.</th>
                    <th scope="col">Nagar Palika</th>
                    <th scope="col">Road Width</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                 
				 @forelse ($road_width_list as $index => $item)
                                <tr>
                                    <td>{{ ($road_width_list->currentPage() - 1) * $road_width_list->perPage() + $index + 1 }}</td>
                                    <td>{{ $item->nagarpalika }}</td>
                                    <td>{{ $item->road_width }}</td>
                                    <td>
                                        @if ($user_access[0]->fn_update == 'Y')
                                            <a class="btn btn-success" 
                                            type="button" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#update_modal{{ $item->id }}">
                                            Edit
                                            </a>
                                       <div class="modal fade" id="update_modal{{$item->id}}" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="road-width-modal-label">Update Road Width</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <!-- Modal Body -->
                                            <form method="POST" action="{{ route('update.RoadWidthDetail') }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-12 col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="nagarpalika" class="form-label">Select Nagarpalika</label>
                                                                <select class="form-select" name="ngrpalika" id="nagarpalika">
                                                                    <option value="">--Select Nagarpalika--</option>
                                                                    <option selected value="{{ $item->nagarpalika }}">{{ $item->nagarpalika }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="road_width" class="form-label">Road Width (In Feet)</label>
                                                                <input type="text" name="roadwid" id="road_width" class="form-control" value="{{ $item->road_width }}">
                                                                <input type="hidden" name="id" id="" class="form-control" value="{{ $item->id }}">
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
                                        @if ($user_access[0]->fn_delete == 'Y')
                                            <a class="btn btn-danger" 
                                            href="{{url('/')}}/Delete-Road-Width/{{$item->id}}" style="background-color:red !important">
                                            Delete
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No records found.</td>
                                </tr>
                            @endforelse
                </tbody>
              </table>
            </div>
            <div class="mt-4">
                    {{ $road_width_list->links() }}
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
            <div class="modal fade" id="road-width-modal" tabindex="-1" aria-labelledby="road-width-modal-label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="road-width-modal-label">Add Road Width</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- Modal Body -->
                        <form method="POST" action="{{ route('Save.RoadWidth') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="nagarpalika" class="form-label">Select Nagarpalika</label>
                                            <select class="form-select" name="nagarpalika" id="nagarpalika1">
                                                <option value="">--Select Nagarpalika--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="road_width" class="form-label">Road Width (In Feet)</label>
                                            <input type="text" name="road_width" id="road_width" class="form-control" placeholder="Enter Road width">
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
$(document).ready(function () {

    // Run when modal is opened
    $('#road-width-modal').on('shown.bs.modal', function () {
        loadNagarpalika();
    });

    function loadNagarpalika() {
        $.ajax({
                   url: "{{ url('/') }}/getnagarpalika",
                   dataType: 'json',
                   success: function(data) {
                       var msg = '<option value="">--Select Nagar Palika--</option>';
                       for (var i = 0; i < data.length; i++) {
                           msg = msg + '<option value="' + data[i].city + '">' + data[i].city + '</option>';
                       }
                       $("#nagarpalika1").html(msg);
                   }
               });
    }

});
</script>




   @endsection

