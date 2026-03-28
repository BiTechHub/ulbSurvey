<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>{{$city}}</title>
<script language="javascript">
fucntion printme()
{
	//alert("print");
	//window.print_area.print();
}
alert("print");
</script>
<style>
#print_area
{
	/*color:#666666;*/
	color:#000000;
	width:900px;
}
.print_style
{
	font-family:Verdana;

}
.print_style1
{
  font-weight:400;
	border-bottom:1px dashed;
	width:auto;
	max-width:500px;
	font-size:20px;
}
.print_style2
{
	font-weight:400;

	width:auto;
	margin-top:10px;
	max-width:550px;
	font-size:18px;
}
.print_style3
{
	font-weight:400;

	width:auto;
	margin-top:10px;
	font-size:14px;
}
.print_style4
{
	font-size: 13px;
    text-align: justify;
    margin: 18px;
    width: 20.1cm;
}
.clear
{
clear:both;
}
.print_tab
{
margin-top:0px;

float:left;
width:100%;
}
.print_tab .underline_me
{
	border-bottom:1px dashed;

}
.submitt_btn
{
	background: none repeat scroll 0 0 #CCCCCC;
    height: 30px;
    padding-bottom: 3px;
    width: 100px;
}
@media print
{
	#button { display:none; }
	#backbutton { display:none; }
}

.page {
  width: 21.1cm;
  height: 31.7cm;
  background: white;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
  border:0px solid #000;
}

.subpage {
  
 padding-left:0.8cm;
 padding-right:0.8cm;
 border:0px solid #000
 height:auto;
  
}

@page {
  size: A4;
  margin: 0;
 
}

