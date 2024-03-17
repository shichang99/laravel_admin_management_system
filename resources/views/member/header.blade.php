<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ __( 'ms.website_desc' ) }}">
    <meta name="author" content="{{ __( 'ms.website_name' ) }}">
    <meta name="keywords" content="{{ __( 'ms.website_name' ) }}">

    

    @if ( @$header )
    <title>{{ @$header['title'] }} - {{ Helper::websiteName() }}</title>
    @else
    <title>{{ Helper::websiteName() }}</title>
    @endif
    
    <!-- PWA -->
    <meta property="og:title" content="{{ __( 'ms.website_name' ) }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ __( 'ms.website_name' ) }}"/>
    <meta property="og:image" content="{{ asset( 'favicon.png?v=' ) }}{{ date('Y-m-d-H:i:s') }}"/>
    <meta property="og:description" content="{{ __( 'ms.website_desc' ) }}"/>
    <meta property="og:site_name" content="{{ __( 'ms.website_name' ) }}"/>
    <link rel="manifest" href="{{ asset( 'manifest.json?v=' ) }}{{ date('Y-m-d-H:i:s') }}">
    <link rel="icon" href="{{ asset( 'favicon.ico?v=' ) }}{{ date('Y-m-d-H:i:s') }}">
    <link rel="apple-touch-icon" href="{{ asset( 'member/pwa/152.png?v=' ) }}{{ date('Y-m-d-H:i:s') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#dfaa38">
    <meta name="apple-mobile-web-app-title" content="{{ __( 'ms.website_name' ) }}">
    <link href="{{ asset( 'member/pwa/1024.png?v=' ) }}{{ date('Y-m-d-H:i:s') }}" media="screen and (device-width: 375px) and (device-height: 812px)" sizes="1024x1024" rel="apple-touch-startup-image" />
    <link href="{{ asset( 'member/pwa/1024.png?v=' ) }}{{ date('Y-m-d-H:i:s') }}" media="screen and (device-width: 414px) and (device-height: 736px)" sizes="1024x1024" rel="apple-touch-startup-image" />
    <meta name="msapplication-TileImage" content="{{ asset( 'favicon.png?v=' ) }}{{ date('Y-m-d-H:i:s') }}">
    <meta name="msapplication-TileColor" content="#dfaa38">
    <!-- END PWA -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css -->
	<link rel="stylesheet" href="{{ asset( 'admin/css/core.css' ) }}">
	<!-- endinject -->

    <!-- inject:css -->
	<link rel="stylesheet" href="{{ asset( 'admin/fonts/feather-font/iconfont.css' ) }}">
    <link rel="stylesheet" href="{{ asset( 'admin/vendors/flag-icon-css/css/flag-icon.min.css' ) }}">
    <link rel="stylesheet" href="{{ asset( 'member/Fonts/style.css?v=' ) }}{{ date('Y-m-d-H:i:s') }}">
	<!-- endinject -->

    <!-- Layout styles -->  
    <link rel="stylesheet" href="{{ asset( 'member/Scripts/css/style_of_default.css?v=' ) }}{{ date('Y-m-d-H:i:s') }}">
    <link rel="stylesheet" href="{{ asset( 'member/Scripts/css/style_of_main.css?v=' ) }}{{ date('Y-m-d-H:i:s') }}">
    <link rel="stylesheet" href="{{ asset( 'member/Scripts/css/style_of_main_pre_auth.css?v=' ) }}{{ date('Y-m-d-H:i:s') }}">
    <link rel="stylesheet" href="{{ asset( 'member/Scripts/css/boostrap.css?v=' ) }}{{ date('Y-m-d-H:i:s') }}">
    <link rel="stylesheet" href="{{ asset( 'member/Scripts/css/calendar.css?v=' ) }}{{ date('Y-m-d-H:i:s') }}">
    <link rel="stylesheet" href="{{ asset( 'member/Scripts/css/breakcrumb.css?v=' ) }}{{ date('Y-m-d-H:i:s') }}">
    <link rel="stylesheet" href="{{ asset( 'member/Scripts/css/inputs.css?v=' ) }}{{ date('Y-m-d-H:i:s') }}">
    <link rel="stylesheet" href="{{ asset( 'member/Scripts/css/modal.css?v=' ) }}{{ date('Y-m-d-H:i:s') }}">
    <!-- End layout styles -->

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset( 'member/Scripts/js/jquery.min.js?v=' ) }}{{ date('Y-m-d-H:i:s') }}"></script>
    
    <!-- https://github.com/frehaiku/DatePicker -->
    <script src="{{ asset( 'member/Scripts/js/calendar.js?v=' ) }}{{ date('Y-m-d-H:i:s') }}"></script>
    
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <!-- End Tailwind -->

</head>


<body class="sidebar-dark ">



