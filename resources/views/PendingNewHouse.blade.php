@extends('layouts.main')
@section('main-section')

    <style>
        video {
            width: 100%;
            max-width: 500px;
        }
        canvas {
            display: none;
        }
        #buttons {
            margin-top: 10px;
        }
    </style>
<style>
    #map {
  height: 700px;
}
.custom-map-control-button{
    background:red;
    color:#fff;
    font-weight:bold;
    padding:6px;
}
</style>
  <div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
  <h6 class="font-semibold mb-0 dark:text-white">Pending New House</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="#" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">Pending New House</li>
  </ul>
</div>
    
    <div class="grid grid-cols-12 gap-5">
      <div class="col-span-12">
       @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
            @endif
        <div class="card border-0">
          
          <div class="card-body" id="">
         <form method="GET" action="{{ route('pending.house.list') }}" class="row g-3 mb-3">
                <input type="hidden" name="city" value="{{ $city }}">
                <input type="hidden" name="ward_no" value="{{ $ward_no }}">
                <div class="row" style="display:inline-flex;">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search house, ward, Nagar Palika..." value="{{ $search ?? '' }}">
                </div>

                <div class="col-md-2" style="padding-left:5px;">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
                </div>
            </form>
            </div>
            </div>
        <div class="card border-0">
          
          <div class="card-body" id="">
          

            <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Sr. No.</th>
                                <th scope="col">Nagar Palika</th>
                                <th scope="col">House Number</th>
                                <th scope="col">Ward Number</th>
                                <th scope="col">Ward Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($houses as $index => $value)
                                <tr>
                                    <td>{{ ($houses->currentPage() - 1) * $houses->perPage() + $index + 1 }}</td>
                                    <td>{{ $value->city }}</td>
                                    <td>{{ $value->house_number }}</td>
                                    <td>{{ $value->ward_number }}</td>
                                    <td>{{ $value->ward_name }}</td>
                                    <td><a href="{{url('/')}}/UpdatePersonalDetails/{{$value->id}}" class="btn btn-primary">Edit</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $houses->links() }}
                </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByoxJYY2T8F1D2QSF_IHrdWpAmKJ3JSrE"></script>
<script>
function initMap() {
            // Check if geolocation is supported
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                       

                        // Initialize the satellite map
                        const map = new google.maps.Map(document.getElementById("map"), {
                            zoom: 50,
                            center: { lat: latitude, lng: longitude },
                            mapTypeId: google.maps.MapTypeId.SATELLITE, // Satellite view
                        });
                         var textbox3 = document.getElementById('lat');
                         textbox3.value = latitude;
                         var textbox4 = document.getElementById('long');
                         textbox4.value = longitude;
                        // Add a marker to the map
                        new google.maps.Marker({
                            position: { lat: latitude, lng: longitude },
                            map: map,
                            title: "Your Location",
                        });

                        console.log(`Latitude: ${latitude}, Longitude: ${longitude}`);
                    },
                    (error) => {
                        console.error("Error getting location:", error.message);
                    }
                );
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
        }

        // Initialize the map when the window loads
        window.onload = initMap;
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 @if(session()->has('message'))
    <script type="text/javascript">
        swal("{{session()->get('message')}}");
    </script>
    @php(session()->forget('message'))
    @endif

    @if(session()->has('errorMsg'))
      <script type="text/javascript">
        swal("{{session()->get('errorMsg')}}");
        //toastr["error"]("{{session()->get('errorMsg')}}")
      </script>
      @php(session()->forget('errorMsg'))
    @endif

@endsection