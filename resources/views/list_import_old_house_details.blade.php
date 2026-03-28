@extends('master')
@section('content');

<!--CONTENT CONTAINER-->
    <!--===================================================-->
    <div id="content-container">

        <!--Page Title-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div id="page-title">
            <h1 class="page-header text-overflow">Mange Old House Details</h1>



        </div>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End page title-->


<!--===================================================-->
    <div id="page-content">

        <!-- Basic Data Tables -->
        <!--===================================================-->
        <div class="panel">
            <div class="panel-body">
            @if($user_access[0]->fn_add=='Y')
              <div align="right">
                       <a href="{{url('/')}}/Add-Import-old-House-Details" class="btn btn-info" role="button">Add</a>
                </div>
            @endif
              <div class="table-responsive">
                <table class="table table-striped table-bordered " cellspacing="0" width="100%" data-toggle="table">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>City</th>
                            <th>Ward Number</th>
                            <th>Ward Name</th>
                            <th>Mohalla Name</th>
                            <th>Total House</th>
                            <th>Inserted Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($house_detail as $index=>$value)
                        <tr>
                         <td>{{$index+1}}</td>
                        <td>{{ $value->city}}</td>
                        <td>{{ $value->ward_number}}</td>
                        <td>{{ $value->ward_name}}</td>
                        <td>{{ $value->mohalla_name}}</td>
                        <td>{{ $value->uploaded_old_house}}</td>
                        <td>{{ $value->created_at}}</td>
                        <td>
                            @if($user_access[0]->fn_delete=='Y')
                            <form method="post" id="delete_form_{{ $value->id }}" action="{{ url('/') }}/Delete-ImportHouseDetails">
                                {{ csrf_field() }}
                                <input type="hidden" name="deleted_id" value="{{ $value->id }}">
                                <span onclick="deleteRow('{{ $value->id }}')" type="button"
                                    class="label label-danger" title="Click to delete this row">Delete</span>
                            </form>
                            @endif
                        </td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
            </div>
        </div>
        <!--===================================================-->
        <!-- End Striped Table -->

    </div>
    </div>
    <!--===================================================-->
    <!--End page content-->
@endsection
@section('script')
<script>


function deleteRow(id) {
               swal({
                       title: "Are you sure?",
                       text: "Once deleted, you will not be able to recover this imaginary file!",
                       icon: "warning",
                       buttons: true,
                       dangerMode: true,
                   })
                   .then((willDelete) => {
                       if (willDelete) {
                           $("#delete_form_" + id).submit();
                       } else {
                           swal("Your data is safe!");
                       }
                   });
           }

</script>

@endsection
