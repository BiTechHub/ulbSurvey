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
    Nagar Palika Parishad Sitapur
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
  <div class="menu" style="font-size:10pt;">
    <ul>

      <li><a href="{{ url('/') }}/payment/" id="Home">Home</a></li>

      <li id="li16"><a href="{{ url('/') }}/payment/Pay-Tax">Pay Tax</a></li>

      <li id="li14"><a href="{{ url('/') }}/payment/Ledger">View Ledger</a></li>

      <li id="li15"><a href="{{ url('/') }}/payment/View-Receipt">View Receipt</a></li>

      <li id="liLin"><a href="{{ url('/') }}/login">Login</a></li>

    </ul>
  </div>
  <div id="content-pannel">
    @yield('content')
    <div class="footer">
        <div>
            <a href="{{url('/')}}/payment/Terms-Condition">Terms & Condition</a> ||
            <a href="{{url('/')}}/payment/Privacy-Policy">Privacy Policy</a> ||
            <a href="{{url('/')}}/payment/Return-Policy">Return Policy</a> ||
        </div>
    </div>
  </div>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript">
    function printDiv() {
        var divToPrint = document.getElementById('DivIdToPrint');
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write(
          '<html><head><style type="text/css">#backgroundImage{z-index: 1;}#backgroundImage:before {content: "";position: fixed;z-index: -1;top: 0;bottom: 0;left: 0;   right: 0;background-image: url(consolelogo.jpg);background-repeat: repeat;background-size: 100%;   opacity: 0.1;filter:alpha(opacity=40);height:100%;width:100%;}.main{height:320px;width:320px;  margin:auto;background-color:green;z-index:-1;opacity: 1;filter:alpha(opacity=100);}</style></head><body onload="window.print()" id="backgroundImage"><div class="main1"><table border="1" cellspacing="0">' +
          divToPrint.innerHTML +
          '</table></div><div align="center">This is a system generated report it does not require any signature or stamp</div><div align="right"><img src="logo.jpg" style="opacity: 0.1"></div></body></html>'
        );
        newWin.document.close();
        setTimeout(function() {
          newWin.close();
        }, 5000);
      }
    </script>
    @if (session()->has('message'))
    <script type="text/javascript">
        swal("{{ session()->get('message') }}");
    </script>
    @php(session()->forget('message'))
@endif
</body>

</html>
