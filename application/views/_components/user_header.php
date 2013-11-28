<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=isset($meta_title) ? $meta_title : 'IntelliCare E-Performance' ?></title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>bootstrap/bootstrap-responsive.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>theme.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="<?=base_url().CSS?>font-awesome/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>validationEngine.jquery.css">

    <script src="<?=base_url().JS?>jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="<?=base_url().JS?>common.js" type="text/javascript"></script>

    <!-- Demo page code -->
    
    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7"> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8"> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9"> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body> 
  <!--<![endif]-->