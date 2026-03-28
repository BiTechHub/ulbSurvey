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
  <h6 class="font-semibold mb-0 dark:text-white">Update Personal Detail</h6>
  <ul class="flex items-center gap-[6px]">
    <li class="font-medium">
      <a href="#" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-md"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li class="dark:text-white">-</li>
    <li class="font-medium dark:text-white">Update Personal Detail</li>
  </ul>
</div>
    
    <div class="grid grid-cols-12 gap-5">
      <div class="col-span-12">
       @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
            @endif
        <div class="card border-0">
          
          <div class="card-body" id="">
           

				  <form method="POST" action="{{ route('update.PersonalDetailsSurvey') }}">
                   @csrf
           
  <div class="grid grid-cols-12 gap-4">
    <!-- भवन / प्लाट सं० -->
    <div class="lg:col-span-3 col-span-12">
      <label class="font-semibold">भवन / प्लाट सं० <span class="text-red-500">*</span></label>
      <input type="text" readonly value="{{$get_personal_details[0]->house_number}}" id="makan_no" name="makan_no" class="form-control">
      <input type="hidden" readonly value="{{$get_personal_details[0]->survey_id}}" id="surv_id" name="surv_id">
    </div>

    <!-- पुराना भवन/प्लाट -->
    <div class="lg:col-span-3 col-span-12">
      <label class="font-semibold">पुराना भवन/प्लाट <span class="text-red-500">*</span></label>
      <input type="text" value="{{$get_personal_details[0]->old_house_number}}" id="old_house_number" name="old_house_number" class="form-control">
    </div>
     <div class="col-span-12 lg:col-span-3">
    <label class="block font-medium">निर्माण का प्रकार <span class="text-red-500">*</span></label>
    <select class="w-full border rounded p-2" name="NirmanPrakar" id="NirmanPrakar">
      <option value="{{$get_house_details[0]->NirmanPrakar ??''}}">{{$get_house_details[0]->NirmanPrakar ??''}}</option>
    </select>
  </div>
   <div class="col-span-12 lg:col-span-3">
    <label class="block font-medium">संपत्ति प्रकार <span class="text-red-500">*</span></label>
    <select class="w-full border rounded p-2" name="sampattiPrakar" id="sampattiPrakar">
      <option value="">-- चयन करें --</option>
      <option value="{{ $get_house_details[0]->sampattiPrakar ??''}}">{{ $get_house_details[0]->sampattiPrakar ??''}}</option>
      @foreach ($property_type as $value )
      <option value="{{$value->property_type_name}}">{{$value->property_type_name}}</option>
      @endforeach
    </select>
  </div>
    <!-- स्वामी का नाम -->
    <div class="lg:col-span-6 col-span-12">
      <label class="font-semibold">भवन /प्लॉट के स्वामी का नाम <span class="text-red-500">*</span></label>
      <input type="text" value="{{$get_personal_details[0]->name}}" id="swami_ka_naam" name="swami_ka_naam" class="form-control" placeholder="Enter Full Name">
    </div>

    <!-- पिता / पति का नाम -->
    <div class="lg:col-span-6 col-span-12">
      <label class="font-semibold">पिता / पति का नाम <span class="text-red-500">*</span></label>
      <input type="text" value="{{$get_personal_details[0]->father_name}}" id="pita_ka_naam" name="pita_ka_naam" class="form-control" placeholder="Enter Full Name">
    </div>

    <!-- मोबाइल नंबर -->
    <div class="lg:col-span-6 col-span-12">
      <label class="font-semibold">मोबाइल नंबर <span class="text-red-500">*</span></label>
      <input type="text" value="{{$get_personal_details[0]->mobile_number}}" id="mobile_num" name="mobile_num" class="form-control" placeholder="मोबाइल नंबर">
    </div>
