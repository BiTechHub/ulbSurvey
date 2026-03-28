@extends('payment.master')
@section('content')
<section class="content-wrapper main-content clear-fix">

    <div class="row">
        <div class="col-md-12 text-center">
            <h2><b><u>VIEW LEDGER</u></b></h2>
        </div>
    </div>
    <form method="POST">
        {{csrf_field()}}
        <div class="container body-content">
            <div class="panel panel-default col-md-6 col-md-offset-3">
                <br><br>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="form-group @if ($errors->has('property_id')) has-error @endif has-feedback">
                            <label class="control-label" for="inputError">Property Id:</label>
                            <input type="text" class="form-control" name="property_id">
                            @if ($errors->has('property_id'))
                            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            <span style="color:red;">{{ $errors->first('property_id') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <small><b>OR</b></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="form-group @if ($errors->has('receipt_number')) has-error @endif has-feedback">
                            <label class="control-label" for="inputError">Receipt No:</label>
                            <input type="text" class="form-control" name="receipt_number">
                            @if ($errors->has('receipt_number'))
                            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            <span style="color:red;">{{ $errors->first('receipt_number') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class='wrapper text-center'>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success">Search</button>
                            <a href="{{ url('/') }}/payment/Ledger" class="btn btn-info">Search Again !</a>
                        </div>
                    </div>
                </div>
                <br><br><br><br><br>
                <div class="row">
                    <div class='wrapper text-center'>
                        <a href="{{ url('/') }}/payment/Pay-Tax">Please Click Here To know Your Property ID</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
