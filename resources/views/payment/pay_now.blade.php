@extends('payment.master')
@section('content')
<section class="content-wrapper main-content clear-fix">

    <div class="row">
        <div class="col-md-12 text-center">
            <h2><b><u>PAY NOW</u></b></h2>
        </div>
    </div>
    <form method="Get" action="{{ url('/') }}/payment/Pay">
        <div class="container body-content">
            <div class="panel panel-default col-md-6 col-md-offset-3">
                <br><br>
                <div class="row">
                    <div class="col-xs-4">Session</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->session}}-{{$tabledata->session+1}}</div>
                    <div class="col-xs-4">PROPERTY ID</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->survey_id}}</div>
                    <div class="col-xs-4">HOUSE NO</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->house_number_1}}</div>
                    <div class="col-xs-4">NAME</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->name}}</div>
                    <div class="col-xs-4">FATHER NAME</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->father_name}}</div>
                    <div class="col-xs-4">MOHALLA</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->mohallaName}}</div>
                    <div class="col-xs-4">WARD</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->wardName}}</div>
                    <div class="col-xs-4">ARV IN RS.</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->arv_total}}</div>
                    <div class="col-xs-4">ARREAR</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->overdue_amount}}</div>
                    <div class="col-xs-4">CURR. ARR. INT.</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->interest_amount}}</div>
                    <div class="col-xs-4">HOUSE TAX</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->house_tax}}</div>
                    <div class="col-xs-4">WATER TAX</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->water_tax}}</div>
                    <div class="col-xs-4">PAID AMOUNT</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->paid}}</div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('email')) has-error @endif has-feedback">
                            <label class="control-label" for="inputError"><span style="color:red;">*</span>Email:</label>
                            <input type="email" class="form-control" name="email">
                            <input type="hidden" class="form-control" value="{{$tabledata->survey_id}}" readonly="readonly" name="house_id">
                            @if ($errors->has('email'))
                            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            <span style="color:red;">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    @if($tabledata->mobile_number=="0000000000")
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('mobile')) has-error @endif has-feedback">
                            <label class="control-label" for="inputError"><span style="color:red;">*</span>Mobile Number:</label>
                            <input type="number" class="form-control" name="mobile">
                            @if ($errors->has('mobile'))
                            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            <span style="color:red;">{{ $errors->first('mobile') }}</span>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pwd"><span style="color:red;">*</span>Mobile Number:</label>
                            <input type="text" class="form-control" id="pwd" value="{{$tabledata->mobile_number}}" readonly="readonly" name="mobile">
                        </div>
                    </div>
                    @endif
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pwd"><span style="color:red;">*</span>Payable Amount:</label>
                            <input type="text" class="form-control" value="{{$tabledata->due_amount}}" name="pay_amount" >
                        </div>
                    </div>

                </div>
                <br>
                <span style="color:red;">* Fields are mandatory</span>
                <br>
                <div class="row">
                    <div class='wrapper text-center'>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success">Pay Now</button>
                            <a href="{{ url('/') }}/payment/Ledger" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </div>
                <br><br>
            </div>
        </div>
    </form>
</section>
@endsection