@if($surveydata[0]->house_type == 'Residential' || $surveydata[0]->house_type == 'Mix')
  <div class="col-span-12 text-center">
    <label class="text-lg font-semibold border-b pb-1 block">---------- आवासीय निर्माण क्षेत्र (वर्ग फिट) ---------</label>
  </div>
  @if($surveydata[0]->basement == 'Yes')
  <!-- भूमिगत मंजिल -->
  <div class="col-span-12">
    <label class="text-base font-bold block">भूमिगत मंजिल</label>
  </div>

  <div class="col-span-12 lg:col-span-6">
    <label for="lengthbasement" class="block font-medium mb-1">लम्बाई <span class="text-red-600">*</span></label>
    <input type="text" id="lengthbasement" name="lengthbasement"
           value="{{ $get_personal_details[0]->basement_area ?? '' }}"
           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
           placeholder="Length" autocomplete="off">
  </div>

  <div class="col-span-12 lg:col-span-6">
    <label for="widthbasement" class="block font-medium mb-1">चौड़ाई <span class="text-red-600">*</span></label>
    <input type="text" id="widthbasement" name="widthbasement"
           value="{{ $get_personal_details[0]->basement_area_width ?? '' }}"
           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
           placeholder="Width" autocomplete="off">
  </div>
  @endif
  <!-- तल मंजिल -->
  @foreach($floors as $floor)
    <div class="col-span-12">
        <label class="text-base font-bold block">{{ $floor['label'] }}</label>
    </div>

    <div class="col-span-12 lg:col-span-6">
        <label for="length{{ $floor['key'] }}" class="block font-medium mb-1">लम्बाई <span class="text-red-600">*</span></label>
        <input type="text" id="length{{ $floor['key'] }}" name="length[{{ $floor['key'] }}]"
               value="{{ $floor['length'] }}"
               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
               placeholder="Length" autocomplete="off">
    </div>

    <div class="col-span-12 lg:col-span-6">
        <label for="width{{ $floor['key'] }}" class="block font-medium mb-1">चौड़ाई <span class="text-red-600">*</span></label>
        <input type="text" id="width{{ $floor['key'] }}" name="width[{{ $floor['key'] }}]"
               value="{{ $floor['width'] }}"
               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
               placeholder="Width" autocomplete="off">
    </div>
@endforeach
@endif
@if($surveydata[0]->house_type == 'Commercial' || $surveydata[0]->house_type == 'Mix')
<div class="col-span-12 text-center">
    <label class="text-lg font-semibold border-b pb-1 block">---------- व्यावसायिक निर्माण क्षेत्र (वर्ग फिट) ---------</label>
  </div>
  @if($surveydata[0]->basement == 'Yes')
  <!-- भूमिगत मंजिल -->
  <div class="col-span-12">
    <label class="text-base font-bold block">भूमिगत मंजिल</label>
  </div>

  <div class="col-span-12 lg:col-span-6">
    <label for="lengthbasement" class="block font-medium mb-1">लम्बाई <span class="text-red-600">*</span></label>
    <input type="text" id="lengthbasement_com" name="lengthbasement_com"
           value="{{ $get_personal_details[0]->basement_area ?? '' }}"
           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
           placeholder="Length" autocomplete="off">
  </div>

  <div class="col-span-12 lg:col-span-6">
    <label for="widthbasement" class="block font-medium mb-1">चौड़ाई <span class="text-red-600">*</span></label>
    <input type="text" id="widthbasement_com" name="widthbasement_com"
           value="{{ $get_personal_details[0]->basement_area_width ?? '' }}"
           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
           placeholder="Width" autocomplete="off">
  </div>
  @endif
  <!-- तल मंजिल -->
   @foreach($floors_com as $floor)
    <div class="col-span-12">
        <label class="text-base font-bold block">{{ $floor['label'] }}</label>
    </div>

    <div class="col-span-12 lg:col-span-6">
        <label for="length{{ $floor['key'] }}" class="block font-medium mb-1">लम्बाई <span class="text-red-600">*</span></label>
        <input type="text" id="length_com{{ $floor['key'] }}" name="length_com[{{ $floor['key'] }}]"
               value="{{ $floor['length'] }}"
               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
               placeholder="Length" autocomplete="off">
    </div>

    <div class="col-span-12 lg:col-span-6">
        <label for="width{{ $floor['key'] }}" class="block font-medium mb-1">चौड़ाई <span class="text-red-600">*</span></label>
        <input type="text" id="width_com{{ $floor['key'] }}" name="width_com[{{ $floor['key'] }}]"
               value="{{ $floor['width'] }}"
               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
               placeholder="Width" autocomplete="off">
    </div>
@endforeach
@endif

    <!-- Add all other fields in the same pattern -->
    <!-- Use lg:col-span-3, lg:col-span-4, or lg:col-span-6 based on width needed -->
    <!-- Don't forget to wrap all in a grid container with col-span-12 on smaller screens -->

    <!-- Example: क्षेत्रफल fields -->
 <!-- भवन का छेत्रफल -->
<div class="col-span-12 text-center">
  <label class="font-bold">---------- भवन का छेत्रफल ---------</label>
</div>

