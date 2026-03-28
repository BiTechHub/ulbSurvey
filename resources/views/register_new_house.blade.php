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
  <h6 class="font-semibold mb-0 dark:text-white">Register New House</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="#" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">Register New House</li>
  </ul>
</div>
    
    <div class="grid grid-cols-12 gap-5">
      <div class="col-span-12">
       @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
            @endif
        <div class="card border-0">
          
          <div class="card-body" id="">
           
            <form method="post" class="grid grid-cols-12 gap-4" enctype="multipart/form-data">
                @csrf
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Ward Number </label>
                <div class="flex">
                  <select class="form-control" name="ward_no">
                    <option selected value="">Select Ward Number</option>
                    <option selected value="{{session('ward_no')}}">{{session('ward_no')}}</option>
                    
                  </select>
                  
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">House Parts </label>
                <div class="flex">
                  <select class="form-control" name="house_no">
                    <option selected value="">Select House Parts</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                  </select>
                  
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">No of Floor </label>
                <div class="flex">
                  <select class="form-control" name="floor">
                    <option selected value="">Select No Of Floor</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                  </select>
                  
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Basement ? </label>
                <div class="flex">
                  <select class="form-control" name="basement">
                    <option selected value="">Please Select</option>
                    <option value="Yes">Yes / हाँ</option>
                    <option value="No">No / नहीं</option>
                  </select>
                  
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">House Type </label>
                <div class="flex">
                  <select class="form-control" name="house_type">
                    <option selected value="">Select House Type</option>
                    <option value="Residential">Residential</option>
                    <option value="Commercial">Commercial</option>
                    <option value="Mix">Mix</option>
                    <option value="Government">Government</option>
                    <option value="Plot">Plot</option>
                    <option value="Other">Other</option>
                  </select>
                  
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Lattitude </label>
                <div class="flex">
                  <input type="text" name="lat" readonly class="form-control" id="lat" required>
                </div>
              </div>
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">Longitude </label>
                <div class="flex">
                  <input type="text" name="long" readonly class="form-control" id="long" required>
                </div>
              </div>
              
              <div class="lg:col-span-3 col-span-12">
                <label class="form-label">House Image </label>
                <div class="flex">
                 <input type="file" class="form-control" accept="image/*" capture="environment" id="cameraInput"  name="image_name">
                </div>
              </div>
              <div class="col-span-12">
                
                <input type="hidden" name="city" value="{{ session('city') }}">
                <input type="hidden" name="username" value="{{ session('username') }}">
                <input type="hidden" name="id" value="{{ session('id') }}">
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