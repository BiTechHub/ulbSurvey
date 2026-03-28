<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Business Innovations - GIS Survey & Property Tax Collection Software</title>
  <link rel="icon" type="image/png" href="{{url('/')}}/assets/images/favicon.png" sizes="16x16">
  <!-- google fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&amp;display=swap" rel="stylesheet">
  <!-- remix icon font css  -->
  <link rel="stylesheet" href="{{url('/')}}/assets/css/remixicon.css">
  <!-- Apex Chart css -->
  <link rel="stylesheet" href="{{url('/')}}/assets/css/lib/apexcharts.css">
  <!-- Data Table css -->
  <link rel="stylesheet" href="{{url('/')}}/assets/css/lib/dataTables.min.css">
  <!-- Text Editor css -->
  <link rel="stylesheet" href="{{url('/')}}/assets/css/lib/editor-katex.min.css">
  <link rel="stylesheet" href="{{url('/')}}/assets/css/lib/editor.atom-one-dark.min.css">
  <link rel="stylesheet" href="{{url('/')}}/assets/css/lib/editor.quill.snow.css">
  <!-- Date picker css -->
  <link rel="stylesheet" href="{{url('/')}}/assets/css/lib/flatpickr.min.css">
  <!-- Calendar css -->
  <link rel="stylesheet" href="{{url('/')}}/assets/css/lib/full-calendar.css">
  <!-- Vector Map css -->
  <link rel="stylesheet" href="{{url('/')}}/assets/css/lib/jquery-jvectormap-2.0.5.css">
  <!-- Popup css -->
  <link rel="stylesheet" href="{{url('/')}}/assets/css/lib/magnific-popup.css">
  <!-- Slick Slider css -->
  <link rel="stylesheet" href="{{url('/')}}/assets/css/lib/slick.css">
  <!-- prism css -->
  <link rel="stylesheet" href="{{url('/')}}/assets/css/lib/prism.css">
  <!-- file upload css -->
  <link rel="stylesheet" href="{{url('/')}}/assets/css/lib/file-upload.css">
  
  <link rel="stylesheet" href="{{url('/')}}/assets/css/lib/audioplayer.css">
  <!-- main css -->
  <link rel="stylesheet" href="{{url('/')}}/assets/css/style.css">
  
  <!--Nifty Stylesheet [ REQUIRED ]-->
  <link href="{{url('/')}}/assets/nifty.min.css" rel="stylesheet">


	<!--Page Load Progress Bar [ OPTIONAL ]-->
  <link href="{{url('/')}}/assets/pace/pace.min.css" rel="stylesheet">
  <script src="{{url('/')}}/assets/pace/pace.min.js"></script>
</head>
  <body class="dark:bg-neutral-800 bg-neutral-100 dark:text-white">

<section class="bg-white dark:bg-dark-2 flex flex-wrap min-h-[100vh]">  
    <div class="lg:w-1/2 lg:block hidden">
        <div class="flex items-center flex-col h-full justify-center">
            <img src="{{url('/')}}/assets/images/gis_new.jpg" alt="">
        </div>
    </div>
    <div class="lg:w-1/2 py-8 px-6 flex flex-col justify-center">
        <div class="lg:max-w-[464px] mx-auto w-full">
            <div>
                <a href="index.html" class="mb-2.5 max-w-[290px]">
                    <img src="{{url('/')}}/assets/images/logo.png" style="width:70%" alt="">
                </a>
                <p class="mb-8 text-secondary-light text-lg">Welcome back! Sign In to your Account</p>
                @if(session('status'))
                <div class="alert alert-danger">{{ session('status') }}</div>
                @endif
            </div>
            <form action="{{ route('admin.login') }}" method="post">
                @csrf 
                
                <div class="icon-field mb-4 relative">
                    <span class="absolute start-4 top-1/2 -translate-y-1/2 pointer-events-none flex text-xl">
                        <iconify-icon icon="mage:user"></iconify-icon>
                    </span>
                    <input type="text" name="username" class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl" placeholder="Enter Username">
                </div>
                <div class="relative mb-5">
                    <div class="icon-field">
                        <span class="absolute start-4 top-1/2 -translate-y-1/2 pointer-events-none flex text-xl">
                            <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                        </span> 
                        <input type="password" name="password" class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl" id="your-password" placeholder="Password">
                    </div>
                    <span class="toggle-password ri-eye-line cursor-pointer absolute end-0 top-1/2 -translate-y-1/2 me-4 text-secondary-light" data-toggle="#your-password"></span>
                </div>
                <div class="mt-7">
                    <div class="flex justify-between gap-2">
                        <div class="flex items-center">
                            <input class="form-check-input border border-neutral-300" type="checkbox" value="" id="remeber">
                            <label class="ps-2" for="remeber">Remember me </label>
                        </div>
                        <a href="javascript:void(0)" class="text-primary-600 font-medium hover:underline">Forgot Password?</a>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary justify-center text-sm btn-sm px-3 py-4 w-full rounded-xl mt-8"> Sign In</button>

                
                
            </form>
        </div>
    </div>
</section>

  <!-- jQuery library js -->
  <script src="{{url('/')}}/assets/js/lib/jquery-3.7.1.min.js"></script>
  <!-- Apex Chart js -->
  <script src="{{url('/')}}/assets/js/lib/apexcharts.min.js"></script>
  <!-- Data Table js -->
  <script src="{{url('/')}}/assets/js/lib/simple-datatables.min.js"></script>
  <!-- Iconify Font js -->
  <script src="{{url('/')}}/assets/js/lib/iconify-icon.min.js"></script>
  <!-- jQuery UI js -->
  <script src="{{url('/')}}/assets/js/lib/jquery-ui.min.js"></script>
  <!-- Vector Map js -->
  <script src="{{url('/')}}/assets/js/lib/jquery-jvectormap-2.0.5.min.js"></script>
  <script src="{{url('/')}}/assets/js/lib/jquery-jvectormap-world-mill-en.js"></script>
  <!-- Popup js -->
  <script src="{{url('/')}}/assets/js/lib/magnifc-popup.min.js"></script>
  <!-- Slick Slider js -->
  <script src="{{url('/')}}/assets/js/lib/slick.min.js"></script>
  <!-- prism js -->
  <script src="{{url('/')}}/assets/js/lib/prism.js"></script>
  <!-- file upload js -->
  <script src="{{url('/')}}/assets/js/lib/file-upload.js"></script>
  <!-- audioplayer -->
  <script src="{{url('/')}}/assets/js/lib/audioplayer.js"></script>
  
  <script src="{{url('/')}}/assets/js/flowbite.min.js"></script>
  <!-- main js -->
  <script src="{{url('/')}}/assets/js/app.js"></script>

<script>
      // ================== Password Show Hide Js Start ==========
      function initializePasswordToggle(toggleSelector) {
        $(toggleSelector).on('click', function() {
            $(this).toggleClass("ri-eye-off-line");
            var input = $($(this).attr("data-toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    }
    // Call the function
    initializePasswordToggle('.toggle-password');
  // ========================= Password Show Hide Js End ===========================
</script>

</body>

<!-- Mirrored from wowdash.wowtheme7.com/tailwind/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 13 Nov 2024 10:17:54 GMT -->
</html>

