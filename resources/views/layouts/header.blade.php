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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <style>
   .btn {
   background-color: rgb(72 127 255 / var(--tw-bg-opacity)) !important;
   }
   a {
   text-decoration:none !important;
   }
  </style>
  
</head>
  <body class="dark:bg-neutral-800 bg-neutral-100 dark:text-white">
<aside class="sidebar">
  <button type="button" class="sidebar-close-btn">
    <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
  </button>
  <div>
    <a href="{{url('/')}}/" class="sidebar-logo">
      <img src="{{url('/')}}/assets/images/logo.png" alt="site logo" class="light-logo">
      <img src="{{url('/')}}/assets/images/logo-light.png" alt="site logo" class="dark-logo">
      <img src="{{url('/')}}/assets/images/user.png" alt="site logo" class="logo-icon">
    </a>
  </div>
  <div class="sidebar-menu-area">
  

    <ul class="sidebar-menu" id="sidebar-menu">
      @foreach($menu as $value)
	  @if($value['menu_type']=='Main')
	  <li class="">
        <a href="{{url('/')}}/{{$value['url']}}" target="{{$value['target']}}">
          <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
          <span>{{$value['menu_name']}}</span>
        </a>
      </li>
      @endif
	  @if($value['menu_type']=='Sub')
      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
          <span>{{$value['menu_name']}}</span>
        </a>
        <ul class="sidebar-submenu">
          @foreach($value['sub_menu'] as $subvalue)
          <li>
            <a target="{{$subvalue->target}}" href="{{url('/')}}/{{$subvalue->url_name}}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> {{$subvalue->sub_menu}}</a>
          </li>
          @endforeach
        </ul>
      </li>
      @endif
	  @endforeach
    </ul>
  </div>
