
@extends('master')
@section('content');


			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">


				<div id="page-content">
					@if($user_access[0]->fn_add=='Y')
				   <div class="row">
						<div class="col-sm-12">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Manage Old House Details</h3>
								</div>

								<!--Block Styled Form -->
								<!--===================================================-->
								{{-- {!!Form::Open(array('route'=>'save.ImportoldHouseDetails'))!!} --}}
                                <form method="POST" enctype="multipart/form-data" action="{{url('/')}}/Save-Import-old-House-Details">
                                    {{ csrf_field() }}
									<div class="panel-body">
										<div class="row">
										  <div class="col-lg-4">
												<div class="form-group">
													<label class="control-label">City</label>
													<select class="form-control" name="city" id="city_id"  required onchange="getmohlla()">
								                        <option value="">--Select Nagar Palika--</option>
                                                        @foreach ($city as $value)
                                                        @if($value->city == old('city'))
                                                        <option selected="selected" value="{{ $value->city }}">{{ $value->city }}</option>
                                                        @else
                                                        <option value="{{ $value->city }}">{{ $value->city }}</option>
                                                        @endif

                                                        @endforeach
													</select>
                                                    @if ($errors->has('city'))
                                                    <div class="invalid-feedback">{{ $errors->first('city') }}</div>
                                                  @endif
								                </div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label class="control-label">Mohalla</label>
													<select class="form-control" name="ward_number" id="ward_number" required>
								                      <option value="">--Select Mohalla--</option>
													</select>
								                </div>
											</div>
                                            <div class="col-lg-4">
                                                <div class="form-group ">
                                                  <label class="control-label">Import old House Excel </label>
                                                  <input type="file" class="form-control" id="excel" name="excel">
                                                </div>
                                            </div>

                                         <div class="col-lg-12">
                                                <div class="btn-list text-center">
                                                  <input class="btn btn-primary" type="submit" name="subBtn" value="Submit" >
                                                  <a href="{{url('/')}}/old_house_excel_sample.xlsx" class="btn btn-warning" download accept=".xls,.xlsx">Download Excel Sample</a>
                                                  <a href="{{url('/')}}/Import-old-House-Details" class="btn btn-danger">Reset</a>
                                                </div>
                                              </div>
										</div>

									</div>
                                </form>
								{{-- {!!Form::Close()!!} --}}
								<!--===================================================-->
								<!--End Block Styled Form -->

							</div>
						</div>

					</div>
					@endif

				</div>

			</div>


	@endsection

	@section('script');
	<script>
		$('document').ready(function(e){
			getmohlla();
		});

		function getmohlla()
		{

            var city_id = $("#city_id").val();
			$.ajax
			({
				url:"{{url('/')}}/getmohllaward/"+city_id,
				dataType:'json',
				success:function(data)
				{
					var msg='<option value="">--Select Ward Number--</option>';
					for(var i=0;i<data.length;i++)
					{
						msg=msg+'<option value="'+data[i].ward_number+'->'+data[i].ward_name+'->'+data[i].mohalla_name+'">'+data[i].ward_number+'->'+data[i].ward_name+'->'+data[i].mohalla_name+'</option>';
					}
					$("#ward_number").html(msg);
				}
			});
		}





	</script>

@endsection
















