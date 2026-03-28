@extends('master')
@section('content');

    <!--CONTENT CONTAINER-->
    <!--===================================================-->
    <div id="content-container">

        <!--Page Title-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div id="page-title">
            <h1 class="page-header text-overflow">Old And New House Mapping Report</h1>



        </div>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End page title-->


        <!--===================================================-->
        <div id="page-content">

            <!-- Basic Data Tables -->
            <!--===================================================-->
            @if ($tabledata == null)
                <div class="panel">
                    <div class="panel-body">
                        <form method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-3">
                                    {{-- <div class="form-group">
                                        <select class="form-control" name="nagarpalika" id="nagarpalika" onchange="get_ward_number(this.value);">
                                           <option value="">--Select Nagar palika--</option>
                                         </select>

                                   </div> --}}
                                    <div class="form-group">
                                        <select class="form-control" name="nagar_palika" id="nagarpalika"
                                            required="required" onchange="getmohlla()">

                                            <option value="Sitapur">Select Nagar Palika</option>
                                            @foreach ($city as $value)
                                                <option value="{{ $value->city }}">{{ $value->city }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">

                                        <select class="form-control" name="ward_number" id="ward_number" required>
                                          <option value="">--Select Mohalla--</option>
                                        </select>
                                    </div>
                                    {{-- <div class="form-group">
                                        <select class="form-control" name="ward_number" id="ward_number">

                                            <option value="">--Select Ward Number --</option>

                                            @foreach ($ward_details as $value)
                                                <option value="{{ $value->id }}">{{ $value->ward_number }} ->
                                                    {{ $value->mohalla_name }}</option>
                                            @endforeach

                                        </select>
                                    </div> --}}
                                </div>


                                <div class="col-sm-2">

                                    <input class="btn btn-success text-uppercase" type="submit" value="search" id="search"
                                        name="search">



                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            @else

                <div class="panel">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr.no.</th>
                                        <th>Ward Number</th>
                                        <th>Mohalla Name</th>
                                        <th>Old House</th>
                                        <th>Old Owner</th>
                                        <th>Old Father</th>
                                        <th>New House</th>
                                        <th>New Owner</th>
                                        <th>New Father</th>
                                    </tr>
                                </thead>
                                <tbody id="searchData">
                                    @php($i = 0)
                                    @foreach ($tabledata as $index => $value)
                                        @if ($value->new_name == null || $value->new_name == '')
                                            @php($i++)
                                        @endif
                                        @if (strpos($value->new_name, $value->old_owner_name) === false)
                                            @if ($value->new_name == $value->old_owner_name)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $value->old_ward_number }}</td>
                                                    <td>{{ $value->mohalla_name }}</td>
                                                    <td>{{ $value->old_house_number }}</td>
                                                    <td>{{ $value->old_owner_name }}</td>
                                                    <td>{{ $value->old_father_name }}</td>
                                                    <td>{{ $value->new_house_number }}</td>
                                                    <td>{{ $value->new_name }}</td>
                                                    <td>{{ $value->new_father_name }}</td>
                                                </tr>
                                            @else
                                                <tr class="text-danger">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $value->old_ward_number }}</td>
                                                    <td>{{ $value->mohalla_name }}</td>
                                                    <td>{{ $value->old_house_number }}</td>
                                                    <td>{{ $value->old_owner_name }}</td>
                                                    <td>{{ $value->old_father_name }}</td>
                                                    <td>{{ $value->new_house_number }}</td>
                                                    <td>{{ $value->new_name }}</td>
                                                    <td>{{ $value->new_father_name }}</td>
                                                </tr>
                                            @endif
                                        @else
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $value->old_ward_number }}</td>
                                                <td>{{ $value->mohalla_name }}</td>
                                                <td>{{ $value->old_house_number }}</td>
                                                <td>{{ $value->old_owner_name }}</td>
                                                <td>{{ $value->old_father_name }}</td>
                                                <td>{{ $value->new_house_number }}</td>
                                                <td>{{ $value->new_name }}</td>
                                                <td>{{ $value->new_father_name }}</td>
                                            </tr>
                                        @endif

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <span>Total Blank New House {{ $i }}</span>
                    </div>
                </div>
            @endif
            <!--===================================================-->
            <!-- End Striped Table -->

        </div>
    </div>
    <!--===================================================-->
    <!--End page content-->
@endsection
@section('script')
    <script>
       	$('document').ready(function(e){
			getmohlla();
		});

		function getmohlla()
		{

            var city_id = $("#nagarpalika").val();
			$.ajax
			({
				url:"{{url('/')}}/getmohllaward/"+city_id,
				dataType:'json',
				success:function(data)
				{
					var msg='<option value="">--Select Ward Number--</option>';
					for(var i=0;i<data.length;i++)
					{
						msg=msg+'<option value="'+data[i].id+'">'+data[i].ward_number+'->'+data[i].ward_name+'->'+data[i].mohalla_name+'</option>';
					}
					$("#ward_number").html(msg);
				}
			});
		}
    </script>
@endsection