</aside>
<main class="dashboard-main">
  <div class="navbar-header border-b border-neutral-200 dark:border-neutral-600">
  <div class="flex items-center justify-between">
    <div class="col-auto">
      <div class="flex flex-wrap items-center gap-[16px]">
        <button type="button" class="sidebar-toggle">
          <iconify-icon icon="heroicons:bars-3-solid" class="icon non-active"></iconify-icon>
          <iconify-icon icon="iconoir:arrow-right" class="icon active"></iconify-icon>
        </button>
        <button type="button" class="sidebar-mobile-toggle">
          <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
        </button>
        <form class="navbar-search">
          <input type="text" id="sidebarSearch" name="search" placeholder="Search Menu..">
          <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
        </form>

        <!-- <span class="max-w-[244px] w-full p-6 h-3 bg-red-600 text-white flex items-center justify-center rounded-[50px]">tesdgxt</span> -->
        
      </div>
    </div>
    <div class="col-auto">
      <div class="flex flex-wrap items-center gap-3">
        <button type="button" id="theme-toggle" class="w-10 h-10 bg-neutral-200 dark:bg-neutral-700 dark:text-white rounded-full flex justify-center items-center">
          <span id="theme-toggle-dark-icon" class="hidden">
            <i class="ri-sun-line"></i>
          </span>
          <span id="theme-toggle-light-icon" class="hidden">
            <i class="ri-moon-line"></i>
          </span>
        </button>  

        <!-- Language Dropdown Start  -->
       
        <!-- Language Dropdown End  -->


        <!-- Message Dropdown Start  -->
        
        <!-- Message Dropdown End  -->


        <!-- Notification Start  -->
        <!--<button data-dropdown-toggle="dropdownNotification" class="has-indicator w-10 h-10 bg-neutral-200 dark:bg-neutral-700 rounded-full flex justify-center items-center" type="button">
          <iconify-icon icon="iconoir:bell" class="text-neutral-900 dark:text-white text-xl"></iconify-icon>
        </button>
        <div id="dropdownNotification" class="z-10 hidden bg-white dark:bg-neutral-700 rounded-2xl overflow-hidden shadow-lg max-w-[394px] w-full">
          <div class="py-3 px-4 rounded-lg bg-primary-50 dark:bg-primary-600/25 m-4 flex items-center justify-between gap-2">
            <h6 class="text-lg text-neutral-900 font-semibold mb-0">Notification</h6>
            <span class="w-10 h-10 bg-white dark:bg-neutral-600 text-primary-600 dark:text-white font-bold flex justify-center items-center rounded-full">05</span>
          </div>
          <div class="scroll-sm !border-t-0">
            <div class="max-h-[400px] overflow-y-auto">
              <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                <div class="flex items-center gap-3">
                  <div class="flex-shrink-0 relative w-11 h-11 bg-success-200 dark:bg-success-600/25 text-success-600 flex justify-center items-center rounded-full">
                    <iconify-icon icon="bitcoin-icons:verify-outline" class="text-2xl"></iconify-icon>
                  </div>
                  <div>
                    <h6 class="text-sm fw-semibold mb-1">Congratulations</h6>
                    <p class="mb-0 text-sm line-clamp-1">Your profile has been Verified. Your profile has been Verified</p>
                  </div>
                </div>
                <div class="shrink-0">
                  <span class="text-sm text-neutral-500">23 Mins ago</span>
                </div>
              </a>
              <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                <div class="flex items-center gap-3">
                  <div class="flex-shrink-0 relative">
                    <img class="rounded-full w-11 h-11" src="assets/images/notification/profile-4.png" alt="Joseph image">
                  </div>
                  <div>
                    <h6 class="text-sm fw-semibold mb-1">Ronald Richards</h6>
                    <p class="mb-0 text-sm line-clamp-1">You can stitch between artboards</p>
                  </div>
                </div>
                <div class="shrink-0">
                  <span class="text-sm text-neutral-500">23 Mins ago</span>
                </div>
              </a>
              <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                <div class="flex items-center gap-3">
                  <div class="flex-shrink-0 relative w-11 h-11 bg-primary-100 dark:bg-primary-600/25 text-primary-600 flex justify-center items-center rounded-full">
                    AM
                  </div>
                  <div>
                    <h6 class="text-sm fw-semibold mb-1">Arlene McCoy</h6>
                    <p class="mb-0 text-sm line-clamp-1">Invite you to prototyping</p>
                  </div>
                </div>
                <div class="shrink-0">
                  <span class="text-sm text-neutral-500">23 Mins ago</span>
                </div>
              </a>
              <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                <div class="flex items-center gap-3">
                  <div class="flex-shrink-0 relative">
                    <img class="rounded-full w-11 h-11" src="assets/images/notification/profile-6.png" alt="Joseph image">
                  </div>
                  <div>
                    <h6 class="text-sm fw-semibold mb-1">Annette Black</h6>
                    <p class="mb-0 text-sm line-clamp-1">Invite you to prototyping</p>
                  </div>
                </div>
                <div class="shrink-0">
                  <span class="text-sm text-neutral-500">23 Mins ago</span>
                </div>
              </a>
              <a href="javascript:void(0)" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 justify-between gap-1">
                <div class="flex items-center gap-3">
                  <div class="flex-shrink-0 relative w-11 h-11 bg-primary-100 dark:bg-primary-600/25 text-primary-600 flex justify-center items-center rounded-full">
                    DR
                  </div>
                  <div>
                    <h6 class="text-sm fw-semibold mb-1">Darlene Robertson</h6>
                    <p class="mb-0 text-sm line-clamp-1">Invite you to prototyping</p>
                  </div>
                </div>
                <div class="shrink-0">
                  <span class="text-sm text-neutral-500">23 Mins ago</span>
                </div>
              </a>
            </div>

            <div class="text-center py-3 px-4">
              <a href="javascript:void(0)" class="text-primary-600 dark:text-primary-600 font-semibold hover:underline text-center">See All Notification </a>
            </div>
          </div>
        </div>-->
        <!-- Notification End  -->


        <button data-dropdown-toggle="dropdownProfile" class="flex justify-center items-center rounded-full" style="border:solid 1px orange;padding:3px" type="button">
          <img src="{{url('/')}}/assets/images/user.png" alt="image" class="w-10 h-10 object-fit-cover rounded-full">
        </button>
        <div id="dropdownProfile" class="z-10 hidden bg-white dark:bg-neutral-700 rounded-lg shadow-lg dropdown-menu-sm p-3">
          <div class="py-3 px-4 rounded-lg bg-primary-50 dark:bg-primary-600/25 mb-4 flex items-center justify-between gap-2">
            <div>
              <h6 class="text-lg text-neutral-900 font-semibold mb-0">{{ Session('name') }}</h6>
              <span class="text-neutral-500" style="font-size:10px;">{{ Session('user_type') }}</span>
            </div>
            <button type="button" class="hover:text-danger-600">
              <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon> 
            </button>
          </div>

          <div class="max-h-[400px] overflow-y-auto scroll-sm pe-2">
            <ul class="flex flex-col">
                <li>
                  <a class="text-black px-0 py-2 hover:text-primary-600 flex items-center gap-4" href="#"> 
                  <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon>  My Profile</a>
                </li>
                
                <li>
                  <a class="text-black px-0 py-2 hover:text-danger-600 flex items-center gap-4" href="{{url('/')}}/logout"> 
                  <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon>  Log Out</a>
                </li>
              </ul>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("sidebarSearch");
    const mainItems = document.querySelectorAll("#sidebar-menu > li");

    searchInput.addEventListener("keyup", function () {
        const query = this.value.toLowerCase();

        mainItems.forEach(function (item) {
            let matchFound = false;
            let isDropdown = item.classList.contains("dropdown");

            // Search main menu text
            const mainText = item.querySelector("a span")?.innerText.toLowerCase() || "";

            if (mainText.includes(query)) {
                matchFound = true;
            }

            // Search inside submenus
            if (isDropdown) {
                let subMenu = item.querySelector(".sidebar-submenu");
                let subItems = subMenu ? subMenu.querySelectorAll("li") : [];

                let subMatchFound = false;
                subItems.forEach(function (subItem) {
                    const subText = subItem.innerText.toLowerCase();
                    if (subText.includes(query)) {
                        subItem.style.display = "";
                        subMatchFound = true;
                    } else {
                        subItem.style.display = "none";
                    }
                });

                // If any submenu item matches, keep dropdown open
                if (subMatchFound) {
                    matchFound = true;
                    subMenu.style.display = "block"; // Auto-open
                    item.classList.add("open");      // Optional class for styling
                } else {
                    subMenu.style.display = "";
                    item.classList.remove("open");
                }
            }

            // Show or hide main item
            item.style.display = matchFound ? "" : "none";
        });
    });
});
</script>

