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
                            <h3 class="panel-title">Edit Property Type</h3>
                        </div>
                        <!--Block Styled Form -->
                        <!--===================================================-->
                        {!! Form::Open(['route' => 'update.PropertType']) !!}
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Property Type</label>
                                        {{-- {!!Form::text('asset_name','',array('class'=>'form-control','placeholder'=>'Enter Assets Name'))!!} --}}
                                        {!!Form::text('property_type_name',$property_type_name[0]->property_type_name,array('class'=>'form-control','placeholder'=>'Enter Property Type Name'))!!}
                                        {!!Form::text('id',$property_type_name[0]->id,array('class'=>'form-control','placeholder'=>'Enter Property Type Name' , 'style'=>'display:none;'))!!}
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Property Tax</label>
                                        {{-- {!!Form::text('asset_name','',array('class'=>'form-control','placeholder'=>'Enter Assets Name'))!!} --}}
                                        {!!Form::text('tax_rate',$property_type_name[0]->tax_rate,array('class'=>'form-control','placeholder'=>'Enter Property Tax'))!!}
                                        {!!Form::text('id',$property_type_name[0]->id,array('class'=>'form-control','placeholder'=>'Enter Property Type Name' , 'style'=>'display:none;'))!!}
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
    </script>
@endsection