<!-- पूरा वर्ग फिट -->

<!-- निर्मित वर्गफिट -->
<div class="col-span-12 lg:col-span-12 text-left mt-4">
  <label class="font-bold">निर्मित वर्गफिट</label>
</div>

<div class="col-span-12 lg:col-span-4">
  <label class="block">लम्बाई <span class="text-red-500">*</span></label>
  <input type="text" value="{{ $get_personal_details[0]->area_constructed }}" readonly autocomplete="off" class="form-input w-full" id="lengthnirmit" name="lengthnirmit" placeholder="Length">
</div>

<div class="col-span-12 lg:col-span-4">
  <label class="block">चौड़ाई <span class="text-red-500">*</span></label>
  <input type="text" value="{{ $get_personal_details[0]->area_constructed_width }}" readonly autocomplete="off" class="form-input w-full" id="widthnirmit" name="widthnirmit" placeholder="Width">
</div>

<div class="col-span-12 lg:col-span-4">
  <label class="block">कुल निर्मित क्षेत्रफल (वर्ग फिट) <span class="text-red-500">*</span></label>
  <input type="text" value="" readonly autocomplete="off" class="form-input w-full" id="total_area" name="total_area" placeholder="Total SquareFit">
</div>

<div class="col-span-12 lg:col-span-12 text-left mt-4">
  <label class="font-bold">खाली स्थान वर्गफिट</label>
</div>

<div class="col-span-12 lg:col-span-6">
  <label class="block">लम्बाई <span class="text-red-500">*</span></label>
  <input type="text" value="{{ $get_personal_details[0]->open_area }}" autocomplete="off" class="form-input w-full" id="lengthopen" name="lengthopen" placeholder="Length">
</div>

<div class="col-span-12 lg:col-span-6">
  <label class="block">चौड़ाई <span class="text-red-500">*</span></label>
  <input type="text" value="{{ $get_personal_details[0]->open_area_width }}" autocomplete="off" class="form-input w-full" id="widthopen" name="widthopen" placeholder="Width">
</div>
<div class="col-span-12 lg:col-span-12 text-left">
  <label class="font-bold">पूरा वर्ग फिट</label>
</div>

<div class="col-span-12 lg:col-span-6">
  <label class="block">लम्बाई <span class="text-red-500">*</span></label>
  <input type="text" value="{{ $get_personal_details[0]->area_all }}" readonly autocomplete="off" class="form-input w-full" id="lengthpura" name="lengthpura" placeholder="Length">
</div>

<div class="col-span-12 lg:col-span-6">
  <label class="block">चौड़ाई <span class="text-red-500">*</span></label>
  <input type="text" value="{{ $get_personal_details[0]->area_all_width }}" readonly autocomplete="off" class="form-input w-full" id="widthpura" name="widthpura" placeholder="Width">
</div>

<div class="col-span-12 text-center mt-6">
  <label class="font-bold">---------- भवन का विवरण ---------</label>
</div>
<div class="col-span-12 lg:col-span-4">
  <label class="block">मंजिल की संख्या <span class="text-red-500">*</span></label>
  <input type="text" value="{{$surveydata[0]->no_of_floor}}" autocomplete="off" readonly class="form-input w-full" id="manjilsankhya" name="manjilsankhya" placeholder="Enter Full Name">
</div>
<div class="col-span-12 lg:col-span-4">
  <label class="block">किरायेदार की संख्या <span class="text-red-500">*</span></label>
  <input type="text" value="{{$get_personal_details[0]->rented_person}}" autocomplete="off" class="form-input w-full" id="kirayrdadasankh" name="kirayrdadasankh" placeholder="Enter Full Name">
</div>
<div class="col-span-12 lg:col-span-4">
  <label class="block">कमरों की संख्या <span class="text-red-500">*</span></label>
  <input type="text" value="{{$get_personal_details[0]->no_of_room}}" autocomplete="off" class="form-input w-full" id="kamrokisankh" name="kamrokisankh" placeholder="Enter Full Name">
</div>
<div class="col-span-12 text-center mt-6">
  <label class="font-bold">---------- भवन का परिमाप फिट व इंच में ---------</label>
</div>
<div class="col-span-12 lg:col-span-3">
  <label class="block">निर्माण वर्ष <span class="text-red-500">*</span></label>
  <select class="form-select w-full" id="nirmaan_varsh" name="nirmaan_varsh">
    <option value="{{$get_personal_details[0]->nirmanVarsh}}">{{$get_personal_details[0]->nirmanVarsh}}</option>
  </select>
