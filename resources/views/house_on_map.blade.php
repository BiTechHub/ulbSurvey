   @extends('master')
   @section('content');

       <!--CONTENT CONTAINER-->
       <!--===================================================-->
       <div id="content-container">

       <!--Page Title-->
       <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
       <div id="page-title">
       <h1 class="page-header text-overflow">House On Map</h1>



       </div>
       <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
       <!--End page title-->
       <div class="panel">

       <div class="panel-body">

       <div class="row">

       <div class="col-sm-3">
       <div class="form-group">
       <select class="form-control" name="nagarpalika" id="nagarpalika"
       onchange="get_ward_number(this.value);">
       <option value="">--Select Nagar palika--</option>
       </select>

       </div>
       </div>

       <div class="col-sm-3">
       <div class="form-group">
       <select class="form-control" name="wardnum" id="wardnum">
       <option value="">--Select Ward Number--</option>
       </select>

       </div>
       </div>

       <div class="col-sm-3">
       <div class="text-left">
       <input class="btn btn-search btn-primary" value="Show" type="button" name="view" id="view"
       onclick="setHouse();">
       <input class="btn btn-search btn-primary" value="New Search" type="button" name="show"
       id="show" style="display:none" onclick="javascript:location.reload();">

       </div>
       </div>
       </div>


       </div>

       </div>

       <!--===================================================-->
       <div id="page-content">

       <!-- Basic Data Tables -->
       <!--===================================================-->
       <div class="row">
       <div class="col-lg-12">
       <div class="panel">
       <div class="panel-body">
       <div class="row" id="datashow">

       </div>
       <div class="row">
       <div class="form-group col-lg-12">
       <div id="default" style="height:550px;"></div>
       </div>
       </div>
       </div>
       </div>
       </div>
       </div>
       <!--===================================================-->
       <!-- End Striped Table -->

       </div>
       </div>

       <!--===================================================-->
       <!--End page content-->
   @endsection
   @section('sidebar')
       <!--ASIDE-->
       <!--===================================================-->
       <aside id="aside-container">
       <div id="aside">
       <div class="nano">
       <div class="nano-content">

       <!--Nav tabs-->
       <!--================================-->

       <!--================================-->
       <!--End nav tabs-->



       <!-- Tabs Content -->
       <!--================================-->
       <div class="tab-content">

       <!--First tab (Contact list)-->
       <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
       <div class="tab-pane fade in active" id="demo-asd-tab-1">
       <h4 class="pad-hor text-thin">
       <a href="javascript:hideSide();"><span
       class="pull-right badge badge-warning">-></span></a> House Details
       </h4>

       <!--Family-->
       <div class="list-group bg-trans">
       <a href="#" class="list-group-item">
       <div class="media-center">
       <img src="" alt="Profile Picture" id="img" style="height:200px">
       </div>
       </a>
       </div>
       <div class="list-group bg-trans">
       <a href="#" class="list-group-item">
       <div class="media-body" id="more_data">
       <div class="text-sm">Stephen Tran</div>
       <span class="text-muted">Availabe</span>
       </div>
       </a>
       </div>


       </div>
       <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
       <!--End first tab (Contact list)-->

       </div>
       </div>
       </div>
       </div>
       </aside>
       <!--===================================================-->
       <!--END ASIDE-->

   @endsection
   @section('script')

       <script type="text/javascript">
           var latstr = 26.8467;
           var lngstr = 80.9462;
           var locations = [];

           function city() {

               $.ajax({
                   url: "{{ url('/') }}/getnagarpalika",
                   dataType: 'json',
                   success: function(data) {
                       var msg = '<option value="">--Select Nagar Palika--</option>';
                       for (var i = 0; i < data.length; i++) {
                           msg = msg + '<option value="' + data[i].city + '">' + data[i].city + '</option>';
                       }
                       $("#nagarpalika").html(msg);
                   }
               });
           }

           function show_hide_btn() {
               //$("#view").click
           }

           function get_ward_number(value) {
               //get_surveyor_list();
               $.ajax({
                   url: "{{ url('/') }}/getwardnum/" + value,
                   dataType: 'json',
                   success: function(data) {
                       var msg = '<option value="0">--All Ward--</option>';
                       for (var i = 0; i < data.length; i++) {
                           msg = msg + '<option value="' + data[i].ward_number + '">' + data[i].ward_number +
                               '->' + data[i].ward_name + '->' + data[i].mohalla_name + '</option>';
                       }
                       $("#wardnum").html(msg);
                   }
               });
           }

           function initialize() {
               myLatlng = new google.maps.LatLng(latstr, lngstr);
               var mapOptions = {
                   zoom: 18,
                   center: myLatlng,
                   mapTypeId: 'satellite'
               };
               var map = new google.maps.Map(document.getElementById("default"),
                   mapOptions);

               setMarkers(map, locations)


           }


           function setHouse() {
               $("#view").hide();
               $("#show").show();

               var city = $("#nagarpalika").val();
               var ward_number = $("#wardnum").val();
               //alert(ward_number);
               $.ajax({
                   url: "{{ url('/') }}/map-data/" + city + "/" + ward_number,
                   dataType: "JSON",
                   success: function(data) {

                       for (var i = 0; i < data.length; i++) {
                           aa = [data[i].lat, data[i].lng, data[i].house_number, data[i].ward_number, data[i].name,
                               data[i].father_name, data[i].mobile_number, data[i].area_all + ' X ' + data[i]
                               .area_all_width, data[i].id
                           ];
                           locations.push(aa);
                       }
                       $("#process").hide();
                       var index = parseInt(data.length / 2);
                       lngstr = data[index].lat;
                       lngstr = data[index].lng;
                       //console.log(locations);
                       initialize();

                   }
               });
           }


           //get_map();
           //http://taxiexchange.in/gps/webapi.php?action=loginMe
           $(document).ready(function(e) {
               city();
           });

           function hideSide(house_id) {
               if ($("#container").hasClass("aside-in")) {

                   $("#container").removeClass("aside-in")
                   $("#showhidebtn").html('Show Details');
               } else {
                   $("#more_data").html("");
                   $.ajax({
                       url: "{{ url('/') }}/more-House-data/" + house_id,
                       dataType: "JSON",
                       success: function(data) {
                           //alert();
                           console.log(data);
                           for (var i = 0; i < data.length; i++) {
                               $("#more_data").append('<div class="text-md">' +
                                   'NagarPalika&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].city + '</span>' +
                                   '</br>' +
                                   'House Number&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].house_number +
                                   '</span>' + '</br>' +
                                   'Name&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].name + '</span>' + '</br>' +
                                   'Father Name&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].father_name + '</span>' +
                                   '</br>' +
                                   'Ward Number&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].ward_number + '</span>' +
                                   '</br>' +
                                   'Mobile&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].mobile_number + '</span>' +
                                   '</br>' +
                                   'Nirmaan Varsh&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].nirmanVarsh +
                                   '</span>' + '</br>' +
                                   'House Type&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].NirmanPrakriti +
                                   '</span>' + '</br>' +
                                   'Farsh Type&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].FarshPrakriti +
                                   '</span>' + '</br>' +
                                   'Road Width&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].sadakKichoudai +
                                   '</span>' + '</br>' +
                                   'Total Area&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].area_all + 'X' + data[i]
                                   .area_all_width + '</span>' + '</br>' +
                                   'Constructed Area&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].area_constructed +
                                   'X' + data[i].area_constructed_width + '</span>' + '</br>' +
                                   'Business Area&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].area_business + 'X' +
                                   data[i].area_business_width + '</span>' + '</br>' +
                                   'Common Area&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].area_common_length +
                                   'X' + data[i].area_common_width + '</span>' + '</br>' +
                                   'Number Of floor&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].no_of_floor +
                                   '</span>' + '</br>' +
                                   'Number Of Room&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].no_of_room +
                                   '</span>' + '</br>' +
                                   'Basement Area&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].basement_area + 'X' +
                                   data[i].basement_area_width + '</span>' + '</br>' +
                                   'Gound Area&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].ground_area + 'X' + data[
                                       i].ground_area_width + '</span>' + '</br>' +
                                   'First Floor Area&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].first_area + 'X' +
                                   data[i].first_area_width + '</span>' + '</br>' +
                                   'Second Floor Area&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].second_area + 'X' +
                                   data[i].second_area_width + '</span>' + '</br>' +
                                   'Third Floor Area&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].third_area + 'X' +
                                   data[i].third_area_width + '</span>' + '</br>' +
                                   'Length From East&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].length_east +
                                   '</span>' + '</br>' +
                                   'Length From West&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].length_west +
                                   '</span>' + '</br>' +
                                   'Length From North&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].length_north +
                                   '</span>' + '</br>' +
                                   'Length From South&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].length_south +
                                   '</span>' + '</br>' +
                                   'Locality From East&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].locality_east +
                                   '</span>' + '</br>' +
                                   'Locality From West&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].locality_west +
                                   '</span>' + '</br>' +
                                   'Locality From North&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].locality_north +
                                   '</span>' + '</br>' +
                                   'Locality From South&nbsp&nbsp:&nbsp&nbsp<span>' + data[i].locality_south +
                                   '</span>' + '</br>' +

                                   '</div>');
                               $("#img").attr('src', '{{ url('/') }}/new_gis/upload/' + data[i].image_name +
                                   '');
                               $("#container").addClass("aside-in")
                               $("#showhidebtn").html('Hide Details');
                           }

                       }
                   });

               }



           }

           function setMarkers(map, locations) {
               var marker, i

               for (i = 0; i < locations.length; i++) {

                   var lat = locations[i][0]
                   var long = locations[i][1]
                   var house_number = locations[i][2]
                   var ward_number = locations[i][3]
                   var name = locations[i][4]
                   var father_name = locations[i][5]
                   var mobile_number = locations[i][6]
                   var area = locations[i][7]
                   var house_id = locations[i][8]
                   latlngset = new google.maps.LatLng(lat, long);
                   var car =
                       "M17.402,0H5.643C2.526,0,0,3.467,0,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759c3.116,0,5.644-2.527,5.644-5.644 V6.584C23.044,3.467,20.518,0,17.402,0z M22.057,14.188v11.665l-2.729,0.351v-4.806L22.057,14.188z M20.625,10.773 c-1.016,3.9-2.219,8.51-2.219,8.51H4.638l-2.222-8.51C2.417,10.773,11.3,7.755,20.625,10.773z M3.748,21.713v4.492l-2.73-0.349 V14.502L3.748,21.713z M1.018,37.938V27.579l2.73,0.343v8.196L1.018,37.938z M2.575,40.882l2.218-3.336h13.771l2.219,3.336H2.575z M19.328,35.805v-7.872l2.729-0.355v10.048L19.328,35.805z";
                   var img = 'img/house-icon.png';
                   /*var icon = {
                   	path: car,
                   	scale: .7,
                   	strokeColor: 'white',
                   	strokeWeight: .10,
                   	fillOpacity: 1,
                   	fillColor: '#404040',
                   	offset: '5%',
                   	// rotation: parseInt(heading[i]),
                   	anchor: new google.maps.Point(10, 25) // orig 10,50 back of car, 10,0 front of car, 10,25 center of car
                   };*/
                   var marker = new google.maps.Marker({
                       map: map,
                       position: latlngset
                   });
                   marker.setIcon(img);
                   map.setCenter(latlngset)
                   var content = '<div class="form-group col-lg-2">House Number :- ' + house_number + '</div>' +
                       '<div class="form-group col-lg-2">Ward Number :- ' + ward_number + '</div>' +
                       '<div class="form-group col-lg-2">Name :- ' + name + '</div>' +
                       '<div class="form-group col-lg-2">Father Name :- ' + father_name + '</div>' +
                       '<div class="form-group col-lg-2">Mobile Number :- ' + mobile_number + '</div>' +
                       '<div class="form-group col-lg-2">Area :- ' + area + '</div>' +
                       '<div class="form-group col-lg-2"><a class="label label-danger" href="javascript:hideSide(' + house_id +
                       ');" id="showhidebtn">More Details</a></div>';
                   var infowindow = new google.maps.InfoWindow()
                   google.maps.event.addListener(marker, 'click', (function(marker, content, infowindow) {
                       return function() {
                           infowindow.setContent(null);
                           infowindow.open(null, null);
                           $("#datashow").html(content);
                       };
                   })(marker, content, infowindow));

               }
               if (marker && marker.setMap) {
                   marker.setMap(null);
               }

           }
       </script>

   @endsection
