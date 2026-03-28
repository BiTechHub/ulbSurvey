@extends('master')
@section('content');

        <!--CONTENT CONTAINER-->
        <!--===================================================-->
        <div id="content-container">
            <!--Page Title-->
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <div id="page-title">
                <h1 class="page-header text-overflow">Update Assets Non-Verified List</h1>
            </div>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--End page title-->
            <!--Breadcrumb-->
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Update Assets Non-Verified List</a></li>
            </ol>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--End breadcrumb-->
            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">

              {!!Form::Open(array('route'=>'update.AssetsDetailsNonVerified'))!!}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Landmark</label>
                                        {!!Form::text('landmark',$assets_detail_not_varify[0]->landmark,array('class'=>'form-control','placeholder'=>'Enter Landmark'))!!}
                                        {!!Form::text('id',$assets_detail_not_varify[0]->id,array('class'=>'form-control','placeholder'=>'Enter Landmark' , 'style'=>'display:none;'))!!}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Ward Number</label>
                                        {!!Form::text('wardnum',$assets_detail_not_varify[0]->ward_number,array('class'=>'form-control','placeholder'=>'Enter Ward No'))!!}
                                        {!!Form::text('id',$assets_detail_not_varify[0]->id,array('class'=>'form-control','placeholder'=>'Enter Ward No' , 'style'=>'display:none;'))!!}
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Asset Name</label>
                                        <select class="form-control serach-select @if ($errors->has('assets_name')) is-invalid @endif"
                                          id="" name="asset">
                                          <option value="">Select Asset</option>
                                        @foreach ($asset_list as $value)
                                            @if ($value->assets_name == old('assets_name'))
                                              <option selected="selected" value="{{ $value->assets_name }}">
                                                {{ $value->assets_name }}</option>
                                            @elseif($assets_detail_not_varify[0]->assets_name==$value->assets_name)
                                            <option selected="selected" value="{{ $value->assets_name }}">
                                                {{ $value->assets_name }}</option>
                                            @else
                                              <option value="{{ $value->assets_name }}">{{ $value->assets_name }}
                                              </option>
                                            @endif
                                          @endforeach
                                        </select>
                                        @if ($errors->has('assets_name'))
                                          <div class="invalid-feedback">{{ $errors->first('assets_name') }}</div>
                                        @endif
                                      </div>
                                </div>

                            </div>
                            <div class="panel-footer text-right">
                                @if($user_access[0]->fn_update=='Y')
                                   <input class="btn btn-primary" value="Update" name="update" type="submit">
                               @endif

                            </div>
                        </div>
                    </div>

                </div>

             {!!Form::Close()!!}
            </div>
            <!--===================================================-->
            <!--End page content-->

        </div>

@endsection