</div>
<div class="col-span-12 lg:col-span-3">
  <label class="block">निर्माण की प्रकृति <span class="text-red-500">*</span></label>
  <select class="form-select w-full" name="bhavannirmankipravatti" id="bhavannirmankipravatti">
    <option value="{{$get_personal_details[0]->NirmanPrakriti}}">{{$get_personal_details[0]->NirmanPrakriti}}</option>
  </select>
</div>
<div class="col-span-12 lg:col-span-3">
  <label class="block">फर्श की प्रकृति <span class="text-red-500">*</span></label>
  <select class="form-select w-full" id="bhavan_k_farsh_prakarti" name="bhavan_k_farsh_prakarti">
    <option value="{{$get_personal_details[0]->FarshPrakriti}}">{{$get_personal_details[0]->FarshPrakriti}}</option>
  </select>
</div>
<div class="col-span-12 lg:col-span-3">
  <label class="block">सड़क की चौड़ाई <span class="text-red-500">*</span></label>
  <select class="form-select w-full" name="road_width" id="road_width">
    <option value="{{$get_personal_details[0]->sadakKichoudai}}">{{$get_personal_details[0]->sadakKichoudai}}</option>
  </select>
</div>

<div class="col-span-12 text-center">
    <label class="font-bold text-lg">----------------अन्य विवरण--------------------</label>
  </div>

  <div class="col-span-12 lg:col-span-3">
    <label class="block font-medium">वार्ड नंबर <span class="text-red-500">*</span></label>
    <select class="w-full border rounded p-2" name="ward_number" id="ward_number">
      <option value="{{$get_personal_details[0]->ward_number}}">{{$get_personal_details[0]->ward_number}}</option>
      
    </select>
  </div>

  <div class="col-span-12 lg:col-span-3">
    <label class="block font-medium">वार्ड का नाम <span class="text-red-500">*</span></label>
    <select class="w-full border rounded p-2" name="wardName" id="wardName">
      <option value="{{$get_house_details[0]->ward_name ??''}}">{{$get_house_details[0]->ward_name ??''}}</option>
    </select>
  </div>

  <div class="col-span-12 lg:col-span-3">
    <label class="block font-medium">मोहल्ला का नाम <span class="text-red-500">*</span></label>
    <select class="w-full border rounded p-2" name="mohallaName" id="mohallaName">
      <option value="{{$get_house_details[0]->mohalla_name ??''}}">{{$get_house_details[0]->mohalla_name ??''}}</option>
    </select>
  </div>

 

  @php
    $fields = [
      'किरायेदार हैं' => 'kirayedaar',
      'मालिक है' => 'malik',
    ];
  @endphp

  @foreach ($fields as $label => $field)
  
  <div class="col-span-12 lg:col-span-3">
    <label class="block font-medium">{{ $label }} <span class="text-red-500">*</span></label>
    <select class="w-full border rounded p-2" name="{{ $field }}" id="{{ $field }}">
      <option value="{{ $get_house_details[0]->$field }}">{{ $get_house_details[0]->$field }}</option>
     
    </select>
  </div>

  @endforeach

  <div class="col-span-12 text-center" style="margin-top:20px;">
    <label class="text-lg font-semibold border-b pb-1 block">---------- चौहद्दी नाम ---------</label>
  </div>

  <div class="col-span-12 lg:col-span-3">
    <label for="purab1" class="block font-medium mb-1">पूरब <span class="text-red-600">*</span></label>
    <input type="text" id="purab1" name="purab1"
           value="{{ $get_personal_details[0]->locality_east ?? '' }}"
           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500"
           placeholder="पूरब का विवरण" autocomplete="off">
  </div>

  <div class="col-span-12 lg:col-span-3">
    <label for="paschim1" class="block font-medium mb-1">पश्चिम <span class="text-red-600">*</span></label>
    <input type="text" id="paschim1" name="paschim1"
           value="{{ $get_personal_details[0]->locality_west ?? '' }}"
           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500"
           placeholder="पश्चिम का विवरण" autocomplete="off">
  </div>

  <div class="col-span-12 lg:col-span-3">
    <label for="uttar1" class="block font-medium mb-1">उत्तर <span class="text-red-600">*</span></label>
    <input type="text" id="uttar1" name="uttar1"
           value="{{ $get_personal_details[0]->locality_north ?? '' }}"
           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500"
           placeholder="उत्तर का विवरण" autocomplete="off">
  </div>

  <div class="col-span-12 lg:col-span-3">
    <label for="dachhin1" class="block font-medium mb-1">दक्षिण <span class="text-red-600">*</span></label>
    <input type="text" id="dachhin1" name="dachhin1"
           value="{{ $get_personal_details[0]->locality_south ?? '' }}"
           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500"
           placeholder="दक्षिण का विवरण" autocomplete="off">
  </div>
 


    <!-- Continue all other sections using this same pattern -->

    <!-- Hidden City and Buttons -->
    <div class="col-span-12 text-center mt-4">
      @if($user_access[0]->fn_update=='Y')
        <input type='hidden' id='city' value='{{$get_house_details[0]->city}}'>
        <button type="submit" class="btn btn-primary">Update House Details</button>
      @endif
      <button type="reset" class="btn btn-secondary ml-2">Reset</button>
    </div>
  </div>

				 </form>
          </div>
        </div>
      </div>
      
    </div>
  </div>
