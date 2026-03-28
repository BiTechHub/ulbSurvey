@extends('payment.master')
@section('content')
<section class="content-wrapper main-content clear-fix">

    <div class="row">
        <div class="col-md-12 text-center">
            <h2 style="color:#28a128;"><b><u>PAYMENT SUCCESS</u></b></h2>
            <img src="{{url('/')}}/pay/images/check.png" width="100" />
        </div>
    </div>
    <form method="Get" action="{{ url('/') }}/payment/Pay">
        <div class="container body-content">
            <div class="panel panel-default col-md-6 col-md-offset-3">
                <br><br>
                <div class="row">
                    <div class="col-xs-4">PROPERTY ID</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->survey_id}}</div>
                    <div class="col-xs-4">HOUSE NO</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->house_number_1}}</div>
                    <div class="col-xs-4">NAME</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->name}}</div>
                    <div class="col-xs-4">FATHER NAME</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->father_name}}</div>
                    <div class="col-xs-4">MOHALLA</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->mohallaName}}</div>
                    <div class="col-xs-4">WARD</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->wardName}}</div>
                    <div class="col-xs-4">PAY AMOUNT.</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$online_payment_data->net_amount_debit}}</div>
                    <div class="col-xs-4">TOTAL PAID AMOUNT</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->paid}}</div>
                    <div class="col-xs-4">TOTAL DUE AMOUNT</div><div class="col-xs-1">:</div><div class="col-xs-7">{{$tabledata->due_amount}}</div>
                </div>
                <br><br>
                <div class="row">
                    <div class='wrapper text-center'>
                        <div class="btn-group">
                            <a href="{{ url('/') }}/payment/Print-Receipt/{{$payment_logs->receipt_number}}" class="btn btn-success">PRINT RECEIPT</a>
                            <a href="{{ url('/') }}/payment/" class="btn btn-danger">HOME</a>
                        </div>
                    </div>
                </div>
                <br><br>
            </div>
        </div>
    </form>
</section>
@endsection
