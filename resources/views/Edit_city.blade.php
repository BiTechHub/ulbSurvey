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
                            <h3 class="panel-title">Edit City</h3>
                        </div>
                        <!--Block Styled Form -->
                        <!--===================================================-->
                        {!! Form::Open(['route' => 'update.manageCity']) !!}
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Select State</label>
                                        <select class="form-control" name="state">
                                            <option value="">--Select State--</option>
                                            <option value="34">Uttar Pradesh</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">ULB Type</label>
                                        <select class="form-control" name="ulb_type">
                                            <option value="">--Select--</option>
                                            <option value="Nagar Palika Parishad">Nagar Palika Parishad</option>
                                            <option value="Nagar Nigam">Nagar Nigam</option>
                                            <option value="Nagar Panchayat">Nagar Panchayat</option>
                                        </select>
                                    </div>
                                </div>
                               
                               
                              
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">City/Nagarpalika</label>
                                        {!!Form::text('city',$citylist[0]->city,array('class'=>'form-control','placeholder'=>'Enter city/nagarpalika','Readonly'))!!}
                                        {{-- {!! Form::text('city', '', ['class' => 'form-control', 'placeholder' => 'Enter city/nagarpalika','Readonly']) !!} --}}
                                        {!!Form::text('id',$citylist[0]->id,array('class'=>'form-control','placeholder'=>'Enter city/nagarpalika' , 'style'=>'display:none;'))!!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Interest Rate (%)</label>
                                        {!!Form::text('interest_rate',$citylist[0]->interest_rate,array('class'=>'form-control','placeholder'=>'Enter Interest Rate'))!!}
                                        {{-- {!! Form::text('interest_rate', '', ['class' => 'form-control', 'placeholder' => 'Enter Interest Rate']) !!} --}}
                                        {!!Form::text('id',$citylist[0]->id,array('class'=>'form-control','placeholder'=>'Enter Interest Rate' , 'style'=>'display:none;'))!!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            @if($user_access[0]->fn_update=='Y')
                            {!!Form::submit('Update',array('class'=>'btn btn-danger text-uppercase'))!!}
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
       
    </script>
@endsection
