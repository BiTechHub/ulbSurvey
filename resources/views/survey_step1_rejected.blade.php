@extends('layouts.main')
@section('main-section')
<div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
  <h6 class="font-semibold mb-0 dark:text-white">Survey Step 1 Rejected</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="index.html" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">Survey Step 1 Rejected</li>
  </ul>
</div>

    {{-- Page Content --}}
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="panel-body">
                
            <div class="card border-0">
          <div class="card-header flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-3">
              
              @if (session()->get('user_type') == 'Admin')
                <form method="post" action="{{ url('/') }}/Search-Survey-Details-List">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                       

                        <!-- Search Box -->
                        <div class="flex justify-start">
                            <div class="flex w-full md:w-2/3 lg:w-1/2">
                                <input type="text" 
                                    name="keyword" 
                                    placeholder="Search Key Word ....." 
                                    class="flex-1 border border-gray-300 rounded-l-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700">
                                    Search
                                </button>
                            </div>
                        </div>
						
                    </div>
                </form>
            
            @endif
            </div>
            
            
          </div>
                <div class="card-body">
            <div class="table-responsive scroll-sm">
              <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th>Sr.no.</th>
                                <th>House Number</th>
                                <th>Ward Number</th>
                                <th>Ward Name</th>
                                <th>Mohalla Name</th>
                                <th>Basement</th>
                                <th>Number Of Floor</th>
                                <th>House Type</th>
                                <th>City</th>
                                <th>Survey By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($surveydatareject as $index => $value)
                                <tr>
                                    <td>{{ ($surveydatareject->currentpage() - 1) * $surveydatareject->perpage() + $index + 1 }}</td>
                                    <td style="display:none">{{ $value->id }}</td>
                                    <td>{{ $value->house_number }}</td>
                                    <td>{{ $value->ward_number }}</td>
                                    <td>{{ $value->ward_name }}</td>
                                    <td>{{ $value->mohalla }}</td>
                                    <td>{{ $value->basement }}</td>
                                    <td>{{ $value->no_of_floor }}</td>
                                    <td>{{ $value->house_type }}</td>
                                    <td>{{ $value->city }}</td>
                                    <td>{{ $value->username }}</td>
                                    <td>
                                        {{-- View Image --}}
                                        <a class="badge bg-primary text-decoration-none"
                                           href="#"
                                           data-bs-toggle="modal"
                                           data-bs-target="#demoDefaultModal"
                                           onclick="showImage('{{ url('/') }}/uploads/gis_image/{{ $value->image_name }}','{{ $value->id }}')">
                                           View
                                        </a>

                                        {{-- View on Map --}}
                                        <a class="badge bg-primary text-decoration-none"
                                           href="#"
                                           data-bs-toggle="modal"
                                           data-bs-target="#mapDefaultModal"
                                           onclick="showMap({{ $value->lat }},{{ $value->lng }})">
                                           View On Map
                                        </a>

                                        @if ($user_access[0]->fn_update == 'Y')
                                          {{--  <a class="badge bg-success text-decoration-none" href="#"
                                               onclick="confirmData('{{ $value->id }}');">Verify</a>
                                            <a class="badge bg-danger text-decoration-none" href="#"
                                               onclick="RejectDatat('{{ $value->id }}');">Reject</a>--}}

                                            {{-- Edit via Modal --}}
                                           {{-- <a href="#"
                                               class="badge bg-info text-decoration-none"
                                               data-bs-toggle="modal"
                                               data-bs-target="#editHouseModal"
                                               data-id="{{ $value->id }}"
                                               data-house_number="{{ $value->house_number }}"
                                               data-ward_number="{{ $value->ward_number }}"
                                               data-ward_name="{{ $value->ward_name }}"
                                               data-mohalla="{{ $value->mohalla }}"
                                               data-basement="{{ $value->basement }}"
                                               data-no_of_floor="{{ $value->no_of_floor }}"
                                               data-house_type="{{ $value->house_type }}"
                                               data-city="{{ $value->city }}">
                                               Edit
                                            </a> --}}

                                            <a class="badge bg-warning text-dark text-decoration-none"
                                               href="{{ url('/') }}/Update-Image/{{ $value->id }}">
                                               Change Image
                                            </a>

                                           {{-- @if ($user_access[0]->fn_delete == 'Y')
                                                <form method="post" id="delete_form_{{ $value->id }}"
                                                      action="{{ url('/') }}/Delete-House" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="deleted_id" value="{{ $value->id }}">
                                                    <a onclick="deleteRow('{{ $value->id }}')" type="button"
                                                       class="badge bg-danger text-decoration-none">
                                                       Delete
                                                    </a>
                                                </form>
                                            @endif  --}}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $surveydatareject->links() }}
            </div>
            </div>
        </div>
    </div>
