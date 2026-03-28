@extends('payment.master')
@section('content')

  <section class="container-fluid">

    <div class="row">
        <div class="col-md-12 text-center">
            <h2><b><u>SEARCH DETAILS</u></b></h2><br><br>
            <h6>You can search by Mohalla Or Mobile Or Property Id Or Name Or House Number</h6>
        </div>
    </div>
    <form method="post">
        {{csrf_field()}}
        <div class="row">
            <div class="col-md-1">
                <div class="form-group">
                    <label for="pwd">Mohalla:</label>
                    <select name="mohalla" class="form-control">
                        <option value="">---Select---</option>
                        @foreach($mohalla as $value)
                            <option value="{{$value->mohalla_name}}">Ward : {{$value->ward_number}} - Mohalla : {{$value->mohalla_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-1 text-center">
                <br><br>
                <b>OR</b>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="pwd">Mobile No:</label>
                    <input type="text" class="form-control" name="mobile_number">
                </div>
            </div>
            <div class="col-md-1 text-center">
                <br><br>
                <b>OR</b>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label for="pwd">Property Id:</label>
                    <input type="text" class="form-control" name="property_id">
                </div>
            </div>
            <div class="col-md-1 text-center">
                <br><br>
                <b>OR</b>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="pwd">Name:</label>
                    <input type="text" class="form-control" name="name">
                </div>
            </div>
            <div class="col-md-1 text-center">
                <br><br>
                <b>OR</b>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="pwd">House Number:</label>
                    <input type="text" class="form-control" name="house_number">
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class='wrapper text-center'>
                <div class="btn-group">
                    <button type="submit" class="btn btn-success">Search</button>
                    <button type="button" class="btn btn-info">Search Again !</button>
                </div>
            </div>
        </div>
    </form>
    <br /><br /><br /><br /><br />
    <div class="row">
        <div class="col-md-12">
            You can search your property by entering any one<br />
            1. Mohalla Name. <br />
            2. Registered Mobile No. <br />
            3. Property ID that is avaliable on your bill delivered to you. <br />
            4. Your Name <br />
            5. House No. <br />
            6. Latest Receipt No.
        </div>
    </div>
  </section>

@endsection
