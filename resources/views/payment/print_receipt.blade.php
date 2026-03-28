@extends('payment.master')
@section('content')
  <section class="content-wrapper main-content clear-fix">
    <div class="container body-content">
      <div class="panel panel-default col-md-12">

        <div>
          <table width="900px">
            <tbody>
              <tr>
                <td align="right">
                  <input type="button" value="Print" title="PRINT" class="btn btn-success" onclick="javascript: printDiv()">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div id="DivIdToPrint" align="center">
          <table width="900px">
            <tbody>
              <tr>
                <td colspan="5">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="6" align="center">
                  <div style="float:center">
                    <img src="{{ url('/') }}/pay/images/uplogo.png" width="100px" height="100px" >
                  </div>
                  <div style="font-weight: bold;width: 60%;font-size: 40px;">Nagar Palika Parishad</div><br>
                  <div style="width: 60%;font-size: 28px;">Sitapur , Uttar Pradesh</div>
                </td>
              </tr>
              <tr>
                <td></td>
                <td colspan="4" align="center"></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="6"><hr></td>
              </tr>
              <tr>
                <td colspan="6" style=" font-weight: bold; font-size: x-large;text-align:center">भुगतान प्राप्ति रसीद</td>
              </tr>
              <tr><td colspan="6"><hr></td></tr>
              <tr>
                <td><span style="display:inline-block;width:10px;"></span></td>
                <td align="left"><span style="font-weight: 700">रसीद सं0 </span></td>
                <td><span >{{$payment_logs->receipt_number}}</span></td>
                <td align="right"></td>
                <td><span style="display:inline-block;width:200px;"></span></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td align="left"><span style="font-weight: 700">पुस्तक सं0 </span></td>
                <td><span>AUTO GENRATED</span></td>
                <td align="left"><span style="font-weight: 700">मोहल्ला </span></td>
                <td><span >{{$tabledata->mohallaName}}</span></td>
              </tr>
              <tr>
                <td></td>
                <td align="left"><span style="font-weight: 700">नाम </span></td>
                <td><span >{{$tabledata->name}} S/O {{$tabledata->father_name}}</span></td>
                <td align="left"><span style="font-weight: 700">प्रॉपर्टी आई0डी0</span></td>
                <td><span >{{$tabledata->house_number_1}}</span></td>
              </tr>
              <tr>
                <td></td>
                <td align="left"></td>
                <td><span></span></td>
                <td align="right"></td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
          </table>
          <table width="900px">
            <tbody>
              <tr>
                <td colspan="8"><br><br></td>
              </tr>
              <tr>
                <td colspan="8">
                  <table width="900px" style="border:solid black  1px;" border="1">
                    <tbody>
                      <tr>
                        <td><span style="font-weight: 700">मॉग रजिस्टर की क्रम सं0(प्रॉपर्टी आई0डी0)</span></td>
                        <td><span style="font-weight: 700">गृह संख्या</span></td>
                        <td><span style="font-weight: 700">अवधि </span></td>
                        <td><span style="font-weight: 700">भुगतान का विवरण</span></td>
                        <td><span style="font-weight: 700">धनराशिरू0/पै0</span></td>
                      </tr>
                      <tr>
                        <td rowspan="7">{{$tabledata->survey_id}}</td>
                        <td rowspan="7">{{$tabledata->house_number_1}}</td>
                        <td rowspan="7">{{$tabledata->session}}-{{$tabledata->session+1}}</td>
                        <td>गृहकर</td>
                        <td align="right">{{$tabledata->house_tax}}</td>
                      </tr>
                      <tr>
                        <td>जलकर</td>
                        <td align="right">{{$tabledata->water_tax}}</td>
                      </tr>
                      <tr><td></td><td></td></tr>
                      <tr>
                          <td>देय राशि</td>
                          <td align="right">{{$payment_logs->old_due}}</td>
                        </tr>
                      <tr>
                        <td><b>जमा राशि(-)</b></td>
                        <td align="right"><b>{{$payment_logs->payment}}</b></td>
                      </tr>
                      <tr>
                        <td>बकाया राशि</td>
                        <td align="right">{{$payment_logs->current_due}}</td>
                      </tr>
                      <tr>
                        <td><b>भुगतान का प्रकार</b></td>
                        <td align="right"><b>{{$payment_logs->payment_mode}}</b></td>
                      </tr>
                      <tr>
                        <td>योग शब्दों में</td>
                        <td colspan="5" align="left"><b>{{ucwords($payment_logs->amount_words)}}</b></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr><td colspan="6"><span style="font-weight: 700">&nbsp;</span></td></tr>
              <tr>
                <td align="left"><span style="font-weight: 700">भुगतान तिथि</span> - <span >{{$payment_logs->created_at}}</span></td>
                <td colspan="4"></td>
                <td align="right">नगर पालिका परिषद् सीतापुर , उ॰ प्र॰ </td>
              </tr>
              <tr><td colspan="6"><span style="font-weight: 700">&nbsp;</span></td></tr>
              <tr>
                <td align="left">रोकडिया</td>
                <td colspan="4"></td>
                <td align="right">मॉग और समाहरण रजिस्टर</td>
              </tr>
              <tr><td colspan="6"><span style="font-weight: 700">&nbsp;</span></td></tr>
              <tr>
                <td align="left">लेखाधिकारी /राजस्व अधीक्षक</td>
                <td colspan="4">
                </td>
                <td align="right">का प्रभारी लिपिक</td>
              </tr>
              <tr><td colspan="6"><span style="font-weight: 700">&nbsp;</span></td></tr>
              <tr>
                <td colspan="6" align="left">
                  <span>अनुज्ञाप्ति लाईसेंस की दशा में यह रसीद अनुज्ञाप्ति के स्&zwj;थान पर
                    प्रयुक्तय नहीं की जा सकती और नगर पालिका परिषद् सीतापुर , उ॰ प्र॰ के अनुज्ञाप्ति अस्वीकार कर देने के अधिकार पर कोई प्रतिकूल प्रभाव
                    नहीं डालती। अवैधानिक निर्माण के गिराये या हटाये जाने हेतु नगर पालिका परिषद् सीतापुर , उ॰ प्र॰ द्वारा की जाने वाली कार्यवाही पर
                    इसका प्रभाव नहीं पडेगा। </span>
                </td>
              </tr>
              <tr><td colspan="6"><span style="font-weight: 700">&nbsp;</span></td></tr>
              <tr>
                <td>Print By: --Website</td>
                <td colspan="4"></td>
                <td align="right">Print On: {{date('d-M-Y')}} </td>
              </tr>
            </tbody>
          </table>
          <div style="height:20px "></div>
        </div>
        <div style="float:right  "></div>
      </div>
    </div>
  </section>
@endsection