</div>

{{-- Image Modal --}}
<div class="modal fade" id="demoDefaultModal" tabindex="-1" aria-labelledby="demoDefaultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    House Picture
                    <a id="anticlock" href="#"><i class="fa fa-rotate-left ms-2"></i></a>
                    <a id="clock" href="#"><i class="fa fa-rotate-right ms-2"></i></a>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="img/av1.png" id="image" class="img-fluid" style="max-height:450px;">
            </div>
        </div>
    </div>
</div>

{{-- Map Modal --}}
<div class="modal fade" id="mapDefaultModal" tabindex="-1" aria-labelledby="mapDefaultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Map View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div style="height:500px;width:100%;" id="map"></div>
            </div>
        </div>
    </div>
</div>

{{-- Edit House Modal --}}
<div class="modal fade" id="editHouseModal" tabindex="-1" aria-labelledby="editHouseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" action="{{ url('/') }}/Update-New-House">
            @csrf
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit House</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label>House Number</label>
                        <input type="text" readonly name="house_number" id="edit_house_number" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Ward Number</label>
                        <input type="text" readonly name="ward_number" id="edit_ward_number" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Ward Name</label>
                        <input type="text" name="ward_name" id="edit_ward_name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Mohalla Name</label>
                        <input type="text" name="mohalla" id="edit_mohalla" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Basement</label>
                        <input type="text" name="basement" id="edit_basement" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Number Of Floor</label>
                        <input type="text" name="no_of_floor" id="edit_no_of_floor" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>House Type</label>
                        <input type="text" name="house_type" id="edit_house_type" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>City</label>
                        <input type="text" name="city" readonly id="edit_city" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script_sec')
<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByoxJYY2T8F1D2QSF_IHrdWpAmKJ3JSrE&callback=initMap">
</script>
<script>
function showImage(imageName, id) {
    document.getElementById("image").src = imageName;
    document.getElementById("clock").href = "javascript:RotateClockwise('" + id + "');";
    document.getElementById("anticlock").href = "javascript:RotateAntiClockwise('" + id + "');";
}

function showMap(lat1, lng1) {
    var myLatLng = { lat: lat1, lng: lng1 };
    initMap(myLatLng);
}

function initMap(myLatLng) {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 20,
        center: myLatLng,
        mapTypeId: 'satellite'
    });
    new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'House Location'
    });
}

function confirmData(id) {
    if (confirm('Are you sure to verify this data ?')) {
        window.location.assign("{{ url('/') }}/verify?id=" + id);
    }
}

function RejectDatat(id) {
    swal("Write Rejection Reason here:", { content: "input" })
    .then((value) => {
        window.location.assign("{{ url('/') }}/RejectedSurveyData?id=" + id + "&reason=" + value);
    });
}

function RotateClockwise(id) {
    if (confirm('Are you sure want to rotate this photo ?')) {
        window.location.assign("{{ url('/') }}/RotateClockwise/" + id);
    }
}

function RotateAntiClockwise(id) {
    if (confirm('Are you sure want to rotate this photo ?')) {
        window.location.assign("{{ url('/') }}/RotateAntiClockwise/" + id);
    }
}

function deleteRow(id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this house!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            document.getElementById("delete_form_" + id).submit();
        } else {
            swal("Your data is safe!");
        }
    });
}

// Populate edit modal
document.getElementById('editHouseModal').addEventListener('show.bs.modal', function (event) {
    let button = event.relatedTarget;
    document.getElementById('edit_id').value = button.getAttribute('data-id');
    document.getElementById('edit_house_number').value = button.getAttribute('data-house_number');
    document.getElementById('edit_ward_number').value = button.getAttribute('data-ward_number');
    document.getElementById('edit_ward_name').value = button.getAttribute('data-ward_name');
    document.getElementById('edit_mohalla').value = button.getAttribute('data-mohalla');
    document.getElementById('edit_basement').value = button.getAttribute('data-basement');
    document.getElementById('edit_no_of_floor').value = button.getAttribute('data-no_of_floor');
    document.getElementById('edit_house_type').value = button.getAttribute('data-house_type');
    document.getElementById('edit_city').value = button.getAttribute('data-city');
});
</script>
@endsection
