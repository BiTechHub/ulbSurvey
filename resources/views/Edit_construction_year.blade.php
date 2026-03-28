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
                            <h3 class="panel-title">Edit Construction Year</h3>
                        </div>
                        <!--Block Styled Form -->
                        <!--===================================================-->
                        {!! Form::Open(['route' => 'update.Construction']) !!}
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">NagarPalika</label>
                                        <select class="form-control" name="ngrpalika" id="nagarpalika"
                                            onmouseover="city();">
                                            <option value="{{ $conts_age[0]->nagarpalika }}">
                                                {{ $conts_age[0]->nagarpalika }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Select Construction Year</label>
                                        <select class="form-control" name="year" id="year">
                                         <option value="0">--Select Year--</option>
                                         <option value="0 To 10">0 To 10</option>
                                         <option value="10 To 20">10 To 20</option>
                                         <option value="More Than 20">More Than 20</option>
                                        </select>
                                    </div>
                                </div>
                               
                                {{-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Road Width(In Feat)</label>
                                        {!!Form::text('roadwid',$conts_age[0]->road_width,array('class'=>'form-control','placeholder'=>'Enter Road width'))!!}
                                        {!!Form::text('id',$conts_age[0]->id,array('class'=>'form-control','placeholder'=>'Enter Road width' , 'style'=>'display:none;'))!!}
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            @if($user_access[0]->fn_update=='Y')
                            {!!Form::submit('Update',array('class'=>'btn btn-danger text-uppercase'))!!}
                            {!!Form::text('id',$conts_age[0]->id,array('class'=>'form-control' , 'style'=>'display:none;'))!!}
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
