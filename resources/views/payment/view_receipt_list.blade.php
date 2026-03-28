@extends('payment.master')
@section('content')
  <section class="content-wrapper main-content clear-fix">

    <div class="container body-content">
        <div class="panel panel-default col-md-12">
            <br>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2><b><u>PAYMENT RECEIPT FOR PROPERTY ID - {{$tabledata->survey_id}}</u></b></h2>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-2 col-xs-6">Name</div>
                    <div class="col-md-4 col-xs-6">{{$tabledata->name}}</div>
                    <div class="col-md-2 col-xs-6">Property ID</div>
                    <div class="col-md-4 col-xs-6">{{$tabledata->survey_id}}</div>
                    <div class="col-md-2 col-xs-6">Father/Husband Name</div>
                    <div class="col-md-4 col-xs-6">{{$tabledata->father_name}}</div>
                    <div class="col-md-2 col-xs-6">Ward</div>
                    <div class="col-md-4 col-xs-6">{{$tabledata->wardName}}</div>
                    <div class="col-md-2 col-xs-6">Mohalla Name</div>
                    <div class="col-md-4 col-xs-6">{{$tabledata->mohallaName}}</div>
                    <div class="col-md-2 col-xs-6">House No</div>
                    <div class="col-md-4 col-xs-6">{{$tabledata->house_number_1}}</div>
            </div>
            <br><br>
            <div class="row">
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr style="color:White;background-color:#222A28;font-weight:bold;">
                            <th scope="col">PAYMENT DATE</th>
                            <th scope="col">AMOUNT DEPOSITED</th>
                            <th scope="col">RECEIPT NO</th>
                            <th scope="col">PAYMENT MODE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payment_logs as $value)
                        <tr align="center" style="color:#333333;background-color:White;">
                            <td>{{date('d-M-Y',strtotime($value->created_at))}}</td>
                            <td>{{$value->payment}}</td>
                            <td><a href="{{url('/')}}/payment/Print-Receipt/{{$value->receipt_number}}">{{$value->receipt_number}}</a></td>
                            <td>{{$value->payment_mode}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
            <br><br><br><br>
        </div>
    </div>
  </section>
@endsection
