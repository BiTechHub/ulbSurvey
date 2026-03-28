@extends('payment.master')
@section('content')
  <section class="content-wrapper main-content clear-fix">

    <div class="container body-content">
        <div class="panel panel-default col-md-12">
            <br>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2><b><u>SEARCH TAX LIST</u></b></h2>
                </div>
            </div>
            <br><br>

            <div class="row">
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr style="color:White;background-color:#222A28;font-weight:bold;">
                            <th scope="col">PROPERTY ID</th>
                            <th scope="col">NAME</th>
                            <th scope="col">HOUSE NO</th>
                            <th scope="col">WARD</th>
                            <th scope="col">MOHALLA</th>
                            <th scope="col">Pay Online</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tabledata as $value)
                        <tr align="center" style="color:#333333;background-color:White;">
                            <td>{{$value->survey_id}}</td>
                            <td>{{$value->name}} S/O {{$value->father_name}}</td>
                            <td>{{$value->house_number_1}}</td>
                            <td>{{$value->wardName}}</td>
                            <td>{{$value->mohallaName}}</td>
                            @if($value->due_amount>0.00)
                            <td><a href="{{url('/')}}/payment/Pay-Now/{{$value->survey_id}}" class="btn btn-info">Pay Online</a></td>
                            @else
                            <td><a href="#" class="btn btn-success">Paid</a></td>
                            @endif
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
