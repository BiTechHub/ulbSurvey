<html>
<head>
<style>
.page {
  width: 7.8cm;
  height: auto;
  background: white;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
  border:0px solid #000;
  font-family: monospace;
}


@media print {
  .page {
    margin: 0;
    font-family: monospace;
    border: initial;
    border-radius: initial;
    width: initial;
    min-height: initial;
    box-shadow: initial;
    background: initial;
    page-break-after: always;
    mso-title-page:yes;
	mso-page-orientation: portrait;
    mso-header: header;
    mso-footer: footer;
  }
}
  </style>
</head>
<body>
	<div class="page">
		<br><br>
		<div align="center"><img src="{{url('/')}}/img/logo.png" width="70"></div>
		<div align="center">{{$states_cities->ulb_type}}<br>{{$tax_details->city}}</div>
		<br>
		<div align="center"><u>House Tax Receipt</u></div>
		<hr>
        <table border="0" align="center" width="280" cellspacing="0" cellpadding="1" >
			<tr>
				<td>
					Receipt No:
				</td>
				<td>
					R-00{{$payment_logs->pay_id}}
				</td>
			</tr>
			<tr>
				<td>
					House Number:
				</td>
				<td>
					{{$survey_personal_details->house_number}}
				</td>
			</tr>
			<tr>
				<td>
					Transaction Date:
				</td>
				<td>
					{{$payment_logs->created_at}}
				</td>
			</tr>
			<tr>
				<td>
					Session:
				</td>
				<td>
					{{$tax_details->session}}-{{$tax_details->session+1}}
				</td>
			</tr>
			<tr>
				<td>
					Owner Name:
				</td>
				<td>
					{{$survey_personal_details->name}}
				</td>
			</tr>
			<tr>
				<td>
					Father Name:
				</td>
				<td>
					{{$survey_personal_details->father_name}}
				</td>
			</tr>
			<tr>
				<td>
					Mobile Number:
				</td>
				<td>
					{{$survey_personal_details->mobile_number}}
				</td>
			</tr>
			<tr>
				<td>
					Cashier Id:
				</td>
				<td>
					{{$users->name}}(#0{{$users->id}})
				</td>
			</tr>
		</table>
		<hr>
		<div align="center"><b>Tax Details</b></div>
		<hr>
		<table border="0" align="center" width="280" cellspacing="0" cellpadding="0" >
			<tr>
				<td>
					House Tax:
				</td>
				<td align="right">
					{{$tax_details->house_tax}}
				</td>
			</tr>
			<tr>
				<td>
					Water Tax:
				</td>
				<td align="right">
					{{$tax_details->water_tax}}
				</td>
			</tr>
			
			<tr>
				<td>
					Sub Total:
				</td>
				<td align="right">
					{{$tax_details->sub_total}}
				</td>
			</tr>
			<tr>
				<td>
					Overdue:
				</td>
				<td align="right">
					{{$tax_details->overdue_amount}}
				</td>
			</tr>
			<tr>
				<td>
					Interest @ {{$tax_details->interest}}%:
				</td>
				<td align="right">
					{{$tax_details->interest_amount}}
				</td>
			</tr>
			<tr>
				<td>
					<b>Total Payable Amount:</b>
				</td>
				<td align="right">
					<b>{{number_format((float)($tax_details->interest_amount+$tax_details->overdue_amount+$tax_details->sub_total), 2, '.', '')}}</b>
				</td>
			</tr>
			
		</table>
		<hr>
		<div align="center"><b>Paid Amount By {{$payment_logs->payment_mode}}: {{$payment_logs->payment}}</b></div>
		<hr>
		<div align="center" style="font-size: 11px;">Rupees:{{$payment_logs->amount_words}}</b></div>
		<hr>
		<br><br>
		<div><b>Note:-</b></div>
		<div><b>1. </b>It is the responsibility of the house owner to deposit the house tax on Ist April.</div>
		<div><b>2. </b>The tax due is to be paid within fifteen (15) days otherwise 12% interest will be levied after the stipulated period.</div>
		<br><br>
		<div align="center">---Thank You---</div>
	</div>
	<script>
            window.print();
        </script>
</body>
</html>