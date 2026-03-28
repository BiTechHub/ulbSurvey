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
                            <h3 class="panel-title">Edit Discount</h3>
                        </div>
                        <!--Block Styled Form -->
                        <!--===================================================-->
                        {!! Form::Open(['route' => 'update.DiscountDetail']) !!}
                        <div class="panel-body">
                            <div class="row">
                                {{-- <div class="col-lg-3">
                                <div class="form-group @if ($errors->has('ngrpalika')) has-error @endif">
                                    <label class="control-label">NagarPalika</label>
                                    <select class="form-control @if ($errors->has('ngrpalika')) is-invalid @endif" 
                                        id="nagarpalika" name="ngrpalika"  onchange="fill_construction_age();">
                                      <option value="">Select State</option>
                                        @foreach ($city as $value)
                                            <option selected value="{{ $value->id }}">{{ $value->city }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ngrpalika'))
                                    <small class="help-block" data-bv-validator="notEmpty" data-bv-for="ngrpalika"
                                    data-bv-result="INVALID" style="">{{ $errors->first('ngrpalika') }}</small>
                                    @endif
                                  </div>
                                </div> --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">NagarPalika</label>
                                        <select class="form-control" name="ngrpalika" id="nagarpalika"
                                        onchange="fill_construction_age();" >
                                            <option value="{{ $discount[0]->nagarpalika }}">
                                                {{ $discount[0]->nagarpalika }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Select Construction Age</label>
                                        <select class="form-control" name="consage" id="consage"   >
                                            <option value="">--Select Construction Age--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Discount</label>
                                        {!! Form::text('discount', $discount[0]->discount_rate, ['class' => 'form-control', 'placeholder' => 'Enter Discount Rate']) !!}
                                        {!! Form::text('id', $discount[0]->id, ['class' => 'form-control', 'placeholder' => 'Enter Discount Rate', 'style' => 'display:none;']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            @if ($user_access[0]->fn_update == 'Y')
                                {!! Form::submit('Update', ['class' => 'btn btn-danger text-uppercase']) !!}
                            @endif
                        </div>
                        {!! Form::Close() !!}
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
        $( document ).ready(function() {
    // console.log( "ready!" );
    city();
          
});

function fill_construction_age() {
               var nagarpalika = $("#nagarpalika").val();
            //    alert(nagarpalika);
               $.ajax({
                   url: "{{ url('/') }}/getConstructionAge/" + nagarpalika,
                   dataType: 'json',
                   success: function(data) {
                       console.log(data);
                       var msg = '<option value="">--Select Construction Age--</option>';
                       for (var i = 0; i < data.length; i++) {
                           msg = msg + '<option value="' + data[i].age + '">' + data[i].age + '</option>';
                       }
                       $("#consage").html(msg);
                   }
               });
           }        
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
