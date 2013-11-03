<?=doctype('html5')?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?=isset($meta_title) ? $meta_title : 'IntelliCare ePerformance'?></title>
	<link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>navi.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>validationEngine.jquery.css">
	<script type="text/javascript" src="<?=base_url().JS?>jquery-1.10.2.min.js"></script>
	<script src="<?=base_url().JS?>common.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(function(){
		$(".box .h_title").not(this).next("ul").hide("normal");
		$(".box .h_title").not(this).next("#home").show("normal");
		$(".box").children(".h_title").click( function() { $(this).next("ul").slideToggle(); });
	});
	</script>	
</head>
<body>
	<!-- Wrap Start -->
	<div class="wrap">
		<!-- Header Start -->
		<div id="header">