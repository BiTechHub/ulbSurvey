            @extends('master')
            @section('content');

            <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">

                    <div id="page-title">
                        <h1 class="page-header text-overflow">Pay House Tax</h1>



                    </div>
            <!--===================================================-->
                <div id="page-content">

                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel">

                        <div class="panel-body">
                            <div class="alert alert-danger p-0 pt-3 text-center">
                                <ul>
                                    <label for="">House No</label>&nbsp; =
                                      <span>{{$tableData->house_number_1}}</span>
                                </ul>
                            </div>
                          {{-- <span class="bg-danger p-3">House No :- {{$tableData->house_number_1}}</span> --}}
                          <div class="row">
                            <form method="Post" action="{{url('/')}}/Tax-Pay">
                                {{ csrf_field() }}
                                <div class="col-md-6">
                                    <div class="white-box">
                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label>Due Amount</label>
                                                    <input type="text"  name="due_amount" readonly="readonly" required="required" class="form-control" placeholder="Enter Due Amount" value="{{$paymentData->due_amount}}">
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="white-box">
                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label>Payment Mode</label>
                                                    <input type="hidden" name="tax_id" value="{{$paymentData->id}}">
                                                    <select name="payment_mode" id="payment_mode" onchange="paymentDetails();" required="required" class="form-control" >
                                                        <option value="">-- Select Payment Mode --</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Credit Card">Credit Card</option>
                                                        <option value="Debit Card">Debit Card</option>
                                                        <option value="Cheque">Cheque</option>
                                                        <option value="IMPS">IMPS</option>
                                                        <option value="NEFT">NEFT</option>
                                                        <option value="RTGS">RTGS</option>
                                                        <option value="Bank Transfer">Bank Transfer</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Cash Div Tag Start Here-->
                                <div class="col-md-12" id="cash_div" style="display:none">
                                    <div class="white-box">
                                        <h4>Please Enter Payment Details (Payment Mode :- Cash)</h4>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">2000 X </div>
                                                        <input type="number" name="cash_2000" id="cash_2000" class="form-control" placeholder="Enter 2000 Amount" onkeydown="Cash2000();" onkeyup="Cash2000();" onchange="Cash2000();" value="0">
                                                        <div class="input-group-addon" id="cash_2000_total_div">= 0.00</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">500 X </div>
                                                        <input type="number" name="cash_500" id="cash_500" class="form-control" placeholder="Enter 500 Amount" onkeydown="Cash500();" onkeyup="Cash500();" onchange="Cash500();" value="0">
                                                        <div class="input-group-addon" id="cash_500_total_div">= 0.00</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">200 X </div>
                                                        <input type="number" name="cash_200" id="cash_200" class="form-control" placeholder="Enter 200 Amount" onkeydown="Cash200();" onkeyup="Cash200();" onchange="Cash200();" value="0">
                                                        <div class="input-group-addon" id="cash_200_total_div">= 0.00</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">100 X </div>
                                                        <input type="number" name="cash_100" id="cash_100" class="form-control" placeholder="Enter 100 Amount" onkeydown="Cash100();" onkeyup="Cash100();" onchange="Cash100();" value="0">
                                                        <div class="input-group-addon" id="cash_100_total_div">= 0.00</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">50 X </div>
                                                        <input type="number" name="cash_50" id="cash_50" class="form-control" placeholder="Enter 50 Amount" onkeydown="Cash50();" onkeyup="Cash50();" onchange="Cash50();" value="0">
                                                        <div class="input-group-addon" id="cash_50_total_div">= 0.00</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">20 X </div>
                                                        <input type="number" name="cash_20" id="cash_20" class="form-control" placeholder="Enter 20 Amount" onkeydown="Cash20();" onkeyup="Cash20();" onchange="Cash20();" value="0">
                                                        <div class="input-group-addon" id="cash_20_total_div">= 0.00</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">10 X </div>
                                                        <input type="number" name="cash_10" id="cash_10" class="form-control" placeholder="Enter 10 Amount" onkeydown="Cash10();" onkeyup="Cash10();" onchange="Cash10();" value="0">
                                                        <div class="input-group-addon" id="cash_10_total_div">= 0.00</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">5 X </div>
                                                        <input type="number" name="cash_5" id="cash_5" class="form-control" placeholder="Enter 5 Amount" onkeydown="Cash5();" onkeyup="Cash5();" onchange="Cash5();" value="0">
                                                        <div class="input-group-addon" id="cash_5_total_div">= 0.00</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">2 X </div>
                                                        <input type="number" name="cash_2" id="cash_2" class="form-control" placeholder="Enter 2 Amount" onkeydown="Cash2();" onkeyup="Cash2();" onchange="Cash2();" value="0">
                                                        <div class="input-group-addon" id="cash_2_total_div">= 0.00</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">1 X </div>
                                                        <input type="number" name="cash_1" id="cash_1" class="form-control" placeholder="Enter 1 Amount" onkeydown="Cash1();" onkeyup="Cash1();" onchange="Cash1();" value="0">
                                                        <div class="input-group-addon" id="cash_1_total_div">= 0.00</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">Other </div>
                                                        <input type="number" name="cash_other" id="cash_other" class="form-control" placeholder="Enter Other Cash" onkeydown="CashOther();" onkeyup="CashOther();" onchange="CashOther();" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">Total Cash</div>
                                                        <input type="number" name="cash_total" id="cash_total" class="form-control" placeholder="Enter Total Cash" readonly="readonly">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">Remark</div>
                                                        <input type="text" name="cash_remark" id="cash_remark" class="form-control" placeholder="Enter Remark">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">Cash Words -: </div>
                                                        <input type="text" name="cashWords" id="cashWords" class="form-control" placeholder="Enter Cash Words" readonly="readonly">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Cash Div Tag End Here-->
                                <!-- Credit Card Div Tag Start Here-->
                                <div class="col-md-12" id="credit_card_div" style="display:none">
                                    <div class="white-box">
                                        <h4>Please Enter Payment Details (Payment Mode :- Credit Card)</h4>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Bank Name</label>
                                                    <select name="credit_card_bank_name" id="credit_card_bank_name" class="form-control select2" >
                                                            @foreach($ifsc as $value)
                                                                <option value="{{$value->bank}}">{{$value->bank}}</option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Transction Id</label>
                                                    <input type="text" name="credit_card_transction_id" id="credit_card_transction_id" class="form-control" placeholder="Enter Transction Id">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Total Amount</label>
                                                    <input type="number" name="credit_card_amount" id="credit_card_amount" class="form-control" placeholder="Enter Total Amount" onchange="convertAmountIntoWords(this.value,'credit_card_cashWords')" onkeydown="convertAmountIntoWords(this.value,'credit_card_cashWords');" onkeyup="convertAmountIntoWords(this.value,'credit_card_cashWords');">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Remark</label>
                                                    <input type="text" name="credit_card_remark" id="credit_card_remark" class="form-control" placeholder="Enter Remark">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Amount in Words</label>
                                                    <input type="text" name="credit_card_cashWords" id="credit_card_cashWords" class="form-control" placeholder="Enter Cash Words" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Credit Card Div Tag End Here-->
                                <!-- Debit Card Div Tag Start Here-->
                                <div class="col-md-12" id="debit_card_div" style="display:none">
                                    <div class="white-box">
                                        <h4>Please Enter Payment Details (Payment Mode :- Debit Card)</h4>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Bank Name</label>
                                                    <select name="debit_card_bank_name" id="debit_card_bank_name" class="form-control select2" >
                                                        @foreach($ifsc as $value)
                                                            <option value="{{$value->bank}}">{{$value->bank}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Transction Id</label>
                                                    <input type="text" name="debit_card_transction_id" id="debit_card_transction_id" class="form-control" placeholder="Enter Transction Id">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Total Amount</label>
                                                    <input type="number" name="debit_card_amount" id="debit_card_amount" class="form-control" placeholder="Enter Total Amount" onchange="convertAmountIntoWords(this.value,'debit_card_cashWords')" onkeydown="convertAmountIntoWords(this.value,'debit_card_cashWords');" onkeyup="convertAmountIntoWords(this.value,'debit_card_cashWords');">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Remark</label>
                                                    <input type="text" name="debit_card_remark" id="debit_card_remark" class="form-control" placeholder="Enter Remark">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Amount in Words</label>
                                                    <input type="text" name="debit_card_cashWords" id="debit_card_cashWords" class="form-control" placeholder="Enter Cash Words" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Debit Card Div Tag End Here-->
                                <!-- Cheque Div Tag Start Here-->
                                <div class="col-md-12" id="cheque_div" style="display:none">
                                    <div class="white-box">
                                        <h4>Please Enter Payment Details (Payment Mode :- Cheque)</h4>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Bank Name</label>
                                                    <select name="cheque_bank_name" id="cheque_bank_name" class="form-control select2" >
                                                        @foreach($ifsc as $value)
                                                            <option value="{{$value->bank}}">{{$value->bank}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Cheque Number</label>
                                                    <input type="number" name="cheque_transction_id" id="cheque_transction_id" class="form-control" placeholder="Enter Transction Id">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Total Amount</label>
                                                    <input type="number" name="cheque_amount" id="cheque_amount" class="form-control" placeholder="Enter Total Amount" onchange="convertAmountIntoWords(this.value,'cheque_cashWords')" onkeydown="convertAmountIntoWords(this.value,'cheque_cashWords');" onkeyup="convertAmountIntoWords(this.value,'cheque_cashWords');">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Remark</label>
                                                    <input type="text" name="cheque_remark" id="cheque_remark" class="form-control" placeholder="Enter Remark">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Amount in Words</label>
                                                    <input type="text" name="cheque_cashWords" id="cheque_cashWords" class="form-control" placeholder="Enter Cash Words" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Cheque Div Tag End Here-->
                                <!-- EMI Div Tag Start Here-->

                                <!-- EMI Div Tag End Here-->
                                <!-- NEFT/RTGS/IMPS Div Tag Start Here-->
                                <div class="col-md-12" id="neft_div" style="display:none">
                                    <div class="white-box">
                                        <h4>Please Enter Payment Details (Payment Mode :- NEFT/RTGS/IMPS)</h4>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Bank Name</label>
                                                    <select name="neft_bank_name" id="neft_bank_name" class="form-control select2" >
                                                        @foreach($ifsc as $value)
                                                            <option value="{{$value->bank}}">{{$value->bank}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Refrence Number</label>
                                                    <input type="text" name="neft_transction_id" id="neft_transction_id" class="form-control" placeholder="Enter Transction Id">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Total Amount</label>
                                                    <input type="number" name="neft_amount" id="neft_amount" class="form-control" placeholder="Enter Total Amount" onchange="convertAmountIntoWords(this.value,'neft_cashWords')" onkeydown="convertAmountIntoWords(this.value,'neft_cashWords');" onkeyup="convertAmountIntoWords(this.value,'neft_cashWords');">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Remark</label>
                                                    <input type="text" name="neft_remark" id="neft_remark" class="form-control" placeholder="Enter Remark">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Amount in Words</label>
                                                    <input type="text" name="neft_cashWords" id="neft_cashWords" class="form-control" placeholder="Enter Cash Words" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- NEFT/RTGS/IMPS Div Tag End Here-->
                                <!-- Bank Transfer Div Tag Start Here-->
                                <div class="col-md-12" id="bank_trf_div" style="display:none">
                                    <div class="white-box">
                                        <h4>Please Enter Payment Details (Payment Mode :- Bank Transfer)</h4>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Bank Name</label>
                                                    <select name="bank_trf_bank_name" id="bank_trf_bank_name" class="form-control select2" >
                                                        @foreach($ifsc as $value)
                                                            <option value="{{$value->bank}}">{{$value->bank}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Refrence Number</label>
                                                    <input type="text" name="bank_trf_transction_id" id="bank_trf_transction_id" class="form-control" placeholder="Enter Transction Id">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Total Amount</label>
                                                    <input type="number" name="bank_trf_amount" id="bank_trf_amount" class="form-control" placeholder="Enter Total Amount" onchange="convertAmountIntoWords(this.value,'bank_trf_cashWords')" onkeydown="convertAmountIntoWords(this.value,'bank_trf_cashWords');" onkeyup="convertAmountIntoWords(this.value,'bank_trf_cashWords');">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Remark</label>
                                                    <input type="text" name="bank_trf_remark" id="bank_trf_remark" class="form-control" placeholder="Enter Remark">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Amount in Words</label>
                                                    <input type="text" name="bank_trf_cashWords" id="bank_trf_cashWords" class="form-control" placeholder="Enter Cash Words" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Bank Transfer Div Tag End Here-->
                                <div class="col-md-12">
                                    <div class="white-box">
                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12">
                                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                                <a href="{{url('/')}}/Available-Plot" class="btn btn-inverse waves-effect waves-light">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <form>
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
            <script type="text/javascript">
                $(document).ready(function(){

                });

                function calculateAmount()
                {
                    var total_emi_amount=$("#total_emi_amount").val();
                    var cashWords=test_skill(total_cash);
                }
                function Cash2000()
                {
                    var cash_2000=$("#cash_2000").val();
                    if(cash_2000<0)
                    {
                        cash_2000=0;
                        $("#cash_2000").val(cash_2000);
                    }
                    var t=2000*cash_2000;
                    t=parseFloat(t).toFixed(2);
                    $("#cash_2000_total_div").html("= "+t);
                    totalCash();
                }
                function Cash500()
                {
                    var cash_500=$("#cash_500").val();
                    if(cash_500<0)
                    {
                        cash_500=0;
                        $("#cash_500").val(cash_500);
                    }
                    var t=500*cash_500;
                    t=parseFloat(t).toFixed(2);
                    $("#cash_500_total_div").html("= "+t);
                    totalCash();
                }
                function Cash100()
                {
                    var cash_100=$("#cash_100").val();
                    if(cash_100<0)
                    {
                        cash_100=0;
                        $("#cash_100").val(cash_100);
                    }
                    var t=100*cash_100;
                    t=parseFloat(t).toFixed(2);
                    $("#cash_100_total_div").html("= "+t);
                    totalCash();
                }
                function Cash200()
                {
                    var cash_200=$("#cash_200").val();
                    if(cash_200<0)
                    {
                        cash_200=0;
                        $("#cash_200").val(cash_200);
                    }
                    var t=200*cash_200;
                    t=parseFloat(t).toFixed(2);
                    $("#cash_200_total_div").html("= "+t);
                    totalCash();
                }
                function Cash50()
                {
                    var cash_50=$("#cash_50").val();
                    if(cash_50<0)
                    {
                        cash_50=0;
                        $("#cash_50").val(cash_50);
                    }
                    var t=50*cash_50;
                    t=parseFloat(t).toFixed(2);
                    $("#cash_50_total_div").html("= "+t);
                    totalCash();
                }
                function Cash20()
                {
                    var cash_20=$("#cash_20").val();
                    if(cash_20<0)
                    {
                        cash_20=0;
                        $("#cash_20").val(cash_20);
                    }
                    var t=20*cash_20;
                    t=parseFloat(t).toFixed(2);
                    $("#cash_20_total_div").html("= "+t);
                    totalCash();
                }
                function Cash10()
                {
                    var cash_10=$("#cash_10").val();
                    if(cash_10<0)
                    {
                        cash_10=0;
                        $("#cash_10").val(cash_10);
                    }
                    var t=10*cash_10;
                    t=parseFloat(t).toFixed(2);
                    $("#cash_10_total_div").html("= "+t);
                    totalCash();
                }
                function Cash5()
                {
                    var cash_5=$("#cash_5").val();
                    if(cash_5<0)
                    {
                        cash_5=0;
                        $("#cash_5").val(cash_5);
                    }
                    var t=5*cash_5;
                    t=parseFloat(t).toFixed(2);
                    $("#cash_5_total_div").html("= "+t);
                    totalCash();
                }
                function Cash2()
                {
                    var cash_2=$("#cash_2").val();
                    if(cash_2<0)
                    {
                        cash_2=0;
                        $("#cash_2").val(cash_2);
                    }
                    var t=2*cash_2;
                    t=parseFloat(t).toFixed(2);
                    $("#cash_2_total_div").html("= "+t);
                    totalCash();
                }
                function Cash1()
                {
                    var cash_1=$("#cash_1").val();
                    if(cash_1<0)
                    {
                        cash_1=0;
                        $("#cash_1").val(cash_1);
                    }
                    var t=1*cash_1;
                    t=parseFloat(t).toFixed(2);
                    $("#cash_1_total_div").html("= "+t);
                    totalCash();
                }
                function CashOther()
                {
                    var cash_other=$("#cash_other").val();
                    if(cash_other<0)
                    {
                        cash_other=0;
                        $("#cash_other").val(cash_other);
                    }
                    totalCash();
                }
                function totalCash()
                {
                    var cash_2000=$("#cash_2000").val()*2000;
                    var cash_500=$("#cash_500").val()*500;
                    var cash_200=$("#cash_200").val()*200;
                    var cash_100=$("#cash_100").val()*100;
                    var cash_50=$("#cash_50").val()*50;
                    var cash_20=$("#cash_20").val()*20;
                    var cash_10=$("#cash_10").val()*10;
                    var cash_5=$("#cash_5").val()*5;
                    var cash_2=$("#cash_2").val()*2;
                    var cash_1=$("#cash_1").val()*1;
                    var cash_other=$("#cash_other").val();
                    var total_cash=parseInt(cash_2000)+parseInt(cash_500)+parseInt(cash_200)+parseInt(cash_100)+parseInt(cash_50)+parseInt(cash_20)+parseInt(cash_10)+parseInt(cash_5)+parseInt(cash_2)+parseInt(cash_1)+parseInt(cash_other);
                    $("#cash_total").val(total_cash);
                    if(total_cash>0)
                    {
                        var cashWords=test_skill(total_cash);
                        $("#cashWords").val(cashWords);
                    }
                }

                function paymentDetails()
                {
                    var paymentMode=$("#payment_mode").val();
                    if(paymentMode=="Cash")
                    {
                        $("#cash_div").slideDown(600);
                        $("#credit_card_div").slideUp(600);
                        $("#debit_card_div").slideUp(600);
                        $("#cheque_div").slideUp(600);
                        $("#emi_div").slideUp(600);
                        $("#neft_div").slideUp(600);
                        $("#bank_trf_div").slideUp(600);
                    }
                    else if(paymentMode=="Credit Card")
                    {
                        $("#cash_div").slideUp(600);
                        $("#credit_card_div").slideDown(600);
                        $("#debit_card_div").slideUp(600);
                        $("#cheque_div").slideUp(600);
                        $("#emi_div").slideUp(600);
                        $("#neft_div").slideUp(600);
                        $("#bank_trf_div").slideUp(600);
                    }else if(paymentMode=="Debit Card")
                    {
                        $("#cash_div").slideUp(600);
                        $("#credit_card_div").slideUp(600);
                        $("#debit_card_div").slideDown(600);
                        $("#cheque_div").slideUp(600);
                        $("#emi_div").slideUp(600);
                        $("#neft_div").slideUp(600);
                        $("#bank_trf_div").slideUp(600);
                    }else if(paymentMode=="Cheque")
                    {
                        $("#cash_div").slideUp(600);
                        $("#credit_card_div").slideUp(600);
                        $("#debit_card_div").slideUp(600);
                        $("#cheque_div").slideDown(600);
                        $("#emi_div").slideUp(600);
                        $("#neft_div").slideUp(600);
                        $("#bank_trf_div").slideUp(600);
                    }else if(paymentMode=="EMI")
                    {
                        $("#cash_div").slideUp(600);
                        $("#credit_card_div").slideUp(600);
                        $("#debit_card_div").slideUp(600);
                        $("#cheque_div").slideUp(600);
                        $("#emi_div").slideDown(600);
                        $("#neft_div").slideUp(600);
                        $("#bank_trf_div").slideUp(600);
                    }else if(paymentMode=="NEFT" || paymentMode=="IMPS" || paymentMode=="RTGS")
                    {
                        $("#cash_div").slideUp(600);
                        $("#credit_card_div").slideUp(600);
                        $("#debit_card_div").slideUp(600);
                        $("#cheque_div").slideUp(600);
                        $("#emi_div").slideUp(600);
                        $("#neft_div").slideDown(600);
                        $("#bank_trf_div").slideUp(600);
                    }else if(paymentMode=="Bank Transfer")
                    {
                        $("#cash_div").slideUp(600);
                        $("#credit_card_div").slideUp(600);
                        $("#debit_card_div").slideUp(600);
                        $("#cheque_div").slideUp(600);
                        $("#emi_div").slideUp(600);
                        $("#neft_div").slideUp(600);
                        $("#bank_trf_div").slideDown(600);
                    }
                }

                function convertAmountIntoWords(total_cash,id)
                {
                    if(total_cash>0)
                    {
                        var cashWords=test_skill(total_cash);
                        $("#"+id).val(cashWords);
                    }
                }
            </script>


            <script type="text/javascript">
                function test_skill(junkVal) {
                    junkVal=Math.floor(junkVal);
                    var obStr=new String(junkVal);
                    numReversed=obStr.split("");
                    actnumber=numReversed.reverse();

                    if(Number(junkVal) >=0){
                        //do nothing
                    }
                    else{
                        alert('wrong Number cannot be converted');
                        return false;
                    }
                    if(Number(junkVal)==0){
                        document.getElementById('container').innerHTML=obStr+''+'Rupees Zero Only';
                        return false;
                    }
                    if(actnumber.length>9){
                        alert('Oops!!!! the Number is too big to covertes');
                        return false;
                    }

                    var iWords=["Zero", " One", " Two", " Three", " Four", " Five", " Six", " Seven", " Eight", " Nine"];
                    var ePlace=['Ten', ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen', ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'];
                    var tensPlace=['dummy', ' Ten', ' Twenty', ' Thirty', ' Forty', ' Fifty', ' Sixty', ' Seventy', ' Eighty', ' Ninety' ];

                    var iWordsLength=numReversed.length;
                    var totalWords="";
                    var inWords=new Array();
                    var finalWord="";
                    j=0;
                    for(i=0; i<iWordsLength; i++){
                        switch(i)
                        {
                        case 0:
                            if(actnumber[i]==0 || actnumber[i+1]==1 ) {
                                inWords[j]='';
                            }
                            else {
                                inWords[j]=iWords[actnumber[i]];
                            }
                            inWords[j]=inWords[j]+' Only';
                            break;
                        case 1:
                            tens_complication();
                            break;
                        case 2:
                            if(actnumber[i]==0) {
                                inWords[j]='';
                            }
                            else if(actnumber[i-1]!=0 && actnumber[i-2]!=0) {
                                inWords[j]=iWords[actnumber[i]]+' Hundred and';
                            }
                            else {
                                inWords[j]=iWords[actnumber[i]]+' Hundred';
                            }
                            break;
                        case 3:
                            if(actnumber[i]==0 || actnumber[i+1]==1) {
                                inWords[j]='';
                            }
                            else {
                                inWords[j]=iWords[actnumber[i]];
                            }
                            if(actnumber[i+1] != 0 || actnumber[i] > 0){
                                inWords[j]=inWords[j]+" Thousand";
                            }
                            break;
                        case 4:
                            tens_complication();
                            break;
                        case 5:
                            if(actnumber[i]==0 || actnumber[i+1]==1) {
                                inWords[j]='';
                            }
                            else {
                                inWords[j]=iWords[actnumber[i]];
                            }
                            if(actnumber[i+1] != 0 || actnumber[i] > 0){
                                inWords[j]=inWords[j]+" Lakh";
                            }
                            break;
                        case 6:
                            tens_complication();
                            break;
                        case 7:
                            if(actnumber[i]==0 || actnumber[i+1]==1 ){
                                inWords[j]='';
                            }
                            else {
                                inWords[j]=iWords[actnumber[i]];
                            }
                            inWords[j]=inWords[j]+" Crore";
                            break;
                        case 8:
                            tens_complication();
                            break;
                        default:
                            break;
                        }
                        j++;
                    }

                    function tens_complication() {
                        if(actnumber[i]==0) {
                            inWords[j]='';
                        }
                        else if(actnumber[i]==1) {
                            inWords[j]=ePlace[actnumber[i-1]];
                        }
                        else {
                            inWords[j]=tensPlace[actnumber[i]];
                        }
                    }
                    inWords.reverse();
                    for(i=0; i<inWords.length; i++) {
                        finalWord+=inWords[i];
                    }
                    return finalWord;
                }
        // American Numbering System
        var th = ['', 'thousand', 'million', 'billion', 'trillion'];

        var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];

        var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];

        var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

        function toWords(s) {
            s = s.toString();
            s = s.replace(/[\, ]/g, '');
            if (s != parseFloat(s)) return 'not a number';
            var x = s.indexOf('.');
            if (x == -1) x = s.length;
            if (x > 15) return 'too big';
            var n = s.split('');
            var str = '';
            var sk = 0;
            for (var i = 0; i < x; i++) {
                if ((x - i) % 3 == 2) {
                    if (n[i] == '1') {
                        str += tn[Number(n[i + 1])] + ' ';
                        i++;
                        sk = 1;
                    } else if (n[i] != 0) {
                        str += tw[n[i] - 2] + ' ';
                        sk = 1;
                    }
                } else if (n[i] != 0) {
                    str += dg[n[i]] + ' ';
                    if ((x - i) % 3 == 0) str += 'hundred ';
                    sk = 1;
                }
                if ((x - i) % 3 == 1) {
                    if (sk) str += th[(x - i - 1) / 3] + ' ';
                    sk = 0;
                }
            }
            if (x != s.length) {
                var y = s.length;
                str += 'point ';
                for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
            }
            return str.replace(/\s+/g, ' ');

        }
    </script>
@endsection

