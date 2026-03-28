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
                            <h3 class="panel-title">Edit Road/width</h3>
                        </div>
                        <!--Block Styled Form -->
                        <!--===================================================-->
                        {!! Form::Open(['route' => 'update.RoadWidthDetail']) !!}
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">NagarPalika</label>
                                        <select class="form-control" name="ngrpalika" id="nagarpalika"
                                            onmouseover="city();">
                                            <option value="{{ $road_data[0]->nagarpalika }}">
                                                {{ $road_data[0]->nagarpalika }}</option>
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Road Width(In Feat)</label>
                                        {!!Form::text('roadwid',$road_data[0]->road_width,array('class'=>'form-control','placeholder'=>'Enter Road width'))!!}
                                        {!!Form::text('id',$road_data[0]->id,array('class'=>'form-control','placeholder'=>'Enter Road width' , 'style'=>'display:none;'))!!}
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
