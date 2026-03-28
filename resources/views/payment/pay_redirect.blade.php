<?php

include(app_path().'\library\AesForJavaSend.php');
//require_once 'AesForJava.php';

//Change Encryption Key as provided by EasyPay Team

//Change Checksum Key as provided by EasyPay Team
$checksum_key = "axis";

$cid = $cid;
$rid = $dataa->txn_id;
$crn = $pay_id;
$amt = $dataa->amount;
$ver = $ver;
$typ = $type;
$cny = 'INR';
$rtu = $call_back;
$ppi = $dataa->first_name.'|'.$dataa->father_name.'|'.$dataa->house_id.'|'.$dataa->phone.'|'.$dataa->ward_number.'|'.date('d/m/Y').'|'.date('H:i:s').'|'.$dataa->txn_id.'|'.$dataa->amount;
$re1 = 'MN';
$re2 = $pay_id;
$re3 = '';
$re4 = '';
$re5 = '';

//PPI:Name|Father Name|House Id|Phone Number|Ward|Date Of Payment|Time of payment|Fund transaction Id|Amount
/*CKS= hash("sha256",CID+RID+CRN+AMT+checksum_key)*/
$cks = hash("sha256", $cid.$rid.$crn.$amt.$checksum_key);

//$str = "CID=".$_POST['CID']."&RID=".$_POST['RID']."&CRN=".$_POST['CRN']."&AMT=".$_POST['AMT']."&VER=".$_POST['VER']."&TYP=".$_POST['TYP']."&CNY=".$_POST['CNY']."&RTU=".$_POST['RTU']."&PPI=".$_POST['PPI']."&RE1=".$_POST['RE1']."&RE2=".$_POST['RE2']."&RE3=".$_POST['RE3']."&RE4=".$_POST['RE4']."&RE5=".$_POST['RE5']."&CKS=".$checksum;
$str ='CID='.$cid.'&RID='.$rid.'&CRN='.$crn.'&AMT='.$amt.'&VER='.$ver.'&TYP='.$typ.'&CNY='.$cny.'&RTU='.$rtu.'&PPI='.$ppi.'&RE1=&RE2=&RE3=&RE4=&RE5=&CKS='.$cks;

$aesJava = new AesForJavaSend();
$i = $aesJava->encrypt(urldecode($str), $encryption_key, 128);
//echo $i;
//echo $ppi;
//exit();
$html='<form style="" name="Formdata" id="Formdata" method="POST" action="'.$action.'" >
    <input name="i" id="i" type="hidden" value="'.$i.'">
    </form>';
?>
<!DOCTYPE html>
<html lang="en">
<head id="Head1">
  <link type="text/css" href="{{ url('/') }}/pay/css/jquery.ui.all.css" rel="stylesheet" />
  <link href="{{ url('/') }}/pay/css/css.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <meta charset="utf-8" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <title>
    Pay Now : Nagar Panchayat Mahul
  </title>

</head>

<body>
  <div class="header">
    <div class="row">
        <div class="col-md-6">
            <img class="logo" src="{{ url('/') }}/pay/images/logoann.png" />
        </div>
        <div class="col-md-6 hidden-xs hidden-sm">
            <img class="pull-right logo" src="{{ url('/') }}/pay/images/govbrand.png">
        </div>
    </div>
  </div>
  <div id="content-pannel">
    <section class="content-wrapper main-content clear-fix">

        <div class="row">
            <div class="col-md-12 text-center">
                <h2><b><u>Redirecting To Payment Gateway</u></b></h2>
            </div>
        </div>
        <div class="row" align="center">
            <img src="{{url('/')}}/pay/images/loading.gif" width="400" />
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <h4>Please do not press back or refresh button !!!!!</h4>
            </div>
        </div>
    </section>
  </div>
  {!! $html !!}
  <script>
    $(document).ready(function(){ $("#Formdata").submit(); });
    </script>

</body>

</html>