@endsection
@section('script_sec')
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
<script>
	$(document).ready(function(e){
		GetConstructionAge();
		GetRoadwidth();
	});

	$.ajax({
	url: "{{ url('/') }}/new_gis/bpage.php?action=selectHouseDetails",
	dataType: "json",
	success: function (data) {
		const dropdowns = {
			Dharm: "#dharm",
			NirmanPrakar: "#NirmanPrakar",
			PanjikaranPrakar: "#panjikaran",
			SampatiShreni: "#sampattiShreni",
			// SampatiPrakar: "#sampattiPrakar", // Uncomment if needed
			Souchalaya: "#souchayala",
			SadakKePrakar: "#sadakKePrakar",
			Jati: "#jati",
			Jalapurti: "#jalapurti",
			gasconnection: "#gasConnection",
			electricity: "#bijliMeter",
			kitayedarhai: "#kirayedaar",
			malikhai: "#malik",
			RashanCard: "#rashanCard",
			NirmanPrakriti: "#bhavannirmankipravatti",
			FarshPrakriti: "#bhavan_k_farsh_prakarti"
		};
   

		for (let key in dropdowns) {
			if (data[key]) {
				let $dropdown = $(dropdowns[key]);
				$dropdown.html(''); // clear existing
        $dropdown.html('<option value="">-- चयन करें --</option>');
				data[key].forEach(item => {
					$dropdown.append('<option value="' + item + '">' + item + '</option>');
				});
			}
		}
	}
});


	var city=$("#city").val();
	$.ajax({
		url:"{{url('/')}}/get_RoadWidth/"+city,
		dataType:"json",
		success:function(data){
			console.log(data);
			var NirmanVarsh=data.construction_age;
			$("#nirmaan_varsh").html();
			for(var i=1;i<NirmanVarsh.length;i++)
			{
				$("#nirmaan_varsh").append('<option value="'+NirmanVarsh[i].age+'">'+NirmanVarsh[i].age+'</option>');
			}
			var SadakKiChoudai=data.road_width;
			$("#road_width").html();
			for(var i=1;i<SadakKiChoudai.length;i++)
			{
				$("#road_width").append('<option value="'+SadakKiChoudai[i].road_width+'">'+SadakKiChoudai[i].road_width+'</option>');
			}
		}
	});

	function changeWardNumber()
	{
		var ward_number=$("#ward_number").val();
		var wardName="{{$get_house_details[0]->ward_name}}";
		var mohallaName="{{$get_house_details[0]->ward_name}}";
		var city=$("#city").val();
		$.ajax({
			url:"{{url('/')}}/getWardDetailsByWardNumber/"+ward_number+"/"+city,
			dataType:"json",
			success:function(data){
				console.log(data);
				//$("#wardName").val(data[0].ward_name);
				//$("#mohallaName").val(data[0].mohalla_name);
				var msgMohalla="<option>-- Select Mohalla --</option>";
				for(var i=0;i<data.length;i++)
				{
					msgMohalla=msgMohalla+"<option value='"+data[i].mohalla_name+"''>"+data[i].mohalla_name+"</option>";
				}
				var msgwardName="<option>-- Select Ward Number --</option>";
				for(var i=0;i<data.length;i++)
				{
					msgwardName=msgwardName+"<option value='"+data[i].ward_name+"''>"+data[i].ward_name+"</option>";
				}
				$("#wardName").html(msgwardName);
				$("#mohallaName").html(msgMohalla);
			}
		});
	}
	/*function GetConstructionAge()
	{

		var city=$("#city").val();
		$.ajax({
			url:"{{url('/')}}/getConstructionAge/"+city,
			dataType:"json",
			success:function(data)
			{
				var msg='';
				for(var i=0;i<data.length;i++)
				{
					msg=msg+'<option value="'+data[i].age+'">'+data[i].age+'</option>';
				}
				$("#nirmaan_varsh").append(msg);
			}
		});
	}*/
	/*function GetRoadwidth()
	{

		var city=$("#city").val();
		$.ajax({
			url:"{{url('/')}}/get-Road-width/"+city,
			dataType:"json",
			success:function(data)
			{
				var msg='<option value="">--Select--</option>';
				for(var i=0;i<data.length;i++)
				{
					msg=msg+'<option value="'+data[i].road_width+'">'+data[i].road_width+'</option>';
				}
				$("#road_width").html(msg);
			}
		});
	}*/
	function showImage(imageName)
	{
		$("#image").attr('src',imageName);
	}
	function showMap(lat1,lng1)
	{
		var myLatLng = {lat: lat1, lng: lng1};
		initMap(myLatLng);
	}
	function initMap(myLatLng) {

		var map = new google.maps.Map(document.getElementById('map'), {
		  zoom: 20,
		  center: myLatLng,
		  mapTypeId: 'satellite'
		});
		var marker = new google.maps.Marker({
		  position: myLatLng,
		  map: map,
		  title: 'Hello World!'
		});
	  }
	</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function calculateAll() {
        let totalLength = 0;
        let totalWidth = 0;

        // Add length_com and width_com
        document.querySelectorAll('input[id^="length_com"]').forEach(input => {
            totalLength += parseFloat(input.value) || 0;
        });
        document.querySelectorAll('input[id^="width_com"]').forEach(input => {
            totalWidth += parseFloat(input.value) || 0;
        });

        // Add length[0..n] and width[0..n] (excluding open, etc.)
        document.querySelectorAll('input[id]').forEach(input => {
            if (/^length\d+$/.test(input.id)) {
                totalLength += parseFloat(input.value) || 0;
            }
            if (/^width\d+$/.test(input.id)) {
                totalWidth += parseFloat(input.value) || 0;
            }
        });

        // Add basement areas to निर्मित लम्बाई & चौड़ाई
        const lengthBasement = parseFloat(document.getElementById('lengthbasement')?.value) || 0;
        const widthBasement = parseFloat(document.getElementById('widthbasement')?.value) || 0;
        const lengthBasementCom = parseFloat(document.getElementById('lengthbasement_com')?.value) || 0;
        const widthBasementCom = parseFloat(document.getElementById('widthbasement_com')?.value) || 0;

        totalLength += lengthBasement + lengthBasementCom;
        totalWidth += widthBasement + widthBasementCom;

        // निर्मित लम्बाई और चौड़ाई
        const lengthNirmitInput = document.getElementById('lengthnirmit');
        const widthNirmitInput = document.getElementById('widthnirmit');
        const totalAreaInput = document.getElementById('total_area');

        if (lengthNirmitInput) lengthNirmitInput.value = totalLength.toFixed(2);
        if (widthNirmitInput) widthNirmitInput.value = totalWidth.toFixed(2);
        if (totalAreaInput) totalAreaInput.value = (totalLength * totalWidth).toFixed(2);

        // Open areas (only for पूरा क्षेत्रफल)
        const lengthOpen = parseFloat(document.getElementById('lengthopen')?.value) || 0;
        const widthOpen = parseFloat(document.getElementById('widthopen')?.value) || 0;

        // पूरा क्षेत्रफल
        const lengthPura = document.getElementById('lengthpura');
        const widthPura = document.getElementById('widthpura');

        if (lengthPura) lengthPura.value = (totalLength + lengthOpen).toFixed(2);
        if (widthPura) widthPura.value = (totalWidth + widthOpen).toFixed(2);
    }

    // Select inputs to watch
    const inputsToWatch = document.querySelectorAll(
        'input[id^="length_com"], input[id^="width_com"], ' +
        'input[id^="lengthopen"], input[id^="widthopen"], ' +
        'input[id^="lengthbasement"], input[id^="widthbasement"], ' +
        'input[id^="lengthbasement_com"], input[id^="widthbasement_com"], ' +
        'input[id^="length"], input[id^="width"]'
    );

    inputsToWatch.forEach(input => {
        input.addEventListener('input', calculateAll);
    });

    calculateAll();
});
</script>







@endsection