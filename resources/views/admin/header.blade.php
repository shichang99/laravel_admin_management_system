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
    <title>{{ Helper::websiteName() }} Admin Panel</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <link rel="stylesheet" href="{{ asset( 'admin/css/bootstrap.min.css' ) . Helper::assetVersion() }}">

    <!-- core:css -->
	<link rel="stylesheet" href="{{ asset( 'admin/css/core.css' ) . Helper::assetVersion() }}">
	<!-- endinject -->

    <!-- inject:css -->
	<link rel="stylesheet" href="{{ asset( 'admin/fonts/feather-font/iconfont.css' ) . Helper::assetVersion() }}">
	<link rel="stylesheet" href="{{ asset( 'admin/vendors/flag-icon-css/css/flag-icon.min.css' ) . Helper::assetVersion() }}">
	<!-- endinject -->

    <!-- Layout styles -->  
    <link rel="stylesheet" href="{{ asset( 'admin/css/style.css' ) . Helper::assetVersion() }}">
    <!-- End layout styles -->

    <link rel="stylesheet" href="{{ asset( 'admin/css/dataTables.bootstrap5.min.css' ) . Helper::assetVersion() }}">
    <link rel="stylesheet" href="{{ asset( 'admin/css/flatpickr.min.css' ) . Helper::assetVersion() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.5.0/css/select.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset( 'admin/css/custom.css' ) . Helper::assetVersion() }}">
    
</head>

<body class="sidebar-dark">