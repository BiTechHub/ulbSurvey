
@extends('master')
@section('content');

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div id="content-container">
				
				
				<div id="page-content">
					
				
					<div class="row">
						<div class="col-sm-12">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Add Mukhiya</h3>
								</div>
					            <form action="{{url('/')}}/SaveMukhiya" method="post">
								@csrf
								<div class="panel-body">
										<div class="row">
										@if(session('success1'))
											<div class="alert alert-success">{{session('success1')}}</div>
										@endif
										<div class="col-sm-3">
												<div class="form-group">
													<label class="control-label">NagarPalika</label>
													<select class="form-control" name="ngrpalika" id="nagarpalika1" >
								                         <option value="">--Select Nagar Plika--</option>
														 
								                         
													 
								                    </select>
												</div>
											</div>
										<div class="col-sm-3">
												<div class="form-group">
													
													<div class="form-group">
													<label class="control-label">House Id</label>
													<input type="text" name="houseid" class="form-control" placeholder="Enter House Number">
												</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													
													<div class="form-group">
													<label class="control-label">Mukhiya Name</label>
													<input type="text" name="mukhiya" class="form-control" placeholder="Enter Mukhiya Name">
												</div>
												</div>
											</div>
										</div>
								</div>
								<div class="panel-footer text-right">
								<input type="submit" value="Save" class="btn btn-danger text-uppercase">
								</div>
								</form>
								<!--Block Styled Form -->
								<!--===================================================-->
								<div class="panel-heading">
									<h3 class="panel-title">Add Family Member</h3>
								</div>
								{!!Form::Open(array('route'=>'save.new-parivar'))!!}
									<div class="panel-body">
										<div class="row">
										@if(session('success'))
											<div class="alert alert-success">{{session('success')}}</div>
										@endif
										    <div class="col-sm-3">
												<div class="form-group">
													<label class="control-label">NagarPalika</label>
													<select class="form-control" name="ngrpalika" id="nagarpalika" >
								                         <option value="">--Select Nagar Plika--</option>
														 
								                         
													 
								                    </select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													
													<div class="form-group">
													<label class="control-label">House Id</label>
													<input type="text" name="houseid" id="hid"   onchange="getmukhiya(this.value);" class="form-control" placeholder="Enter House Number">
												</div>
												</div>
											</div>
											
										</div>
										<div class="row ">

                                    <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
									<th>Mukhiya Name</th>
                                    <th>Member Name</th>
                                    <th>Father/Husband</th>
                                    <th>Relation</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Occupation</th>
									<th>Education</th>
                                    <th>Aadhar Number</th>
                                    <th>Abhiyukti</th>
                                    </tr>
                                    </thead>

                                    <tbody >
                                    <tr class="form-group multiple-form-group">
									    <td>
										<select class="form-control" name="mukhiya_n[]" required id="mkh">
								                         <option value="">--Select Mukhiya--</option>
														 
								                         
													 
								        </select>
										</td>
									    <td>{!!Form::text('member[]','',array('class'=>'form-control','placeholder'=>'Enter Member name','required'=>'required'))!!}</td>
                                        <td>{!!Form::text('father_husband[]','',array('class'=>'form-control','placeholder'=>'Enter Father/Husband name','required'=>'required'))!!}</td>
									    <td>
										<select class="form-control" name="relation[]" required id="relation" >
								                         <option value="">--Select Relation--</option>
														 <option value="Self">Self</option>
														 <option value="Father">Father</option>
								                         <option value="Mother">Mother</option>
													     <option value="Son">Son</option>
														 <option value="Brother">Brother</option>
														 <option value="Brother In Law">Brother In Law</option>
								                         <option value="Sister">Sister</option>
														 <option value="Daughter In Law">Daughter In Law</option>
													     <option value="Son In Law">Son In Law</option>
														 <option value="Daughter">Daughter</option>
														 <option value="Husband">Husband</option>
								                         <option value="Wife">Wife</option>
													     <option value="Grandson">Grandson</option>
														 <option value="Granddaughter">Granddaughter</option>
														 <option value="Nephew">Nephew</option>
														 <option value="Niece">Niece</option>
								                    </select>
										</td>
                                        <td>
										<select class="form-control" name="gender[]" required id="nagarpalika" >
								                         <option value="">--Select Gender--</option>
														 <option value="Male">Male</option>
								                         <option value="Female">Female</option>
													     <option value="Other">Other</option>
								                    </select>
										</td>
                                        <td>{!!Form::date('age[]','',array('class'=>'form-control','placeholder'=>'Enter Age','required'=>'required'))!!}</td>
                                        <td>{!!Form::text('occupation[]','',array('class'=>'form-control','placeholder'=>'Enter Occupation','required'=>'required'))!!}</td>
                                        <td>
										<select class="form-control" required name="education[]" id="education" >
								                         <option value="">--Select Education--</option>
														 <option value="Illiterate">Illiterate</option>
														 <option value="5th">5th</option>
								                         <option value="8th">8th</option>
													     <option value="10th">10th</option>
														 <option value="12th">12th</option>
														 <option value="Graduate">Graduate</option>
								                         <option value="Post Graduate">Post Graduate</option>
													     <option value="Politechnic">Politechnic</option>
														 <option value="I.T.I">I.T.I</option>
														 <option value="Other">Other</option>
								                         
								                    </select>
										</td>
                                        <td><input type="text" required name="aadhar[]" id="aadhar" class="form-control"></td>
                                        <td>{!!Form::text('abhiyukti[]','',array('class'=>'form-control','placeholder'=>'Enter Abhiyukti','required'=>'required'))!!}</td>
                                        <td>
                                            <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-add">+</button>
                                            </span>
                                        </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
									</div>
									<div class="panel-footer text-right">
									@if($user_access[0]->fn_add=='Y')
										{!!Form::submit('save',array('class'=>'btn btn-danger text-uppercase'))!!}
									@endif
									</div>
								{!!Form::Close()!!}
								<!--===================================================-->
								<!--End Block Styled Form -->
					
							</div>
						</div>
					
					</div>
				</div>
					
			</div>		
					
		
	

