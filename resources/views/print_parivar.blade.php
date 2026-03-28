<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0080)http://nppaitenpur.in/software/parivar%20reg/familyregprint_original.php?ms=1898 -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title></title>
<style type="text/css" media="print">
body
{
	margin:0;
	padding:0;
}
@page { size: portrait}
</style>


<style>
#print_area
{
	/*color:#666666;*/
	color:#000000;
	width:1024px;
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
	font-size:25px;
}
.print_style2
{
	font-weight:400;

	width:auto;
	margin-top:30px;
	max-width:550px;
	font-size:25px;
}
.clear
{
	clear:both;
}
.print_tab
{
	margin-top:30px;
	float:left;
	width:100%;
}
.print_tab .myf
{
	border-right:1px solid #000;
	border-top:1px solid #000;
	height:35px;

}
.print_tab .myf1
{
	border-left:1px solid #000;
	border-bottom:1px solid #000;
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
<style>
.my_new_col
{
	font-weight:bold;
	text-align:center;
}
.my_new_col1
{
	font-weight:bold;
	text-align:center;
	border-right:1px solid #000000;
	border-top:1px solid #000000;
	border-bottom:1px solid #000000;
}
.my_new_col2
{
	font-weight:bold;
	text-align:center;
	border-right:1px solid #000000;
 	border-bottom:1px solid #000000;
}
.my_new_col22
{
 	text-align:center;
	border-right:1px solid #000000;
 	border-bottom:1px solid #000000;
}
</style>
</head>
<body onload="printDiv('print_area');">
<center>
	 <div id="print_area" align="center">
	 <div  class="print_style page">
		 
      
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tbody><tr>
    <td colspan="10" class="titel" align="center"><h1>नगर पंचायत बृजमनगंज
</h1></td>
    </tr>
    
    
    </tbody></table>
    
 
    
    
  
    
    <table width="100%" cellpadding="0" cellspacing="0">
    <tbody><tr><td width="83">मकान नंबर</td> 
    <td width="136" class="boderbottom"><b>{{$family_members->house_number}}</b></td>
  
    <td width="74">मोहल्ला</td>
    <td width="164" class="boderbottom"><b>{{$family_members->mohallaName}}</b></td>
        <td width="6"></td>
   <td width="93">वार्ड संख्या</td> 
    <td width="133" class="boderbottom"><b>{{$family_members->wardNumber}}</b></td>
    <td width="4"></td>
    <td width="112">वार्ड का नाम.</td>
    <td width="217" class="boderbottom"><b>{{$family_members->wardName}}</b></td>
  
    
    
    </tr></tbody></table>
    
    
   <hr>
	
    <table width="100%" cellpadding="0" cellspacing="0">
    <tbody><tr><td width="179"> परिवार के मुखिया का नाम</td> 
    <td width="182" class="boderbottom"><b>{{$family_members->member_name}}</b></td>
    <td width="3"></td>
    <td width="60"> फ़ोन न०</td>
    <td width="185" class="boderbottom"><b>{{$family_members->mobile_number}}</b></td>
        <td width="34"></td>
        <td width="185"> स्थानीय  निवास की अवधी </td>
          <td width="194" class="boderbottom"><b>{{$family_members->panjikaran}}</b></td>
         
          </tr>
    
    
    </tbody></table>
    
	<hr>
	
    <table width="100%" cellpadding="0" cellspacing="0">
    <tbody><tr><td width="113">राशन कार्ड संख्या.</td> 
 <td width="103" class="boderbottom"><b>{{$family_members->rashanCardNumber}}</b></td>

            <td width="8"></td>
        <td width="134">राशन कार्ड का प्रकार</td>
            <td width="86" class="boderbottom"><b>{{$family_members->rashanCard}}</b></td>

 <td width="3"></td>
        <td width="32"> धर्म </td>
            <td width="75" class="boderbottom"><b>{{$family_members->dharm}}</b></td>
    <td width="1"></td>
        <td width="47">जाति</td>
            <td width="52" class="boderbottom"><b>{{$family_members->jati}}</b></td>
			  <td width="10"></td>
  <td width="114">बिजली है/नही है.</td> 
    <td width="48" class="boderbottom"><b>{{$family_members->bijliMeter}}</b></td>
    <td width="1"></td>
    <td width="152">गैस कनेक्शन है /नही है.</td>
    <td width="43" class="boderbottom"><b>{{$family_members->gasConnection}}</b></td>
    </tr>
    
    
    </tbody></table>
    
    <p>&nbsp;</p>
      
    
    <table border="1" cellpadding="0" cellspacing="0" width="100%">		
  			<tbody><tr>
				<td width="2%" style="padding:5px;">क्र स०</td>
				
				<td width="9%" style="padding:5px;">परिवार के सदस्यों का नाम</td>
				<td width="15%" style="padding:5px;">पिता/पति का नाम</td>
				<td width="9%" style="padding:5px;">सम्बन्ध</td>
				<td width="10%" style="padding:5px;">लिंग</td>
				<td width="9%" style="padding:5px;">आयु/जन्मतिथि</td>
				<td width="9%" style="padding:5px;">व्यवसाय</td>
				<td width="15%" style="padding:5px;">शैक्षिक योग्यता/साक्षर/निरक्षर</td>
				<td width="15%" style="padding:5px;">सर्किल छोड़ देने या मृत्यु का दिनांक</td>
				<td width="9%" style="padding:5px;">आधार कार्ड संख्या / निर्वाचन कार्ड संख्या</td>
				<td width="9%" style="padding:5px;">अन्य विवरण</td>
			</tr>
		<!--	<tr>
				<td style="padding:5px;">1</td>
				<td style="padding:5px;">2</td>
				<td style="padding:5px;">3</td>
				<td style="padding:5px;">4</td>
				<td style="padding:5px;">5</td>
				<td style="padding:5px;">6</td>
				<td style="padding:5px;">7</td>
				<td style="padding:5px;">8</td>
				<td style="padding:5px;">9</td>
				<td style="padding:5px;">10</td>
			</tr>-->
			
			
			@foreach($family_members_all as $value)
			<?php
				$from = new DateTime($value->age);
				$to   = new DateTime('today');
				

				# procedural
				//echo ;
			?>
			<tr>
				<td style="padding:5px;">1</td>
				<td style="padding:5px;">{{$value->member_name}}</td>
				<td style="padding:5px;">{{$value->father_husband}}</td>
				<td style="padding:5px;">{{$value->relation}}</td>
				<td style="padding:5px;">{{$value->gender}}</td>
				<td style="padding:5px;">{{$from->diff($to)->y}}</td>
				<td style="padding:5px;">{{$value->vyvasay}}</td>
				<td style="padding:5px;">{{$value->education}}</td>
				<td style="padding:5px;"></td>
				<td style="padding:5px;">{{$value->aadhar_num}}</td>
				<td style="padding:5px;"></td>
			</tr>
			@endforeach
			
			
			</tbody>
</table>
    
    
    
     मै........<b style="font-size:14px;">{{$family_members->member_name}}</b>................सशपथ घोषणा करता हूँ कि उपरोक्त सभी बाते सत्य है तथा कोई तथ्य छिपाया नहीं गया है मेरे तथा परिवार के सभी सदस्यों का भोजन एक रसोई में बनता है तथा परिवार के किसी सदस्य का राशन कार्ड अन्य कही भी प्रचलित नही है और न ही किसी राशन कार्ड में कही सम्मिलित है  तथा मेरे व मेरे परिवार का नाम नगर पंचायत बृजमनगंज के परिवार रजिस्टर के अभिलेखों में दर्ज कर लिया जाये ! इसमें किसी प्रकार  का कोई विवाद नही है ! यदि होती है तो सम्पूर्ण जिम्मेदारी मुझ पर होगी!			
    
    <p>&nbsp;</p>
      
    
    <table width="100%"><tbody><tr><td width="58%" align="left"><strong>(आवेदक/परिवार के मुखिया का हस्ताक्षर/निशानी अंगूठा )</strong></td>
    <td width="42%" align="right"><strong>जांचकर्ता हस्ताक्षर/संतुति विवरण नाम /पदनाम सहित  दिनांक</strong></td>
  </tr>
  
  <tr>
    <td colspan="2" align="center"><strong>अधिकारी के हस्ताक्षर पदनाम सहित</strong></td>
  </tr>
  </tbody></table>
    
    
    
    <center><input style="margin-top:30px; margin-bottom:30px;  " type="button" name="button" id="button" class="submitt_btn" value="प्रिंट करें" onclick="javascript:printDiv('print_area')">
<a href="http://nppaitenpur.in/software/parivar%20reg/dashboard.php"></a></center>



</div>
</div>
</center>


</body></html>