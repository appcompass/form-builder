<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Plus 3 Interactive, LLC">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="shortcut icon" href="/assets/ui/images/favicon.png">

	<title>Plus 3 CMS</title>

	<!--Core CSS -->
	<link href="/assets/ui/bs3/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/ui/css/bootstrap-reset.css" rel="stylesheet">
	<link href="/assets/ui/font-awesome/css/font-awesome.css" rel="stylesheet" />

	<!--external css-->
    <link rel="stylesheet" type="text/css" href="/assets/ui/js/jquery-ui/jquery-ui-1.10.1.custom.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/ui/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/assets/ui/js/jvector-map/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" type="text/css" href="/assets/ui/css/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="/assets/ui/js/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="/assets/ui/js/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />

    <link rel="stylesheet" type="text/css" href="/assets/ui/js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="/assets/ui/js/bootstrap-timepicker/css/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="/assets/ui/js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="/assets/ui/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="/assets/ui/js/bootstrap-datetimepicker/css/datetimepicker.css" />

    <link rel="stylesheet" type="text/css" href="/assets/ui/js/iCheck/skins/minimal/minimal.css" />
    <link rel="stylesheet" type="text/css" href="/assets/ui/js/iCheck/skins/square/square.css" />

    <link rel="stylesheet" type="text/css" href="/assets/ui/js/jquery-multi-select/css/multi-select.css" />
    <link rel="stylesheet" type="text/css" href="/assets/ui/js/jquery-tags-input/jquery.tagsinput.css" />

    <!-- <link rel="stylesheet" type="text/css" href="/assets/ui/js/select2/select2.css" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/ui/css/clndr.css">
    <!--clock css-->
    <link rel="stylesheet" type="text/css" href="/assets/ui/js/css3clock/css/style.css">
    <!--Morris Chart CSS -->
    <link rel="stylesheet" type="text/css" href="/assets/ui/js/morris-chart/morris.css">

	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="/assets/ui/css/style.css">
	<link rel="stylesheet" type="text/css" href="/assets/ui/css/style-responsive.css"/>

	<!-- Just for debugging purposes. Don't actually copy this line! -->
	<!--[if lt IE 9]>
	<script src="/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
    @yield('scripts.header')
</head>

<body class="{{ $bodyClass  or '' }}" onload="{{ $bodyOnLoad or '' }}">
