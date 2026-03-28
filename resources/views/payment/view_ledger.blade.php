@extends('payment.master')
@section('content')
  <section class="content-wrapper main-content clear-fix">

    <div class="container body-content">
        <div class="panel panel-default col-md-12">
            <br>
            <input type="button" value="Print" title="PRINT" class="btn btn-success" onclick="javascript: printDiv()">
            <div id="DivIdToPrint">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2><b><u>LEDGER FOR PROPERTY ID - {{$tabledata->survey_id}}</u></b></h2>
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
                    <table class="table table-bordered" border="1">
                        <thead>
                        <tr>
                            <th scope="col">DATE</th>
                            <th scope="col">PARTICULARS</th>
                            <th align="right" scope="col">Amount</th>
                            <th align="right" scope="col">Payment</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php($credit=0.00)
                            @php($debit=0.00)
                            @foreach($tax_log as $value)
                                <tr align="center" style="color:#333333;background-color:White;border-color:#4D89B4;border-width:1px;border-style:Solid;">
                                <td>{{date('d-M-Y',strtotime($value->created_at))}}</td>
                                <td align="left">{{$value->remark}}</td>
                                @if($value->type=="Credit")
                                <td align="right">0</td>
                                <td align="right">{{$value->amount}}</td>
                                @php($credit +=$value->amount)
                                @else
                                <td align="right">{{$value->amount}}</td>
                                <td align="right">0</td>
                                @php($debit +=$value->amount)
                                @endif

                            </tr>
                            @endforeach
                            <tr align="center"
                                style="color:#284775;background-color:White;border-color:#4D89B4;border-width:1px;border-style:Solid;font-weight:bold;">
                                <td>&nbsp;</td>
                                <td align="left">TOTAL</td>
                                <td align="right">{{$debit}}</td>
                                <td align="right">{{$credit}}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3><a href="{{url('/')}}/payment/Pay-Now/{{$tabledata->survey_id}}" class="btn btn-danger">Total Due Amount is {{$debit-$credit}}</a></h3>
                    </div>
                </div>
            </div>
            <br><br><br><br>
        </div>
    </div>
  </section>
@endsection