@media print {
  .page {
	margin: 0;
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
<script>
        function printDiv(divID) {
		
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;

          
        }
</script>
</head>
<body onload="printDiv('print_area');">
<center>
<div id="print_area" align="center" >
	@for($i=0;$i < sizeof($tableData); $i=$i+2)
	
	<div class="print_style page">
		<br>
		<div class="print_style1">कार्यालय {{$city}}</div>
		<br>
		<div class="print_style3">
			पत्रांक __&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;दिनांक :- ___/___/_____
		</div>
		<br>
		<div class="print_style2"><u>मांग नोटिस अंतर्गत धारा 141 (क)_(2)</u></div>
		<p class="print_style4">
			भवन स्वामी/अध्यासी का नाम श्री:_<u><b>{{$tableData[$i]->name}}</b></u>_ पिता/पति का नाम श्री _<u><b>{{$tableData[$i]->father_name}}</b></u>_भवन सं. :- _<u><b>{{$tableData[$i]->house_number}}</b></u>_ पुराना भवन सं _<u><b>{{$tableData[$i]->old_house_number}}</b></u>_ वार्ड सं. _<u><b>{{$tableData[$i]->ward_number}}</b></u>_ मुहल्ला _<u><b>{{$tableData[$i]->mohallaName}}</b></u>_, {{$city}} 
		</p>
		<p class="print_style4">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;स्वकर निर्धारण व्यवस्था के अंतर्गत आपके द्वारा अपने भवन के कवर्ड / कारपेट एरिया का विवरण स्वतः घोषित करते हुये कर निर्धारण नही कराया गया है, जबकि नगर पालिका द्वारा इस सम्बन्ध में कराये गए सर्वे के अनुसार आपके भवन का आच्छादित क्षेत्रफल __<u><b>{{$tableData[$i]->area_basement+$tableData[$i]->area_ground+$tableData[$i]->area_first+$tableData[$i]->area_second+$tableData[$i]->area_third}}</b></u>_ वर्गफुट है जिसमें ___<u><b>{{$tableData[$i]->area_business*$tableData[$i]->area_business_width}}</b></u>___ वर्गफुट व्यावसायिक है |
		</p>
		<p class="print_style4">
			अतः भूमि भवन स्वकर निर्धारण नियमावली-2018 के अंतर्गत दी गयी व्यवस्था के आधार पर आपके भवन पर वार्षिक किराया रु. _<u><b>{{$tableData[$i]->arv_total_discount}}</b></u>_ मूल्यांकन किया गया है, जिसके अनुसार आपके भवन का वार्षिक गृहकर _<u><b>{{$tableData[$i]->house_tax}}</b></u>_ वार्षिक  जलकर_<u><b>{{$tableData[$i]->water_tax}}</b></u>_ कुल वार्षिक कर_<u><b>{{$tableData[$i]->house_tax + $tableData[$i]->water_tax}}</b></u>_ अधिरोपित किया जाता है | कृपया इस नोटिस प्राप्ति के 15 दिवस के अन्दर कोई आपत्ति हो तो दाखिल करें |
		</p>
	<p class="print_style4">
		अन्यथा की स्थिति में आपकी स्वीकृति समझते हुए उक्त मूल्यांकित दर प्रभावी की जायेगी | वाद मियाद डिमांड कायम करते हुये नगर पालिका अधिनियम 1916 की धारा 141 (क) (2) के अनुसार शास्ति निर्धारण करते हुये बिल (मांग) प्रेषित की जाएगी एवं अधिनियम 1916 की धारा 144 एवं भूमि/भवन स्वकर निर्धारण नियमावली-2018 के अंतर्गत वसूली की जाएगी |
		<br>
		<b>नोट:-</b> उक्त कर निर्धारण वाद प्रकिया हेतु मान्य नहीं होगा एवं कोई भी भवन स्वामी का उक्त प्रक्रिया एवं कर रसीद से स्वामित्व का दावा मान्य नहीं होगा |
	</p>
        <br>
		<div style="display: inline-flex;">
			<div style="width:10cm;float: left;">क्रमांक _<u><b>{{$i+1}}</b></u></div>
			<div style="width:10cm;float: right;">अधिशासी अधिकारी <br>{{$city}} </div>
		</div>
		<br>
		<hr>
		@php($j=$i+1)
		@if(sizeof($tableData)>$j)
		<div class="print_style1">कार्यालय {{$city}} </div>
		<br>
		<div class="print_style3">
			पत्रांक__&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;दिनांक:- ___/___/_____
		</div>
		<br>
		<div class="print_style2"><u>मांग नोटिस अंतर्गत धारा 141 (क)_(2)</u></div>
		<p class="print_style4">
			भवन स्वामी/अध्यासी का नाम श्री:_<u><b>{{$tableData[$j]->name}}</b></u>_ पिता/पति का नाम श्री _<u><b>{{$tableData[$j]->father_name}}</b></u>_ भवन सं. :- _<u><b>{{$tableData[$j]->house_number}}</b></u>_ पुराना भवन सं _<u><b>{{$tableData[$j]->old_house_number}}</b></u>_ वार्ड सं. _<u><b>{{$tableData[$j]->ward_number}}</b></u>_ मुहल्ला _<u><b>{{$tableData[$j]->mohallaName}}</b></u>_, {{$city}} 
		</p>
		<p class="print_style4">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;स्वकर निर्धारण व्यवस्था के अंतर्गत आपके द्वारा अपने भवन के कवर्ड / कारपेट एरिया का विवरण स्वतः घोषित करते हुये कर निर्धारण नही कराया गया है, जबकि नगर पालिका द्वारा इस सम्बन्ध में कराये गए सर्वे के अनुसार आपके भवन का आच्छादित क्षेत्रफल __<u><b>{{$tableData[$j]->area_basement+$tableData[$j]->area_ground+$tableData[$j]->area_first+$tableData[$j]->area_second+$tableData[$j]->area_third}}</b></u>_ वर्गफुट है जिसमें ___<u><b>{{$tableData[$j]->area_business*$tableData[$j]->area_business_width}}</b></u>___ वर्गफुट व्यावसायिक है |
		</p>
		<p class="print_style4">
			अतः भूमि भवन स्वकर निर्धारण नियमावली-2018 के अंतर्गत दी गयी व्यवस्था के आधार पर आपके भवन पर वार्षिक किराया रु. _<u><b>{{$tableData[$j]->arv_total_discount}}</b></u>_ मूल्यांकन किया गया है, जिसके अनुसार आपके भवन का वार्षिक गृहकर _<u><b>{{$tableData[$j]->house_tax}}</b></u>_ वार्षिक  जलकर_<u><b>{{$tableData[$j]->water_tax}}</b></u>_ कुल वार्षिक कर_<u><b>{{$tableData[$j]->house_tax + $tableData[$j]->water_tax}}</b></u>_ अधिरोपित किया जाता है | कृपया इस नोटिस प्राप्ति के 15 दिवस के अन्दर कोई आपत्ति हो तो दाखिल करें |
		</p>
	<p class="print_style4">
		अन्यथा की स्थिति में आपकी स्वीकृति समझते हुए उक्त मूल्यांकित दर प्रभावी की जायेगी | वाद मियाद डिमांड कायम करते हुये नगर पालिका अधिनियम 1916 की धारा 141 (क) (2) के अनुसार शास्ति निर्धारण करते हुये बिल (मांग) प्रेषित की जाएगी एवं अधिनियम 1916 की धारा 144 एवं भूमि/भवन स्वकर निर्धारण नियमावली-2018 के अंतर्गत वसूली की जाएगी |
		<br>
		<b>नोट:-</b> उक्त कर निर्धारण वाद प्रकिया हेतु मान्य नहीं होगा एवं कोई भी भवन स्वामी का उक्त प्रक्रिया एवं कर रसीद से स्वामित्व का दावा मान्य नहीं होगा |
	</p>
	<br>
		<div style="display: inline-flex;">
			<div style="width:10cm;float: left;">क्रमांक _<u><b>{{$j+1}}</b></u></div>
			<div style="width:10cm;float: right;">अधिशासी अधिकारी <br>{{$city}} </div>
		</div>
		@endif
	</div>
	<br>
	<br>		
	@endfor
</div>
</center>
</body>
</html>
