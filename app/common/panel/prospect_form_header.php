<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "Prospect" . ' | ' . env('APP_NAME'); ?></title>
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
<meta name="description"
	content="This is an example dashboard created using build-in elements and components.">
<link rel="icon" href="/assets/images/logos/favicon.ico">

<!-- Disable tap highlight on IE -->
<meta name="msapplication-tap-highlight" content="no">

<link href="<?php echo url('/assets/main.07a59de7b920cd76b874.css'); ?>"
	rel="stylesheet">
</head>

<style>
.vertical-nav-menu i.metismenu-icon {
	width: 18px;
	height: 28px;
}

.app-header__logo .logo-src {
	width: 180px;
	height: 40px;
	background: none;
}
</style>

<link
	href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"
	rel="stylesheet">
<link
	href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css"
	rel="stylesheet" />
<style>
.select2-container--default .select2-selection--multiple .select2-selection__choice
	{
	color: black;
}

.select2-container .select2-selection--single {
	height: 100%;
	min-height: 36px;
	padding-top: 4px;
	z-index: 999;
}
</style>

<style>
.daterangepicker {
	z-index: 2000 !important;
}
</style>

<script>
    function resizeIframe(obj) {
        obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
    }
</script>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="<?php echo url('hummingbird/hummingbird-treeview.js'); ?>"></script>
<script type="text/javascript"
	src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript"
	src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<body>
	<div class="app-container app-theme-gray app-sidebar-full fixed-sidebar <?php if (isset($close_sidebar)) echo 'header-mobile-open'; ?>">
		<div class="container">
				<div>
					<div class="app-header__logo"
						style="padding-top: 15px; padding-bottom: 15px;">
						<img class="img-responsive logo-src"
							src="<?php echo url('images/logo.png'); ?>"
							alt="NextLevel Akademie" style="max-width: 150px;">
					</div>
				</div>	