   @extends('master')
   @section('content');

       <!--CONTENT CONTAINER-->
       <!--===================================================-->
       <div id="content-container">

           <!--Page Title-->
           <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
           <div id="page-title">
               <h1 class="page-header text-overflow">Report Payment Tax Details</h1>



           </div>
           <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
           <!--End page title-->

           <!--===================================================-->
           <div id="page-content">
               <div class="panel">
                   <form action="{{url('/')}}/Tax-Payment-List" method="post">
                    {{ csrf_field() }}
                       <div class="panel-body">

                           <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                     <select class="form-control" name="city" id="nagarpalika" onchange="get_ward_number(this.value);">
                                        <option value="">--Select Nagar palika--</option>
                                      </select>

                                </div>
                             </div>


                               <div class="col-sm-3">
                                   <div class="form-group">
                                       <select class="form-control" name="wardnum" id="wardnum" >
                                       </select>

                                   </div>
                               </div>
                               <div class="col-sm-3">
                                   <div class="form-group">
                                       <input type="text" class="form-control" name="keyword" id="housenumber">
                                   </div>
                               </div>

                               <div class="col-sm-3">
                                   <div class="text-left">
                                       <input class="btn btn-search btn-primary" value="Search" type="submit">
                                   </div>
                               </div>
                           </div>


                       </div>
                   </form>
               </div>

               <!-- Basic Data Tables -->
               <!--===================================================-->
               <div class="panel">
                @if(session()->has('message'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{session()->get('message')}}</li>
                    </ul>
                </div>
                @endif


                @if(session()->has('errorMsg'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{{session()->get('errorMsg')}}</li>
                    </ul>
                </div>
                @endif
                   <div class="panel-body">
                       <span style="color:red;" id="totalData">Total due list {{ sizeof($tableData) }}</span><br>
                       <div class="table-responsive">
                           <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                               <thead>
                                   <tr>
                                       <th>Sr.no.</th>
                                       <th>Nagar Palika Name</th>
                                       <th>Ward No</th>
                                       <th>House Number</th>
                                       <th>Old House Number</th>
                                       <th>Old House Owner Name</th>
                                       <th>GIS Name</th>
                                       <th>Financial Session</th>
                                       <th>Floor</th>
                                       <th>House tax Rate</th>
                                       <th>House Tax</th>
                                       <th>Water tax Rate</th>
                                       <th>Water Tax </th>
                                       <th>Total Tax </th>
                                       <th>Overdue Tax </th>
                                       <th>Int. % </th>
                                       <th>Int. Amount </th>
                                       <th>Paid</th>
                                       <th>Payable Tax </th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach ($tableData as $index => $value)
                                       <tr>
                                           <td>{{ ($tableData->currentpage() - 1) * $tableData->perpage() + $index + 1 }}
                                           </td>
                                           <td>{{ $value->city }}</td>
                                           <td>{{ $value->ward_number }}</td>
                                           <td>{{ $value->house_number_1 }}</td>
                                           <td>{{ $value->old_house_number }}</td>
                                           <td>{{ $value->old_house_owner_name }}</td>
                                           <td>{{ $value->name }}</td>
                                           <td>{{ $value->session }}</td>
                                           <td>{{ $value->no_of_floor }}</td>
                                           <td>{{ $value->house_tax_percentage }}</td>
                                           <td>{{ $value->house_tax }}</td>
                                           <td>{{ $value->water_tax_rate }}</td>
                                           <td>{{ $value->water_tax }}</td>
                                           <td>{{ $value->sub_total }}</td>
                                           <td>{{ $value->overdue_amount }}</td>
                                           <td>{{ $value->interest }}</td>
                                           <td>{{ $value->interest_amount }}</td>
                                           <td>{{ $value->paid }}</td>
                                           <td><a target="_BLANK" class="label label-success"
                                                   href="{{ url('/') }}/Tax-Pay/{{ $value->id }}">{{ $value->due_amount }}</a>
                                                   @if($user_access[0]->fn_delete=='Y')
                                                        <form method="post" id="delete_form_{{$value->id}}" action="{{url('/')}}/Delete-Tax-Payment">
                                                        {{csrf_field()}}
                                                        <input type="hidden" name="id" value="{{$value->id}}" >
                                                        <button onclick="deleteRow('{{$value->id}}')" type="button" class="btn btn-danger btn-icon icon-sm fa fa-trash" title="Click to delete this row"><i class="mdi mdi-trash-can"></i></button>
                                                    </form>
                                                @endif
                                           </td>
                                       </tr>
                                   @endforeach
                               </tbody>
                           </table>
                       </div>
                       {{ $tableData->links() }}
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
           city();
        function city()
		{

			$.ajax
			({
				url:"{{url('/')}}/getnagarpalika",
				dataType:'json',
				success:function(data)
				{
					var msg='<option value="">--Select Nagar Palika--</option>';
					for(var i=0;i<data.length;i++)
					{
						msg=msg+'<option value="'+data[i].city+'">'+data[i].city+'</option>';
					}
					$("#nagarpalika").html(msg);
				}
			});
		}
		function get_ward_number(value)
		{

			$.ajax
			({
				url:"{{url('/')}}/getwardnum/"+value,
				dataType:'json',
				success:function(data)
				{
					var msg='<option value="">--Select Ward Number--</option>';
					for(var i=0;i<data.length;i++)
					{
						msg=msg+'<option value="'+data[i].ward_number+'">'+data[i].ward_number+'->'+data[i].ward_name+'->'+data[i].mohalla_name+'</option>';
					}
					$("#wardnum").html(msg);
				}
			});
		}

        function deleteRow(id)
        {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
            $("#delete_form_"+id).submit();
            } else {
            swal("Your data is safe!");
            }
        });
        }
       </script>

   @endsection
