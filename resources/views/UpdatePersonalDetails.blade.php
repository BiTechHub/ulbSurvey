    @extends('master')
	@section('content');

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				<!--Page Title-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<div id="page-title">
					<h1 class="page-header text-overflow">मकान के विवरण का संशोधन </h1>
				</div>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End page title-->
				<!--Breadcrumb-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<ol class="breadcrumb">
					<li><a href="#">होम</a></li>
					<li><a href="#">मकान के विवरण का संशोधन </a></li>
				</ol>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End breadcrumb-->
				<!--Page content-->
				<!--===================================================-->
				<div id="page-content">
					<a class="btn btn-info" href="#" data-target="#demo-default-modal" data-toggle="modal" onclick="showImage('{{url('/')}}/new_gis/upload/{{$surveydata[0]->image_name}}')">View Image</a>
					<a class="btn btn-success" href="#" data-target="#map-default-modal" data-toggle="modal" onclick="showMap({{$surveydata[0]->lat}},{{$surveydata[0]->lng}})">View On Map</a>
				  {!!Form::Open(array('route'=>'update.PersonalDetails'))!!}
					<div class="row">
						<div class="col-lg-6">
							<div class="panel">
								<div class="panel-body">
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">भवन / प्लाट सं०</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" readonly value="{{$get_personal_details[0]->house_number}}" autocomplete="off" class="form-control" id="makan_no" name="makan_no">
											<input type="text" readonly value="{{$get_personal_details[0]->survey_id}}" autocomplete="off" class="form-control" id="surv_id" name="surv_id" style="display:none">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">पुराना भवन/प्लाट</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->old_house_number}}" autocomplete="off" class="form-control" id="old_house_number" name="old_house_number">
										</div>
									</div>

									<div class="col-lg-6">
									    <div class="form-group">
											<label class="control-label">भवन /प्लॉट के स्वामी का नाम</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
												<input type="text" value="{{$get_personal_details[0]->name}}" autocomplete="off" class="form-control" id="swami_ka_naam" name="swami_ka_naam" placeholder="Enter Full Name">
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">पिता / पति का नाम</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->father_name}}" autocomplete="off" class="form-control" id="pita_ka_naam" name="pita_ka_naam" placeholder="Enter Full Name">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">मोबाइल नंबर</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->mobile_number}}" autocomplete="off" class="form-control" id="mobile_num" name="mobile_num" placeholder="Enter Full Name">
										</div>
									</div>


									<div class="col-lg-12 text-center">
										<label class="control-label text-bold">----------भवन का छेत्रफल---------</label>
									</div>
									<div class="col-lg-12 text-left">
										<label class="control-label text-bold">पूरा  वर्ग फिट</label>
									</div>
									<div class="col-lg-6">

										<div class="form-group">
											<label class="control-label">लम्बाई </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->area_all}}" autocomplete="off" class="form-control" id="lengthpura" name="lengthpura" placeholder="Length">

										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">चौड़ाई  </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->area_all_width}}" autocomplete="off" class="form-control" id="widthpura" name="widthpura" placeholder="width">
										</div>
									</div>
									<div class="col-lg-12 text-left">
										<label class="control-label text-bold">निर्मित वर्गफिट </label>
									</div>
									<div class="col-lg-6">

										<div class="form-group">
											<label class="control-label">लम्बाई </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->area_constructed}}" autocomplete="off" class="form-control" id="lengthnirmit" name="lengthnirmit" placeholder="Length">

										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">चौड़ाई  </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->area_constructed_width}}" autocomplete="off" class="form-control" id="widthnirmit" name="widthnirmit" placeholder="width">
										</div>
									</div>
									<div class="col-lg-12 text-left">
										<label class="control-label text-bold">व्यवसायिक वर्गफिट</label>
									</div>
									<div class="col-lg-6">

										<div class="form-group">
											<label class="control-label">लम्बाई </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->area_business}}" autocomplete="off" class="form-control" id="lengthvyvsaik" name="lengthvyvsaik" placeholder="Length">

										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">चौड़ाई  </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->area_business_width}}" autocomplete="off" class="form-control" id="widthvyvsaik" name="widthvyvsaik" placeholder="width">
										</div>
									</div>
									<div class="col-lg-12 text-left">
										<label class="control-label text-bold">कॉमन छेत्रफल</label>
									</div>
									<div class="col-lg-6">

										<div class="form-group">
											<label class="control-label">लम्बाई </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->area_common_length}}" autocomplete="off" class="form-control" id="lengthcomon" name="lengthcomon" placeholder="Length">

										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">चौड़ाई  </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->area_common_width}}" autocomplete="off" class="form-control" id="widthcomon" name="widthcomon" placeholder="width">
										</div>
									</div>
									<div class="col-lg-12 text-center">
										<label class="control-label text-bold">----------भवन का विवरण---------</label>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label class="control-label">मंजिल की संख्या</label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->no_of_floor}}" autocomplete="off" class="form-control" id="manjilsankhya" name="manjilsankhya" placeholder="Enter Full Name">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label class="control-label">किरायेदार की संख्या </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->rented_person}}" autocomplete="off" class="form-control" id="kirayrdadasankh" name="kirayrdadasankh" placeholder="Enter Full Name">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label class="control-label">कमरों की संख्या </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->no_of_room}}" autocomplete="off" class="form-control" id="kamrokisankh" name="kamrokisankh" placeholder="Enter Full Name">
										</div>
									</div>

									<div class="col-lg-12 text-center">
										<label class="control-label text-bold">----------भवन का परिमाप फिट व इंच में---------</label>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">पूरब </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->length_east}}" autocomplete="off" class="form-control" id="purab" name="purab" placeholder="Enter Full Name">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">पश्चिम  </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->length_west}}" autocomplete="off" class="form-control" id="paschim" name="paschim" placeholder="Enter Full Name">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">उत्तर  </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->length_north}}" autocomplete="off" class="form-control" id="uttar" name="uttar" placeholder="Enter Full Name">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">दक्षिण </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->length_south}}" autocomplete="off" class="form-control" id="dachhin" name="dachhin" placeholder="Enter Full Name">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">निर्माण वर्ष</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" id="nirmaan_varsh" name="nirmaan_varsh">
											 <option value="{{$get_personal_details[0]->nirmanVarsh}}">{{$get_personal_details[0]->nirmanVarsh}}</option>


											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">निमार्ण की प्रकृति</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control"  name="bhavannirmankipravatti" id="bhavannirmankipravatti">
												<option  value="{{$get_personal_details[0]->NirmanPrakriti}}">{{$get_personal_details[0]->NirmanPrakriti}}</option>


											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label"> फर्श की प्रकृति</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" id="bhavan_k_farsh_prakarti" name="bhavan_k_farsh_prakarti">
											 <option  value="{{$get_personal_details[0]->FarshPrakriti}}">{{$get_personal_details[0]->FarshPrakriti}}</option>

											</select>
										</div>
                                    </div>

									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">सड़क की चौड़ाई</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="road_width" id="road_width">
											 <option  value="{{$get_personal_details[0]->sadakKichoudai}}">{{$get_personal_details[0]->sadakKichoudai}}</option>

											</select>
										</div>
                                    </div>

									<div class="col-lg-12 text-center">
										<label class="control-label text-bold">----------चौहद्दी नाम---------</label>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">पूरब </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" autocomplete="off" class="form-control" value="{{$get_personal_details[0]->locality_east}}" id="purab1" name="purab1" placeholder="Enter Full Name">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group ">
											<label class="control-label">पश्चिम  </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" autocomplete="off" class="form-control" value="{{$get_personal_details[0]->locality_west}}" id="paschim1" name="paschim1" placeholder="Enter Full Name">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">उत्तर  </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" autocomplete="off" class="form-control" value="{{$get_personal_details[0]->locality_north}}" id="uttar1" name="uttar1" placeholder="Enter Full Name">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">दक्षिण </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" autocomplete="off" class="form-control" value="{{$get_personal_details[0]->locality_south}}" id="dachhin1" name="dachhin1" placeholder="Enter Full Name">
										</div>
									</div>

                                </div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="panel">
								<div class="panel-body">

									<div class="col-lg-12 text-center">
										<label class="control-label text-bold">----------निर्माण छेत्र (वर्ग फिट)---------</label>
									</div>
									<div class="col-lg-12 text-left">
										<label class="control-label text-bold">भूमिगत मंजिल</label>
									</div>
									<div class="col-lg-6">

										<div class="form-group">
											<label class="control-label">लम्बाई </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->basement_area}}" autocomplete="off" class="form-control" id="lengthbasement" name="lengthbasement" placeholder="Length">

										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">चौड़ाई  </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->basement_area_width}}" autocomplete="off" class="form-control" id="widthbasement" name="widthbasement" placeholder="width">
										</div>
									</div>
									<div class="col-lg-12 text-left">
										<label class="control-label text-bold">तल मंजिल</label>
									</div>
									<div class="col-lg-6">

										<div class="form-group">
											<label class="control-label">लम्बाई </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->ground_area}}" autocomplete="off" class="form-control" id="lengthground" name="lengthground" placeholder="Length">

										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">चौड़ाई  </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->ground_area_width}}" autocomplete="off" class="form-control" id="widthground" name="widthground" placeholder="width">
										</div>
									</div>
									<div class="col-lg-12 text-left">
										<label class="control-label text-bold">पहली मंजिल </label>
									</div>
									<div class="col-lg-6">

										<div class="form-group">
											<label class="control-label">लम्बाई </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->first_area}}" autocomplete="off" class="form-control" id="lengthfirst" name="lengthfirst" placeholder="Length">

										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">चौड़ाई  </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->first_area_width}}" autocomplete="off" class="form-control" id="widthfirst" name="widthfirst" placeholder="width">
										</div>
									</div>
									<div class="col-lg-12 text-left">
										<label class="control-label text-bold">दूसरी मंजिल </label>
									</div>
									<div class="col-lg-6">

										<div class="form-group">
											<label class="control-label">लम्बाई </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->second_area}}" autocomplete="off" class="form-control" id="lengthsecond" name="lengthsecond" placeholder="Length">

										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">चौड़ाई  </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->second_area_width}}" autocomplete="off" class="form-control" id="widthsecond" name="widthsecond" placeholder="width">
										</div>
									</div>
									<div class="col-lg-12 text-left">
										<label class="control-label text-bold">तीसरी मंजिल</label>
									</div>
									<div class="col-lg-6">

										<div class="form-group">
											<label class="control-label">लम्बाई </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->third_area}}" autocomplete="off" class="form-control" id="lengththird" name="lengththird" placeholder="Length">

										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label">चौड़ाई  </label><font style="color:red">*&nbsp;&nbsp;<span id="errname"></span></font>
											<input type="text" value="{{$get_personal_details[0]->third_area_width}}" autocomplete="off" class="form-control" id="widththird" name="widththird" placeholder="width">
										</div>
									</div>
									<div class="col-lg-12 text-center">
										<label class="control-label text-bold">----------------अन्य विवरण--------------------</label>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">वार्ड नंबर </label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="ward_number" onchange="changeWardNumber();" id="ward_number">
											 <option  value="{{$get_personal_details[0]->ward_number}}">{{$get_personal_details[0]->ward_number}}</option>
											@foreach($get_ward_number as $value)
											<option value="{{$value->ward_number}}">{{$value->ward_number}}</option>
											@endforeach
											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">वार्ड का नाम </label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="wardName" id="wardName">
											 	<option  value="{{$get_house_details[0]->wardName}}">{{$get_house_details[0]->wardName}}</option>
											</select>
										</div>
								    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">मोहल्ला का नाम </label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="mohallaName" id="mohallaName">
											 	<option  value="{{$get_house_details[0]->mohallaName}}">{{$get_house_details[0]->mohallaName}}</option>
											</select>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">निर्माण  का प्रकार</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="NirmanPrakar" id="NirmanPrakar">
											 <option  value="{{$get_house_details[0]->nirmanBhavanKaPrakar}}">{{$get_house_details[0]->nirmanBhavanKaPrakar}}</option>

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">पंजीकरण प्रकार</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="panjikaran" id="panjikaran">
											 <option  value="{{$get_house_details[0]->panjikaran}}">{{$get_house_details[0]->panjikaran}}</option>

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">संपत्ति श्रेणी</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="sampattiShreni" id="sampattiShreni">
											 <option  value="{{$get_house_details[0]->sampattiShreni}}">{{$get_house_details[0]->sampattiShreni}}</option>

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">संपत्ति प्रकार</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="sampattiPrakar" id="sampattiPrakar">
											 <option  value="{{$get_house_details[0]->sampattiPrakar}}">{{$get_house_details[0]->sampattiPrakar}}</option>
                                             @foreach ($property_type as $value )
                                                 <option value="{{$value->property_type_name}}">{{$value->property_type_name}}</option>
                                             @endforeach

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">शौचालय</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="souchayala" id="souchayala">
											 <option  value="{{$get_house_details[0]->souchayala}}">{{$get_house_details[0]->souchayala}}</option>

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">सड़क के प्रकार</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="sadakKePrakar" id="sadakKePrakar">
											 <option  value="{{$get_house_details[0]->sadakKePrakar}}">{{$get_house_details[0]->sadakKePrakar}}</option>

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">धर्म</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="dharm" id="dharm">
											 <option  value="{{$get_house_details[0]->dharm}}">{{$get_house_details[0]->dharm}}</option>

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">जाति</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="jati" id="jati">
											 <option  value="{{$get_house_details[0]->jati}}">{{$get_house_details[0]->jati}}</option>

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">जलापूर्ति</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="jalapurti" id="jalapurti">
											 <option  value="{{$get_house_details[0]->jalapurti}}">{{$get_house_details[0]->jalapurti}}</option>

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">गैस कनेक्शन</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="gasConnection" id="gasConnection">
											 <option  value="{{$get_house_details[0]->gasConnection}}">{{$get_house_details[0]->gasConnection}}</option>

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">बिजली के मीटर</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="bijliMeter" id="bijliMeter">
											 <option  value="{{$get_house_details[0]->bijliMeter}}">{{$get_house_details[0]->bijliMeter}}</option>

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">किरायेदार हैं</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="kirayedaar" id="kirayedaar">
											 <option  value="{{$get_house_details[0]->kirayedaar}}">{{$get_house_details[0]->kirayedaar}}</option>

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">मालिक  है</label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="malik" id="malik">
											 <option  value="{{$get_house_details[0]->malik}}">{{$get_house_details[0]->malik}}</option>

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">राशन कार्ड </label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<select class="form-control" name="rashanCard" id="rashanCard">
											 <option  value="{{$get_house_details[0]->rashanCard}}">{{$get_house_details[0]->rashanCard}}</option>

											</select>
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">राशन कार्ड नंबर </label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<input type="text" value="{{$get_house_details[0]->rashanCardNumber}}" autocomplete="off" class="form-control" id="rashanCardNumber" name="rashanCardNumber" placeholder="राशन कार्ड नंबर ">
										</div>
                                    </div>
									<div class="col-lg-3">
										<div class="form-group">
											<label class="control-label">बिजली मीटर नंबर </label><font style="color:red">*&nbsp;&nbsp;<span id="errstate"></span></font>
											<input type="text" value="{{$get_house_details[0]->bijliMeterNumber}}" autocomplete="off" class="form-control" id="bijliMeterNumber" name="bijliMeterNumber" placeholder="बिजली मीटर नंबर">
										</div>
                                    </div>


                                </div>
							</div>
						</div>
					</div>


					<input type="hidden" name="id" value="" >
					<div align="center">
					@if($user_access[0]->fn_update=='Y')
						<input type='hidden' id='city' value='{{$get_house_details[0]->city}}'>
					<input class="btn btn-primary" value="Update House Details" name="update" type="submit">
                   @endif


					<input class="btn btn-primary" value="Reset" type="reset"></div>
				 {!!Form::Close()!!}
				</div>
				<!--===================================================-->
				<!--End page content-->

			</div>
			<div class="modal fade"  id="demo-default-modal" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
				<div class="modal-dialog" >
					<div class="modal-content">

						<!--Modal header-->
						<div class="modal-header">
							<button data-dismiss="modal" class="close" type="button">
							<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title"><span id="address">House Image</span></h4>
						</div>

						<!--Modal body-->
						<div class="modal-body">
							<img src="img/av1.png" id="image" style="width:100%;height:450px">
						</div>

						<!--Modal footer-->
						<div class="modal-footer">
							<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>

						</div>
					</div>
				</div>
			</div>

			<div class="modal fade"  id="map-default-modal" role="dialog" tabindex="-1" aria-labelledby="map-default-modal" aria-hidden="true">
				<div class="modal-dialog" >
					<div class="modal-content">
						<!--Modal header-->
						<div class="modal-header">
							<button data-dismiss="modal" class="close" type="button">
							<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title"><span id="address">Map View</span></h4>
						</div>
						<!--Modal body-->
						<div class="modal-body">
							<div style="height:500px;width:100%;" id="map"></div>
						</div>
						<!--Modal footer-->
						<div class="modal-footer">
							<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>

						</div>
					</div>
				</div>
			</div>

	@endsection
	@section('script')
	<script>
	$(document).ready(function(e){
		GetConstructionAge();
		GetRoadwidth();
	});

	$.ajax({
		url:"{{url('/')}}/new_gis/bpage.php?action=selectHouseDetails",
		dataType:"json",
		success:function(data){
			console.log(data);
			var Dharm=data.Dharm;
			$("#dharm").html();
			for(var i=1;i<Dharm.length;i++)
			{
				$("#dharm").append('<option value="'+Dharm[i]+'">'+Dharm[i]+'</option>');
			}
			var NirmanPrakar=data.NirmanPrakar;
			$("#NirmanPrakar").html();
			for(var i=1;i<NirmanPrakar.length;i++)
			{
				$("#NirmanPrakar").append('<option value="'+NirmanPrakar[i]+'">'+NirmanPrakar[i]+'</option>');
			}
			var PanjikaranPrakar=data.PanjikaranPrakar;
			$("#panjikaran").html();
			for(var i=1;i<PanjikaranPrakar.length;i++)
			{
				$("#panjikaran").append('<option value="'+PanjikaranPrakar[i]+'">'+PanjikaranPrakar[i]+'</option>');
			}
			var SampatiShreni=data.SampatiShreni;
			$("#sampattiShreni").html();
			for(var i=1;i<SampatiShreni.length;i++)
			{
				$("#sampattiShreni").append('<option value="'+SampatiShreni[i]+'">'+SampatiShreni[i]+'</option>');
			}
			var SampatiPrakar=data.SampatiPrakar;
			// $("#sampattiPrakar").html();
			// for(var i=1;i<SampatiPrakar.length;i++)
			// {
			// 	$("#sampattiPrakar").append('<option value="'+SampatiPrakar[i]+'">'+SampatiPrakar[i]+'</option>');
			// }
			var Souchalaya=data.Souchalaya;
			$("#souchayala").html();
			for(var i=1;i<SampatiPrakar.length;i++)
			{
				$("#souchayala").append('<option value="'+Souchalaya[i]+'">'+Souchalaya[i]+'</option>');
			}
			var SadakKePrakar=data.SadakKePrakar;
			$("#sadakKePrakar").html();
			for(var i=1;i<SadakKePrakar.length;i++)
			{
				$("#sadakKePrakar").append('<option value="'+SadakKePrakar[i]+'">'+SadakKePrakar[i]+'</option>');
			}
			var Jati=data.Jati;
			$("#jati").html();
			for(var i=1;i<Jati.length;i++)
			{
				$("#jati").append('<option value="'+Jati[i]+'">'+Jati[i]+'</option>');
			}
			var Jalapurti=data.Jalapurti;
			$("#jalapurti").html();
			for(var i=1;i<Jalapurti.length;i++)
			{
				$("#jalapurti").append('<option value="'+Jalapurti[i]+'">'+Jalapurti[i]+'</option>');
			}
			var gasconnection=data.gasconnection;
			$("#gasConnection").html();
			for(var i=1;i<gasconnection.length;i++)
			{
				$("#gasConnection").append('<option value="'+gasconnection[i]+'">'+gasconnection[i]+'</option>');
			}
			var electricity=data.electricity;
			$("#bijliMeter").html();
			for(var i=1;i<electricity.length;i++)
			{
				$("#bijliMeter").append('<option value="'+electricity[i]+'">'+electricity[i]+'</option>');
			}
			var kitayedarhai=data.kitayedarhai;
			$("#kirayedaar").html();
			for(var i=1;i<kitayedarhai.length;i++)
			{
				$("#kirayedaar").append('<option value="'+kitayedarhai[i]+'">'+kitayedarhai[i]+'</option>');
			}
			var malikhai=data.malikhai;
			$("#malik").html();
			for(var i=1;i<malikhai.length;i++)
			{
				$("#malik").append('<option value="'+malikhai[i]+'">'+malikhai[i]+'</option>');
			}
			var RashanCard=data.RashanCard;
			$("#rashanCard").html();
			for(var i=1;i<RashanCard.length;i++)
			{
				$("#rashanCard").append('<option value="'+RashanCard[i]+'">'+RashanCard[i]+'</option>');
			}
			var NirmanPrakriti=data.NirmanPrakriti;
			$("#bhavannirmankipravatti").html();
			for(var i=1;i<NirmanPrakriti.length;i++)
			{
				$("#bhavannirmankipravatti").append('<option value="'+NirmanPrakriti[i]+'">'+NirmanPrakriti[i]+'</option>');
			}
			var FarshPrakriti=data.FarshPrakriti;
			$("#bhavan_k_farsh_prakarti").html();
			for(var i=1;i<FarshPrakriti.length;i++)
			{
				$("#bhavan_k_farsh_prakarti").append('<option value="'+FarshPrakriti[i]+'">'+FarshPrakriti[i]+'</option>');
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
		var wardName="{{$get_house_details[0]->wardName}}";
		var mohallaName="{{$get_house_details[0]->mohallaName}}";
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
	@endsection