@endsection
			
@section('script')
<script>
(function ($) {
    $(function () {

        var addFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.form-group');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
            var $formGroupClone = $formGroup.clone();

            $(this)
                .toggleClass('btn-success btn-add btn-danger btn-remove')
                .html('–');

            $formGroupClone.find('input').val('');
            $formGroupClone.find('.concept').text('Phone');
            $formGroupClone.insertAfter($formGroup);

            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
            if ($multipleFormGroup.data('max') <= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', true);
            }
        };

        var removeFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.form-group');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');

            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
            if ($multipleFormGroup.data('max') >= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', false);
            }

            $formGroup.remove();
        };

        var selectFormGroup = function (event) {
            event.preventDefault();

            var $selectGroup = $(this).closest('.input-group-select');
            var param = $(this).attr("href").replace("#","");
            var concept = $(this).text();

            $selectGroup.find('.concept').text(concept);
            $selectGroup.find('.input-group-select-val').val(param);

        }

        var countFormGroup = function ($form) {
            return $form.find('.form-group').length;
        };

        $(document).on('click', '.btn-add', addFormGroup);
        $(document).on('click', '.btn-remove', removeFormGroup);
        $(document).on('click', '.dropdown-menu a', selectFormGroup);

    });
})(jQuery);


</script>
<script>
	function verifyHouse(value) {
            
                $.ajax({
                    url: "{{ url('/') }}/verifyHouse/" + value,
                    success: function(data) {
                        console.log(data);
                        if (data == "") {
                            $("#house_id").val("");
                            alert(data);
                        }
                    }
                });
          
        }
		function city()
		{
			
			$.ajax
			({
				url:"{{url('/')}}/getnagarpalika",
				dataType:'json',
				success:function(data)
				{
					var msg='<option value="">--Select Nagar Palika--</option>';
					for(var i=0;i<data.length;i++)
					{
						msg=msg+'<option value="'+data[i].city+'">'+data[i].city+'</option>';
					}
					$("#nagarpalika").html(msg);
					$("#nagarpalika1").html(msg);
				}
			});
		}
		$('document').ready(function(e){
			city();
		});
		function getmukhiya(housenumber)
	    {
		var ngpalika=$("#nagarpalika").val();
		$.ajax
			({
				url:"{{url('/')}}/getmukhiya",
				data:"housenumber="+housenumber+"&ngpalika="+ngpalika,
				success:function(result)
				{
					data = JSON.parse(result);
					var msg='<option value="">--Select Mukhiya--</option>';
					for(var i=0;i<data.length;i++)
					{
						msg=msg+'<option value="'+data[i].id+'">'+data[i].mukhiya+'</option>';
					}
					
					$("#mkh").html(msg);
				}
			});
	    }
		
	</script>
	
@endsection	

		

		

	
		
		



	
	

